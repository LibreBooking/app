<?php
/*
Copyright 2012-2014 Alois Schloegl, IST Austria
Copyright 2012-2014 Moritz Schepp, IST Austria

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
$icskey   = $conf['settings']['ics']['subscription.key'];
$ikey     = $conf['settings']['ics']['import.key'];
$enabled  = $conf['settings']['ics']['import'];

//header("delete ical event into Booked Scheduler");
if (!$enabled) {
        header('HTTP/1.1 406 Not Acceptable', true, 406);
        print json_encode(array('message' => "iCal import is not enabled"));
        return;
}

/*
    Input
 */
$params = array(
        'username' => null,
        'rn' => null,
);
$params = array_merge($params, $_REQUEST);

$username     = $params['username'];
$rn           = $params['rn'];
#$contact_info = $params['contact_info'];

foreach ($params AS $key => $val) {
        if (!$val) {
                header('HTTP/1.1 406 Not Acceptable', true, 406);
                print json_encode(array('message' => "$key has to be set"));
                return;
        }
}

if ( $ikey != NULL
  && $ikey != $params['ikey'] )
{
        header('HTTP/1.1 401 Unauthorized', true, 401);
        print json_encode(array('message' => "your iKey is invalid"));
        return;
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
#$resourceRepository = new ResourceRepository();
#$resource = $resourceRepository->LoadByContactInfo($params['contact_info']);

/*************************************************
 	Action
 *************************************************/
$updateAction = ReservationAction::Delete;
$persistenceFactory = new ReservationPersistenceFactory();
$persistenceService = $persistenceFactory->Create($updateAction);

#$handler = ReservationHandler::Create($updateAction, $persistenceService);

$reservationRepository = new ReservationRepository();
$series = $reservationRepository->LoadByReferenceNumber($params['rn']);

if (!$series) {
        header('HTTP/1.1 404 Not Found', true, 404);
        $response = array(
                'reference_number' => $rn,
                'message' => 'Reservation could not be found',
        );
        print json_encode($response);
        return;
}

$vfactory = new ReservationValidationFactory();
$validationService = $vfactory->Create($updateAction, $user_session);

$nfactory = new ReservationNotificationFactory();
$notificationService = $nfactory->Create($updateAction, $user_session);

$result = $series->Delete($user_session);
if (1) {
        try
        {

                $persistenceService->Persist($series);

                header('HTTP/1.1 200 Ok', true, 200);
                $response = array(
                        #'url' => $url . "/reservation.php?rn=" . $rn,
			'message' => 'Reservation deleted',
                        'reference_number' => $rn
                );
                //print json_encode($response,JSON_UNESCAPED_SLASHES);  ## only in Php 5.4
                print json_encode($response);
                return;
        }
        catch (Exception $ex)
        {
                Log::Error('Error deleting reservation: %s', $ex);
                throw($ex);
        }

        $this->notificationService->Notify($reservationSeries);
}
else
{
        header('HTTP/1.1 406 Not Acceptable', true, 406);
        $response = array(
                'series_id' => $series->SeriesId(),
                'reference_number' => $rn,
                'message' => 'Reservation could not be deleted',
                'status' => $result
        );
        print json_encode($response);
}

