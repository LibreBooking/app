<?php
/**
* Authorization and login functionality
* @author Nick Korbel <lqqkout13@users.sourceforge.net>
* @author David Poole <David.Poole@fccc.edu>
* @version 05-31-06
* @package phpScheduleIt
*
* Copyright (C) 2003 - 2007 phpScheduleIt
* License: GPL, see LICENSE
*/

$basedir = dirname(__FILE__) . '/..';
include_once($basedir . '/lib/db/AuthDB.class.php');
include_once($basedir . '/lib/User.class.php');
include_once($basedir . '/lib/PHPMailer.class.php');
include_once($basedir . '/templates/auth.template.php');

/**
* This class provides all authoritiative and verification
*  functionality, including login/logout, registration,
*  and user verification
*/
class Auth {
	var $is_loggedin = false;
	var	$login_msg = '';
	var $is_attempt = false;
	var $db;
	var $success;

	/**
	* Create a reference to the database class
	*  and start the session
	* @param none
	*/
	function Auth() {
		$this->db = new AuthDB();
	}

	/**
	* Check if user is the administrator
	* This function checks to see if the currently
	*  logged in user is the administrator, granting
	*  them special permissions
	* @param none
	* @return boolean whether the user is the admin
	*/
	function isAdmin() {
		return isset($_SESSION['sessionAdmin']);
	}

	/**
	* Check user login
	* This function checks to see if the user has
	* a valid session set (if they are logged in)
	* @param none
	* @return boolean whether the user is logged in
	*/
	function is_logged_in() {
		return isset($_SESSION['sessionID']);
	}

	/**
	* Returns the currently logged in user's userid
	* @param none
	* @return the userid, or null if the user is not logged in
	*/
	function getCurrentID() {
		return isset($_SESSION['sessionID']) ? $_SESSION['sessionID'] : null;
	}

	/**
	* Logs the user in
	* @param string $uname username
	* @param string $pass password
	* @param string $cookieVal y or n if we are using cookie
	* @param string $isCookie id value of user stored in the cookie
	* @param string $resume page to forward the user to after a login
	* @param string $lang language code to set
	* @return any error message that occured during login
	*/
	function doLogin($uname, $pass, $cookieVal = null, $isCookie = false, $resume = '', $lang = '') {
		global $conf;
		$msg = '';
		$activeAccount = true;
		if (empty($resume)) $resume = 'ctrlpnl.php';		// Go to control panel by default

		$_SESSION['sessionID'] = null;
		$_SESSION['sessionName'] = null;
		$_SESSION['sessionAdmin'] = null;
		$_SESSION['hourOffset'] = null;

		$uname = stripslashes($uname);
		$pass = stripslashes($pass);
		$ok_user = $ok_pass = false;
		$use_logonname = (bool)$conf['app']['useLogonName'];

		$adminemail = strtolower($conf['app']['adminEmail']);
		if ($isCookie !== false) {		// Cookie is set			
			$id = $isCookie;
			$activeAccount = $this->db->check_active_account($id);
			if ($this->db->verifyID($id)) {
				$ok_user = $ok_pass = true;
			}
			else {
				$ok_user = $ok_pass = false;
				setcookie('ID', '', time()-3600, '/');	// Clear out all cookies
				$msg .= translate('That cookie seems to be invalid') . '<br/>';
			}
		}
		else {
		  if( $conf['ldap']['authentication'] ) {
		    // Include LDAPEngine class
            include_once('LDAPEngine.class.php');

            $ldap = new LDAPEngine($uname, $pass);

	        if( $ldap->connected() ) {

                $mail = $ldap->getUserEmail();

                if( $mail ) {

                    $id = $this->db->userExists( $mail );
					
                    if( $id ) {
                    	$activeAccount = $this->db->check_active_account($id);
                        // check if LDAP and local DB are in consistancy.
                        $updates = $ldap->getUserData();

                        if( $this->db->check_updates( $id, $updates ) ) {
                            $this->db->update_user( $id, $updates );
                        }

                    } else {
                        $data = $ldap->getUserData();
                        $id = $this->do_register_user( $data, false );
                    }

                    $ok_user = true; $ok_pass = true;

                }
				else {
                    $msg .= translate('This system requires that you have an email address.');
            	}
            }
			else {
                $msg .= translate('Invalid User Name/Password.');
            }

            $ldap->disconnect();

		  }
		  else {		  	
				// If we cant find email, set message and flag
				if ( !$id = $this->db->userExists($uname, $use_logonname) ) {
					$msg .= translate('We could not find that logon in our database.') . '<br/>';
					$ok_user = false;
				}
				else
					$ok_user = true;
	
				// If password is incorrect, set message and flag
				if ($ok_user && !$this->db->isPassword($uname, $pass, $use_logonname)) {
					$msg .= translate('That password did not match the one in our database.') . '<br/>';
					$ok_pass = false;
				}
				else
					$ok_pass = true;
				if($ok_user) {	// if user exists check for active account
					$activeAccount = $this->db->check_active_account($id);
					//echo "######".$activeAccount;
					if($ok_user && !$activeAccount) { // if the user exists and the account is not active
				  		$msg = translate('NotActivated'). '<br/>';
				  		$ok_user = $ok_pass = false;
				  	}			  	
				}
		  	
		  }
        }


		// If the login failed, notify the user and quit the app
		if (!$ok_user || !$ok_pass) {
			if($activeAccount)
				$msg .= translate('You can try');
			return $msg;
		}
		else {

			$this->is_loggedin = true;
			$user = new User($id);	// Get user info

			// If the user wants to set a cookie, set it
			// for their ID and fname.  Expires in 30 days (2592000 seconds)
			if (!empty($cookieVal)) {
				//die ('Setting cookie');
				setcookie('ID', $user->get_id(), time() + 2592000, '/');
			}

			 // If it is the admin, set session variable
			if ($user->get_email() == $adminemail || $user->get_isadmin()) {
				$_SESSION['sessionAdmin'] = $user->get_email();
			}

			// Set other session variables
			$_SESSION['sessionID'] = $user->get_id();
			$_SESSION['sessionName'] = $user->get_fname();
			$_SESSION['hourOffset'] = $user->get_timezone() - $conf['app']['timezone'];

			if ($lang != '') {
				set_language($lang);
				if ($lang != $user->get_lang()) {
					$user->set_lang($lang);		// Language changed so update the DB
				}
			}

			// Send them to the control panel
			if($activeAccount) {
			CmnFns::redirect(urldecode($resume));
			}
		}
	}

