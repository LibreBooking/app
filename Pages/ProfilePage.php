<?php
require_once(ROOT_DIR . 'config/timezones.php');
require_once(ROOT_DIR . 'Pages/SecurePage.php');
require_once(ROOT_DIR . 'Domain/Access/namespace.php');
require_once(ROOT_DIR . 'lib/Config/namespace.php');
require_once(ROOT_DIR . 'lib/Common/namespace.php');

interface IProfilePage
{

	public function SetFirstName($firstName);

	public function SetLastName($lastName);

	public function SetEmail($email);
	
	public function SetUsername($username);

	public function SetTimezone($timezoneName);

	public function SetHomepage($homepageId);

	public function SetTimezones($timezoneValues, $timezoneOutput);

	public function SetHomepages($homepageValues, $homepageOutput);
}

class ProfilePage extends SecurePage implements IProfilePage
{
	/**
	 * @var \ProfilePresenter
	 */
	private $presenter;
	
	public function __construct()
	{
	    parent::__construct('EditProfile');
		$this->presenter = new ProfilePresenter($this, new UserRepository());
	}

	public function PageLoad()
	{
		$this->presenter->PageLoad();
		$this->Display('profile.tpl');
	}

	public function SetFirstName($firstName)
	{
		$this->Set('FirstName', $firstName);
	}

	public function SetEmail($email)
	{
		$this->Set('Email', $email);
	}

	public function SetHomepage($homepageId)
	{
		$this->Set('Homepage', $homepageId);
	}

	public function SetLastName($lastName)
	{
		$this->Set('LastName', $lastName);
	}

	public function SetTimezone($timezoneName)
	{
		$this->Set('Timezone', $timezoneName);
	}


	public function SetHomepages($homepageValues, $homepageOutput)
	{
		$this->Set('HomepageValues', $homepageValues);
		$this->Set('HomepageOutput', $homepageOutput);
	}

	public function SetTimezones($timezoneValues, $timezoneOutput)
	{
		$this->Set('TimezoneValues', $timezoneValues);
		$this->Set('TimezoneOutput', $timezoneOutput);
	}

	public function SetUsername($username)
	{
		$this->Set('Username', $username);
	}
}

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
		$this->PopulateTimezones();
		$this->PopulateHomepages();

		$userSession = ServiceLocator::GetServer()->GetUserSession();
		$user = $this->userRepository->LoadById($userSession->UserId);

		$this->page->SetFirstName($user->FirstName());
		$this->page->SetLastName($user->LastName());
		$this->page->SetEmail($user->EmailAddress());
		$this->page->SetTimezone($user->Timezone());
		$this->page->SetHomepage($user->Homepage());
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
}
