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

require_once(ROOT_DIR . 'lib/Config/namespace.php');
require_once(ROOT_DIR . 'lib/Server/namespace.php');
require_once(ROOT_DIR . 'lib/Common/namespace.php');
require_once(ROOT_DIR . 'Domain/namespace.php');
require_once(ROOT_DIR . 'Domain/Access/namespace.php');
require_once(ROOT_DIR . 'lib/Application/Reservation/namespace.php');
require_once(ROOT_DIR . 'lib/Application/Reservation/Persistence/namespace.php');
require_once(ROOT_DIR . 'lib/Application/Reservation/Validation/namespace.php');
require_once(ROOT_DIR . 'lib/Application/Reservation/Notification/namespace.php');

interface IReservationHandler
{
	/**
	 * @param ReservationSeries $reservationSeries
	 * @param IReservationSaveResultsView $view
	 * @return bool if the reservation was handled or not
	 */
	public function Handle(ReservationSeries $reservationSeries, IReservationSaveResultsView $view);
}

class ReservationHandler implements IReservationHandler
{
	/**
	 * @var IReservationPersistenceService
	 */
	private $persistenceService;

	/**
	 * @var IReservationValidationService
	 */
	private $validationService;

	/**
	 * @var IReservationNotificationService
	 */
	private $notificationService;

	public function __construct(IReservationPersistenceService $persistenceService, IReservationValidationService $validationService, IReservationNotificationService $notificationService)
	{
		$this->persistenceService = $persistenceService;
		$this->validationService = $validationService;
		$this->notificationService = $notificationService;
	}

	/**
	 * @static
	 * @param $reservationAction string|ReservationAction
	 * @param $persistenceService null|IReservationPersistenceService
	 * @param UserSession $session
	 * @return IReservationHandler
	 */
	public static function Create($reservationAction, $persistenceService, UserSession $session)
	{
		if (!isset($persistenceService))
		{
			$persistenceFactory = new ReservationPersistenceFactory();
			$persistenceService = $persistenceFactory->Create($reservationAction);
		}

		$validationFactory = new ReservationValidationFactory();
		$validationService = $validationFactory->Create($reservationAction, $session);

		$notificationFactory = new ReservationNotificationFactory();
		$notificationService = $notificationFactory->Create($reservationAction, $session);

		return new ReservationHandler($persistenceService, $validationService, $notificationService);
	}

	/**
	 * @param ReservationSeries $reservationSeries
	 * @param IReservationSaveResultsView $view
	 * @return bool if the reservation was handled or not
	 */
	public function Handle(ReservationSeries $reservationSeries, IReservationSaveResultsView $view)
	{
		$validationResult = $this->validationService->Validate($reservationSeries);
		$result = $validationResult->CanBeSaved();

		if ($validationResult->CanBeSaved())
        {
			try
			{
				$this->persistenceService->Persist($reservationSeries);
			}
			catch (Exception $ex)
			{
				Log::Error('Error saving reservation: %s', $ex);
				throw($ex);
			}

			$this->notificationService->Notify($reservationSeries);

			$view->SetSaveSuccessfulMessage($result);
		}
		else
		{
			$view->SetSaveSuccessfulMessage($result);
			$view->SetErrors($validationResult->GetErrors());
		}

		$view->SetWarnings($validationResult->GetWarnings());

		return $result;
	}

}