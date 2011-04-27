<?php
class ResourceMinimumNoticeRule implements IReservationValidationRule
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
			
			if ($resource->HasMinNotice())
			{
				$minStartDate = Date::Now()->ApplyDifference($resource->GetMinNotice()->Interval());
		
				/* @var $instance Reservation */
				foreach ($reservationSeries->Instances() as $instance)
				{
					if ($instance->StartDate()->LessThan($minStartDate))
					{
						return new ReservationRuleResult(false, 
							$resources->GetString("MinNoticeError", $minStartDate->Format($resources->GeneralDateTimeFormat())));
					}
				}
			}
		}
		
		return new ReservationRuleResult();
	}
}
?>