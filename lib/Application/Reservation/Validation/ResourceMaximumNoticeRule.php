<?php
class ResourceMaximumNoticeRule implements IReservationValidationRule
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
			if ($resource->HasMaxNotice())
			{
				$maxStartDate = Date::Now()->ApplyDifference($resource->GetMaxNotice()->Interval());
		
				/* @var $instance Reservation */
				foreach ($reservationSeries->Instances() as $instance)
				{
					if ($instance->StartDate()->GreaterThan($maxStartDate))
					{
						return new ReservationRuleResult(false, 
							$r->GetString("MaxNoticeError", $maxStartDate->Format($r->GeneralDateTimeFormat())));
					}
				}
			}
		}
		
		return new ReservationRuleResult();
	}
}
?>