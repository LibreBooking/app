<?php
/**
Copyright 2017-2020 Nick Korbel

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
require_once(ROOT_DIR . 'Pages/SecurePage.php');
require_once(ROOT_DIR . 'Domain/Access/namespace.php');
require_once(ROOT_DIR . 'lib/Application/Attributes/namespace.php');
require_once(ROOT_DIR . 'lib/Application/Reservation/namespace.php');

interface IUserDetailsPopupPage
{
	/**
	 * @return string
	 */
	public function GetUserId();

	/**
	 * @param bool $canView
	 */
	public function SetCanViewUser($canView);

	/**
	 * @param CustomAttribute[] $attributes
	 */
	public function BindAttributes($attributes);

	/**
	 * @param User $user
	 */
	public function BindUser($user);
}

class UserDetailsPopupPage extends Page implements IUserDetailsPopupPage
{
	public function __construct()
	{
		parent::__construct('', 1);
		$this->presenter = new UserDetailsPopupPresenter($this, new PrivacyFilter(), new UserRepository(), new AttributeService(new AttributeRepository()));
	}

	public function PageLoad()
	{
		$this->presenter->PageLoad(ServiceLocator::GetServer()->GetUserSession());
		$this->Display('Ajax/user_details.tpl');
	}

	public function SetCanViewUser($canView)
	{
		$this->Set('CanViewUser', $canView);
	}

	/**
	 * @return string
	 */
	public function GetUserId()
	{
		return $this->GetQuerystring(QueryStringKeys::USER_ID);
	}

	/**
	 * @param CustomAttribute[] $attributes
	 */
	public function BindAttributes($attributes)
	{
		$this->Set('Attributes', $attributes);
	}

	/**
	 * @param User $user
	 */
	public function BindUser($user)
	{
		$this->Set('User', $user);
	}
}

class UserDetailsPopupPresenter
{
	/**
	 * @var IUserDetailsPopupPage
	 */
	private $page;
	/**
	 * @var IPrivacyFilter
	 */
	private $privacyFilter;
	/**
	 * @var IUserRepository
	 */
	private $userRepository;
	/**
	 * @var IAttributeService
	 */
	private $attributeService;

	public function __construct(IUserDetailsPopupPage $page, IPrivacyFilter $privacyFilter, IUserRepository $userRepository, IAttributeService $attributeService)
	{
		$this->page = $page;
		$this->privacyFilter = $privacyFilter;
		$this->userRepository = $userRepository;
		$this->attributeService = $attributeService;
	}
	/**
	 * @param $currentUser UserSession
	 */
	public function PageLoad($currentUser)
	{
		$user = $this->userRepository->LoadById($this->page->GetUserId());

		if ($this->privacyFilter->CanViewUser($currentUser, null, $user->Id()))
		{
			$this->page->SetCanViewUser(true);
			$attributes = $this->attributeService->GetByCategory(CustomAttributeCategory::USER);
			$this->page->BindAttributes($attributes);
			$this->page->BindUser($user);
		}
		else
		{
			$this->page->SetCanViewUser(false);
		}
	}
}