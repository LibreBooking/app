<?php
/**
* This file provides output functions for bug_report.php and relies
* No data manipulation is done in this file
* @author Nick Korbel <lqqkout13@users.sourceforge.net>
* @version 03-13-04
* @package Templates
*
* Copyright (C) 2003 - 2006 phpScheduleIt
* License: GPL, see LICENSE
*/

/**
* Prints out a form for user to submit a bug report
* @param none
*/
function printBugForm() {
?>

<h4 align="center">Submit a bug report</h4>
<form action="<?php echo $_SERVER['PHP_SELF']?>" method="post" name="bug_report">
  <table width="90%" border="0" cellspacing="5" cellpadding="3" align="center">
    <tr class="cellColor0">
      <td>Please describe the error you recieved:</td>
      <td><textarea name="error_desc" cols="40" rows="6" id="error_desc" class="textbox"></textarea>
      </td>
    </tr>
    <tr class="cellColor1">
      <td>Please describe what you were doing at the time you recieved the error:</td>
      <td><textarea name="doing" cols="40" rows="6" id="doing" class="textbox"></textarea>
      </td>
    </tr>
    <tr class="cellColor0">
      <td>Please inlude any error codes or messages you recieved:</td>
      <td><textarea name="error_msg" cols="40" rows="6" id="error_msg" class="textbox"></textarea>
      </td>
    </tr>
    <tr class="cellColor1">
      <td>Any additional comments or questions:</td>
      <td><textarea name="comments" cols="40" rows="6" id="comments" class="textbox"></textarea>
      </td>
    </tr>
    <tr class="cellColor0">
      <td>Please contact me at this email, instead of the one I am logged in
        with:</td>
      <td><input name="email" type="text" id="email" value="" size="40" class="textbox">
      </td>
    </tr>
  </table>
  <div align="right" width="100%">
    <input name="sendBug" type="submit" id="sendBug" value="Submit" class="button" />
    <input name="clear" type="reset" id="clear" value="Reset" class="button" />
  </div>
</form>
<?php
}

/**
* Prints out a thank you message for submitting report
* @param none
*/
function print_thank_you() {
	global $conf;
	CmnFns::do_message_box(
				'Thank you for submitting your bug report.<br />'
    			. ' Please be asssured that the issue will be reviewed and remedied as quickly as'
      			. ' possible.<br /><br />'
    			. ' You will be contacted if any additional information is needed.<br /><br />'
				. ' If you have any questions, please contact tech support at <a href="mailto:' . $conf['app']['techEmail'] . '">' . $conf['app']['techEmail'] . '</a><br /><br />'
				. '<a href="javascript: window.close();">Finished</a>'
				, 'width: 75%;'
			);
}
?>
