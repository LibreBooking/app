<?php
/**
Copyright 2012-2014 Alois Schloegl, IST Austria
Copyright 2012-2014 Moritz Schepp, IST Austria
Copyright 2013-2014 Patrick Meidl, IST Austria

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

error_reporting(E_ERROR | E_WARNING | E_PARSE);
header("Content-Type: application/json", true);

define('ROOT_DIR', '../../');
require_once(ROOT_DIR . 'config/config.php');
require_once(ROOT_DIR . 'Pages/Ajax/ReservationSavePage.php');
#require_once(ROOT_DIR . 'lib/Application/Reservation/Validation/namespace.php');
require_once(ROOT_DIR . 'lib/Config/namespace.php');
require_once(ROOT_DIR . 'lib/Server/namespace.php');
require_once(ROOT_DIR . 'lib/Common/namespace.php');
require_once(ROOT_DIR . 'Domain/namespace.php');
require_once(ROOT_DIR . 'Domain/Access/namespace.php');
require_once(ROOT_DIR . 'lib/Application/Reservation/namespace.php');
require_once(ROOT_DIR . 'lib/Application/Reservation/Persistence/namespace.php');
require_once(ROOT_DIR . 'lib/Application/Reservation/Validation/namespace.php');
require_once(ROOT_DIR . 'lib/Application/Reservation/Notification/namespace.php');

## use parameters in config/config
$tz       = $conf['settings']['server.timezone'];
$url      = $conf['settings']['script.url'];
$ikey     = $conf['settings']['ics']['import.key'];
$enabled  = $conf['settings']['ics']['import'];

/*
CREATE
1 Organizer (username or email address)
2 email address of resource (matches with resource.contact_info)
3 start_time
4 end_time
5 [optional] recurrence rule
6 [optional] Attendees
7 Summary/Title
8 [optional] Description
9 [optional] TimeStamp
*/

if (!$enabled) {
	header('HTTP/1.1 406 Not Acceptable', true, 406);
	print json_encode(array('message' => "iCal import is not enabled"));
	return;
}

$params = array(
	'username' => null,
	'starts_at' => null,
	'ends_at' => null,
	'summary' => null,
);

foreach ($params AS $key => $val) {
	if (!$_REQUEST[$key]) {
		header('HTTP/1.1 406 Not Acceptable', true, 406);
		print json_encode(array('message' => "$key has to be set"));
		return;
	}
}

if ( $ikey != NULL
  && $ikey != $_REQUEST['ikey'] )
{
        header('HTTP/1.1 401 Unauthorized', true, 401);
        print json_encode(array('message' => "your iKey is invalid"));
        return;
}

$username     = $_REQUEST['username'];
$starts_at    = $_REQUEST['starts_at'];
$ends_at      = $_REQUEST['ends_at'];
#$recurrence   = $_REQUEST['recurrence'];
$title        = $_REQUEST['summary'];
$description  = $_REQUEST['description'];
$contact_info = trim($_REQUEST['contact_info']);
$rid          = trim($_REQUEST['rid']);

##$regexp_email = firstname.lastname@aaa.bbb.com;
$regexp_email = "/^[^0-9][A-z0-9_]+([.][A-z0-9_]+)*[@][A-z0-9_]+([.][A-z0-9_]+)*[.][A-z]{2,4}$/";
if (preg_match($regexp_email, $contact_info)) {
	$contact_info = strtolower($contact_info);
}

/*************************************************
 	user information
 *************************************************/
$userRepository = new UserRepository();
$user = $userRepository->LoadByUsername($username);
if ($user instanceof NullUser) {
	header('HTTP/1.1 403 Forbidden', true, 403);
	print json_encode(array('message' => "invalid userId"));
	return;
}
$user_session = new UserSession($user->Id());
$user_session->Timezone = 'UTC';


/*************************************************
 	resources
 *************************************************/
$resourceRepository = new ResourceRepository();
if ($contact_info && $rid) {
        header('HTTP/1.1 406 Not Acceptable', true, 406);
        print json_encode(array('message' => "You must not set both contact_info and rid"));
        return;
}
if ($contact_info) {
	$resource = $resourceRepository->LoadByContactInfo($contact_info);
} elseif ($rid) {
	$resource = $resourceRepository->LoadByPublicId($rid);
} else {
        header('HTTP/1.1 406 Not Acceptable', true, 406);
        print json_encode(array('message' => "contact_info or rid has to be set"));
        return;
}


/*************************************************
 	date
 *************************************************/
$timing = DateRange::Create($starts_at, $ends_at, $tz);


/*************************************************
 	Action
 *************************************************/
$series = ReservationSeries::Create(
	$user->Id(),
	$resource,
	$title,
	$description,
	$timing,
	new RepeatNone(),
	$user_session
);

	$reservationAction = ReservationAction::Create;

	$pfactory = new ReservationPersistenceFactory();
	$persistenceService = $pfactory->Create($reservationAction);

	$vfactory = new ReservationValidationFactory();
	$validationService = $vfactory->Create($reservationAction, $user_session);

	$nfactory = new ReservationNotificationFactory();
	$notificationService = $nfactory->Create($reservationAction, $user_session);

#	$handler = new ReservationHandler($persistenceService, $validationService, $notificationService);

$validationResult = $validationService->Validate($series);

$result = $validationResult->CanBeSaved();

if ($result) {
	try
	{
		$persistenceResult = $persistenceService->Persist($series);
		header('HTTP/1.1 200 Ok', true, 200);
		$response = array(
			'series_id' => $series->SeriesId(),
			'reference_number' => $series->CurrentInstance()->ReferenceNumber(),
			'requires_approval' => $resource->GetRequiresApproval()
		);

		print json_encode($response);
		return;
	}
	catch (Exception $ex)
	{
		//Log::Error('Error saving reservation: %s', $ex);
		header('HTTP/1.1 403 Forbidden', true, 403);
		print json_encode(array('message' => "exception in making reservation persistant"));
		return;
	}
}
else
{
	header('HTTP/1.1 406 Not Acceptable', true, 406);
	$response = array(
		'resource' => array(
			'name' => $resource->GetName(),
			'email' => $resource->GetContact()
		),
		'errors' => $validationResult->GetErrors(),
	);
	print json_encode($response);
	return;

}


?>