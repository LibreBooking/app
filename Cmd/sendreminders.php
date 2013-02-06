<?php

/**
Part of phpScheduleIt
written by Stephen Oliver
add this file to /Pages
 */

define('ROOT_DIR', '../');
require_once(ROOT_DIR . 'Domain/Access/namespace.php');
require_once(ROOT_DIR . 'Domain/Reminder.php');


$rep = new ReminderRepository();
$head = $rep->GetAll();
$user = ServiceLocator::GetServer()->GetUserSession();
foreach($head as $remind){
    $time1 = Date::FromDatabase($remind->SendTime());
    $time2 = $time1->Format('Y:m:d H:i');
    $current = Date::Now()->Format('Y:m:d H:i');
    if($time2 <= $current){
        Reminder::SendItOut($remind);
    }
};
