<?php
require_once(ROOT_DIR . 'config/timezones.php');
require_once(ROOT_DIR . 'Pages/SecurePage.php');
require_once(ROOT_DIR . 'Domain/Access/namespace.php');
require_once(ROOT_DIR . 'lib/Config/namespace.php');
require_once(ROOT_DIR . 'lib/Common/namespace.php');

interface IProfilePage extends IPage
{
	public function SetFirstName($firstName);

	public function SetLastName($lastName);

	public function SetEmail($email);
	
	public function SetUsername($username);

	public function SetTimezone($timezoneName);

	public function SetHomepage($homepageId);

	public function SetTimezones($timezoneValues, $timezoneOutput);

	public function SetHomepages($homepageValues, $homepageOutput);

	public function SetProfileUpdated();

	public function GetFirstName();

	public function GetLastName();

	public function GetEmail();

	public function GetLoginName();

	public function GetTimezone();

	public function GetHomepage();

	public function GetPhone();

	public function GetOrganization();

	public function GetPosition();

	public function SetPhone($param1);

	public function SetOrganization($param1);

	public function SetPosition($param1);
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

	public function SetProfileUpdated()
	{
		$this->Set('ProfileUpdated', true);
	}

	public function GetEmail()
	{
		return $this->GetForm(FormKeys::EMAIL);
	}

	public function GetFirstName()
	{
		return $this->GetForm(FormKeys::FIRST_NAME);
	}

	public function GetLastName()
	{
		return $this->GetForm(FormKeys::LAST_NAME);
	}

	public function GetLoginName()
	{
		return $this->GetForm(FormKeys::USERNAME);
	}

	public function GetHomepage()
	{
		return $this->GetForm(FormKeys::DEFAULT_HOMEPAGE);
	}

	public function GetTimezone()
	{
		return $this->GetForm(FormKeys::TIMEZONE);
	}

	public function GetOrganization()
	{
		return $this->GetForm(FormKeys::ORGANIZATION);
	}

	public function GetPhone()
	{
		return $this->GetForm(FormKeys::PHONE);
	}

	public function GetPosition()
	{
		return $this->GetForm(FormKeys::POSITION);
	}

	public function SetOrganization($organization)
	{
		$this->Set('Organization', $organization);
	}

	public function SetPhone($phone)
	{
		$this->Set('Phone', $phone);
	}

	public function SetPosition($position)
	{
		$this->Set('Position', $position);
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