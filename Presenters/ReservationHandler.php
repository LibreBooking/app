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
	 * @param IReservationSaveResultsPage $page
	 * @return bool if the reservation was handled or not
	 */
	public function Handle(ReservationSeries $reservationSeries, IReservationSaveResultsPage $page);
}

class ReservationHandler implements IReservationHandler
{
	/**
	 * @var \IReservationPersistenceService
	 */
	private $persistenceService;

	/**
	 * @var \IReservationValidationService
	 */
	private $validationService;

	/**
	 * @var \IReservationNotificationService
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
	 * @return IReservationHandler
	 */
	public static function Create($reservationAction, $persistenceService)
	{
		if (!isset($persistenceService))
		{
			$pfactory = new ReservationPersistenceFactory();
			$persistenceService = $pfactory->Create($reservationAction);
		}

		$vfactory = new ReservationValidationFactory();
		$validationService = $vfactory->Create($reservationAction, ServiceLocator::GetServer()->GetUserSession());

		$nfactory = new ReservationNotificationFactory();
		$notificationService = $nfactory->Create($reservationAction, ServiceLocator::GetServer()->GetUserSession());

		return new ReservationHandler($persistenceService, $validationService, $notificationService);
	}

	/**
	 * @param ReservationSeries $reservationSeries
	 * @param IReservationSaveResultsPage $page
	 * @return bool if the reservation was handled or not
	 */
	public function Handle(ReservationSeries $reservationSeries, IReservationSaveResultsPage $page)
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

			$page->SetSaveSuccessfulMessage($result);
		}
		else
		{
			$page->SetSaveSuccessfulMessage($result);
			$page->ShowErrors($validationResult->GetErrors());
		}

		$page->ShowWarnings($validationResult->GetWarnings());

		return $result;
	}
}

?>