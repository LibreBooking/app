<?php
/**
 * Copyright 2018-2019 Nick Korbel
 *
 * This file is part of Booked Scheduler.
 *
 * Booked Scheduler is free software: you can redistribute it and/or modify
 * it under the terms of the GNU General Public License as published by
 * the Free Software Foundation, either version 3 of the License, or
 * (at your option) any later version.
 *
 * Booked Scheduler is distributed in the hope that it will be useful,
 * but WITHOUT ANY WARRANTY; without even the implied warranty of
 * MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
 * GNU General Public License for more details.
 *
 * You should have received a copy of the GNU General Public License
 * along with Booked Scheduler.  If not, see <http://www.gnu.org/licenses/>.
 */

require_once(ROOT_DIR . 'Pages/Admin/AdminPage.php');

class DataCleanupPage extends AdminPage
{
    public function __construct()
    {
        parent::__construct('DataCleanup', 1);
    }

    public function PageLoad()
    {
        if ($this->RequestingData()) {
            $this->ProcessDataRequest();
            return;
        }

        if ($this->TakingAction()) {
            $this->ProcessAction();
            return;
        }

        $reservationsReader = ServiceLocator::GetDatabase()->Query(new AdHocCommand('select count(1) as count from reservation_instances ri inner join reservation_series rs on ri.series_id = rs.series_id where rs.status_id <> 2'));
        $deletedReservationReader = ServiceLocator::GetDatabase()->Query(new AdHocCommand('select count(1) as count from reservation_instances ri inner join reservation_series rs on ri.series_id = rs.series_id where rs.status_id = 2'));
        $blackoutsReader = ServiceLocator::GetDatabase()->Query(new AdHocCommand('select count(1) as count from blackout_instances bi inner join blackout_series bs on bi.blackout_series_id = bs.blackout_series_id'));
        $usersReader = ServiceLocator::GetDatabase()->Query(new AdHocCommand('select count(1) as count from users'));

        $reservationCount = 0;
        $deletedReservationCount = 0;
        $blackoutsCount = 0;
        $userCount = 0;

        if ($row = $reservationsReader->GetRow()) {
            $reservationCount = $row['count'];
        }
        if ($row = $deletedReservationReader->GetRow()) {
            $deletedReservationCount = $row['count'];
        }
        if ($row = $blackoutsReader->GetRow()) {
            $blackoutsCount = $row['count'];
        }
        if ($row = $usersReader->GetRow()) {
            $userCount = $row['count'];
        }

        $reservationsReader->Free();
        $deletedReservationReader->Free();
        $blackoutsReader->Free();
        $usersReader->Free();

        $this->Set('ReservationCount', $reservationCount);
        $this->Set('DeletedReservationCount', $deletedReservationCount);
        $this->Set('BlackoutsCount', $blackoutsCount);
        $this->Set('UserCount', $userCount);
        $this->Set('DeleteDate', Date::Now()->AddYears(-1));
        $this->Display('Configuration/data_cleanup.tpl');
    }

    private function ProcessAction()
    {
        $action = $this->GetAction();
        Log::Debug('Processing action %s', $action);

        $date = $this->GetDate();

        if ($action == 'deleteReservations') {
            $command = new AdHocCommand('update reservation_series inner join reservation_instances on reservation_instances.series_id = reservation_series.series_id set status_id = 2 where start_date < @startDate');
            $command->AddParameter(new Parameter(ParameterNames::START_DATE, $date));

            ServiceLocator::GetDatabase()->Execute($command);
        }
        if ($action == 'purge') {
            $command = new AdHocCommand('delete from reservation_series where status_id = 2');
            $command->AddParameter(new Parameter(ParameterNames::START_DATE, $date));

            ServiceLocator::GetDatabase()->Execute($command);
        }
        if ($action == 'deleteBlackouts') {
            $command = new AdHocCommand('delete from blackout_instances where start_date < @startDate');
            $command->AddParameter(new Parameter(ParameterNames::START_DATE, $date));

            ServiceLocator::GetDatabase()->Execute($command);
        }
        if ($action == 'deleteUsers') {
            $command = new AdHocCommand('delete from users where lastlogin is null or lastlogin < @startDate');
            $command->AddParameter(new Parameter(ParameterNames::START_DATE, $date));

            ServiceLocator::GetDatabase()->Execute($command);
        }
    }

    private function ProcessDataRequest()
    {
        $dr = $this->GetDataRequest();
        Log::Debug('Processing data request %s', $dr);

        $date = $this->GetDate();
        if ($dr == 'getReservationCount') {
            $command = new AdHocCommand('select count(1) as count from reservation_instances ri inner join reservation_series rs on ri.series_id = rs.series_id where rs.status_id <> 2 and ri.start_date < @startDate');
            $command->AddParameter(new Parameter(ParameterNames::START_DATE, $date));

            $reservationsReader = ServiceLocator::GetDatabase()->Query($command);
            if ($row = $reservationsReader->GetRow()) {
                $this->SetJson(array('count' => $row['count']));
            }
            $reservationsReader->Free();
        }
        if ($dr == 'getBlackoutCount') {
            $command = new AdHocCommand('select count(1) as count from blackout_instances bi inner join blackout_series bs on bi.blackout_series_id = bs.blackout_series_id where bi.start_date < @startDate');
            $command->AddParameter(new Parameter(ParameterNames::START_DATE, $date));

            $reservationsReader = ServiceLocator::GetDatabase()->Query($command);
            if ($row = $reservationsReader->GetRow()) {
                $this->SetJson(array('count' => $row['count']));
            }
            $reservationsReader->Free();
        }
        if ($dr == 'getUserCount') {
            $command = new AdHocCommand('select count(1) as count from users where lastlogin is null or lastlogin < @startDate');
            $command->AddParameter(new Parameter(ParameterNames::START_DATE, $date));

            $reservationsReader = ServiceLocator::GetDatabase()->Query($command);
            if ($row = $reservationsReader->GetRow()) {
                $this->SetJson(array('count' => $row['count']));
            }
            $reservationsReader->Free();
        }
    }

    /**
     * @return string
     */
    private function GetDate()
    {
        $queryDate = $this->GetQuerystring('date');
        $postDate = $this->GetForm(FormKeys::BEGIN_DATE);

        $parsedDate = !empty($queryDate) ? $queryDate : $postDate;

        $date = Date::Parse($parsedDate, ServiceLocator::GetServer()->GetUserSession()->Timezone)->ToDatabase();
        return $date;
    }
}