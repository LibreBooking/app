<?php
/**
 * Copyright 2012-2018 Nick Korbel
 *
 * This file is part of Booked Scheduler is free software: you can redistribute it and/or modify
 * it under the terms of the GNU General Public License as published by
 * the Free Software Foundation, either version 3 of the License, or
 * (at your option) any later version is distributed in the hope that it will be useful,
 * but WITHOUT ANY WARRANTY; without even the implied warranty of
 * MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
 * GNU General Public License for more details.
 *
 * You should have received a copy of the GNU General Public License
 * along with Booked Scheduler.  If not, see <http://www.gnu.org/licenses/>.
 */

require_once(ROOT_DIR . 'lib/Application/Reporting/namespace.php');
require_once(ROOT_DIR . 'lib/Email/namespace.php');
require_once(ROOT_DIR . 'lib/Email/Messages/ReportEmailMessage.php');
require_once(ROOT_DIR . 'Domain/Access/ReportingRepository.php');

interface IReportingService
{
    /**
     * @param Report_Usage $usage
     * @param Report_ResultSelection $selection
     * @param Report_GroupBy $groupBy
     * @param Report_Range $range
     * @param Report_Filter $filter
     * @return IReport
     */
    public function GenerateCustomReport(Report_Usage $usage, Report_ResultSelection $selection, Report_GroupBy $groupBy, Report_Range $range, Report_Filter $filter);

    /**
     * @param string $reportName
     * @param int $userId
     * @param Report_Usage $usage
     * @param Report_ResultSelection $selection
     * @param Report_GroupBy $groupBy
     * @param Report_Range $range
     * @param Report_Filter $filter
     */
    public function Save($reportName, $userId, Report_Usage $usage, Report_ResultSelection $selection, Report_GroupBy $groupBy, Report_Range $range, Report_Filter $filter);

    /**
     * @param int $userId
     * @return array|SavedReport[]
     */
    public function GetSavedReports($userId);

    /**
     * @param int $reportId
     * @param int $userId
     * @return IGeneratedSavedReport
     */
    public function GenerateSavedReport($reportId, $userId);

    /**
     * @param IGeneratedSavedReport $report
     * @param IReportDefinition $definition
     * @param string $toAddress
     * @param UserSession $reportUser
     * @param string $selectedColumns
     */
    public function SendReport($report, $definition, $toAddress, $reportUser, $selectedColumns);

    /**
     * @param int $reportId
     * @param int $userId
     */
    public function DeleteSavedReport($reportId, $userId);

    /**
     * @param ICannedReport $cannedReport
     * @return IReport
     */
    public function GenerateCommonReport(ICannedReport $cannedReport);
}


class ReportingService implements IReportingService
{
    /**
     * @var IReportingRepository
     */
    private $repository;

    /**
     * @var IAttributeRepository
     */
    private $attributeRepository;

    /**
     * @var IScheduleRepository
     */
    private $scheduleRepository;

    /**
     * @param IReportingRepository $repository
     * @param IAttributeRepository|null $attributeRepository
     * @param IScheduleRepository|null $scheduleRepository
     */
    public function __construct(IReportingRepository $repository, $attributeRepository = null, $scheduleRepository = null)
    {
        $this->repository = $repository;

        $this->attributeRepository = $attributeRepository;
        if ($attributeRepository == null) {
            $this->attributeRepository = new AttributeRepository();
        }

        $this->scheduleRepository = $scheduleRepository;
        if ($scheduleRepository == null) {
            $this->scheduleRepository = new ScheduleRepository();
        }
    }

    public function GenerateCustomReport(Report_Usage $usage, Report_ResultSelection $selection, Report_GroupBy $groupBy, Report_Range $range, Report_Filter $filter)
    {
        $builder = new ReportCommandBuilder();

        $selection->Add($builder);
        if ($selection->Equals(Report_ResultSelection::FULL_LIST)) {
            $usage->Add($builder);
        }
        $groupBy->Add($builder);
        $range->Add($builder);
        $filter->Add($builder);

        $data = $this->repository->GetCustomReport($builder);

        if ($selection->Equals(Report_ResultSelection::UTILIZATION)) {
            $utilization = new ReportUtilizationData($data, $this->scheduleRepository, $range);
            $data = $utilization->Rows();
        }
        return new CustomReport($data, $this->attributeRepository);
    }

    public function Save($reportName, $userId, Report_Usage $usage, Report_ResultSelection $selection, Report_GroupBy $groupBy, Report_Range $range, Report_Filter $filter)
    {
        $report = new SavedReport($reportName, $userId, $usage, $selection, $groupBy, $range, $filter);
        $this->repository->SaveCustomReport($report);
    }

    public function GetSavedReports($userId)
    {
        return $this->repository->LoadSavedReportsForUser($userId);
    }

    public function GenerateSavedReport($reportId, $userId)
    {
        $savedReport = $this->repository->LoadSavedReportForUser($reportId, $userId);

        if ($savedReport == null) {
            return null;
        }

        $report = $this->GenerateCustomReport($savedReport->Usage(), $savedReport->Selection(), $savedReport->GroupBy(), $savedReport->Range(), $savedReport->Filter());

        return new GeneratedSavedReport($savedReport, $report);
    }

