is_email()
Copyright 2008-2011 Dominic Sayers <dominic@sayers.cc>
http://www.dominicsayers.com/isemail
BSD License (http://www.opensource.org/licenses/bsd-license.php)

-------------------------------------------------------------------------------
How to use is_email()
-------------------------------------------------------------------------------
1. Add the downloaded file is_email.php to your project
2. In your scripts use it like this:

	require_once 'is_email.php';
	if (is_email($email)) echo "$email is a valid email address";

3. If you want to return detailed diagnostic error codes then you can ask
is_email to do so. Something like this should work:

	require_once 'is_email.php';
	$email = 'dominic@sayers.cc';
	$result = is_email($email, true, true);

	if ($result === ISEMAIL_VALID) {
		echo "$email is a valid email address";
	} else if ($result < ISEMAIL_THRESHOLD) {
		echo "Warning! $email has unusual features (result code $result)";
	} else {
		echo "$email is not a valid email address (result code $result)";
	}

4. Example scripts are in the extras folder

-------------------------------------------------------------------------------
Version history
-------------------------------------------------------------------------------
Date       Component    Version Notes
.......... ............ ....... ...............................................
2010-10-18 is_email.php 3.0	Forensic categorization of email validity
.......... ............ ....... ...............................................
2010-10-18 tests.xml    3.0	New schema designed to enhance fault
				identification.
-------------------------------------------------------------------------------
