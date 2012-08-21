<?php
/**
Copyright 2012 Nick Korbel

This file is part of phpScheduleIt.

phpScheduleIt is free software: you can redistribute it and/or modify
it under the terms of the GNU General Public License as published by
the Free Software Foundation, either version 3 of the License, or
(at your option) any later version.

phpScheduleIt is distributed in the hope that it will be useful,
but WITHOUT ANY WARRANTY; without even the implied warranty of
MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
GNU General Public License for more details.

You should have received a copy of the GNU General Public License
along with phpScheduleIt.  If not, see <http://www.gnu.org/licenses/>.
 */

require_once(ROOT_DIR . 'Presenters/CalendarExportPresenter.php');

class CalendarExportPresenterTests extends TestBase
{
	/**
	 * @var IReservationViewRepository|PHPUnit_Framework_MockObject_MockObject
	 */
	private $repo;

	/**
	 * @var ICalendarExportPage|PHPUnit_Framework_MockObject_MockObject
	 */
	private $page;

	/**
	 * @var CalendarExportPresenter
	 */
	private $presenter;

	/**
	 * @var ICalendarExportValidator|PHPUnit_Framework_MockObject_MockObject
	 */
	private $validator;

	/**
	 * @var IReservationAuthorization|PHPUnit_Framework_MockObject_MockObject
	 */
	private $reservationAuth;

	public function setup()
	{
		parent::setup();

		$this->repo = $this->getMock('IReservationViewRepository');
		$this->page = $this->getMock('ICalendarExportPage');
		$this->validator = $this->getMock('ICalendarExportValidator');
		$this->reservationAuth = $this->getMock('IReservationAuthorization');

		$this->presenter = new CalendarExportPresenter($this->page, $this->repo, $this->validator, $this->reservationAuth);
	}

	public function testLoadsReservationByReferenceNumber()
	{
		$referenceNumber = 'ref';
		$reservationResult = new ReservationView();

		$this->validator->expects($this->atLeastOnce())
				->method('IsValid')
				->will($this->returnValue(true));

		$this->page->expects($this->once())
				->method('GetReferenceNumber')
				->will($this->returnValue($referenceNumber));

		$this->repo->expects($this->once())
				->method('GetReservationForEditing')
				->with($this->equalTo($referenceNumber))
				->will($this->returnValue($reservationResult));

		$this->page->expects($this->once())
				->method('SetReservations')
				->with($this->arrayHasKey(0), $this->equalTo(false));

		$this->presenter->PageLoad($this->fakeUser);
	}

	public function testCannotSeeReservationDetailsIfConfiguredOff()
	{
		$this->fakeConfig->SetSectionKey(ConfigSection::PRIVACY, ConfigKeys::PRIVACY_HIDE_RESERVATION_DETAILS, 'true');

		$referenceNumber = 'ref';
		$reservationResult = new ReservationView();

		$this->validator->expects($this->atLeastOnce())
				->method('IsValid')
				->will($this->returnValue(true));

		$this->page->expects($this->once())
				->method('GetReferenceNumber')
				->will($this->returnValue($referenceNumber));

		$this->repo->expects($this->once())
				->method('GetReservationForEditing')
				->with($this->equalTo($referenceNumber))
				->will($this->returnValue($reservationResult));

		$this->reservationAuth->expects($this->once())
						->method('CanViewDetails')
						->with($this->equalTo($reservationResult), $this->equalTo($this->fakeUser))
						->will($this->returnValue(false));

		$this->page->expects($this->once())
				->method('SetReservations')
				->with($this->arrayHasKey(0), $this->equalTo(true));

		$this->presenter->PageLoad($this->fakeUser);
	}

	public function testOrganizerIsOwnerIfCurrentUserIsNotOrganizer()
	{
		// this fixes a bug in outlook which prevents you from adding a meeting that you are the organizer of
		$user = new FakeUserSession();
		$res = new ReservationView();
		$res->OwnerId = $user->UserId+1;
		$res->OwnerFirstName = "f";
		$res->OwnerLastName = "l";
		$res->OwnerEmailAddress = "e@m.com";

		$reservationView = new iCalendarReservationView($res, $user);
		$this->assertEquals($res->OwnerEmailAddress, $reservationView->OrganizerEmail);
		$this->assertEquals(new FullName($res->OwnerFirstName, $res->OwnerLastName), $reservationView->Organizer);
	}

	public function testOrganizerIsDefaultedIfCurrentUserIsOrganizer()
	{
		// this fixes a bug in outlook which prevents you from adding a meeting that you are the organizer of
		$user = new FakeUserSession();
		$res = new ReservationView();
		$res->OwnerId = $user->UserId;
		$res->OwnerFirstName = "f";
		$res->OwnerLastName = "l";
		$res->OwnerEmailAddress = "e@m.com";

		$reservationView = new iCalendarReservationView($res, $user);
		$this->assertEquals('e-noreply@m.com', $reservationView->OrganizerEmail);
		$this->assertEquals(new FullName($res->OwnerFirstName, $res->OwnerLastName), $reservationView->Organizer);
	}
}

?>