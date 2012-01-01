<?php
/**
Copyright 2011-2012 Nick Korbel

This file is part of phpScheduleIt.

phpScheduleIt is free software: you can redistribute it and/or modify
it under the terms of the GNU General Public License as published by
the Free Software Foundation, either version 3 of the License, or
(at your option) any later version.

phpScheduleIt is distributed in the hope that it will be useful,
but WITHOUT ANY WARRANTY; without even the implied warranty of
MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
GNU General Public License for more details.

You should have received a copy of the GNU General Public License
along with phpScheduleIt.  If not, see <http://www.gnu.org/licenses/>.
*/

require_once(ROOT_DIR . 'Pages/Admin/ManageBlackoutsPage.php');
require_once(ROOT_DIR . 'Domain/Access/namespace.php');
require_once(ROOT_DIR . 'Presenters/ActionPresenter.php');
require_once(ROOT_DIR . 'lib/Application/Reservation/namespace.php');

class ManageBlackoutsActions
{
	const ADD = 'add';
	const DELETE = 'delete';
}

class ManageBlackoutsPresenter extends ActionPresenter
{
	/**
	 * @var IManageBlackoutsPage
	 */
	private $page;

	/**
	 * @var IManageBlackoutsService
	 */
	private $manageBlackoutsService;

	/**
	 * @var IScheduleRepository
	 */
	private $scheduleRepository;

	/**
	 * @var IResourceRepository
	 */
	private $resourceRepository;

	public function __construct(
		IManageBlackoutsPage $page,
		IManageBlackoutsService $manageBlackoutsService,
		IScheduleRepository $scheduleRepository,
		IResourceRepository $resourceRepository)
	{
		parent::__construct($page);

		$this->page = $page;
		$this->manageBlackoutsService = $manageBlackoutsService;
		$this->scheduleRepository = $scheduleRepository;
		$this->resourceRepository = $resourceRepository;

		$this->AddAction(ManageBlackoutsActions::ADD, 'AddBlackout');
		$this->AddAction(ManageBlackoutsActions::DELETE, 'DeleteBlackout');
	}

	public function PageLoad($userTimezone)
	{
		$session = ServiceLocator::GetServer()->GetUserSession();

		$this->page->BindSchedules($this->scheduleRepository->GetAll());
		$this->page->BindResources($this->resourceRepository->GetResourceList());

		$startDateString = $this->page->GetStartDate();
		$endDateString = $this->page->GetEndDate();

		$startDate = $this->GetDate($startDateString, $userTimezone, -7);
		$endDate = $this->GetDate($endDateString, $userTimezone, 7);
		$scheduleId = $this->page->GetScheduleId();
		$resourceId = $this->page->GetResourceId();

		$this->page->SetStartDate($startDate);
		$this->page->SetEndDate($endDate);
		$this->page->SetScheduleId($scheduleId);
		$this->page->SetResourceId($resourceId);

		$filter = new BlackoutFilter($startDate, $endDate, $scheduleId, $resourceId);

		$blackouts = $this->manageBlackoutsService->LoadFiltered($this->page->GetPageNumber(),
																 $this->page->GetPageSize(),
																 $filter,
																 $session);

		$this->page->BindBlackouts($blackouts->Results());
		$this->page->BindPageInfo($blackouts->PageInfo());

		$this->page->ShowPage();
	}

	private function GetDate($dateString, $timezone, $defaultDays)
	{
		$date = null;
		if (is_null($dateString)) {
			$date = Date::Now()->AddDays($defaultDays)->ToTimezone($timezone)->GetDate();

		}
		elseif (!empty($dateString))
		{
			$date = Date::Parse($dateString, $timezone);
		}

		return $date;
	}

	public function AddBlackout()
	{
		$session = ServiceLocator::GetServer()->GetUserSession();

		$resourceIds = array();
		if ($this->page->GetApplyBlackoutToAllResources())
		{
			$scheduleId = $this->page->GetBlackoutScheduleId();
			$resources = $this->resourceRepository->GetScheduleResources($scheduleId);
			foreach ($resources as $resource)
			{
				$resourceIds[] = $resource->GetId();
			}
		}
		else
		{
			$resourceIds[] = $this->page->GetBlackoutResourceId();
		}

		$startDate = $this->page->GetBlackoutStartDate();
		$startTime = $this->page->GetBlackoutStartTime();
		$endDate = $this->page->GetBlackoutEndDate();
		$endTime = $this->page->GetBlackoutEndTime();

		$blackoutDate = DateRange::Create($startDate . ' ' . $startTime, $endDate . ' ' . $endTime, $session->Timezone);

		$title = $this->page->GetBlackoutTitle();
		$conflictAction = $this->page->GetBlackoutConflictAction();

		$result = $this->manageBlackoutsService->Add($blackoutDate, $resourceIds, $title, ReservationConflictResolution::Create($conflictAction));

		$this->page->ShowAddResult($result->WasSuccessful(), $result->Message(), $result->ConflictingReservations(), $result->ConflictingBlackouts(), $session->Timezone);
	}

    public function DeleteBlackout()
    {
        $id = $this->page->GetBlackoutId();

        Log::Debug('Deleting blackout with id %s', $id);

        $this->manageBlackoutsService->Delete($id);
    }

}

?>