	/**
	* Log the user out of the system
	* @param none
	*/
	function doLogout() {
		// Check for valid session
		if (!$this->is_logged_in()) {
			$this->print_login_msg();
			die;
		}
		else {
			// Destroy all session variables
			if (isset($_SESSION['sessionID'])) unset($_SESSION['sessionID']);
			if (isset($_SESSION['sessionName'])) unset($_SESSION['sessionName']);
			if (isset($_SESSION['sessionAdmin'])) unset($_SESSION['sessionAdmin']);
			if (isset($_SESSION['hourOffset'])) unset($_SESSION['hourOffset']);
			session_destroy();

			// Clear out all cookies
			setcookie('ID', '', time()-3600, '/');

			// Refresh page
			CmnFns::redirect($_SERVER['PHP_SELF']);
		}
	}

	/**
	* Register a new user
	* This function will allow a new user to register.
	* It checks to make sure the email does not already
	* exist and then stores all user data in the login table.
	* It will also set a cookie if the user wants
	* @param array $data array of user data
	* @param bool $adminCreated if the user was created by an admin
	*/
	function do_register_user($data, $adminCreated) {
		global $conf;
		// Verify user data
		$msg = $this->check_all_values($data, false);
		if (!empty($msg)) {
			return $msg;
		}

		$adminemail = strtolower($conf['app']['adminEmail']);
		$techEmail  = empty($conf['app']['techEmail']) ? translate('N/A') : $conf['app']['techEmail'];
		$url        = CmnFns::getScriptURL();

		// Register the new member
		$id = $this->db->insertMember($data);

		$this->db->autoassign($id);		// Give permission on auto-assigned resources

		$mailer = new PHPMailer();
		$mailer->IsHTML(false);

		// Email user informing about successful registration
		$subject = $conf['ui']['welcome'];
		$activationPart = $url."/register.php?activate=".md5($id)."&email=".$data['emailaddress'];
		$msg = translate_email('register',
								$data['fname'], $conf['ui']['welcome'],
								(isset($data['logon_name']) ? $data['logon_name'] : $data['emailaddress']),
								$data['fname'], $data['lname'],
								$data['phone'],
								$data['institution'],
								$data['position'],
								$url,
								$adminemail,
								$activationPart								
								);
		//echo "msg--";						
		//$msg .= "<br/>Activate your ID using ".$activationLink."<br/>".$data['position'];
		$mailer->AddAddress($data['emailaddress'], $data['fname'] . ' ' . $data['lname']);
		$mailer->From = $adminemail;
		$mailer->FromName = $conf['app']['title'];
		$mailer->Subject = $subject;
		$mailer->Body = $msg;
		$mailer->Send();
		// Email the admin informing about new user
		if ($conf['app']['emailAdmin']) {
			$subject = translate('A new user has been added');
			$msg = translate_email('register_admin',
								$data['emailaddress'],
								$data['fname'], $data['lname'],
								$data['phone'],
								$data['institution'],
								$data['position']);

			$mailer->ClearAllRecipients();
			$mailer->AddAddress($adminemail);
			$mailer->Subject = $subject;
			$mailer->Body = $msg;
			$mailer->Send();
		}
		if (!$adminCreated) {
				// If the user wants to set a cookie, set it
				// for their ID and fname.  Expires in 30 days (2592000 seconds)
				if (isset($data['setCookie'])) {
					setcookie('ID', $id, time() + 2592000, '/');
				}

				// If it is the admin, set session variable
				if ($data['emailaddress'] == $adminemail) {
					$_SESSION['sessionAdmin'] = $adminemail;
				}

				// Set other session variables
				$_SESSION['sessionID'] = $id;
				$_SESSION['sessionName'] = $data['fname'];
				$_SESSION['hourOffset'] = $data['timezone'] - $conf['app']['timezone'];
		}

		// Write log file
		CmnFns::write_log('New user registered. Data provided: fname- ' . $data['fname'] . ' lname- ' . $data['lname']
						. ' email- '. $data['emailaddress'] . ' phone- ' . $data['phone'] . ' institution- ' . $data['institution']
						. ' position- ' . $data['position'], $id);

		if( !$conf['ldap']['authentication'] ) {
			//$url = 'ctrlpnl.php';
			$url = 'index.php';
			if ($adminCreated){
				$url = 'admin.php?tool=users';
			}
			//CmnFns::redirect($url, 1, false);
			$link = CmnFns::getNewLink();
			$statusMsg = 'You have successfully registered. An email has been sent to '.$data['emailaddress'];
			$this->success = translate('You have successfully registered'). ' '.translate('An email has been sent to') .$data['emailaddress']. '<br/>';
			$this->success .= translate('activate'). '<br/>'.$link->getLink($url, translate('LogIn'));
		}
		else {
			// return DB id from entry created if using LDAP
			return $id;
		}
	//die();	
	}

