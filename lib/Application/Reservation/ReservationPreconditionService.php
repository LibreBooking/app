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
			$page->RedirectToError(ErrorMessages::MISSING_RESOURCE);
			return;
		}
		
		if (empty($requestedScheduleId))
		{
			$page->RedirectToError(ErrorMessages::MISSING_SCHEDULE);
			return;
		}
		
		if (!$this->UserHasPermission($user, $requestedResourceId))
		{
			$page->RedirectToError(ErrorMessages::INSUFFICIENT_PERMISSIONS);
			return;
		}
	}
	
	private function UserHasPermission(UserSession $user, $resourceId)
	{
		$permissionService = $this->_permissionServiceFactory->GetPermissionService();
		return $permissionService->CanAccessResource(new ReservationResource($resourceId), $user);
	}
}

class EditReservationPreconditionService
{
	public function CheckAll(IExistingReservationPage $page, UserSession $user, ReservationView $reservationView)
	{
		if (!$reservationView->IsDisplayable())
		{
			$page->RedirectToError(ErrorMessages::RESERVATION_NOT_FOUND);
			return;
		}
	}
}

abstract class ReservationPreconditionService implements IReservationPreconditionService
{
}
?>