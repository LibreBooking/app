<?php
/**
Copyright 2011-2015 Nick Korbel

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

interface IReservationDeletePresenter
{
	/**
	 * @return ExistingReservationSeries
	 */
	public function BuildReservation();

	/**
	 * @param ExistingReservationSeries $reservationSeries
	 */
	public function HandleReservation($reservationSeries);
}

class ReservationDeletePresenter implements IReservationDeletePresenter
{
	/**
	 * @var IReservationDeletePage
	 */
	private $page;

	/**
	 * @var IDeleteReservationPersistenceService
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
		IReservationDeletePage $page,
		IDeleteReservationPersistenceService $persistenceService,
		IReservationHandler $handler,
		UserSession $userSession)
	{
		$this->page = $page;
		$this->persistenceService = $persistenceService;
		$this->handler = $handler;
		$this->userSession = $userSession;
	}

	/**
	 * @return ExistingReservationSeries
	 */
	public function BuildReservation()
	{
		$referenceNumber = $this->page->GetReferenceNumber();
		$existingSeries = $this->persistenceService->LoadByReferenceNumber($referenceNumber);
		$existingSeries->ApplyChangesTo($this->page->GetSeriesUpdateScope());

		$existingSeries->Delete($this->userSession);

		return $existingSeries;
	}

	/**
	 * @param ExistingReservationSeries $reservationSeries
	 */
	public function HandleReservation($reservationSeries)
	{
		Log::Debug("Deleting reservation %s", $reservationSeries->CurrentInstance()->ReferenceNumber());

		$this->handler->Handle($reservationSeries, $this->page);
	}
}