<?php
/**
* This file provides output functions for all auth pages
* No data manipulation is done in this file
* @author Nick Korbel <lqqkout13@users.sourceforge.net>
* @version 03-30-06
* @package Templates
*
* Copyright (C) 2003 - 2006 phpScheduleIt
* License: GPL, see LICENSE
*/

$link = CmnFns::getNewLink();	// Get Link object

/**
* Prints out a form for users can register
*  filling in any values
* @param boolean $edit whether this is an edit or a new register
* @param array $data values to auto fill
* @param string $msg error message to print to user
* @param string $memberid id of the member to edit
*/
function print_register_form($edit, $data = array(), $msg = '', $memberid = '') {
	global $conf;

	$positions    = $conf['ui']['positions'];		// Postions that are availble in the pull down menu
	$institutions = $conf['ui']['institutions'];	// Institutions that are available in the pull down menu
	$use_logonname = (bool)$conf['app']['useLogonName'];	// If we are using logon name or email for authentication
	$timezones = array(-12, -11, -10, -9, -8, -7, -6, -5, -4, -3.5, -3, -2, -1, 0, 1, 2, 3, 3.5, 4, 4.5, 5, 5.5, 6, 6.5, 7, 8, 9, 9.5, 10, 11, 12, 13);

	// Print header
	echo '<h3 align="center">' . (($edit) ? translate('Please edit your profile') : translate('Please register')) . '</h3>' . "\n";

	if (!empty($msg))
		CmnFns::do_error_box($msg, '', false);

?>
<form name="register" method="post" action="<?php echo $_SERVER['PHP_SELF'] . "?edit=$edit&amp;memberid=$memberid";?>">
<table width="100%" border="0" cellspacing="0" cellpadding="0">
<tr>
  <td bgcolor="#333333">
	<table width="100%" border="0" cellspacing="1" cellpadding="2">
	  <?php  if ($use_logonname) { ?>
	  <tr bgcolor="#FFFFFF">
		<td width="250">
		  <p align="right">* <?php echo translate('Logon name') . ' ' . ($use_logonname ? translate('this will be your login') : '')?></p>
		</td>
		<td>
		  <input type="text" name="logon_name" class="textbox" value="<?php echo isset($data['logon_name']) ? $data['logon_name'] : ''?>" maxlength="30" />
		</td>
	  </tr>
	  <?php  } ?>
	  <tr bgcolor="#FFFFFF">
		<td width="250">
		  <p align="right">* <?php echo translate('Email address') . ' ' . (!$use_logonname ? translate('this will be your login') : '')?></p>
		</td>
		<td>
		  <input type="text" name="emailaddress" class="textbox" value="<?php echo isset($data['emailaddress']) ? $data['emailaddress'] : ''?>" maxlength="75" />
		  <input type="hidden" name="memberid" value="<?php echo isset($data['memberid']) ? $data['memberid'] : ''?>"/>
		</td>
	  </tr>
	  <tr bgcolor="#FFFFFF">
		<td>
		  <p align="right">* <?php echo translate('First Name')?></p>
		</td>
		<td>
		  <input type="text" name="fname" class="textbox" value="<?php echo isset($data['fname']) ? $data['fname'] : ''?>" maxlength="50" />
		</td>
	  </tr>
	  <tr bgcolor="#FFFFFF">
		<td>
		  <p align="right">* <?php echo translate('Last Name')?></p>
		</td>
		<td>
		  <input type="text" name="lname" class="textbox" value="<?php echo isset($data['lname']) ? $data['lname'] : ''?>" maxlength="50" />
		</td>
	  </tr>
	  <tr bgcolor="#FFFFFF">
		<td>
		  <p align="right">* <?php echo translate('Phone')?></p>
		</td>
		<td>
		  <input type="text" name="phone" class="textbox" value="<?php echo isset($data['phone']) ? $data['phone'] : ''?>" size="15" />
		</td>
	  </tr>
	  <tr bgcolor="#FFFFFF">
		<td>
		  <p align="right"><?php echo translate('Institution')?></p>
		</td>
		<td>
		  <?php
		  if (empty($institutions[0])) {
			echo '<input type="text" name="institution" class="textbox" value="' . (isset($data['institution']) ? $data['institution'] : '') . '" maxlength="255" />' . "\n";
		  }
		  else {
		  ?>
		  <select name="institution" class="textbox">
		  <?php
			  // Print out position options
			  for ($i = 0; $i < count($institutions); $i++) {
				echo '<option value="' . $institutions[$i] . '"'
					. ( (isset($data['institution']) && ($data['institution'] == $institutions[$i])) ? ' selected="selected"' : '' )
					. '>' . $institutions[$i] . '</option>' . "\n";
			  }
		  ?>
		  </select>
		  <?php
		  }
		  ?>
		</td>
	  </tr>
	  <tr bgcolor="#FFFFFF">
		<td>
		  <p align="right"><?php echo translate('Position')?></p>
		</td>
		<td>
		  <?php
		  if (empty($positions[0])) {
			echo '<input type="text" name="position" class="textbox" value="' . (isset($data['position']) ? $data['position'] : '') . '" maxlength="100" />' . "\n";
		  }
		  else {
		  ?>
		  <select name="position" class="textbox">
		  <?php
			  // Print out position options
			  for ($i = 0; $i < count($positions); $i++) {
				echo '<option value="' . $positions[$i] . '"'
					. ( (isset($data['position']) && ($data['position'] == $positions[$i])) ? ' selected="selected"' : '' )
					. '>' . $positions[$i] . '</option>' . "\n";
			  }
		  ?>
		  </select>
		  <?php
		  }
		  ?>
		</td>
	  </tr>
	  <tr bgcolor="#FFFFFF">
		<td>
		  <p align="right">* <?php echo translate('Password (6 char min)', array($conf['app']['minPasswordLength']))?></p>
		</td>
		<td>
		  <input type="password" name="password" class="textbox" />
		</td>
	  </tr>
	  <tr bgcolor="#FFFFFF">
		<td>
		  <p align="right">* <?php echo translate('Re-Enter Password')?></p>
		</td>
		<td>
		  <input type="password" name="password2" class="textbox" />
		</td>
	  </tr>
	  <tr bgcolor="#FFFFFF">
	  		<td>
	  		  <p align="right"><?php echo translate('Timezone')?></p>
	  		</td>
	  		<td>
			<select name="timezone" id="timezone" class="textbox">
			<?php
	  		for ($i = 0; $i < count($timezones); $i++) {
				$label = $timezones[$i];
				if ($timezones[$i] >= 0) { $label = '+' . $label; }
				echo "<option value=\"{$timezones[$i]}\""
					. ( (isset($data['timezone']) && ($data['timezone'] == $timezones[$i])) ? ' selected="selected"' : '' )
					. ">GMT $label</option>\n";
			}
			?>
			</select>
	  		</td>
	  </tr>
	  <?php if (!$edit && (bool)$conf['app']['allowSelfRegistration']) { ?>
	  <tr bgcolor="#FFFFFF">
		<td>
		  <p align="right"><?php echo translate('Keep me logged in')?></p>
		</td>
		<td>
		  <input type="checkbox" name="setCookie" value="true" />
		</td>
	  </tr>
	  <?php } ?>
	</table>
  </td>
</tr>
</table>
<br />
<?php if ($edit) {
	$cancelUrl = !empty($memberid) ? "admin.php?tool=users" : "ctrlpnl.php";
?>
<input type="submit" name="update" value="<?php echo translate('Edit Profile')?>" class="button" />
<input type="button" name="cancel" value="<?php echo translate('Cancel')?>" class="button" onclick="javascript: document.location='<?php echo $cancelUrl;?>';" />
<?php } else {
	$cancelUrl = !empty($memberid) ? "admin.php?tool=users" : "index.php";
?>
<input type="submit" name="register" value="<?php echo translate('Register')?>" class="button" />
<input type="button" name="cancel" value="<?php echo translate('Cancel')?>" class="button" onclick="javascript: document.location='<?php echo $cancelUrl;?>';" />
<?php } ?>
</form>
<?php
}

