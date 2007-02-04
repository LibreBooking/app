<?php
/**
* Sends all pending email reminders
* This file is meant to be run from the command line and has no HTML output
* @author Nick Korbel <lqqkout13@users.sourceforge.net>
* @version 06-14-06
* @package phpScheduleIt Command Line
*
* Copyright (C) 2003 - 2007 phpScheduleIt
* License: GPL, see LICENSE
*/

$basedir = dirname(__FILE__) . '/..';
require_once($basedir . '/lib/Reminder.class.php');
require_once($basedir . '/lib/db/ReminderDB.class.php');
require_once($basedir . '/lib/ReminderEmail.class.php');

$max_date = date(REMINDER_DATE_FORMAT);
$reminder = new Reminder();
$reminder->setDB(new ReminderDB());

$reminders = $reminder->getReminders($max_date);
$reminderids_sent = array();

for ($i = 0; $i < count($reminders); $i++) {
	$cur = $reminders[$i];
	if (is_lang_valid($cur->lang)) {
		include(get_language_path($cur->lang));		// Make sure email is in correct language
		$mail = new ReminderEmail(new PHPMailer());
		$mail->buildFromReminder($cur);
		$mail->send();
		$reminderids_sent[] = $cur->id;
	}
}

$reminder->deleteReminders($reminderids_sent);	// Delete reminder records that were sent
?>