<?php
/**
* Reset user password
* This file will allow a user to reset 
*  their password to a randomly generated password.
* This new password will be set in the database
* and it will be emailed to the user.
* @author Nick Korbel <lqqkout13@users.sourceforge.net>
* @version 10-12-04
* @package phpScheduleIt
*
* Copyright (C) 2003 - 2007 phpScheduleIt
* License: GPL, see LICENSE
*/
/**
* Template class
*/
include_once('lib/Template.class.php');
/**
* PHPMailer
*/
include_once('lib/PHPMailer.class.php');
/**
* User class
*/
//include_once('lib/User.class.php');

$t = new Template(translate('Forgot Password'));
// Print HTML header
$t->printHTMLHeader();

// Start main table
$t->startMain();

// Set status to false so we print the form by default
$status = false;

// Determine if we are changing the password
if ( (isset($_POST['email_address'])) && strstr($_SERVER['HTTP_REFERER'],$_SERVER['PHP_SELF']))
    $status = changePassword();

// Print form or success message
if ($status)
    printSuccess();
else
    printPasswordForm();

// End main table
$t->endMain();

// Print HTML footer
$t->printHTMLFooter();


/**
* Print password form
* This function prints out a form allowing
*  a user to enter their email to change
*  their forgotten password
* @param none
*/
function printPasswordForm() {
?>
<h5 align="center"><?php echo translate('This will change your password to a new, randomly generated one.')?></h5>
<h5 align="center"><?php echo translate('your new password will be set')?></h5>
<br />
<div align="center" style="border: solid 1px #CCCCCC">
<form name="new_pwd" method="post" action="<?php echo $_SERVER['PHP_SELF']?>">
  <?php echo translate('Email')?> <input type="text" class="textbox" name="email_address" />
  <br />
  <input type="submit" class="button" name="changePassword" value="<?php echo translate('Change Password')?>" />
  <input type="button" class="button" name="cancel" value="<?php echo translate('Cancel')?>" onclick="javascript: document.location='index.php';" />
</form>
</div>
<?php
}


/**
* Seed the random number generator
* @param none
* @return int seed
*/
function make_seed() {
    list($usec, $sec) = explode(' ', microtime());
    return (float) $sec + ((float) $usec * 100000);
}


/**
* Change user password
* This function creates a new random 8 character password,
*  sets it in the database and emails it to the user
* @return boolean true or false on success of function
* @see make_seed()
*/
function changePassword() {
    global $conf;
    $adminemail = $conf['app']['adminEmail'];
	$title = $conf['app']['title'];
	$use_logon_name = (bool)$conf['app']['useLogonName'];
      
    // Check if user exists
    $email = stripslashes(trim($_POST['email_address']));
    
	// Connect to database
	$AuthDB = new AuthDB();
	$id = $AuthDB->userExists($email);

	if (empty($id)) {
        CmnFns::do_error_box(translate('Sorry, we could not find that user in the database.'), '', false);
        return false;
    }
	else {
		$user = new User($id);
		$result = $user->get_user_data();
	}
    
    // Generate new 8 character password by choosing random 
    // ASCII characters between 48 and 122
    // (valid password characters)
    $pwd = '';
	$num = 0;
    
    for ($i = 0; $i < 8; $i++) {
        // Seed random for older versions of PHP
        mt_srand(make_seed());
        if ($i % 2 == 0)
			$num = mt_rand(97, 122);	// Lowercase letters
		else if ($i %3 == 0)
			$num = mt_rand(48, 58);		// Numbers and colon
		else
			$num = mt_rand(63, 90);		// Uppercase letters and '@ ?'
        // Put password together
        $pwd .= chr($num);
    }
    
	// Set password in database
	$user->set_password($pwd);
 
    // Send email to user
    $sub = translate('Your New Password', array($title));
    
    $msg = translate_email('new_password', $result['fname'], $conf['app']['title'], $pwd, CmnFns::getScriptURL(), $adminemail);
	
	$msg .= ($use_logon_name ? "\r\n" . translate('Your logon name is', array($result['logon_name'])) : '');
	
	// Send email    
    $mailer = new PHPMailer();
	$mailer->AddAddress($result['email'], $result['fname']);
	$mailer->FromName = $conf['app']['title'];
	$mailer->From = $adminemail;
	$mailer->Subject = $sub;
	$mailer->Body = $msg;
	$mailer->Send();
    
    return true;   
}


/**
* Print success message after changed password
* This function simply prints out a message informing
*  the user that thier password was changed and how to
*  log in now
* @param none
*/
function printSuccess() {
	CmnFns::do_message_box(translate('Your new passsword has been emailed to you.'), 'width: 75%;');
}
?>