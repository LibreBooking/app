<?php
class ResourceMaximumDurationRule implements IReservationValidationRule
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
			
			if ($resource->HasMaxLength())
			{
				$maxDuration = $resource->GetMaxLength()->Interval();
				$start = $reservationSeries->CurrentInstance()->StartDate();
				$end = $reservationSeries->CurrentInstance()->EndDate();
				
				$maxEnd = $start->ApplyDifference($maxDuration);
				if ($end->GreaterThan($maxEnd))
				{
					return new ReservationRuleResult(false,
						$resources->GetString("MaxDurationError", $maxDuration));
				}
			}
		}
		
		return new ReservationRuleResult();
	}
}
?>