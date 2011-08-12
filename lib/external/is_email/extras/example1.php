<?php
// Demonstrates the simplest use of is_email()
require_once '../is_email.php';

// Valid
$email = 'dominic@sayers.cc';
if (is_email($email)) echo "$email is a valid email address";

echo '<br/>';

// Invalid
$email = 'dominic.@sayers.cc';
if (is_email($email))
	echo "$email is a valid email address";
else
	echo "$email is not a valid email address";

?>