<?php
/**
Copyright 2015 Nick Korbel

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

require_once(ROOT_DIR . 'Pages/Ajax/UserDetailsPopupPage.php');

class UserDetailsPopupPresenterTests extends TestBase
{
	/**
	 * @var UserDetailsPopupPresenter
	 */
	private $presenter;

	/**
	 * @var FakeUserDetailsPopupPage
	 */
	private $page;

	/**
	 * @var FakePrivacyFilter
	 */
	private $privacyFilter;

	/**
	 * @var FakeAttributeService
	 */
	private $attributeService;

	/**
	 * @var FakeUserRepository
	 */
	private $userRepository;

	public function setup()
	{
		parent::setup();

		$this->page = new FakeUserDetailsPopupPage();
		$this->privacyFilter = new FakePrivacyFilter();
		$this->userRepository = new FakeUserRepository();
		$this->attributeService = new FakeAttributeService();

		$this->presenter = new UserDetailsPopupPresenter($this->page, $this->privacyFilter, $this->userRepository, $this->attributeService);
	}

	public function testWhenUserCannotAccessDetails_ThenDoNotBindAnything()
	{
		$this->privacyFilter->_CanViewUser = false;

		$this->presenter->PageLoad($this->fakeUser);

		$this->assertFalse($this->page->_CanViewUser);
	}

	public function testWhenUserCannotAccessDetails_ThenBindUser()
	{
		$this->privacyFilter->_CanViewUser = true;

		$this->presenter->PageLoad($this->fakeUser);

		$this->assertTrue($this->page->_CanViewUser);
		$this->assertEquals($this->userRepository->_User, $this->page->_User);
	}
}

class FakeUserDetailsPopupPage implements IUserDetailsPopupPage
{
	/**
	 * @var bool
	 */
	public $_CanViewUser;

	/**
	 * @var User
	 */
	public $_User;

	/**
	 * @var CustomAttribute[]
	 */
	public $_Attributes;

	public function SetCanViewUser($canView)
	{
		$this->_CanViewUser = $canView;
	}

	public function GetUserId()
	{
		return '1';
	}

	/**
	 * @param CustomAttribute[] $attributes
	 */
	public function BindAttributes($attributes)
	{
		$this->_Attributes = $attributes;
	}

	/**
	 * @param User $user
	 */
	public function BindUser($user)
	{
		$this->_User = $user;
	}
}