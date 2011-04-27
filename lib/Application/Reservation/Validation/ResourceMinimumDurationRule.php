<?php
class ResourceMinimumDurationRule implements IReservationValidationRule
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
			
			if ($resource->HasMinLength())
			{
				$minDuration = $resource->GetMinLength()->Interval();
				$start = $reservationSeries->CurrentInstance()->StartDate();
				$end = $reservationSeries->CurrentInstance()->EndDate();
				
				$minEnd = $start->ApplyDifference($minDuration);
				if ($end->LessThan($minEnd))
				{
					return new ReservationRuleResult(false,
						$resources->GetString("MinDurationError", $minDuration));
				}
			}
		}
		
		return new ReservationRuleResult();
	}
}
?>