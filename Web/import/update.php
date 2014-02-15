<?php
/*
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

require_once('../../config/config.php');

## use parameters in config/config
$tz       = $conf['settings']['server.timezone'];
$url      = $conf['settings']['script.url'];
$icskey   = $conf['settings']['ics']['subscription.key'];
$ikey     = $conf['settings']['ics']['import.key'];
$enabled  = $conf['settings']['ics']['import'];

if (!$enabled) {
        header('HTTP/1.1 406 Not Acceptable', true, 406);
        print json_encode(array('message' => "iCal import is not enabled"));
        return;
}

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


$params = array(
	'rn' => null,
        'username' => null,
        'starts_at' => null,
        'ends_at' => null,
        'summary' => null,
        'description' => null,
);
$params = array_merge($params, $_REQUEST);

if ( $ikey != NULL
  && $ikey != $params['ikey'] )
{
          header('HTTP/1.1 401 Unauthorized', true, 401);
          print json_encode(array('message' => "your iKey is invalid",'ikey' => $ikey, 'param_ikey' => $params['ikey']));
          return;
}

foreach (array('rn', 'username') AS $key) {
  if (!$params[$key]) {
    header('HTTP/1.1 406 Not Acceptable', true, 406);
    print json_encode(array('message' => "$key has to be set"));
    return;
  }
}
$rn = $params['rn'];

$userRepo = new UserRepository();
$user = $userRepo->LoadByUsername($params['username']);
if ($user instanceof NullUser) {
        header('HTTP/1.1 403 Forbidden', true, 403);
        print json_encode(array('message' => "invalid userId" ));
        return;
}

$user_session = new UserSession($user->Id());

// load resource by contact_info or rid
$resourceRepository = new ResourceRepository();
$contact_info = trim($_REQUEST['contact_info']);
$rid = trim($_REQUEST['rid']);
if ($contact_info && $rid) {
        header('HTTP/1.1 406 Not Acceptable', true, 406);
        print json_encode(array('message' => "You must not set both contact_info and rid"));
        return;
}
if ($contact_info) {
	$resource = $resourceRepository->LoadByContactInfo($contact_info);
} elseif ($rid) {
	$resource = $resourceRepository->LoadByPublicId($rid);
}

$updateAction = ReservationAction::Update;
$persistenceFactory = new ReservationPersistenceFactory();
$persistenceService = $persistenceFactory->Create($updateAction);
$handler = ReservationHandler::Create($updateAction, $persistenceService, ServiceLocator::GetServer()->GetUserSession());

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


$series->ApplyChangesTo(SeriesUpdateScope::FullSeries);

if ($params['starts_at'] || $params['ends_at'])
{
        if (!$params['starts_at'])
        {
                $params['starts_at'] = $series->CurrentInstance()->Duration()->GetBegin();
        }
        if (!$params['ends_at'])
        {
                $params['ends_at'] = $series->CurrentInstance()->Duration()->GetEnd();
        }

        $timing = DateRange::Create($params['starts_at'], $params['ends_at'], $tz);
        $series->UpdateDuration($timing);
}


if ( $user->Id() == $series->UserId() )
{
        $series->WithOwner($user->Id());
}

$title = $series->Title();
if ($params['summary'])
{
        $title = $params['summary'];
}

$description = $series->Description();
if ($params['description'])
{
        $description = $params['description'];
}
$series->Update($user->Id(), $resource, $title, $description, $user_session);

$vfactory = new ReservationValidationFactory();
$validationService = $vfactory->Create($updateAction, $user_session);

$nfactory = new ReservationNotificationFactory();
$notificationService = $nfactory->Create($updateAction, $user_session);

$validationResult = $validationService->Validate($series);
$result = $validationResult->CanBeSaved();

if ($result) {
        try
        {
                $persistenceService->Persist($series);

                header('HTTP/1.1 200 Ok', true, 200);
                $rn = $series->CurrentInstance()->ReferenceNumber();
                $response = array(
                        #'url' => $url . "/reservation.php?rn=" . $rn,
                        'series_id' => $series->SeriesId(),
                        'title' => $title,
                        'description' => $description,
                        'reference_number' => $rn
                );
                //print json_encode($response,JSON_UNESCAPED_SLASHES);  ## only in Php 5.4
                print json_encode($response);
                return;
        }
        catch (Exception $ex)
        {
                Log::Error('Error updating reservation: %s', $ex);
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
                'message' => 'Reservation could not be updated',
                'status' => $result
        );
        print json_encode($response);
}

?>