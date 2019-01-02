<?php
/**
Copyright 2011-2019 Nick Korbel

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

require_once(ROOT_DIR . 'lib/Application/Reservation/namespace.php');

class ReservationCheckinPresenter
{
	/**
	 * @var IReservationCheckinPage
	 */
	private $page;

	/**
	 * @var IUpdateReservationPersistenceService
	 */
	private $persistenceService;

	/**
	 * @var IReservationHandler
	 */
	private $handler;

	/**
	 * @var UserSession
	 */
	private $userSession;

	public function __construct(
		IReservationCheckinPage $page,
		IUpdateReservationPersistenceService $persistenceService,
		IReservationHandler $handler,
		UserSession $userSession)
	{
		$this->page = $page;
		$this->persistenceService = $persistenceService;
		$this->handler = $handler;
		$this->userSession = $userSession;
	}

	public function PageLoad()
	{
		$referenceNumber = $this->page->GetReferenceNumber();
		$action = $this->page->GetAction();

		if ($action != ReservationAction::Checkin)
		{
			$action = ReservationAction::Checkout;
		}

		Log::Debug('User: %s, Checkin/out reservation with reference number %s, action %s', $this->userSession->UserId, $referenceNumber, $action);

		$reservationSeries = $this->persistenceService->LoadByReferenceNumber($referenceNumber);

		if ($action == ReservationAction::Checkin)
		{
			$reservationSeries->Checkin($this->userSession);
		}
		else
		{
			$reservationSeries->Checkout($this->userSession);
		}

		$this->handler->Handle($reservationSeries, $this->page);
	}
}