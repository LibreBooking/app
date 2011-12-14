<?php
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
	 * @param $announcements AnnouncementDto[]
	 * @return void
	 */
	public function BindAnnouncements($announcements);
}

class ManageAnnouncementsPage extends AdminPage implements IManageAnnouncementsPage
{
	/**
	 * @var ManageAnnouncementsPresenter
	 */
	private $presenter;

	public function __construct()
	{
		parent::__construct('ManageAnnouncements');
		$this->presenter = new ManageAnnouncementsPresenter($this, new AnnouncementRepository());
	}

	public function PageLoad()
	{
		$this->presenter->PageLoad();

		$this->Display('manage_Announcements.tpl');
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


}

?>