<?php
/**
Copyright 2011-2019 Nick Korbel

This file is part of Booked Scheduler.

Booked Scheduler is free software: you can redistribute it and/or modify
it under the terms of the GNU General Public License as published by
the Free Software Foundation, either version 3 of the License, or
(at your option) any later version.

Booked Scheduler is distributed in the hope that it will be useful,
but WITHOUT ANY WARRANTY; without even the implied warranty of
MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
GNU General Public License for more details.

You should have received a copy of the GNU General Public License
along with Booked Scheduler.  If not, see <http://www.gnu.org/licenses/>.
 */

require_once(ROOT_DIR . 'Domain/namespace.php');
require_once(ROOT_DIR . 'Domain/Access/namespace.php');
require_once(ROOT_DIR . 'Presenters/ActionPresenter.php');
require_once(ROOT_DIR . 'Pages/Admin/ManageResourceStatusPage.php');

class ManageResourceStatusActions
{
	const Add = 'Add';
	const Update = 'Update';
	const Delete = 'Delete';
}

class ManageResourceStatusPresenter extends ActionPresenter
{
	/**
	 * @var IManageResourceStatusPage
	 */
	private $page;

	/**
	 * @var IResourceRepository
	 */
	private $resourceRepository;

	public function __construct(
		IManageResourceStatusPage $page,
		UserSession $user,
		IResourceRepository $resourceRepository)
	{
		parent::__construct($page);

		$this->page = $page;
		$this->resourceRepository = $resourceRepository;

		$this->AddAction(ManageResourceStatusActions::Add, 'Add');
		$this->AddAction(ManageResourceStatusActions::Update, 'Update');
		$this->AddAction(ManageResourceStatusActions::Delete, 'Delete');
	}

	public function PageLoad()
	{
		$statusReasons = $this->resourceRepository->GetStatusReasons();
		$statusReasonList = array();

		foreach ($statusReasons as $reason)
		{
			$statusReasonList[$reason->StatusId()][] = $reason;
		}
		$this->page->BindResourceStatusReasons($statusReasonList);
	}

	public function Add()
	{
		$statusId = $this->page->GetStatusId();
		$description = $this->page->GetDescription();

		$this->resourceRepository->AddStatusReason($statusId, $description);
	}

	public function Update()
	{
		$reasonId = $this->page->GetReasonId();
		$description = $this->page->GetDescription();

		$this->resourceRepository->UpdateStatusReason($reasonId, $description);
	}

	public function Delete()
	{
		$reasonId = $this->page->GetReasonId();
		$this->resourceRepository->RemoveStatusReason($reasonId);
	}
}