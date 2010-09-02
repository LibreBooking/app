<?php
require_once(ROOT_DIR . 'lib/Domain/namespace.php');

require_once(ROOT_DIR . 'lib/Reservation/IReservationInitializer.php');
require_once(ROOT_DIR . 'lib/Reservation/IReservationInitializerFactory.php');
require_once(ROOT_DIR . 'lib/Reservation/IReservationNotificationFactory.php');
require_once(ROOT_DIR . 'lib/Reservation/IReservationPreconditionService.php');
require_once(ROOT_DIR . 'lib/Reservation/IReservationValidationFactory.php');
require_once(ROOT_DIR . 'lib/Reservation/IReservationValidationResult.php');
require_once(ROOT_DIR . 'lib/Reservation/IReservationValidationRule.php');
require_once(ROOT_DIR . 'lib/Reservation/IReservationValidationService.php');

require_once(ROOT_DIR . 'lib/Reservation/AddReservationValidationService.php');
require_once(ROOT_DIR . 'lib/Reservation/NewReservationInitializer.php');
require_once(ROOT_DIR . 'lib/Reservation/PermissionValidationRule.php');
require_once(ROOT_DIR . 'lib/Reservation/ReservationInitializerFactory.php');
require_once(ROOT_DIR . 'lib/Reservation/ReservationPreconditionService.php');
require_once(ROOT_DIR . 'lib/Reservation/ReservationResource.php');
require_once(ROOT_DIR . 'lib/Reservation/ReservationRuleResult.php');
require_once(ROOT_DIR . 'lib/Reservation/ReservationValidationFactory.php');
require_once(ROOT_DIR . 'lib/Reservation/ReservationValidResult.php');
?>