    public function SendReport($report, $definition, $toAddress, $reportUser, $selectedColumns)
    {
        $message = new ReportEmailMessage($report, $definition, $toAddress, $reportUser, $selectedColumns);
        ServiceLocator::GetEmailService()->Send($message);
    }

    public function DeleteSavedReport($reportId, $userId)
    {
        $this->repository->DeleteSavedReport($reportId, $userId);
    }

    public function GenerateCommonReport(ICannedReport $cannedReport)
    {
        $data = $this->repository->GetCustomReport($cannedReport->GetBuilder());
        return new CustomReport($data, $this->attributeRepository);
    }
}

class ReportUtilizationData
{
    /**
     * @var IScheduleLayout[]
     */
    private $layouts = array();
    /**
     * @var ReportDailyAvailability[]
     */
    private $weekdayAvailability = array();

    /**
     * @var array
     */
    private $data;
    /**
     * @var IScheduleRepository
     */
    private $scheduleRepository;
    /**
     * @var Report_Range
     */
    private $range;
    /**
     * @var int[]
     */
    private $totals = array();
    /**
     * @var int[]
     */
    private $unavailable = array();

    /**
     * @param array $data
     * @param IScheduleRepository $scheduleRepository
     * @param Report_Range $range
     */
    public function __construct($data, $scheduleRepository, $range)
    {
        $this->data = $data;
        $this->scheduleRepository = $scheduleRepository;
        $this->range = $range;
    }

    public function Rows()
    {
        $earliest = Date::Max();
        $latest = Date::Min();
        $resources = array();

        foreach ($this->data as $row) {
            $scheduleId = $row[ColumnNames::SCHEDULE_ID];
            $resourceId = $row[ColumnNames::RESOURCE_ID];
            $type = $row[ColumnNames::UTILIZATION_TYPE];

            if (!array_key_exists($resourceId, $resources)) {
                $resources[$resourceId] = $row;
            }

            $layout = $this->GetLayout($scheduleId);
            $timezone = $layout->Timezone();
            $start = Date::FromDatabase($row[ColumnNames::RESERVATION_START])->ToTimezone($timezone);
            $end = Date::FromDatabase($row[ColumnNames::RESERVATION_END])->ToTimezone($timezone);

            if ($start->LessThan($earliest)) {
                $earliest = $start;
            }
            if ($end->GreaterThan($latest)) {
                $latest = $end;
            }

            $this->CacheTotalAvailability($start, $layout, $scheduleId);

            if ($type == 1) {
                $this->AddReservation($start, $end, $resourceId, $scheduleId);
            }
            else {
                $this->AddBlackout($start, $end, $resourceId, $scheduleId);
            }
        }

        $rows = array();
        $rowIndex = 0;
        if ($this->range->Equals(Report_Range::ALL_TIME)) {
            $dates = (new DateRange($earliest, $latest))->Dates();
        }
        else {
            $dates = $this->range->Dates();
        }

        foreach ($dates as $date) {
            foreach ($resources as $rid => $row) {
                $rows[$rowIndex][ColumnNames::RESOURCE_ID] = $rid;
                $rows[$rowIndex][ColumnNames::RESOURCE_NAME] = $row[ColumnNames::RESOURCE_NAME];
                $rows[$rowIndex][ColumnNames::UTILIZATION] = $this->GetUtilization($date, $rid, $row[ColumnNames::SCHEDULE_ID]);
                $rows[$rowIndex][ColumnNames::DATE] = $date->Format(Resources::GetInstance()->GetDateFormat('general_date'));
                $rows[$rowIndex][ColumnNames::SCHEDULE_ID] = $row[ColumnNames::SCHEDULE_ID];
                $rowIndex++;
            }
        }

        return $rows;
    }

    /**
     * @param int $scheduleId
     * @return IScheduleLayout
     */
    private function GetLayout($scheduleId)
    {
        if (!array_key_exists($scheduleId, $this->layouts)) {
            $this->layouts[$scheduleId] = $this->scheduleRepository->GetLayout($scheduleId, new ScheduleLayoutFactory());
        }

        return $this->layouts[$scheduleId];
    }

    /**
     * @param Date $date
     * @param IScheduleLayout $layout
     * @param int $scheduleId
     */
    private function CacheTotalAvailability($date, $layout, $scheduleId)
    {
        $key = $date->Weekday() . $scheduleId;
        if (!array_key_exists($key, $this->weekdayAvailability)) {
            $seconds = 0;
            $first = null;
            $last = null;
            $periods = $layout->GetLayout($date->GetDate());

            foreach ($periods as $period) {
                if ($period->IsReservable()) {
                    if ($first == null) {
                        $first = $period;
                    }
                    $last = $period;
                    $seconds += DateDiff::BetweenDates($period->BeginDate(), $period->EndDate())->TotalSeconds();
                }
            }

            if ($first == null) {
                $first = $periods[0];
            }
            if ($last == null) {
                $last = $periods[count($periods)-1];
            }

            $this->weekdayAvailability[$key] = new ReportDailyAvailability($seconds, $first->Begin(), $last->End());
        }
    }

