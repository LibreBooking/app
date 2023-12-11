<?php
// // cleanup_script.php

// // Your PHP logic goes here
// $message = "Cron job executed successfully!\n";
// $currentDateTime = date('Y-m-d H:i:s');
// echo 'PROJECT -> '. $currentDateTime . ': ' .$message;

/**
*  Cron Example:
*  This script must be executed at a specific time to be enabled
*  * * * * * /usr/bin/env php -f ${WWW_DIR}/librebooking/Jobs/sendmissedcheckin.php

*  Each * correspods to Minute Hour Day_Of_Month Month Day_Of_Week, respectively

*  /usr/bin/env php -f                                  -> the path to php (run "which php" to know where it is)
*  ${WWW_DIR}/librebooking/Jobs/sendmissedcheckin.php   -> the path to this script
*/
define('ROOT_DIR', dirname(__FILE__) . '/../');
require_once(ROOT_DIR . 'Domain/Access/namespace.php');
require_once(ROOT_DIR . 'Jobs/JobCop.php');

Log::Debug('Running deleteolddata.php');

$configFilePath = '/opt/lampp/htdocs/librebooking/app/config/config.php';

if (file_exists($configFilePath)) { echo ("Ficheiro existe!"); } 

JobCop::EnsureCommandLine();

try {
    //ANNOUNCEMENTS
    $getAnnouncements = GetAnnoucementsIdsToDeleteQuery();
    echo $getAnnouncements;
    $reader = ServiceLocator::GetDatabase()->Query($getAnnouncements);
    Log::Debug('Getting %s old announcements', $reader->NumRows());
    while ($row = $reader->GetRow()) {
        $annoucementId = $row[ColumnNames::ANNOUNCEMENT_ID];
        Log::Debug('Deleting announcement with id %s', $annoucementId);
        DeleteAnnouncementsQuery($AnnoucementId);
    }
    $reader->Free();

    //BLACKOUTS
    $getBlackouts = GetBlackoutsIdsToDeleteQuery();
    echo $getBlackouts;
    $reader = ServiceLocator::GetDatabase()->Query($getBlackouts);
    Log::Debug('Getting %s old blackouts', $reader->NumRows());
    while ($row = $reader->GetRow()) {
        $blackoutId = $row[ColumnNames::BLACKOUT_SERIES_ID];
        Log::Debug('Deleting blackout with id %s', $blackoutId);
        DeleteBlackoutsQuery($BlackoutId);      
    }
    $reader->Free();

    //RESERVATIONS
    $getReservations = GetReservationsIdsToDeleteQuery();
    echo $getReservations;
    $reader = ServiceLocator::GetDatabase()->Query($getReservations);
    Log::Debug('Getting %s old reservations', $reader->NumRows());
    while ($row = $reader->GetRow()) {
        $reservationId = $row[ColumnNames::RESERVATION_SERIES_ID];
        Log::Debug('Deleting reservation with id %s', $reservationId);
        DeleteReservationsQuery($ReservationId);
    }
    $reader->Free();
    

} catch (Exception $ex){
    Log::Error('Error running deleteolddata.php: %s', $ex);
}

Log::Debug('Finished running deleteolddata.php');


function GetReservationsIdsToDeleteQuery() {
    
    $deleteBefore = Date::Now()->AddYears(-1);

    $reservationIds = new AdHocCommand(
        "   SELECT reservation_series.series_id
            FROM reservation_series
            LEFT JOIN reservation_instances 
            ON reservation_instances.series_id = reservation_series.series_id
            WHERE reservation_series.repeat_type = 'none' AND end_date < '{$deleteBefore}'
            
            UNION
            
            SELECT series_id
            FROM reservation_series
            WHERE SUBSTRING_INDEX(SUBSTRING_INDEX(repeat_options, '|', -1), '=', -1) < '{$deleteBefore}' AND repeat_options != ''"
    );

    return $reservationIds;
}

function GetAnnoucementsIdsToDeleteQuery(){

    $deleteBefore = Date::Now()->AddYears(-1);

    $annoucementsIds = new AdHocCommand(
        "   SELECT announcementid
            FROM announcements
            WHERE end_date < '{$deleteBefore}'"
    );

    return $annoucementsIds;
}

