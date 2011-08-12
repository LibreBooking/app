<?php
// Using is_email() to report unusual addresses
require_once '../is_email.php';

function test_address($email) {
	$result = is_email($email, true, true);

	if ($result === ISEMAIL_VALID) {
		echo "$email is a valid email address";
	} else if ($result < ISEMAIL_THRESHOLD) {
		echo "Warning! $email has unusual features (result code $result)";
	} else {
		echo "$email is not a valid email address (result code $result)";
	}

	echo '<br/>';
}

test_address('dominic@sayers.cc');
test_address('dominic@sayers');
test_address('dominic.@sayers.cc');
?>