	/**
	* Edits user data
	* @param array $data array of user data
	* @param bool if the admin is updating user data
	*/
	function do_edit_user($data, $adminUpdate) {
		global $conf;

		// Verify user data
		$msg = $this->check_all_values($data, true);
		if (!empty($msg)) {
			return $msg;
		}

		$this->db->update_user($data['memberid'], $data);

		if (!$adminUpdate) {
			$adminemail = strtolower($conf['app']['adminEmail']);
			// If it is the admin, set session variable
			if ($data['emailaddress'] == $adminemail) {
				$_SESSION['sessionAdmin'] = $adminemail;
			}

			// Set other session variables
			$_SESSION['sessionName'] = $data['fname'];
			$_SESSION['hourOffset'] = $data['timezone'] - $conf['app']['timezone'];
		}

		CmnFns::write_log('User data modified. Data provided: fname- ' . $data['fname'] . ' lname- ' . $data['lname']
						. ' email- '. $data['emailaddress'] . ' phone- ' . $data['phone'] . ' institution- ' . $data['institution']
						. ' position- ' . $data['position'], $data['memberid']);

		$link = CmnFns::getNewLink();

		$url = 'ctrlpnl.php';
		if ($adminUpdate){
			$url = 'admin.php?tool=users';
		}

		$this->success = translate('Your profile has been successfully updated!') . '<br/>' . $link->getLink($url, translate('Continue'));
	}

	function do_activate_user($hashedMemberId, $memberEmail) {
		$link = CmnFns::getNewLink();
		$url = 'index.php';
		$this->db->update_user_activate($data['memberid']);
		$this->success = '<br/>' . $link->getLink($url, translate('Activated'));
		//$this->success = $link->getLink($url, translate('Your profile has been successfully activated!. Continue'));
		// Write log file
		CmnFns::write_log('User Activated. Data provided: memberid- ' . $data['memberid'], $id);
	}

