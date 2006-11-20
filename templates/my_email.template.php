<?php
/**
* Template functions for managing email contacts
* @author Nick Korbel <lqqkout13@users.sourceforge.net>
* @author David Poole <David.Poole@fccc.edu>
* @version 09-25-04
* @package Templates
*
* Copyright (C) 2003 - 2006 phpScheduleIt
* License: GPL, see LICENSE
*/

/**
* Print out a form to let users select what kind of emails they wish to recieve
* @param object $user current user to manage
*/
function print_email_contacts(&$user) {
?>
	<form action="<?php echo $_SERVER['PHP_SELF']?>" method="post" name="mngemail">
	<table border="0" cellpadding="0" cellspacing="0" width="100%">
	  <tr>
	    <td class="tableTitle" colspan="2"><?php echo translate('Manage My Email Preferences')?></td></tr>

<?php
	echo '<tr class="cellColor" style="font-weight: bold;"><td colspan="2">' . translate('Email me when') . '</td></tr>' . "\n"
		. '<tr class="cellColor0">'
		. '  <td width="15%">'
		. translate('Yes') . '<input type="radio" name="e_add" value="y" ' . (($user->wants_email('e_add')) ? 'checked="checked"' : '') . ' />'
		. translate('No') . '<input type="radio" name="e_add" value="n" ' . ((!$user->wants_email('e_add')) ? 'checked="checked"' : '') . ' />'
		. '  </td>'
		. '  <td>' . translate('I place a reservation') . '</td>'
		. '</tr>' . "\n"
		. '<tr class="cellColor1">'
		. '  <td>'
		. translate('Yes') . '<input type="radio" name="e_mod" value="y" ' . (($user->wants_email('e_mod')) ? 'checked="checked"' : '') . ' />'
		. translate('No') . '<input type="radio" name="e_mod" value="n" ' . ((!$user->wants_email('e_mod')) ? 'checked="checked"' : '') . ' />'
		. '  </td>'
		. '  <td>' . translate('My reservation is modified') . '</td>'
		. '</tr>' . "\n"
		. '<tr class="cellColor0">'		
		. '  <td>'
		. translate('Yes') . '<input type="radio" name="e_del" value="y" ' . (($user->wants_email('e_del')) ? 'checked="checked"' : '') . ' />'
		. translate('No') . '<input type="radio" name="e_del" value="n" ' . ((!$user->wants_email('e_del')) ? 'checked="checked"' : '') . ' />'
		. '  </td>'
		. '  <td>' . translate('My reservation is deleted') . '</td>'
		. '</tr>' . "\n"
		. '<tr class="cellColor0">'		
		. '  <td>'
		. translate('Yes') . '<input type="radio" name="e_app" value="y" ' . (($user->wants_email('e_app')) ? 'checked="checked"' : '') . ' />'
		. translate('No') . '<input type="radio" name="e_app" value="n" ' . ((!$user->wants_email('e_app')) ? 'checked="checked"' : '') . ' />'
		. '  </td>'
		. '  <td>' . translate('My reservation is approved') . '</td>'
		. '</tr>' . "\n"

		. '<tr class="cellColor1">'
		. '<td colspan="2">' . translate('I prefer') . ' '
		. translate('HTML') . '<input type="radio" name="e_html" value="y" ' . (($user->wants_html()) ? 'checked="checked"' : '') . ' /> '
		. translate('Plain text') . '<input type="radio" name="e_html" value="n" ' . ((!$user->wants_html()) ? 'checked="checked"' : '') . ' /></td>'
		. '</tr>' . "\n"
		. '</table>' . "\n";
?>
<input type="submit" name="submit" value="<?php echo translate('Save')?>" class="button" />
<input type="reset" name="reset" value="<?php echo translate('Reset')?>" class="button" />
<br /><br /><input type="button" name="cancel" value="<?php echo translate('Cancel')?>" class="button" onclick="javascript: document.location='ctrlpnl.php';" />
</form>
<?php
}

/**
* Prints a message letting the user know that the update was successful
* @param none
*/
function print_success() {
	$link = CmnFns::getNewLink();
	CmnFns::do_message_box(translate('Your email preferences were successfully saved') . '<br />' . $link->getLink('ctrlpnl.php', translate('Return to My Control Panel')));
}
?>