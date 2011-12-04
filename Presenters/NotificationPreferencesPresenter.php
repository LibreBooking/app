<?php
require_once(ROOT_DIR . 'lib/Application/Reservation/namespace.php');
require_once(ROOT_DIR . 'Domain/Access/namespace.php');
require_once(ROOT_DIR . 'lib/Common/namespace.php');

class NotificationPreferencesPresenter
{
	/**
	 * @var INotificationPreferencesPage
	 */
	private $page;

	/**
	 * @var UserRepository
	 */
	private $userRepository;

	public function __construct(INotificationPreferencesPage $page, IUserRepository $userRepository)
	{
		$this->page = $page;
		$this->userRepository = $userRepository;
	}

	public function PageLoad()
	{
        $userSession = ServiceLocator::GetServer()->GetUserSession();
        $user = $this->userRepository->LoadById($userSession->UserId);

        if ($this->page->IsPostBack())
		{
			$this->UpdateProfile($user);
			$this->page->SetPreferencesSaved(true);
		}

        $this->page->SetApproved($user->WantsEventEmail(new ReservationApprovedEvent()));
        $this->page->SetCreated($user->WantsEventEmail(new ReservationCreatedEvent()));
        $this->page->SetUpdated($user->WantsEventEmail(new ReservationUpdatedEvent()));
	}

	private function UpdateProfile(User $user)
	{
		Log::Debug("%s %s %s", $this->page->GetApproved(), $this->page->GetCreated(), $this->page->GetUpdated());

        $user->ChangeEmailPreference(new ReservationApprovedEvent(), $this->page->GetApproved());
        $user->ChangeEmailPreference(new ReservationCreatedEvent(), $this->page->GetCreated());
        $user->ChangeEmailPreference(new ReservationUpdatedEvent(), $this->page->GetUpdated());

        $this->userRepository->Update($user);
	}

}

?>