	/**
	* Verify that the user entered all data properly
	* @param array $data array of data to check
	* @param boolean $is_edit whether this is an edit or not
	*/
	function check_all_values(&$data, $is_edit) {
		global $conf;
		$use_logonname = (bool)$conf['app']['useLogonName'];

		$msg = '';

		if ($use_logonname && empty($data['logon_name'])) {
			$msg .= translate('Valid username is required') . '<br/>';
		}
		else if ($use_logonname) {
			$data['logon_name'] = htmlspecialchars($data['logon_name']);
		}
		if (empty($data['emailaddress']) || !preg_match("/^[a-zA-Z][\w\.-]*[a-zA-Z0-9]@[a-zA-Z0-9][\w\.-]*[a-zA-Z0-9]\.[a-zA-Z][a-zA-Z\.]*[a-zA-Z]$/", $data['emailaddress']))
			$msg .= translate('Valid email address is required.') . '<br/>';
		if (empty($data['fname'])) {
			$msg .= translate('First name is required.') . '<br/>';
		}
		else {
			$data['fname'] = htmlspecialchars($data['fname']);
		}
		if (empty($data['lname'])) {
			$msg .= translate('Last name is required.') . '<br/>';
		}
		else {
			$data['lname'] = htmlspecialchars($data['lname']);
		}
		if(!empty($data['phone'])) {
			$data['phone'] = htmlspecialchars($data['phone']);
		}
		if (!empty($data['institution'])) {
			$data['institution'] = htmlspecialchars($data['institution']);
		}
		if (!empty($data['position'])) {
			$data['position'] = htmlspecialchars($data['position']);
		}


        if( !$conf['ldap']['authentication'] ) {

            // Make sure email isnt in database (and is not current users email)
            if ($is_edit) {
                $user = new User($data['memberid']);
                if (!$use_logonname) {
					if ($this->db->userExists($data['emailaddress']) && ($data['emailaddress'] != $user->get_email()) ) {
						$msg .= translate('That email is taken already.') . '<br/>';
					}
				}
				else {
					if ( $this->db->userExists($data['logon_name'], true) && ($data['logon_name'] != $user->get_logon_name()) ) {
						$msg .= translate('That logon name is taken already.') . '<br/>';
					}
				}

                if (!empty($data['password'])) {
                    if (strlen($data['password']) < $conf['app']['minPasswordLength'])
                        $msg .= translate('Min 6 character password is required.', array($conf['app']['minPasswordLength'])) . '<br/>';
                    if ($data['password'] != $data['password2'])
                        $msg .= translate('Passwords do not match.') . '<br/>';
                }

                unset($user);
            }
            else {
                if (empty($data['password']) || strlen($data['password']) < $conf['app']['minPasswordLength']) {
                     $msg .= translate('Min 6 character password is required.', array($conf['app']['minPasswordLength'])) . '<br/>';
				}
                if ($data['password'] != $data['password2']) {
                    $msg .= translate('Passwords do not match.') . '<br/>';
				}
                if ($this->db->userExists($data['emailaddress'])) {
                    $msg .= translate('That email is taken already.') . '<br/>';
                }
				if ($use_logonname && $this->db->userExists($data['logon_name'], true)) {
					$msg .= translate('That logon name is taken already.') . '<br/>';
				}
            }
        }

		return $msg;
	}
	/**
	* Returns whether the user is attempting to log in
	* @param none
	* @return whether the user is attempting to log in
	*/
	function isAttempting() {
		return $this->is_attempt;
	}

	/**
	* Kills app
	* @param none
	*/
	function kill() {
		die;
	}

	/**
	* Destroy any lingering sessions
	* @param none
	*/
	function clean() {
		// Destroy all session variables
		if (isset($_SESSION['sessionID'])) unset($_SESSION['sessionID']);
		if (isset($_SESSION['sessionName'])) unset($_SESSION['sessionName']);
		if (isset($_SESSION['sessionAdmin'])) unset($_SESSION['sessionAdmin']);
		if (isset($_SESSION['hourOffset'])) unset($_SESSION['hourOffset']);
		session_destroy();
		session_destroy();
	}

	/**
	* Wrapper function to call template 'print_register_form' function
	* @param boolean $edit whether this is an edit or a new register
	* @param array $data values to auto fill
	* @param string $msg error message to print out
	* @param string $id member id to edit
	*/
	function print_register_form($edit, $data, $msg = '', $id = '') {
		print_register_form($edit, $data, $msg, $id);		// Function in auth.template.php
	}


	/**
	* Wrapper function to call template 'printLoginForm' function
	* @param string $msg error messages to display for user
	* @param string $resume page to resume after a login
	*/
	function printLoginForm($msg = '', $resume = '') {
		printLoginForm($msg, $resume);
	}

	/**
	* Prints a message telling the user to log in
	* @param boolean $kill whether to end the program or not
	*/
	function print_login_msg($kill = true) {
		CmnFns::redirect(CmnFns::getScriptURL() . '/index.php?auth=no&resume=' . urlencode($_SERVER['PHP_SELF']) . '?' . urlencode($_SERVER['QUERY_STRING']));
	}

	/**
	* Prints out the latest success box
	* @param none
	*/
	function print_success_box() {
		CmnFns::do_message_box($this->success);
	}
}
?>