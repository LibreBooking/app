<?php
/**
 * Copyright 2018 Nick Korbel
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

require_once(ROOT_DIR . 'Presenters/Reservation/ReservationEmailPresenter.php');
require_once(ROOT_DIR . 'Pages/Ajax/ReservationEmailPage.php');
require_once(ROOT_DIR . 'lib/Application/Reservation/namespace.php');

class ReservationEmailPresenterTests extends TestBase
{
    private $userId;

    /**
     * @var UserSession
     */
    private $user;

    /**
     * @var FakeReservationEmailPage
     */
    private $page;

    /**
     * @var ReservationEmailPresenter
     */
    private $presenter;

    /**
     * @var FakeReservationRepository
     */
    private $reservationRepository;

    /**
     * @var FakeUserRepository
     */
    private $userRepository;

    /**
     * @var FakeAttributeRepository
     */
    private $attributeRepository;

    /**
     * @var FakePermissionService
     */
    private $permissionService;

    public function setup()
    {
        parent::setup();

        $this->user = $this->fakeServer->UserSession;
        $this->userId = $this->user->UserId;

        $this->reservationRepository = new FakeReservationRepository();
        $this->userRepository = new FakeUserRepository();
        $this->attributeRepository = new FakeAttributeRepository();
        $this->permissionService = new FakePermissionService();

        $this->page = new FakeReservationEmailPage();

        $this->presenter = new ReservationEmailPresenter(
            $this->page,
            $this->fakeUser,
            $this->reservationRepository,
            $this->userRepository,
            $this->attributeRepository,
            $this->permissionService
        );
    }

    public function testSendsEmailIfCurrentUserIsOwner()
    {
        $reservation = new TestHelperExistingReservationSeries();
        $reservation->WithOwner($this->fakeUser->UserId);
        $reservation->WithCurrentInstance(new TestReservation());

        $this->page->_EmailAddresses = array('email1', 'email2');
        $this->reservationRepository->_Series = $reservation;

        $user = new FakeUser($this->fakeUser->UserId);
        $this->userRepository->_User = $user;

        $this->presenter->PageLoad();

        $messages = $this->fakeEmailService->_Messages;

        $this->assertEquals(count($this->page->_EmailAddresses), count($messages));
    }

    public function testSendsIfUserCanSeeReservation()
    {
        $reservation = new TestHelperExistingReservationSeries();
        $reservation->WithOwner(999);
        $reservation->WithCurrentInstance(new TestReservation());

        $this->permissionService->_CanViewResource[2] = true;
        $this->permissionService->_CanViewResource[3] = true;

        $this->page->_EmailAddresses = array('email1', 'email2');
        $this->reservationRepository->_Series = $reservation;

        $user = new FakeUser($this->fakeUser->UserId);
        $this->userRepository->_User = $user;

        $this->presenter->PageLoad();

        $messages = $this->fakeEmailService->_Messages;

        $this->assertEquals(count($this->page->_EmailAddresses), count($messages));
    }

    public function testDoesNotSendIfUserCannotSeeReservation()
    {
        $reservation = new TestHelperExistingReservationSeries();
        $reservation->WithOwner(999);
        $reservation->WithCurrentInstance(new TestReservation());

        $this->permissionService->_CanViewResource[2] = false;
        $this->permissionService->_CanViewResource[3] = false;

        $this->page->_EmailAddresses = array('email1', 'email2');
        $this->reservationRepository->_Series = $reservation;

        $user = new FakeUser($this->fakeUser->UserId);
        $this->userRepository->_User = $user;

        $this->presenter->PageLoad();

        $messages = $this->fakeEmailService->_Messages;

        $this->assertEquals(0, count($messages));
    }
}

class FakeReservationEmailPage implements IReservationEmailPage
{
    public $_ReferenceNumber = 'reference number';
    public $_EmailAddresses = array();

    public function GetReferenceNumber()
    {
        return $this->_ReferenceNumber;
    }

    public function GetEmailAddresses()
    {
        return $this->_EmailAddresses;
    }
}