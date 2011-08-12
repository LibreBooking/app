<pre>
<?php
// Demonstrates diagnostic testing of an email address
require_once '../is_email.php';
require_once '../test/meta.php';

$email = 'dominic@sayers.cc';

$result		= is_email($email, true, true);
$analysis	= is_email_analysis($result, ISEMAIL_META_ALL);

echo "Result is $result" . PHP_EOL;
echo 'Result description is ' . 	$analysis[ISEMAIL_META_DESC]		. PHP_EOL;
echo 'PHP constant name is ' .		$analysis[ISEMAIL_META_CONSTANT]	. PHP_EOL;
echo 'SMTP enhanced status code is ' .	$analysis[ISEMAIL_META_SMTP]		. PHP_EOL;
?>
</pre>