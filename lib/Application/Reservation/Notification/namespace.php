<?php

require_once(ROOT_DIR . 'lib/Application/Reservation/Notification/PostReservationFactory.php');

require_once(ROOT_DIR . 'lib/Application/Reservation/Notification/IReservationNotification.php');
require_once(ROOT_DIR . 'lib/Application/Reservation/Notification/IReservationNotificationFactory.php');
require_once(ROOT_DIR . 'lib/Application/Reservation/Notification/IReservationNotificationService.php');

require_once(ROOT_DIR . 'lib/Application/Reservation/Notification/AddReservationNotificationService.php');
require_once(ROOT_DIR . 'lib/Application/Reservation/Notification/UpdateReservationNotificationService.php');
require_once(ROOT_DIR . 'lib/Application/Reservation/Notification/DeleteReservationNotificationService.php');
require_once(ROOT_DIR . 'lib/Application/Reservation/Notification/ApproveReservationNotificationService.php');
require_once(ROOT_DIR . 'lib/Application/Reservation/Notification/ReservationNotificationFactory.php');

require_once(ROOT_DIR . 'lib/Application/Reservation/Notification/AdminEmailNotification.php');
require_once(ROOT_DIR . 'lib/Application/Reservation/Notification/OwnerEmailNotification.php');

require_once(ROOT_DIR . 'lib/Application/Reservation/Notification/InviteeAddedEmailNotification.php');
require_once(ROOT_DIR . 'lib/Application/Reservation/Notification/ParticipantAddedEmailNotification.php');
require_once(ROOT_DIR . 'lib/Application/Reservation/Notification/ParticipantDeletedEmailNotification.php');
require_once(ROOT_DIR . 'lib/Application/Reservation/Notification/InviteeUpdatedEmailNotification.php');
require_once(ROOT_DIR . 'lib/Application/Reservation/Notification/ParticipantUpdatedEmailNotification.php');
require_once(ROOT_DIR . 'lib/Application/Reservation/Notification/GuestAddedEmailNotification.php');
require_once(ROOT_DIR . 'lib/Application/Reservation/Notification/GuestDeletedEmailNotification.php');
require_once(ROOT_DIR . 'lib/Application/Reservation/Notification/GuestUpdatedEmailNotification.php');

require_once(ROOT_DIR . 'lib/Application/Reservation/Notification/ParticipationNotification.php');
