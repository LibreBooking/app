<?php
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
		$notificationService = $nfactory->Create($reservationAction);

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

		if ($validationResult->CanBeSaved()) {
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