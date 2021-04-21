<?php

class ReservationCanBeCheckedOutRule implements IReservationValidationRule
{
	/**
	 * @param ExistingReservationSeries $reservationSeries
	 * @param null|ReservationRetryParameter[] $retryParameters
	 * @return ReservationRuleResult
	 */
	public function Validate($reservationSeries, $retryParameters)
	{
		$isOk = true;
		$atLeastOneReservationRequiresCheckIn = false;
		$tooEarly = Date::Now()->LessThan($reservationSeries->CurrentInstance()->StartDate());

		foreach ($reservationSeries->AllResources() as $resource)
		{
			if ($resource->IsCheckInEnabled())
			{
				$atLeastOneReservationRequiresCheckIn = true;
			}

			if ($tooEarly || !$reservationSeries->CurrentInstance()->IsCheckedIn())
			{
				$isOk = false;
				break;
			}
		}

		return new ReservationRuleResult($isOk && $atLeastOneReservationRequiresCheckIn, Resources::GetInstance()->GetString('ReservationCannotBeCheckedOutFrom'));
	}
}
