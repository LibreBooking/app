<?php
/**
Copyright 2011-2012 Nick Korbel

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

require_once(ROOT_DIR . 'Presenters/ReservationHandler.php');

class ReservationApprovalPresenter
{
	/**
	 * @var IReservationApprovalPage
	 */
	private $page;

	/**
	 * @var \IUpdateReservationPersistenceService
	 */
	private $persistenceService;

	/**
	 * @var \IReservationHandler
	 */
	private $handler;

	public function __construct(
		IReservationApprovalPage $page,
		IUpdateReservationPersistenceService $persistenceService,
		IReservationHandler $handler)
	{
		$this->page = $page;
		$this->persistenceService = $persistenceService;
		$this->handler = $handler;
	}

	public function PageLoad()
	{
		$referenceNumber = $this->page->GetReferenceNumber();
		$userSession = ServiceLocator::GetServer()->GetUserSession();

		Log::Debug('User: %s, Approving reservation with reference number %s', $userSession->UserId, $referenceNumber);

		$series = $this->persistenceService->LoadByReferenceNumber($referenceNumber);
		$series->Approve($userSession);
		$this->handler->Handle($series, $this->page);
	}
}

?>