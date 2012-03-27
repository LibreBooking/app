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

require_once(ROOT_DIR . 'config/timezones.php');
require_once(ROOT_DIR . 'Pages/IPageable.php');
require_once(ROOT_DIR . 'Pages/Admin/AdminPage.php');
require_once(ROOT_DIR . 'Pages/Ajax/AutoCompletePage.php');
require_once(ROOT_DIR . 'Presenters/Admin/ManageUsersPresenter.php');
require_once(ROOT_DIR . 'Domain/Access/namespace.php');

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
		parent::__construct('ManageUsers', 1);
		$this->_presenter = new ManageUsersPresenter(
			$this,
			new UserRepository(),
			new ResourceRepository(),
			new PasswordEncryption(),
            new Registration());

		$this->pageable = new PageablePage($this);
	}
	
	public function PageLoad()
	{
		$this->_presenter->PageLoad();

		$this->Set('statusDescriptions', array(AccountStatus::ACTIVE => 'Active', AccountStatus::AWAITING_ACTIVATION => 'Pending', AccountStatus::INACTIVE => 'Inactive'));

		$this->Set('Timezone', Configuration::Instance()->GetKey(ConfigKeys::SERVER_TIMEZONE));
		$this->Set('Timezones', $GLOBALS['APP_TIMEZONES']);
		$this->Set('Languages', $GLOBALS['APP_TIMEZONES']);
        $this->Set('ManageReservationsUrl', Pages::MANAGE_RESERVATIONS);

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

	public function ProcessDataRequest()
	{
		$this->_presenter->ProcessDataRequest();
	}

	/**
	 * @return int
	 */
	public function GetUserId()
	{
		return $this->GetQuerystring(QueryStringKeys::USER_ID);
	}

	/**
	 * @param BookableResources[] $resources
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
}
?>