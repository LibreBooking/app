<?php
require_once(ROOT_DIR . 'lib/Application/Authorization/namespace.php');
require_once(ROOT_DIR . 'lib/Common/namespace.php');

class PermissionValidationRule implements IReservationValidationRule
{
	/**
	 * @var IPermissionServiceFactory
	 */
	private $permissionServiceFactory;

	public function __construct(IPermissionServiceFactory $permissionServiceFactory)
	{
		$this->permissionServiceFactory = $permissionServiceFactory;
	}

	/**
	 * @param ReservationSeries $reservation
	 * @return ReservationRuleResult
	 */
	public function Validate($reservation)
	{
		$reservation->UserId();
		
		$permissionService = $this->permissionServiceFactory->GetPermissionService();

		$resourceIds = $reservation->AllResourceIds();

		foreach ($resourceIds as $resourceId)
		{
			if (!$permissionService->CanAccessResource(new ReservationResource($resourceId), $reservation->BookedBy()))
			{
				return new ReservationRuleResult(false, Resources::GetInstance()->GetString('NoResourcePermission'));
			}
		}

		return new ReservationRuleResult(true);
	}
}
?>