<?php
$txt = "%s has invited you to participate in the following reservation:\r\n\r\n"
		. "Resource: %s\r\n"
		. "Start Date: %s\r\n"
		. "Start Time: %s\r\n"
		. "End Date: %s\r\n"
		. "End Time: %s\r\n"
		. "Summary: %s\r\n"
		. "Repeated Dates (if present): %s\r\n\r\n"
		. "To accept this invitation click this link (copy and paste if it is not highlighted) %s\r\n"
		. "To decline this invitation click this link (copy and paste if it is not highlighted) %s\r\n"
		. "To accept select dates or manage your invitations at a later time, please log into %s at %s";
$sprintf_args = "'Nick Korbel','Resource 1','06/02/2006','9:00am','06/02/2006','10:30am','','','http://localhost/phpScheduleIt/manage_invites.php?id=sc1447cd03f6f4a6&memberid=sc1447cdae95d446&accept_code=sc1447fb2dfa89c3&action=accept','http://localhost/phpScheduleIt/manage_invites.php?id=sc1447cd03f6f4a6&memberid=sc1447cdae95d446&accept_code=sc1447fb2dfa89c3&action=decline','phpScheduleIt','http://localhost/phpScheduleIt'";
eval('echo sprintf("' . str_replace('"','\"', $txt) . "\",$sprintf_args);");
		
?>