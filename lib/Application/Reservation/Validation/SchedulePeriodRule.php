<?php
/**
Copyright 2012 Nick Korbel

This file is part of phpScheduleIt.

phpScheduleIt is free software: you can redistribute it and/or modify
it under the terms of the GNU General Public License as published by
the Free Software Foundation, either version 3 of the License, or
(at your option) any later version.

phpScheduleIt is distributed in the hope that it will be useful,
but WITHOUT ANY WARRANTY; without even the implied warranty of
MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
GNU General Public License for more details.

You should have received a copy of the GNU General Public License
along with phpScheduleIt.  If not, see <http://www.gnu.org/licenses/>.
 */

class SchedulePeriodRule implements IReservationValidationRule
{
	/**
	 * @var IScheduleRepository
	 */
	private $repository;

	/**
	 * @var UserSession
	 */
	private $session;

	public function __construct(IScheduleRepository $repository, UserSession $session)
	{
		$this->repostiory = $repository;
		$this->session = $session;
	}

	/**
	 * @param ReservationSeries $reservationSeries
	 * @return ReservationRuleResult
	 */
	public function Validate($reservationSeries)
	{
		$layout = $this->repostiory->GetLayout($reservationSeries->Resource()->GetScheduleId(), new ScheduleLayoutFactory($this->session->Timezone));

		$startDate = $reservationSeries->CurrentInstance()->StartDate();
		$startPeriod = $layout->GetPeriod($startDate);
		$endDate = $reservationSeries->CurrentInstance()->EndDate();
		$endPeriod = $layout->GetPeriod($endDate);

		$errors = new StringBuilder();
		if ($startPeriod == null || !$startPeriod->IsReservable() || !$startPeriod->BeginDate()->Equals($startDate))
		{
			$errors->AppendLine(Resources::GetInstance()->GetString('InvalidStartSlot'));
		}

		if ($endPeriod == null || !$endPeriod->BeginDate()->Equals($endDate))
		{
			$errors->AppendLine(Resources::GetInstance()->GetString('InvalidEndSlot'));
		}

		$errorMessage = $errors->ToString();

		return new ReservationRuleResult(strlen($errorMessage) == 0, $errorMessage);
	}
}

?>