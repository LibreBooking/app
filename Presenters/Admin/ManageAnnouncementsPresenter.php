<?php
require_once(ROOT_DIR . 'Domain/Access/namespace.php');
require_once(ROOT_DIR . 'Presenters/ActionPresenter.php');

class ManageAnnouncementsActions
{
	const Add = 'addAnnouncement';
	const Change = 'changeAnnouncement';
	const Delete = 'deleteAnnouncement';
}

class ManageAnnouncementsPresenter extends ActionPresenter
{
	/**
	 * @var IManageAnnouncementsPage
	 */
	private $page;

	/**
	 * @var IAnnouncementRepository
	 */
	private $announcementRepository;

	/**
	 * @param IManageAnnouncementsPage $page
	 * @param IAnnouncementRepository $announcementRepository
	 */
	public function __construct(IManageAnnouncementsPage $page, IAnnouncementRepository $announcementRepository)
	{
		parent::__construct($page);

		$this->page = $page;
		$this->announcementRepository = $announcementRepository;

		$this->AddAction(ManageAnnouncementsActions::Add, 'AddAnnouncement');
		$this->AddAction(ManageAnnouncementsActions::Change, 'ChangeAnnouncement');
		$this->AddAction(ManageAnnouncementsActions::Delete, 'DeleteAnnouncement');
	}

	public function PageLoad()
	{
		$this->page->BindAnnouncements($this->announcementRepository->GetAll());
	}

	public function AddAnnouncement()
	{
        $user = ServiceLocator::GetServer()->GetUserSession();
		$text = $this->page->GetText();
		$start = Date::Parse($this->page->GetStart(), $user->Timezone);
		$end = Date::Parse($this->page->GetEnd(), $user->Timezone);
		$priority = $this->page->GetPriority();

		Log::Debug('Adding new Announcement');

		$this->announcementRepository->Add(Announcement::Create($text, $start, $end, $priority));
	}

	public function ChangeAnnouncement()
	{
		$id = $this->page->GetAnnouncementId();
		$name = $this->page->GetAnnouncementName();
		$quantity = $this->page->GetQuantityAvailable();
		
		Log::Debug('Changing Announcement with id %s to name %s and quantity %s', $id, $name, $quantity);

		$Announcement = $this->announcementRepository->LoadById($id);
		$Announcement->SetName($name);
		$Announcement->SetQuantityAvailable($quantity);
		
		$this->announcementRepository->Update($Announcement);
	}
	
	public function DeleteAnnouncement()
	{
		$id = $this->page->GetAnnouncementId();
		
		Log::Debug('Deleting Announcement with id %s', $id);

		$this->announcementRepository->Delete($id);
	}
}
?>