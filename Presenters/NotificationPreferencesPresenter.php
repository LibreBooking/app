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
		}

	}

	private function UpdateProfile(User $user)
	{

	}

}

?>