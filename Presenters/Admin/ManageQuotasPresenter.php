<?php
/**
 * Copyright 2011-2019 Nick Korbel
 *
 * This file is part of Booked Scheduler.
 *
 * Booked Scheduler is free software: you can redistribute it and/or modify
 * it under the terms of the GNU General Public License as published by
 * the Free Software Foundation, either version 3 of the License, or
 * (at your option) any later version.
 *
 * Booked Scheduler is distributed in the hope that it will be useful,
 * but WITHOUT ANY WARRANTY; without even the implied warranty of
 * MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
 * GNU General Public License for more details.
 *
 * You should have received a copy of the GNU General Public License
 * along with Booked Scheduler.  If not, see <http://www.gnu.org/licenses/>.
 */

require_once(ROOT_DIR . 'Domain/Access/namespace.php');
require_once(ROOT_DIR . 'Presenters/ActionPresenter.php');
require_once(ROOT_DIR . 'lib/Application/Authentication/namespace.php');

class ManageQuotasActions
{
	const AddQuota = 'addQuota';
	const DeleteQuota = 'deleteQuota';
}

class ManageQuotasPresenter extends ActionPresenter
{
	/**
	 * @var IManageQuotasPage
	 */
	private $page;

	/**
	 * @var IResourceRepository
	 */
	private $resourceRepository;

	/**
	 * @var IGroupViewRepository
	 */
	private $groupRepository;

	/**
	 * @var \IQuotaViewRepository
	 */
	private $quotaRepository;

	/**
	 * @param IManageQuotasPage $page
	 * @param IResourceRepository $resourceRepository
	 * @param IGroupViewRepository $groupRepository
	 * @param IScheduleRepository $scheduleRepository
	 * @param IQuotaViewRepository|IQuotaRepository $quotaRepository
	 */
	public function __construct(IManageQuotasPage $page,
								IResourceRepository $resourceRepository,
								IGroupViewRepository $groupRepository,
								IScheduleRepository $scheduleRepository,
								IQuotaViewRepository $quotaRepository)
	{
		parent::__construct($page);

		$this->page = $page;
		$this->resourceRepository = $resourceRepository;
		$this->groupRepository = $groupRepository;
		$this->scheduleRepository = $scheduleRepository;
		$this->quotaRepository = $quotaRepository;

		$this->AddAction(ManageQuotasActions::AddQuota, 'AddQuota');
		$this->AddAction(ManageQuotasActions::DeleteQuota, 'DeleteQuota');
	}

	public function PageLoad()
	{
		$resources = $this->resourceRepository->GetResourceList();
		$groups = $this->groupRepository->GetList()->Results();
		$schedules = $this->scheduleRepository->GetAll();

		$this->page->BindResources($resources);
		$this->page->BindGroups($groups);
		$this->page->BindSchedules($schedules);

		$quotas = $this->quotaRepository->GetAll();
		$this->page->BindQuotas($quotas);
	}

	public function AddQuota()
	{
		$duration = $this->page->GetDuration();
		$decimal = $this->page->GetLimit();
		$unit = $this->page->GetUnit();
		$resourceId = $this->page->GetResourceId();
		$groupId = $this->page->GetGroupId();
		$scheduleId = $this->page->GetScheduleId();
		$allDay = $this->page->GetEnforcedAllDay();
		$startTime = $this->page->GetEnforcedStartTime();
		$endTime = $this->page->GetEnforcedEndTime();
		$everyDay = $this->page->GetEnforcedEveryDay();
		$enforcedDays = $this->page->GetEnforcedDays();
		$scope = $this->page->GetScope();

		if ($allDay)
		{
			$startTime = null;
			$endTime = null;
		}

		if ($everyDay)
		{
			$enforcedDays = array();
		}

		Log::Debug('Adding new quota. Duration %s, Limit %s, Unit %s, Resource %s, Group %s, Schedule %s, All Day %s, Start Time %s, End Time %s, Every Day %s, Days %s, Scope %s',
				   $duration,
				   $decimal,
				   $unit,
				   $resourceId,
				   $groupId,
				   $scheduleId,
				   $allDay,
				   $startTime,
				   $endTime,
				   $everyDay,
				   implode(',', $enforcedDays),
				   $scope);

		$quota = Quota::Create($duration,
							   $decimal,
							   $unit,
							   $resourceId,
							   $groupId,
							   $scheduleId,
							   $startTime,
							   $endTime,
							   $enforcedDays,
							   $scope);

		$this->quotaRepository->Add($quota);
	}

	public function DeleteQuota()
	{
		$quotaId = $this->page->GetQuotaId();
		Log::Debug('Deleting quota %s', $quotaId);

		$this->quotaRepository->DeleteById($quotaId);
	}

}

