<?php
class ResourceMinimumDurationRule implements IReservationValidationRule
{
	/**
	 * @see IReservationValidationRule::Validate()
	 * 
	 * @param ReservationSeries $reservationSeries
	 * @return ReservationRuleResult
	 */
	public function Validate($reservationSeries)
	{
		$r = Resources::GetInstance();
		
		$resources = $reservationSeries->AllResources();
		
		foreach ($resources as $resource)
		{
			if ($resource->HasMinLength())
			{
				$minDuration = $resource->GetMinLength()->Interval();
				$start = $reservationSeries->CurrentInstance()->StartDate();
				$end = $reservationSeries->CurrentInstance()->EndDate();
				
				$minEnd = $start->ApplyDifference($minDuration);
				if ($end->LessThan($minEnd))
				{
					return new ReservationRuleResult(false,
						$r->GetString("MinDurationError", $minDuration));
				}
			}
		}
		
		return new ReservationRuleResult();
	}
}
?>