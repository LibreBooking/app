<?php
/**
Copyright 2011-2015 Nick Korbel

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

require_once(ROOT_DIR . 'config/timezones.php');
require_once(ROOT_DIR . 'Pages/IPageable.php');
require_once(ROOT_DIR . 'Pages/Admin/AdminPage.php');
require_once(ROOT_DIR . 'Pages/Ajax/AutoCompletePage.php');
require_once(ROOT_DIR . 'Presenters/Admin/ManageUsersPresenter.php');
require_once(ROOT_DIR . 'Domain/Access/namespace.php');
require_once(ROOT_DIR . 'lib/Application/Attributes/namespace.php');

interface IManageUsersPage extends IPageable, IActionPage
{
	/**
	 * @abstract
	 * @param UserItemView[] $users
	 * @return void
	 */
	function BindUsers($users);

	/**
	 * @abstract
	 * @return int
	 */
	public function GetUserId();

	/**
	 * @abstract
	 * @param BookableResources[] $resources
	 * @return void
	 */
	public function BindResources($resources);

	/**
	 * @abstract
	 * @param mixed $objectToSerialize
	 * @return void
	 */
	public function SetJsonResponse($objectToSerialize);

	/**
	 * @abstract
	 * @return int[] resource ids the user has permission to
	 */
	public function GetAllowedResourceIds();

	/**
	 * @abstract
	 * @return string
	 */
	public function GetPassword();

	/**
	 * @abstract
	 * @return string
	 */
	public function GetEmail();

	/**
	 * @abstract
	 * @return string
	 */
	public function GetUserName();

	/**
	 * @abstract
	 * @return string
	 */
	public function GetFirstName();

	/**
	 * @abstract
	 * @return string
	 */
	public function GetLastName();

	/**
	 * @abstract
	 * @return string
	 */
	public function GetTimezone();

	/**
	 * @abstract
	 * @return string
	 */
	public function GetPhone();

	/**
	 * @abstract
	 * @return string
	 */
	public function GetPosition();

	/**
	 * @abstract
	 * @return string
	 */
	public function GetOrganization();

	/**
	 * @abstract
	 * @return string
	 */
	public function GetLanguage();

	/**
	 * @param $attributeList CustomAttribute[]
	 */
	public function BindAttributeList($attributeList);

	/**
	 * @return AttributeFormElement[]|array
	 */
	public function GetAttributes();

	/**
	 * @return AccountStatus|int
	 */
	public function GetFilterStatusId();

	/**
	 * @return int
	 */
	public function GetUserGroup();

	/**
	 * @param GroupItemView[] $groups
	 */
	public function BindGroups($groups);

	/**
	 * @return string
	 */
	public function GetReservationColor();
}


class ManageUsersPage extends ActionPage implements IManageUsersPage
{
	/**
	 * @var \ManageUsersPresenter
	 */
	protected $_presenter;

	/**
	 * @var \PageablePage
	 */
	protected $pageable;

	public function __construct()
	{
		$serviceFactory = new ManageUsersServiceFactory();

		parent::__construct('ManageUsers', 1);
		$groupRepository = new GroupRepository();
		$this->_presenter = new ManageUsersPresenter(
			$this,
			new UserRepository(),
			new ResourceRepository(),
			new PasswordEncryption(),
			$serviceFactory->CreateAdmin(),
			new AttributeService(new AttributeRepository()),
			$groupRepository,
			$groupRepository);

		$this->pageable = new PageablePage($this);
	}

	public function ProcessPageLoad()
	{
		$this->_presenter->PageLoad();

		$config = Configuration::Instance();
		$resources = Resources::GetInstance();
		$this->Set('statusDescriptions',
				   array(AccountStatus::ALL => $resources->GetString('All'), AccountStatus::ACTIVE => $resources->GetString('Active'), AccountStatus::AWAITING_ACTIVATION => $resources->GetString('Pending'), AccountStatus::INACTIVE => $resources->GetString('Inactive')));

		$this->Set('Timezone', $config->GetDefaultTimezone());
		$this->Set('Timezones', $GLOBALS['APP_TIMEZONES']);
		$this->Set('Languages', $GLOBALS['APP_TIMEZONES']);
		$this->Set('ManageGroupsUrl', Pages::MANAGE_GROUPS);
		$this->Set('ManageReservationsUrl', Pages::MANAGE_RESERVATIONS);
		$this->Set('FilterStatusId', $this->GetFilterStatusId());
		$this->Set('PerUserColors', $config->GetSectionKey(ConfigSection::SCHEDULE, ConfigKeys::SCHEDULE_PER_USER_COLORS, new BooleanConverter()));

		$this->RenderTemplate();
	}

