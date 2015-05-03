<?php
/**
 * Copyright 2012-2015 Nick Korbel
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

require_once(ROOT_DIR . 'Presenters/Reservation/ReservationSavePresenter.php');
require_once(ROOT_DIR . 'Presenters/Reservation/ReservationUpdatePresenter.php');
require_once(ROOT_DIR . 'Presenters/Reservation/ReservationDeletePresenter.php');

interface IReservationPresenterFactory
{
	/**
	 * @param IReservationSavePage $savePage
	 * @param UserSession $userSession
	 * @return ReservationSavePresenter
	 */
	public function Create(IReservationSavePage $savePage, UserSession $userSession);

	/**
	 * @param IReservationUpdatePage $updatePage
	 * @param UserSession $userSession
	 * @return ReservationUpdatePresenter
	 */
	public function Update(IReservationUpdatePage $updatePage, UserSession $userSession);

	/**
	 * @param IReservationDeletePage $deletePage
	 * @param UserSession $userSession
	 * @return ReservationDeletePresenter
	 */
	public function Delete(IReservationDeletePage $deletePage, UserSession $userSession);

	/**
	 * @param IReservationApprovalPage $approvePage
	 * @param UserSession $userSession
	 * @return ReservationApprovalPresenter
	 */
	public function Approve(IReservationApprovalPage $approvePage, UserSession $userSession);
}

class ReservationPresenterFactory implements IReservationPresenterFactory
{
	public function Create(IReservationSavePage $savePage, UserSession $userSession)
	{
		$persistenceFactory = new ReservationPersistenceFactory();
		$resourceRepository = new ResourceRepository();
		$reservationAction = ReservationAction::Create;
		$handler = ReservationHandler::Create($reservationAction,
											  $persistenceFactory->Create($reservationAction),
											  $userSession);

		return new ReservationSavePresenter($savePage, $persistenceFactory->Create($reservationAction), $handler, $resourceRepository, $userSession);
	}

	public function Update(IReservationUpdatePage $updatePage, UserSession $userSession)
	{
		$persistenceFactory = new ReservationPersistenceFactory();
		$resourceRepository = new ResourceRepository();
		$reservationAction = ReservationAction::Update;
		$handler = ReservationHandler::Create($reservationAction,
											  $persistenceFactory->Create($reservationAction),
											  $userSession);

		return new ReservationUpdatePresenter($updatePage, $persistenceFactory->Create($reservationAction), $handler, $resourceRepository, $userSession);
	}

	public function Delete(IReservationDeletePage $deletePage, UserSession $userSession)
	{
		$persistenceFactory = new ReservationPersistenceFactory();

		$deleteAction = ReservationAction::Delete;

		$handler = ReservationHandler::Create($deleteAction, $persistenceFactory->Create($deleteAction), $userSession);
		return new ReservationDeletePresenter(
				$deletePage,
				$persistenceFactory->Create($deleteAction),
				$handler,
				$userSession
		);
	}

	/**
	 * @param IReservationApprovalPage $approvePage
	 * @param UserSession $userSession
	 * @return ReservationApprovalPresenter
	 */
	public function Approve(IReservationApprovalPage $approvePage, UserSession $userSession)
	{
		$persistenceFactory = new ReservationPersistenceFactory();

		$approveAction = ReservationAction::Approve;

		$handler = ReservationHandler::Create($approveAction, $persistenceFactory->Create($approveAction),
											  $userSession);

		$auth = new ReservationAuthorization(PluginManager::Instance()->LoadAuthorization());

		return new ReservationApprovalPresenter(
				$approvePage,
				$persistenceFactory->Create($approveAction),
				$handler,
				$auth,
				$userSession
		);
	}
}
