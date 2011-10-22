<?php
require_once(ROOT_DIR . 'config/timezones.php');
require_once(ROOT_DIR . 'Domain/Access/namespace.php');
require_once(ROOT_DIR . 'lib/Config/namespace.php');
require_once(ROOT_DIR . 'lib/Common/namespace.php');

class ProfilePresenter
{
	/**
	 * @var \IProfilePage
	 */
	private $page;

	/**
	 * @var UserRepository
	 */
	private $userRepository;

	public function __construct(IProfilePage $page, IUserRepository $userRepository)
	{
		$this->page = $page;
		$this->userRepository = $userRepository;
	}

	public function PageLoad()
	{
		if ($this->page->IsPostBack())
		{
			$this->LoadValidators();
			$this->UpdateProfile();

			// reset after post back
			$this->page->SetTimezone($this->page->GetTimezone());
			$this->page->SetHomepage($this->page->GetHomepage());
		}
		else
		{
			$userSession = ServiceLocator::GetServer()->GetUserSession();

			Log::Debug('ProfilePresenter loading user %s', $userSession->UserId);

			$user = $this->userRepository->LoadById($userSession->UserId);

			$this->page->SetUsername($user->Username());
			$this->page->SetFirstName($user->FirstName());
			$this->page->SetLastName($user->LastName());
			$this->page->SetEmail($user->EmailAddress());
			$this->page->SetTimezone($user->Timezone());
			$this->page->SetHomepage($user->Homepage());

			$this->page->SetPhone($user->GetAttribute(UserAttribute::Phone));
			$this->page->SetOrganization($user->GetAttribute(UserAttribute::Organization));
			$this->page->SetPosition($user->GetAttribute(UserAttribute::Position));
		}

		$this->PopulateTimezones();
		$this->PopulateHomepages();
	}

	private function PopulateTimezones()
	{
		$timezoneValues = array();
		$timezoneOutput = array();

		foreach($GLOBALS['APP_TIMEZONES'] as $timezone)
		{
			$timezoneValues[] = $timezone;
			$timezoneOutput[] = $timezone;
		}

		$this->page->SetTimezones($timezoneValues, $timezoneOutput);
	}

	private function PopulateHomepages()
	{
		$homepageValues = array();
		$homepageOutput = array();

		$pages = Pages::GetAvailablePages();
		foreach($pages as $pageid => $page)
		{
			$homepageValues[] = $pageid;
			$homepageOutput[] = Resources::GetInstance()->GetString($page['name']);
		}

		$this->page->SetHomepages($homepageValues, $homepageOutput);
	}

	private function UpdateProfile()
	{
		if ($this->page->IsValid())
		{
			$userSession = ServiceLocator::GetServer()->GetUserSession();
			$user = $this->userRepository->LoadById($userSession->UserId);

			$user->ChangeName($this->page->GetFirstName(), $this->page->GetLastName());
			$user->ChangeEmailAddress($this->page->GetEmail());
			$user->ChangeUsername($this->page->GetLoginName());
			$user->ChangeDefaultHomePage($this->page->GetHomepage());
			$user->ChangeTimezone($this->page->GetTimezone());

			$user->ChangeAttributes($this->page->GetPhone(), $this->page->GetOrganization(), $this->page->GetPosition());

			$this->userRepository->Update($user);

			$this->page->SetProfileUpdated();
		}
	}

	private function LoadValidators()
	{
		$userId = ServiceLocator::GetServer()->GetUserSession()->UserId;
		$this->page->RegisterValidator('fname', new RequiredValidator($this->page->GetFirstName()));
		$this->page->RegisterValidator('username', new RequiredValidator($this->page->GetLoginName()));
		$this->page->RegisterValidator('lname', new RequiredValidator($this->page->GetLastName()));
		$this->page->RegisterValidator('emailformat', new EmailValidator($this->page->GetEmail()));
		$this->page->RegisterValidator('uniqueemail', new UniqueEmailValidator($this->page->GetEmail(), $userId));
		$this->page->RegisterValidator('uniqueusername', new UniqueUserNameValidator($this->page->GetLoginName(), $userId));
	}
}

?>