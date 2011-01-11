<?php
class ReservationUpdatePresenter
{
	/**
	 * @var IReservationUpdatePage
	 */
	private $_page;
	
	/**
	 * @var IReservationUpdatePersistenceService
	 */
	private $_persistenceService;
	
	/**
	 * @var IReservationValidationService
	 */
	private $_validationService;
	
	/**
	 * @var IReservationNotificationService
	 */
	private $_notificationService;
	
	public function __construct(
		IReservationUpdatePage $page, 
		IReservationUpdatePersistenceService $persistenceService,
		IReservationUpdateValidationService $validationService,
		IReservationUpdateNotificationService $notificationService)
	{
		$this->_page = $page;
		$this->_persistenceService = $persistenceService;
		$this->_validationService = $validationService;
		$this->_notificationService = $notificationService;
	}
}
?>