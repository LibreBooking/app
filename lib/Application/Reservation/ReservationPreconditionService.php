<?php 
require_once(ROOT_DIR . 'Domain/namespace.php');
require_once(ROOT_DIR . 'Pages/NewReservationPage.php');

class NewReservationPreconditionService implements INewReservationPreconditionService
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
	 * @see INewReservationPreconditionService::CheckAll()
	 */
	public function CheckAll(INewReservationPage $page, UserSession $user)
	{
		$requestedResourceId = $page->GetRequestedResourceId();
		$requestedScheduleId = $page->GetRequestedScheduleId();

		if (empty($requestedResourceId))
		{
			$page->RedirectToError(ErrorMessages::MISSING_RESOURCE, $page->GetLastPage());
			return;
		}
		
		if (empty($requestedScheduleId))
		{
			$page->RedirectToError(ErrorMessages::MISSING_SCHEDULE, $page->GetLastPage());
			return;
		}
		
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

class EditReservationPreconditionService
{
	public function CheckAll(IExistingReservationPage $page, UserSession $user, ReservationView $reservationView)
	{
		// TODO: Handle if reservation is not found
	}
}

abstract class ReservationPreconditionService implements IReservationPreconditionService
{
}
?>