    /**
     * @param Date $date
     * @param int $scheduleId
     * @return ReportDailyAvailability
     */
    private function GetTotalAvailability($date, $scheduleId)
    {
        $this->CacheTotalAvailability($date, $this->GetLayout($scheduleId), $scheduleId);

        $key = $date->Weekday() . $scheduleId;

        return $this->weekdayAvailability[$key];
    }

    /**
     * @param Date $start
     * @param Date $end
     * @param int $resourceId
     * @param int $scheduleId
     */
    private function AddReservation(Date $start, Date $end, $resourceId, $scheduleId)
    {
        $this->AddItem($start, $end, $resourceId, $scheduleId, true);
    }

    /**
     * @param Date $start
     * @param Date $end
     * @param int $resourceId
     * @param int $scheduleId
     */
    private function AddBlackout(Date $start, Date $end, $resourceId, $scheduleId)
    {
        $this->AddItem($start, $end, $resourceId, $scheduleId, false);
    }

    /**
     * @param Date $start
     * @param Date $end
     * @param int $resourceId
     * @param int $scheduleId
     * @param bool $add
     */
    private function AddItem(Date $start, Date $end, $resourceId, $scheduleId, $add)
    {
        if (!$start->DateEquals($end)) {
            $dates[] = $start;
            $currentDate = $start->AddDays(1);
            while (!$currentDate->GreaterThan($end)) {
                if (!$currentDate->DateEquals($start) && !$currentDate->DateEquals($end)) {
                    $dates[] = $currentDate->GetDate();
                }
                $currentDate = $currentDate->AddDays(1);
            }
            $dates[] = $end;

            /** @var Date $date */
            foreach ($dates as $date) {
                $a = $this->GetTotalAvailability($date, $scheduleId);

                if ($date->DateEquals($start)) {
                    $secondsReserved = DateDiff::BetweenDates($date, $date->SetTimeString($a->Latest(), true))->TotalSeconds();
                }
                elseif ($date->DateEquals($end)) {
                    $secondsReserved = DateDiff::BetweenDates($date->SetTimeString($a->Earliest()), $date)->TotalSeconds();
                }
                else {
                    $secondsReserved = $a->TotalSeconds();
                }

                if ($add) {
                    $this->AddTotal($date, $resourceId, $secondsReserved);
                }
                else {
                    $this->SubtractAvailable($date, $resourceId, $secondsReserved);
                }
            }
        }
        else {
            $secondsReserved = DateDiff::BetweenDates($start, $end)->TotalSeconds();
            if ($add) {
                $this->AddTotal($start, $resourceId, $secondsReserved);
            }
            else {
                $this->SubtractAvailable($start, $resourceId, $secondsReserved);
            }
        }
    }

    private function AddTotal(Date $date, $resourceId, $total)
    {
//        echo sprintf("%s reserved on %s for %s\n", $total / 60 / 60, $date->Format('Y-m-d'), $resourceId);

        $key = $resourceId . $date->GetDate()->Timestamp();
        if (!array_key_exists($key, $this->totals)) {
            $this->totals[$key] = $total;
        }
        else {
            $this->totals[$key] += $total;
        }
    }

    private function SubtractAvailable(Date $date, $resourceId, $total)
    {
        $key = $resourceId . $date->GetDate()->Timestamp();
        $this->unavailable[$key] = $total;
    }

    private function GetUnavailable(Date $date, $resourceId)
    {
        $key = $resourceId . $date->GetDate()->Timestamp();
        if (array_key_exists($key, $this->unavailable)) {
            return $this->unavailable[$key];
        }

        return 0;
    }

    private function GetTotal(Date $date, $resourceId)
    {
        $key = $resourceId . $date->GetDate()->Timestamp();
        if (!array_key_exists($key, $this->totals)) {
            return 0;
        }
        return max(0, $this->totals[$key]);
    }

    /**
     * @param Date $date
     * @param int $resourceId
     * @param int $scheduleId
     * @return float
     */
    private function GetUtilization(Date $date, $resourceId, $scheduleId)
    {
        $total = $this->GetTotal($date, $resourceId);
        $available = $this->GetTotalAvailability($date, $scheduleId);
        $unavailable = $this->GetUnavailable($date, $resourceId);

        return $total / ($available->TotalSeconds() - $unavailable);
    }
}

class ReportDailyAvailability
{
    /**
     * @var int
     */
    private $totalSeconds;
    /**
     * @var Time
     */
    private $earliest;
    /**
     * @var Time
     */
    private $latest;

    public function __construct($totalSeconds, Time $earliest, Time $latest)
    {
        $this->totalSeconds = $totalSeconds;
        $this->earliest = $earliest;
        $this->latest = $latest;
    }

    /**
     * @return int
     */
    public function TotalSeconds()
    {
        return $this->totalSeconds;
    }

    /**
     * @return Time
     */
    public function Earliest()
    {
        return $this->earliest;
    }

    /**
     * @return Time
     */
    public function Latest()
    {
        return $this->latest;
    }
}