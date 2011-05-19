<?php
require_once(ROOT_DIR . 'lib/Application/Reservation/Validation/IReservationValidationFactory.php');
require_once(ROOT_DIR . 'lib/Application/Reservation/Validation/IReservationValidationResult.php');
require_once(ROOT_DIR . 'lib/Application/Reservation/Validation/IReservationValidationRule.php');
require_once(ROOT_DIR . 'lib/Application/Reservation/Validation/IUpdateReservationValidationRule.php');
require_once(ROOT_DIR . 'lib/Application/Reservation/Validation/IReservationValidationService.php');

require_once(ROOT_DIR . 'lib/Application/Reservation/Validation/ReservationValidationRuleProcessor.php');

require_once(ROOT_DIR . 'lib/Application/Reservation/Validation/AdminExcludedRule.php');
require_once(ROOT_DIR . 'lib/Application/Reservation/Validation/ResourceAvailabilityRule.php');
require_once(ROOT_DIR . 'lib/Application/Reservation/Validation/ExistingResourceAvailabilityRule.php');
require_once(ROOT_DIR . 'lib/Application/Reservation/Validation/ReservationDateTimeRule.php');
require_once(ROOT_DIR . 'lib/Application/Reservation/Validation/ReservationStartTimeRule.php');
require_once(ROOT_DIR . 'lib/Application/Reservation/Validation/PermissionValidationRule.php');
require_once(ROOT_DIR . 'lib/Application/Reservation/Validation/ReservationRuleResult.php');
require_once(ROOT_DIR . 'lib/Application/Reservation/Validation/ReservationValidationFactory.php');
require_once(ROOT_DIR . 'lib/Application/Reservation/Validation/ReservationValidationResult.php');
require_once(ROOT_DIR . 'lib/Application/Reservation/Validation/ResourceMinimumNoticeRule.php');
require_once(ROOT_DIR . 'lib/Application/Reservation/Validation/ResourceMaximumNoticeRule.php');
require_once(ROOT_DIR . 'lib/Application/Reservation/Validation/ResourceMinimumDurationRule.php');
require_once(ROOT_DIR . 'lib/Application/Reservation/Validation/ResourceMaximumDurationRule.php');

require_once(ROOT_DIR . 'lib/Application/Reservation/Validation/AddReservationValidationService.php');
require_once(ROOT_DIR . 'lib/Application/Reservation/Validation/UpdateReservationValidationService.php');
require_once(ROOT_DIR . 'lib/Application/Reservation/Validation/DeleteReservationValidationService.php');
?>