	protected function RenderTemplate()
	{
		$this->Display('Admin/manage_users.tpl');
	}

	public function BindPageInfo(PageInfo $pageInfo)
	{
		$this->pageable->BindPageInfo($pageInfo);
	}

	public function GetPageNumber()
	{
		return $this->pageable->GetPageNumber();
	}

	public function GetPageSize()
	{
		return $this->pageable->GetPageSize();
	}

	public function BindUsers($users)
	{
		$this->Set('users', $users);
	}

	public function ProcessAction()
	{
		$this->_presenter->ProcessAction();
	}

	public function ProcessDataRequest($dataRequest)
	{
		$this->_presenter->ProcessDataRequest($dataRequest);
	}

	/**
	 * @return int
	 */
	public function GetUserId()
	{
		return $this->GetQuerystring(QueryStringKeys::USER_ID);
	}

	/**
	 * @param BookableResource[] $resources
	 * @return void
	 */
	public function BindResources($resources)
	{
		$this->Set('resources', $resources);
	}

	/**
	 * @return int[] resource ids the user has permission to
	 */
	public function GetAllowedResourceIds()
	{
		return $this->GetForm(FormKeys::RESOURCE_ID);
	}

	/**
	 * @return string
	 */
	public function GetPassword()
	{
		return $this->GetForm(FormKeys::PASSWORD);
	}

	/**
	 * @param mixed $objectToSerialize
	 * @return void
	 */
	public function SetJsonResponse($objectToSerialize)
	{
		parent::SetJson($objectToSerialize);
	}

	/**
	 * @return string
	 */
	public function GetEmail()
	{
		return $this->GetForm(FormKeys::EMAIL);
	}

	/**
	 * @return string
	 */
	public function GetUserName()
	{
		return $this->GetForm(FormKeys::USERNAME);
	}

	public function GetFirstName()
	{
		return $this->GetForm(FormKeys::FIRST_NAME);
	}

	public function GetLastName()
	{
		return $this->GetForm(FormKeys::LAST_NAME);
	}

	public function GetTimezone()
	{
		return $this->GetForm(FormKeys::TIMEZONE);
	}

	public function GetPhone()
	{
		return $this->GetForm(FormKeys::PHONE);
	}

	public function GetPosition()
	{
		return $this->GetForm(FormKeys::POSITION);
	}

	public function GetOrganization()
	{
		return $this->GetForm(FormKeys::ORGANIZATION);
	}

	public function GetLanguage()
	{
		return $this->GetForm(FormKeys::LANGUAGE);
	}

	public function BindAttributeList($attributeList)
	{
		$this->Set('AttributeList', $attributeList);
	}

	public function GetAttributes()
	{
		return AttributeFormParser::GetAttributes($this->GetForm(FormKeys::ATTRIBUTE_PREFIX));
	}

	/**
	 * @return AccountStatus|int
	 */
	public function GetFilterStatusId()
	{
		$statusId = $this->GetQuerystring(QueryStringKeys::ACCOUNT_STATUS);
		return empty($statusId) ? AccountStatus::ALL : $statusId;
	}

	/**
	 * @return int
	 */
	public function GetUserGroup()
	{
		return $this->GetForm(FormKeys::GROUP_ID);
	}

	/**
	 * @param GroupItemView[] $groups
	 */
	public function BindGroups($groups)
	{
		$this->Set('Groups', $groups);
	}

	/**
	 * @return string
	 */
	public function GetReservationColor()
	{
		return $this->GetForm(FormKeys::RESERVATION_COLOR);
	}
}