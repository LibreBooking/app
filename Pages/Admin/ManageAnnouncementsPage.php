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

require_once(ROOT_DIR . 'Pages/Admin/AdminPage.php');
require_once(ROOT_DIR . 'Presenters/Admin/ManageAnnouncementsPresenter.php');

interface IManageAnnouncementsPage extends IActionPage
{
	/**
	 * @abstract
	 * @return int
	 */
	public function GetAnnouncementId();

    /**
     * @abstract
     * @return string
     */
    public function GetText();

    /**
     * @abstract
     * @return string
     */
    public function GetStart();

    /**
     * @abstract
     * @return string
     */
    public function GetEnd();

    /**
     * @abstract
     * @return string
     */
    public function GetPriority();

	/**
	 * @abstract
	 * @param $announcements AnnouncementDto[]
	 * @return void
	 */
	public function BindAnnouncements($announcements);
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
		$this->presenter = new ManageAnnouncementsPresenter($this, new AnnouncementRepository());
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

	/**
	 * @return int
	 */
	public function GetAnnouncementId()
	{
		return $this->GetQuerystring(QueryStringKeys::ANNOUNCEMENT_ID);
	}

    /**
     * @return string
     */
    public function GetText()
    {
        return $this->GetForm(FormKeys::ANNOUNCEMENT_TEXT);
    }

    /**
     * @return string
     */
    public function GetStart()
    {
        return $this->GetForm(FormKeys::ANNOUNCEMENT_START);
    }

    /**
     * @return string
     */
    public function GetEnd()
    {
        return $this->GetForm(FormKeys::ANNOUNCEMENT_END);
    }

    /**
     * @return string
     */
    public function GetPriority()
    {
        return $this->GetForm(FormKeys::ANNOUNCEMENT_PRIORITY);
    }

	public function ProcessDataRequest($dataRequest)
	{
		// no-op
	}
}

?>