function GetBlackoutsIdsToDeleteQuery(){

    $deleteBefore = Date::Now()->AddYears(-1);

    $blackoutsIds = new AdHocCommand(
        "   SELECT blackout_series_id
            FROM blackout_series
            WHERE SUBSTRING_INDEX(SUBSTRING_INDEX(SUBSTRING_INDEX(repeat_options, '|', -2),'=',-2),'|',1) < '{$deleteBefore}' AND repeat_options != ''
            
            UNION
            
            SELECT blackout_series.blackout_series_id
            FROM blackout_series
            LEFT JOIN blackout_instances
            ON blackout_series.blackout_series_id = blackout_instances.blackout_series_id
            WHERE blackout_series.repeat_type = 'none' AND blackout_instances.end_date < '{$deleteBefore}'"
    );

    return $blackoutsIds;
}

function DeleteReservationsQuery($reservationId){
    $deleteReservationAcessories = new AdHocCommand(
        "DELETE FROM reservation_acessories
        WHERE series_id = '{$reservationId}'"
    );
    ServiceLocator::GetDatabase()->Execute($deleteReservationAcessories);

    $deleteReservationFiles = new AdHocCommand(
        "DELETE FROM reservation_files
        WHERE series_id = '{$reservationId}'"
    );
    ServiceLocator::GetDatabase()->Execute($deleteReservationFiles);

    $deleteReservationGuests = new AdHocCommand(
        "DELETE FROM reservation_guests
        WHERE series_id = '{$reservationId}'"
    );
    ServiceLocator::GetDatabase()->Execute($deleteReservationGuests);

    $deleteReservationReminders = new AdHocCommand(
        "DELETE FROM reservation_reminders 
        WHERE series_id = '{$reservationId}'"
    );
    ServiceLocator::GetDatabase()->Execute($deleteReservationReminders);

    $deleteReservationResources = new AdHocCommand(
        "DELETE FROM reservation_resources
        WHERE series_id = '{$reservationId}'"
    );
    ServiceLocator::GetDatabase()->Execute($deleteReservationResources);

    $deleteReservationUsers = new AdHocCommand(
        "DELETE FROM reservation_users
        WHERE series_id = '{$reservationId}'"
    );
    ServiceLocator::GetDatabase()->Execute($deleteReservationUsers);

    $deleteReservationInstances = new AdHocCommand(
        "DELETE FROM reservation_instances
        WHERE series_id = '{$reservationId}'"
    );
    ServiceLocator::GetDatabase()->Execute($deleteReservationInstances);

    $deleteReservationSeries = new AdHocCommand(
        "DELETE FROM reservation_series
        WHERE series_id = '{$reservationId}'"
    );    
    ServiceLocator::GetDatabase()->Execute($deleteReservationSeries);

    Log::Debug('Reservation with id %s deleted', $reservationId);
}

function DeleteAnnouncementsQuery($announcementid){
    $deleteGroupAnnouncements = new AdHocCommand(
        "   DELETE FROM announcement_groups 
            WHERE announcementid = '{$announcementid}'"
    );
    ServiceLocator::GetDatabase()->Execute($deleteGroupAnnouncements);

    $deleteResourceAnnouncements = new AdHocCommand(
        "   DELETE FROM announcement_resources 
            WHERE announcementid = '{$announcementid}'"
    );
    ServiceLocator::GetDatabase()->Execute($deleteResourceAnnouncements);

    $deleteAnnouncements = new AdHocCommand(
        "   DELETE FROM announcements
            WHERE announcementid = '{$announcementid}'"
    );
    ServiceLocator::GetDatabase()->Execute($deleteAnnouncements);

    Log::Debug('Announcement with id %s deleted', $announcementid);
}

function DeleteBlackoutsQuery($blackoutid){
    $deleteBlackoutSeriesResources = new AdHocCommand(
        "   DELETE FROM blackout_series_resources
            WHERE blackout_series_id = '{$blackoutid}'"
    );
    ServiceLocator::GetDatabase()->Execute($deleteBlackoutSeriesResources);

    $deleteBlackoutInstances = new AdHocCommand(
        "   DELETE FROM blackout_instances
            WHERE blackout_series_id = '{$blackoutid}'"
    );
    ServiceLocator::GetDatabase()->Execute($deleteBlackoutInstances);

    $deleteBlackoutSeries = new AdHocCommand(
        "   DELETE FROM blackout_series
            WHERE blackout_series_id = '{$blackoutid}'"
    );
    ServiceLocator::GetDatabase()->Execute($deleteBlackoutSeries);

    Log::Debug('Blackout with id %s deleted', $blackoutid);
}