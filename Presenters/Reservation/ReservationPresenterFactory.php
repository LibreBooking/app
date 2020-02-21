<?php
/**
 * Copyright 2012-2020 Nick Korbel
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
require_once(ROOT_DIR . 'Presenters/Reservation/ReservationCheckinPresenter.php');
require_once(ROOT_DIR . 'Presenters/Reservation/ReservationWaitlistPresenter.php');

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

	/**
	 * @param IReservationWaitlistPage $page
	 * @param UserSession $userSession
	 * @return ReservationWaitlistPresenter
	 */
	public function JoinWaitlist(IReservationWaitlistPage $page, UserSession $userSession);

	/**
	 * @param IReservationCheckinPage $page
	 * @param UserSession $userSession
	 * @return ReservationCheckinPresenter
	 */
	public function Checkin(IReservationCheckinPage $page, UserSession $userSession);
}

class ReservationPresenterFactory implements IReservationPresenterFactory
{
	public function Create(IReservationSavePage $savePage, UserSession $userSession)
	{
		$persistenceFactory = new ReservationPersistenceFactory();
		$resourceRepository = new ResourceRepository();
		$scheduleRepository = new ScheduleRepository();
		$reservationAction = ReservationAction::Create;
		$persistenceService = $persistenceFactory->Create($reservationAction);
		$handler = ReservationHandler::Create($reservationAction,
											  $persistenceService,
											  $userSession);

		return new ReservationSavePresenter($savePage, $persistenceService, $handler, $resourceRepository, $scheduleRepository, $userSession);
	}

	public function Update(IReservationUpdatePage $updatePage, UserSession $userSession)
	{
		$persistenceFactory = new ReservationPersistenceFactory();
		$resourceRepository = new ResourceRepository();
		$scheduleRepository = new ScheduleRepository();
		$reservationAction = ReservationAction::Update;
		$persistenceService = $persistenceFactory->Create($reservationAction);
		$handler = ReservationHandler::Create($reservationAction,
											  $persistenceService,
											  $userSession);

		return new ReservationUpdatePresenter($updatePage, $persistenceService, $handler, $resourceRepository, $scheduleRepository, $userSession);
	}

	public function Delete(IReservationDeletePage $deletePage, UserSession $userSession)
	{
		$persistenceFactory = new ReservationPersistenceFactory();

		$deleteAction = ReservationAction::Delete;

		$persistenceService = $persistenceFactory->Create($deleteAction);
		$handler = ReservationHandler::Create($deleteAction, $persistenceService, $userSession);
		return new ReservationDeletePresenter(
				$deletePage,
				$persistenceService,
				$handler,
				$userSession
		);
	}

	public function Approve(IReservationApprovalPage $approvePage, UserSession $userSession)
	{
		$persistenceFactory = new ReservationPersistenceFactory();

		$approveAction = ReservationAction::Approve;

		$persistenceService = $persistenceFactory->Create($approveAction);
		$handler = ReservationHandler::Create($approveAction, $persistenceService,
											  $userSession);

		$auth = new ReservationAuthorization(PluginManager::Instance()->LoadAuthorization());

		return new ReservationApprovalPresenter(
				$approvePage,
				$persistenceService,
				$handler,
				$auth,
				$userSession
		);
	}

	public function Checkin(IReservationCheckinPage $page, UserSession $userSession)
	{
		$persistenceFactory = new ReservationPersistenceFactory();

		$action = ReservationAction::Checkout;
		if ($page->GetAction() == ReservationAction::Checkin)
		{
			$action = ReservationAction::Checkin;
		}

		$persistenceService = $persistenceFactory->Create(ReservationAction::Update);
		$handler = ReservationHandler::Create($action, $persistenceService, $userSession);

		return new ReservationCheckinPresenter(
				$page,
				$persistenceService,
				$handler,
				$userSession
		);
	}

    public function JoinWaitlist(IReservationWaitlistPage $page, UserSession $userSession)
    {
        return new ReservationWaitlistPresenter($page, $userSession, new ReservationWaitlistRepository());
    }
}
