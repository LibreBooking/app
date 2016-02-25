<?php
/**
 * Copyright 2016 Nick Korbel
 *
 * This file is part of Booked Scheduler.
 *
 * Booked Scheduler is free software: you can redistribute it and/or modify
 * it under the terms of the GNU General Public License as published by
 * the Free Software Foundation, either version 3 of the License, or
 * (at your option) any later version.
 *
 * Booked Scheduler is distributed in the hope that it will be useful,
 * but WITHOUT ANY WARRANTY; without even the implied warranty of
 * MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
 * GNU General Public License for more details.
 *
 * You should have received a copy of the GNU General Public License
 * along with Booked Scheduler.  If not, see <http://www.gnu.org/licenses/>.
 */

require_once(ROOT_DIR . 'Presenters/ResourceDisplayPresenter.php');
require_once(ROOT_DIR . 'Pages/ResourceDisplayPage.php');

class ResourceDisplayPresenterTests extends TestBase
{
	/**
	 * @var TestResourceDisplayPage
	 */
	private $page;

	/**
	 * @var FakeResourceRepository
	 */
	private $resourceRepository;

	/**
	 * @var FakeReservationViewRepository
	 */
	private $reservationRepository;

	/**
	 * @var ResourceDisplayPresenter
	 */
	private $presenter;

	/**
	 * @var IAuthorizationService
	 */
	private $authorizationService;

	public function setup()
	{
		parent::setup();

		$this->page = new TestResourceDisplayPage();
		$this->resourceRepository = new FakeResourceRepository();
		$this->reservationRepository = new FakeReservationViewRepository();
		$this->authorizationService = new FakeAuthorizationService();
		$this->presenter = new ResourceDisplayPresenter($this->page, $this->resourceRepository, $this->reservationRepository, $this->authorizationService);
	}

	public function testShowsLoginIfNotLoggedInAndNoResource()
	{
		$this->fakeServer->UserSession = new NullUserSession();

		$this->presenter->PageLoad();

		$this->assertTrue($this->page->_DisplayLoginCalled);
	}
}

class TestResourceDisplayPage extends FakePageBase implements IResourceDisplayPage
{
	public $_DisplayLoginCalled = false;

	public function TakingAction()
	{
		// TODO: Implement TakingAction() method.
	}

	public function GetAction()
	{
		// TODO: Implement GetAction() method.
	}

	public function RequestingData()
	{
		// TODO: Implement RequestingData() method.
	}

	public function GetDataRequest()
	{
		// TODO: Implement GetDataRequest() method.
	}

	/**
	 * @return string
	 */
	public function GetResourceId()
	{
		// TODO: Implement GetResourceId() method.
	}

	public function DisplayLogin()
	{
		$this->_DisplayLoginCalled = true;
	}

	public function DisplayResourceList()
	{
		// TODO: Implement DisplayResourceList() method.
	}

	public function DisplayResourceAvailability()
	{
		// TODO: Implement DisplayResourceAvailability() method.
	}
}