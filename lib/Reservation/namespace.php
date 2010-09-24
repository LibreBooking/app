<?php
require_once(ROOT_DIR . 'lib/Domain/namespace.php');

require_once(ROOT_DIR . 'lib/Reservation/IReservationInitializer.php');
require_once(ROOT_DIR . 'lib/Reservation/IReservationInitializerFactory.php');
require_once(ROOT_DIR . 'lib/Reservation/IReservationNotificationService.php');
require_once(ROOT_DIR . 'lib/Reservation/IReservationNotificationFactory.php');
require_once(ROOT_DIR . 'lib/Reservation/IReservationPreconditionService.php');
require_once(ROOT_DIR . 'lib/Reservation/IReservationValidationFactory.php');
require_once(ROOT_DIR . 'lib/Reservation/IReservationValidationResult.php');
require_once(ROOT_DIR . 'lib/Reservation/IReservationValidationRule.php');
require_once(ROOT_DIR . 'lib/Reservation/IReservationValidationService.php');
require_once(ROOT_DIR . 'lib/Reservation/IReservationPersistenceService.php');
require_once(ROOT_DIR . 'lib/Reservation/IReservationPersistenceFactory.php');

require_once(ROOT_DIR . 'lib/Reservation/ReservationPersistenceFactory.php');
require_once(ROOT_DIR . 'lib/Reservation/ReservationNotificationFactory.php');
require_once(ROOT_DIR . 'lib/Reservation/AddReservationPersistenceService.php');
require_once(ROOT_DIR . 'lib/Reservation/AddReservationNotificationService.php');
require_once(ROOT_DIR . 'lib/Reservation/AddReservationValidationService.php');
require_once(ROOT_DIR . 'lib/Reservation/NewReservationInitializer.php');
require_once(ROOT_DIR . 'lib/Reservation/ReservationDateTimeRule.php');
require_once(ROOT_DIR . 'lib/Reservation/PermissionValidationRule.php');
require_once(ROOT_DIR . 'lib/Reservation/ResourceAvailabilityRule.php');
require_once(ROOT_DIR . 'lib/Reservation/ReservationInitializerFactory.php');
require_once(ROOT_DIR . 'lib/Reservation/ReservationPreconditionService.php');
require_once(ROOT_DIR . 'lib/Reservation/ReservationResource.php');
require_once(ROOT_DIR . 'lib/Reservation/ReservationRuleResult.php');
require_once(ROOT_DIR . 'lib/Reservation/ReservationValidationFactory.php');
require_once(ROOT_DIR . 'lib/Reservation/ReservationValidResult.php');
?>