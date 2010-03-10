<?php 
require_once(ROOT_DIR . 'lib/Domain/namespace.php');

class ReservationPreconditionService implements IReservationPreconditionService
{
	/**
	 * @var IPermissionServiceFactory
	 */
	private $_permissionServiceFactory;
	
	public function __construct(IPermissionServiceFactory $permissionServiceFactory)
	{
		$this->_permissionServiceFactory = $permissionServiceFactory;
	}
	
	/**
	 * @see IReservationPreconditionService::CheckAll()
	 */
	public function CheckAll(IReservationPage $page)
	{
		$user = ServiceLocator::GetServer()->GetUserSession();
		$requestedResourceId = $page->GetRequestedResourceId();
		
		if (!$this->UserHasPermission($user, $requestedResourceId))
		{
			$page->RedirectToError(ErrorMessages::INSUFFICIENT_PERMISSIONS, $page->GetLastPage());
			return;
		}
	}
	
	private function UserHasPermission(UserSession $user, $resourceId)
	{
		$permissionService = $this->_permissionServiceFactory->GetPermissionService($user->UserId);
		return $permissionService->CanAccessResource(new ReservationResource($resourceId));
	}
}
?>