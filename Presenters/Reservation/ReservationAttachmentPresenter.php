<?php
/**
Copyright 2012-2019 Nick Korbel

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

require_once(ROOT_DIR . 'lib/Common/namespace.php');
require_once(ROOT_DIR . 'lib/Application/Reservation/namespace.php');
require_once(ROOT_DIR . 'Domain/Access/namespace.php');
require_once(ROOT_DIR . 'Pages/Reservation/ReservationAttachmentPage.php');

class ReservationAttachmentPresenter
{
	/**
	 * @var IReservationAttachmentPage
	 */
	private $page;

	/**
	 * @var IReservationRepository
	 */
	private $reservationRepository;

	/**
	 * @var IPermissionService
	 */
	private $permissionService;

	public function __construct(IReservationAttachmentPage $page, IReservationRepository $reservationRepository, IPermissionService $permissionService)
	{
		$this->page = $page;
		$this->reservationRepository = $reservationRepository;
		$this->permissionService = $permissionService;
	}

	public function PageLoad(UserSession $currentUser)
	{
		$loaded = $this->TryPageLoad($currentUser);
		if ($loaded === false)
		{
			$this->page->ShowError();
		}
		else
		{
			$this->page->BindAttachment($loaded);
		}
	}

	private function TryPageLoad($currentUser)
	{
		$fileId = $this->page->GetFileId();
		$referenceNumber = $this->page->GetReferenceNumber();
		Log::Debug('Trying to load reservation attachment. FileId: %s, ReferenceNumber %s', $fileId, $referenceNumber);

		$attachment = $this->reservationRepository->LoadReservationAttachment($fileId);
		if ($attachment == null)
		{
			Log::Error('Error loading resource attachment, attachment not found');
			return false;
		}

		$reservation = $this->reservationRepository->LoadByReferenceNumber($referenceNumber);
		if ($reservation == null)
		{
			Log::Error('Error loading resource attachment, reservation not found');
			return false;
		}

		if ($reservation->SeriesId() != $attachment->SeriesId())
		{
			Log::Error('Error loading resource attachment, attachment not associated with reservation');
			return false;
		}

		if (!$this->permissionService->CanAccessResource(new ReservationResource($reservation->ResourceId()), $currentUser))
		{
			Log::Error('Error loading resource attachment, insufficient permissions');
			return false;
		}

		return $attachment;
	}
}


