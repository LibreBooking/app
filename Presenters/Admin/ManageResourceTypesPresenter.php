<?php
/**
Copyright 2011-2013 Nick Korbel

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

require_once(ROOT_DIR . 'Domain/namespace.php');
require_once(ROOT_DIR . 'Domain/Access/namespace.php');
require_once(ROOT_DIR . 'Presenters/ActionPresenter.php');
require_once(ROOT_DIR . 'Pages/Admin/ManageResourceTypesPage.php');

class ManageResourceTypesActions
{
	const Add = 'Add';
}

class ManageResourceTypesPresenter extends ActionPresenter
{
	/**
	 * @var IManageResourceTypesPage
	 */
	private $page;

	/**
	 * @var IResourceRepository
	 */
	private $resourceRepository;

	public function __construct(
		IManageResourceTypesPage $page,
		UserSession $user,
		IResourceRepository $resourceRepository)
	{
		parent::__construct($page);

		$this->page = $page;
		$this->resourceRepository = $resourceRepository;

		$this->AddAction(ManageResourceTypesActions::Add, 'AddResource');
	}

	public function PageLoad()
	{
		$types = $this->resourceRepository->GetResourceTypes();

		$this->page->BindResourceTypes($types);
	}
}

?>