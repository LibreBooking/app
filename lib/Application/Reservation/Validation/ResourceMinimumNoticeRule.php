<?php
class ResourceMinimumNoticeRule implements IReservationValidationRule
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
			if ($resource->HasMinNotice())
			{
				$minStartDate = Date::Now()->ApplyDifference($resource->GetMinNotice()->Interval());
		
				/* @var $instance Reservation */
				foreach ($reservationSeries->Instances() as $instance)
				{
					if ($instance->StartDate()->LessThan($minStartDate))
					{
						return new ReservationRuleResult(false, 
							$r->GetString("MinNoticeError", $minStartDate->Format($r->GeneralDateTimeFormat())));
					}
				}
			}
		}
		
		return new ReservationRuleResult();
	}
}
?>