/**
* Prints out a login form and any error messages
* @param string $msg error messages to display for user
* @param string $resume page to resume on after login
*/
function printLoginForm($msg = '', $resume = '') {
	global $conf;
	$link = CmnFns::getNewLink();
	$use_logonname = (bool)$conf['app']['useLogonName'] || (bool)$conf['ldap']['authentication'];

	// Check browser information
	echo '<script language="JavaScript" type="text/javascript">checkBrowser();</script>';

	if (!empty($msg))
		CmnFns::do_error_box($msg, '', false);
?>
<form name="login" method="post" action="<?php echo $_SERVER['PHP_SELF']?>">
<table width="350px" border="0" cellspacing="0" cellpadding="1" align="center">
<tr>
  <td bgcolor="#CCCCCC">
	<table width="100%" border="0" cellspacing="0" cellpadding="3">
	  <tr bgcolor="#EDEDED">
		<td colspan="2" style="border-bottom: solid 1px #CCCCCC;">
		  <h5 align="center"><?php echo translate('Please Log In')?></h5>
		</td>
	  </tr>
	  <tr bgcolor="#FFFFFF">
		<td width="150">
		  <p><b><?php echo translate(($use_logonname ? 'Logon name' : 'Email address'))?></b></p>
		</td>
		<td>
		  <input type="text" name="email" class="textbox" />
		</td>
	  </tr>
	  <tr bgcolor="#FFFFFF">
		<td>
		  <p><b><?php echo translate('Password')?></b></p>
		</td>
		<td>
		  <input type="password" name="password" class="textbox" />
		</td>
	  </tr>
	  <tr bgcolor="#FFFFFF">
		<td>
		  <p><b><?php echo translate('Language')?></b></p>
		</td>
		<td>
		<?php CmnFns::print_language_pulldown(); ?>
		</td>
	  </tr>
	  <tr bgcolor="#FFFFFF">
		<td>
		  <p><b><?php echo translate('Keep me logged in')?></b></p>
		</td>
		<td>
		  <input type="checkbox" name="setCookie" value="true" />
		</td>
	  </tr>
	  <tr bgcolor="#FAFAFA">
		<td colspan="2" style="border-top: solid 1px #CCCCCC;">
		   <p align="center">
			<input type="submit" name="login" value="<?php echo translate('Log In')?>" class="button" />
			<input type="hidden" name="resume" value="<?php echo $resume?>" />
		  </p>
		  <?php if ((bool)$conf['app']['allowSelfRegistration']) { ?>
		  <h4 align="center" style="margin-bottom:1px;"><b><?php echo translate('First time user')?>
			<?php $link->doLink('register.php', translate('Click here to register'), '', '', translate('Register for phpScheduleIt')) ?>
		  </h4>
		  <?php } ?>
		</td>
	  </tr>
	</table>
  </td>
</tr>
</table>
<p align="center">
<?php $link->doLink('roschedule.php', translate('View Schedule'), '', '', translate('View a read-only version of the schedule')) ?>
|
<?php $link->doLink('forgot_pwd.php', translate('I Forgot My Password'), '', '', translate('Retreive lost password')) ?>
|
<?php $link->doLink('javascript: help();', translate('Help'), '', '', translate('Get online help')) ?>
</p>
</form>
<?php
}
?>