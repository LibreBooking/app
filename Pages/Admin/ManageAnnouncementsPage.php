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

require_once(ROOT_DIR . 'Pages/Admin/AdminPage.php');
require_once(ROOT_DIR . 'Presenters/Admin/ManageAnnouncementsPresenter.php');

interface IManageAnnouncementsPage extends IActionPage
{
	/**
	 * @return int
	 */
	public function GetAnnouncementId();

    /**
     * @return string
     */
    public function GetText();

    /**
     * @return string
     */
    public function GetStart();

    /**
     * @return string
     */
    public function GetEnd();

    /**
     * @return string
     */
    public function GetPriority();

	/**
	 * @return int[]
	 */
	public function GetGroups();

	/**
	 * @return int[]
	 */
	public function GetResources();

	/**
	 * @return bool
	 */
	public function GetSendAsEmail();

	/**
	 * @param $announcements Announcement[]
	 * @return void
	 */
	public function BindAnnouncements($announcements);

	/**
	 * @param GroupItemView[] $groups
	 */
	public function BindGroups($groups);

	/**
	 * @param BookableResource[] $resources
	 */
	public function BindResources($resources);

	/**
	 * @param int $number
	 */
	public function BindNumberOfUsersToBeSent($number);

    /**
     * @return int
     */
    public function GetDisplayPage();
}

class ManageAnnouncementsPage extends ActionPage implements IManageAnnouncementsPage
{
	/**
	 * @var ManageAnnouncementsPresenter
	 */
	private $presenter;

	public function __construct()
	{
		parent::__construct('ManageAnnouncements', 1);
		$resourceRepository = new ResourceRepository();
		$this->presenter = new ManageAnnouncementsPresenter(
			$this,
			new AnnouncementRepository(),
			new GroupRepository(),
			$resourceRepository,
			PluginManager::Instance()->LoadPermission(),
			new UserRepository()
			);
	}

	public function ProcessPageLoad()
	{
		$this->presenter->PageLoad();

        $this->Set('priorities', range(1,10));
        $this->Set('timezone', ServiceLocator::GetServer()->GetUserSession()->Timezone);

		$this->Display('Admin/manage_announcements.tpl');
	}

	public function BindAnnouncements($announcements)
	{
		$this->Set('announcements', $announcements);
	}

	public function ProcessAction()
	{
		$this->presenter->ProcessAction();
	}

	public function GetAnnouncementId()
	{
		return $this->GetQuerystring(QueryStringKeys::ANNOUNCEMENT_ID);
	}

    public function GetText()
    {
        return $this->GetForm(FormKeys::ANNOUNCEMENT_TEXT);
    }

    public function GetStart()
    {
        return $this->GetForm(FormKeys::ANNOUNCEMENT_START);
    }

    public function GetEnd()
    {
        return $this->GetForm(FormKeys::ANNOUNCEMENT_END);
    }

    public function GetPriority()
    {
        return $this->GetForm(FormKeys::ANNOUNCEMENT_PRIORITY);
    }

	public function ProcessDataRequest($dataRequest)
	{
		$this->presenter->ProcessDataRequest($dataRequest);
	}

	public function BindGroups($groups)
	{
		$this->Set('Groups', $groups);
	}

	public function BindResources($resources)
	{
		$this->Set('Resources', $resources);
	}

	public function BindNumberOfUsersToBeSent($number)
	{
		$this->SetJson(array('users' => $number));
	}
	public function GetGroups()
	{
		$groupIds = $this->GetForm(FormKeys::GROUP_ID);

		if (!is_array($groupIds))
		{
			return array();
		}

		return $groupIds;
	}

	public function GetResources()
	{
		$resourceIds = $this->GetForm(FormKeys::RESOURCE_ID);

		if (!is_array($resourceIds))
		{
			return array();
		}

		return $resourceIds;
	}

	public function GetSendAsEmail()
	{
		$send = $this->GetForm(FormKeys::SEND_AS_EMAIL);

		return isset($send);
	}

    public function GetDisplayPage()
    {
        return $this->GetForm(FormKeys::DISPLAY_PAGE);
    }
}