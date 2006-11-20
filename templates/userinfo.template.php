<?php
/**
* This file provides output functions for userinfo.php
* No data manipulation is done in this file
* @author Nick Korbel <lqqkout13@users.sourceforge.net>
* @version 06-13-04
* @package Templates
*
* Copyright (C) 2003 - 2006 phpScheduleIt
* License: GPL, see LICENSE
*/

/**
* Prints out information about a user
* @param object $user current user
*/
function printUI(&$user) {
?>
<table width="100%" border="0" cellspacing="0" cellpadding="1" align="center">
	<tr>
	  <td class="tableBorder">
		<table width="100%" border="0" cellspacing="1" cellpadding="0">
          <tr> 
            <td class="rowHeaders" width="25%"><?php echo translate('Name')?></td>
            <td class="cellColor"><?php echo $user->get_name() ?></td>
          </tr>
          <tr> 
            <td class="rowHeaders"><?php echo translate('Member ID')?></td>
            <td class="cellColor"><?php echo $user->get_id() ?></td>
          </tr>
          <tr>
            <td class="rowHeaders"><?php echo translate('Email')?></td>
            <td class="cellColor"><?php echo '<a href="mailto:' . $user->get_email() . '">' . $user->get_email() . '</a>'?></td>
          </tr>
          <tr>
            <td class="rowHeaders"><?php echo translate('Phone')?></td>
            <td class="cellColor"><?php echo $user->get_phone() ?></td>
          </tr>
          <tr>
            <td class="rowHeaders"><?php echo translate('Institution')?></td>
            <td class="cellColor"><?php echo $user->get_inst() ?></td>
          </tr>
          <tr>
            <td class="rowHeaders"><?php echo translate('Position')?></td>
            <td class="cellColor"><?php echo $user->get_position() ?></td>
          </tr>
          <tr>
            <td class="rowHeaders" valign="top"><?php echo translate('Permissions')?></td>
            <td class="cellColor">
				<?php
				$perms = $user->get_perms();
				foreach ($perms as $machid => $name) {
					echo $name . '<br />';
				}
				?></td>
          </tr>
        </table>
      </td>
    </tr>
  </table>
<?php
}


/**
* Print previous/next user and close window links
* @param string $prev previous memberid
* @param string $next next memberid
*/
function printLinks($prev, $next) {
	global $link;
    
    echo "<p align=\"center\">\n"
      . $link->getLink("javascript: viewUser('" . $prev . "');", translate('Previous User')) . "\n"
      . "&nbsp;&nbsp;&nbsp;"
      . $link->getLink("javascript: viewUser('" . $next . "');", translate('Next User')) . "\n"
      . "</p>\n"
      . "<p>&nbsp;</p>\n"
      . "<p align=\"center\"><input type=\"button\" name=\"close\" value=\"" . translate('Close Window') . "\" class=\"button\" onclick=\"window.close();\" />"
      . "</p>\n";
}
?>