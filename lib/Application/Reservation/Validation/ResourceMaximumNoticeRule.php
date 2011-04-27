<?php
class ResourceMaximumNoticeRule implements IReservationValidationRule
{
	/**
	 * @var IResourceRepository
	 */
	private $resourceRepository;
	
	public function __construct(IResourceRepository $resourceRepository)
	{
		$this->resourceRepository = $resourceRepository;
	}
	
	/**
	 * @see IReservationValidationRule::Validate()
	 * 
	 * @param ReservationSeries $reservationSeries
	 * @return ReservationRuleResult
	 */
	public function Validate($reservationSeries)
	{
		$resources = Resources::GetInstance();
		
		$resourceIds = $reservationSeries->AllResources();
		
		foreach ($resourceIds as $resourceId)
		{
			$resource = $this->resourceRepository->LoadById($resourceId);
			
			if ($resource->HasMaxNotice())
			{
				$maxStartDate = Date::Now()->ApplyDifference($resource->GetMaxNotice()->Interval());
		
				/* @var $instance Reservation */
				foreach ($reservationSeries->Instances() as $instance)
				{
					if ($instance->StartDate()->GreaterThan($maxStartDate))
					{
						return new ReservationRuleResult(false, 
							$resources->GetString("MaxNoticeError", $maxStartDate->Format($resources->GeneralDateTimeFormat())));
					}
				}
			}
		}
		
		return new ReservationRuleResult();
	}
}
?>