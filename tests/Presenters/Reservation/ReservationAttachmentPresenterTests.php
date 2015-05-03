<?php
/**
Copyright 2012-2015 Nick Korbel

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

require_once(ROOT_DIR . 'Presenters/Reservation/ReservationAttachmentPresenter.php');

class ReservationAttachmentPresenterTests extends TestBase
{
	/**
	 * @var ReservationAttachmentPresenter
	 */
	private $presenter;

	/**
	 * @var IReservationAttachmentPage|PHPUnit_Framework_MockObject_MockObject
	 */
	private $page;

	/**
	 * @var IReservationRepository|PHPUnit_Framework_MockObject_MockObject
	 */
	private $reservationRepository;

	/**
	 * @var FakePermissionService
	 */
	private $fakePermissionService;

	public function setup()
	{
		$this->fakePermissionService = new FakePermissionService(array(true));
		$this->reservationRepository = $this->getMock('IReservationRepository');
		$this->page = $this->getMock('IReservationAttachmentPage');

		$this->presenter = new ReservationAttachmentPresenter($this->page, $this->reservationRepository, $this->fakePermissionService);

		parent::setup();
	}

	public function testLoadsAttachmentIfUserHasPermissionToPrimaryResource()
	{
		$fileId = 110;
		$resourceId = 1909;
		$referenceNumber = 'rn';
		$seriesId = 1;

		$builder = new ExistingReservationSeriesBuilder();
		$builder->WithPrimaryResource(new FakeBookableResource($resourceId));
		$builder->WithId($seriesId);
		$reservationSeries = $builder->Build();

		$reservationAttachment = new FakeReservationAttachment($fileId);
		$reservationAttachment->SetSeriesId($seriesId);

		$this->page->expects($this->once())
				->method('GetFileId')
				->will($this->returnValue($fileId));

		$this->page->expects($this->once())
				->method('GetReferenceNumber')
				->will($this->returnValue($referenceNumber));

		$this->reservationRepository->expects($this->once())
				->method('LoadReservationAttachment')
				->with($this->equalTo($fileId))
				->will($this->returnValue($reservationAttachment));

		$this->reservationRepository->expects($this->once())
				->method('LoadByReferenceNumber')
				->with($this->equalTo($referenceNumber))
				->will($this->returnValue($reservationSeries));

		$this->page->expects($this->once())
				->method('BindAttachment')
				->with($this->equalTo($reservationAttachment));

		$this->presenter->PageLoad($this->fakeUser);

		$this->assertEquals(1, count($this->fakePermissionService->Resources));
		$this->assertEquals(new ReservationResource($resourceId), $this->fakePermissionService->Resources[0]);
		$this->assertEquals($this->fakeUser, $this->fakePermissionService->User);
	}

	public function testShowsErrorIfUserDoesNotHavePermissionToPrimaryResource()
	{
		$this->fakePermissionService->ReturnValues = array(false);
		$fileId = 110;
		$resourceId = 1909;
		$referenceNumber = 'rn';
		$seriesId = 1;

		$builder = new ExistingReservationSeriesBuilder();
		$builder->WithPrimaryResource(new FakeBookableResource($resourceId));
		$builder->WithId($seriesId);
		$reservationSeries = $builder->Build();

		$reservationAttachment = new FakeReservationAttachment($fileId);
		$reservationAttachment->SetSeriesId($seriesId);

		$this->page->expects($this->once())
				->method('GetFileId')
				->will($this->returnValue($fileId));

		$this->page->expects($this->once())
				->method('GetReferenceNumber')
				->will($this->returnValue($referenceNumber));

		$this->reservationRepository->expects($this->once())
				->method('LoadReservationAttachment')
				->with($this->equalTo($fileId))
				->will($this->returnValue($reservationAttachment));

		$this->reservationRepository->expects($this->once())
				->method('LoadByReferenceNumber')
				->with($this->equalTo($referenceNumber))
				->will($this->returnValue($reservationSeries));

		$this->page->expects($this->once())
				->method('ShowError');

		$this->presenter->PageLoad($this->fakeUser);

		$this->assertEquals(1, count($this->fakePermissionService->Resources));
		$this->assertEquals(new ReservationResource($resourceId), $this->fakePermissionService->Resources[0]);
		$this->assertEquals($this->fakeUser, $this->fakePermissionService->User);
	}

	public function testShowsErrorIfReservationNotFound()
	{
		$fileId = 110;
		$referenceNumber = 'rn';

		$reservationAttachment = new FakeReservationAttachment($fileId);

		$this->page->expects($this->once())
				->method('GetFileId')
				->will($this->returnValue($fileId));

		$this->page->expects($this->once())
				->method('GetReferenceNumber')
				->will($this->returnValue($referenceNumber));

		$this->reservationRepository->expects($this->once())
				->method('LoadReservationAttachment')
				->with($this->equalTo($fileId))
				->will($this->returnValue($reservationAttachment));

		$this->reservationRepository->expects($this->once())
				->method('LoadByReferenceNumber')
				->with($this->equalTo($referenceNumber))
				->will($this->returnValue(null));

		$this->page->expects($this->once())
				->method('ShowError');

		$this->presenter->PageLoad($this->fakeUser);
	}

	public function testShowsErrorIfFileNotFound()
	{
		$fileId = 110;
		$referenceNumber = 'rn';

		$this->page->expects($this->once())
				->method('GetFileId')
				->will($this->returnValue($fileId));

		$this->page->expects($this->once())
				->method('GetReferenceNumber')
				->will($this->returnValue($referenceNumber));

		$this->reservationRepository->expects($this->once())
				->method('LoadReservationAttachment')
				->with($this->equalTo($fileId))
				->will($this->returnValue(null));

		$this->page->expects($this->once())
				->method('ShowError');

		$this->presenter->PageLoad($this->fakeUser);
	}

	public function testShowsErrorFileDoesNotBelongToReservation()
	{
		$fileId = 110;
		$resourceId = 1909;
		$referenceNumber = 'rn';
		$seriesId = 1;
		$fileSeriesId = 2;

		$builder = new ExistingReservationSeriesBuilder();
		$builder->WithId($seriesId);
		$builder->WithPrimaryResource(new FakeBookableResource($resourceId));
		$reservationSeries = $builder->Build();

		$reservationAttachment = new FakeReservationAttachment($fileId);
		$reservationAttachment->SetSeriesId($fileSeriesId);

		$this->page->expects($this->once())
				->method('GetFileId')
				->will($this->returnValue($fileId));

		$this->page->expects($this->once())
				->method('GetReferenceNumber')
				->will($this->returnValue($referenceNumber));

		$this->reservationRepository->expects($this->once())
				->method('LoadReservationAttachment')
				->with($this->equalTo($fileId))
				->will($this->returnValue($reservationAttachment));

		$this->reservationRepository->expects($this->once())
				->method('LoadByReferenceNumber')
				->with($this->equalTo($referenceNumber))
				->will($this->returnValue($reservationSeries));

		$this->page->expects($this->once())
				->method('ShowError');

		$this->presenter->PageLoad($this->fakeUser);
	}
}

?>