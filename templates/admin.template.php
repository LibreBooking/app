<?php
/**
* This file provides output functions for the admin class
* No data manipulation is done in this file
* @author Nick Korbel <lqqkout13@users.sourceforge.net>
* @author David Poole <David.Poole@fccc.edu>
* @version 05-22-06
* @package Templates
*
* Copyright (C) 2003 - 2006 phpScheduleIt
* License: GPL, see LICENSE
*/

$link = CmnFns::getNewLink();	// Get Link object

/**
* Return the tool name
* @param none
*/
function getTool() {
	return $_GET['tool'];
}

/**
* Prints out list of current schedules
* @param Pager $pager pager object
* @param mixed $schedules array of schedule data
* @param string $err last database error
*/
function print_manage_schedules(&$pager, $schedules, $err) {
	global $link;
?>
<form name="manageSchedule" method="post" action="admin_update.php" onsubmit="return checkAdminForm();">
<table width="100%" border="0" cellspacing="0" cellpadding="1" align="center">
  <tr>
    <td class="tableBorder">
      <table width="100%" border="0" cellspacing="1" cellpadding="0">
        <tr>
          <td colspan="9" class="tableTitle">&#8250; <?php echo translate('All Schedules')?></td>
        </tr>
	<?php
		echo "
        <tr class=\"rowHeaders\">
          <td>" . translate('Schedule Title') . "</td>
          <td width=\"8%\">" . translate('Start Time') . "</td>
          <td width=\"8%\">" . translate('End Time') . "</td>
          <td width=\"9%\">" . translate('Time Span') . "</td>
		  <td width=\"11%\">" . translate('Weekday Start') . "</td>
          <td width=\"20%\">" . translate('Admin Email') . "</td>
		  <td width=\"7%\">" . translate('Default') . "</td>
		  <td width=\"5%\">" . translate('Edit') . "</td>
          <td width=\"7%\">" . translate('Delete') . "</td>
        </tr>
		";

	if (!$schedules)
		echo '<tr class="cellColor0"><td colspan="9" style="text-align: center;">' . $err . '</td></tr>' . "\n";

    for ($i = 0; is_array($schedules) && $i < count($schedules); $i++) {
		$cur = $schedules[$i];
        echo "<tr class=\"cellColor" . ($i%2) . "\" align=\"center\" id=\"tr$i\">\n"
            . '<td style="text-align:left">' . $cur['scheduletitle'] . "</td>\n"
            . '<td style="text-align:left">' . Time::formatTime($cur['daystart']) . "</td>\n"
            . '<td style="text-align:left">' . Time::formatTime($cur['dayend']) . "</td>\n"
            . '<td style="text-align:left">' . Time::minutes_to_hours($cur['timespan']) . "</td>\n"
		    . '<td style="text-align:left">' . CmnFns::get_day_name($cur['weekdaystart'], 0) . "</td>\n"
		 	. '<td style="text-align:left">' . $cur['adminemail'] . "</td>\n"
			. '<td><input type="radio" value="' . $schedules[$i]['scheduleid'] . "\" name=\"isdefault\"" . ($schedules[$i]['isdefault'] == 1 ? ' checked="checked"' : '') . ' onclick="javacript: setSchedule(\'' . $schedules[$i]['scheduleid'] . '\');" /></td>'
            . '<td>' . $link->getLink($_SERVER['PHP_SELF'] . '?' . preg_replace("/&scheduleid=[\d\w]*/", "", $_SERVER['QUERY_STRING']) . '&amp;scheduleid=' . $cur['scheduleid'] . ((strpos($_SERVER['QUERY_STRING'], $pager->getLimitVar())===false) ? '&amp;' . $pager->getLimitVar() . '=' . $pager->getLimit() : ''), translate('Edit'), '', '', translate('Edit data for', array($cur['scheduletitle']))) . "</td>\n"
            . "<td><input type=\"checkbox\" name=\"scheduleid[]\" value=\"" . $cur['scheduleid'] . "\" onclick=\"adminRowClick(this,'tr$i',$i);\"/></td>\n"
            . "</tr>\n";
    }

    // Close table
    ?>
      </table>
    </td>
  </tr>
</table>
<br />
<?php
	echo submit_button(translate('Delete'), 'scheduleid') . hidden_fn('delSchedule');
?>
</form>
<form id="setDefaultSchedule" name="setDefaultSchedule" method="post" action="admin_update.php">
<input type="hidden" name="scheduleid" value=""/>
<input type="hidden" name="fn" value="dfltSchedule"/>
</form>
<?php
}


/**
* Interface to add or edit schedule information
* @param mixed $rs array of schedule data
* @param boolean $edit whether this is an edit or not
* @param object $pager Pager object
*/
function print_schedule_edit($rs, $edit, &$pager) {
	global $conf;
    ?>
<form name="addSchedule" method="post" action="admin_update.php" <?php echo $edit ? "" : "onsubmit=\"return checkAddSchedule();\"" ?>>
<table width="100%" border="0" cellspacing="0" cellpadding="1" align="center">
  <tr>
    <td class="tableBorder">
      <table width="100%" border="0" cellspacing="1" cellpadding="0">
        <tr>
          <td width="200" class="formNames"><?php echo translate('Schedule Title')?></td>
          <td class="cellColor"><input type="text" name="scheduletitle" class="textbox" value="<?php echo isset($rs['scheduletitle']) ? $rs['scheduletitle'] : '' ?>" />
          </td>
        </tr>
		<tr>
		  <td class="formNames"><?php echo translate('Start Time')?></td>
		  <td class="cellColor"><select name="daystart" class="textbox">
		  <?php
		  for ($time = 0; $time <= 1410; $time += 30)
		  	echo '<option value="' . $time . '"' . ((isset($rs['daystart']) && ($rs['daystart'] == $time)) ? ' selected="selected"' : '') . '>' . Time::formatTime($time) . '</option>' . "\n";
		  ?>
		  </select>
		  </td>
		</tr>
		<tr>
		  <td class="formNames"><?php echo translate('End Time')?></td>
		  <td class="cellColor"><select name="dayend" class="textbox">
		  <?php
		  for ($time = 30; $time <= 1440; $time += 30)
		  	echo '<option value="' . $time . '"' . ((isset($rs['dayend']) && ($rs['dayend'] == $time)) ? (' selected="selected"') : (($time==1440 && !isset($rs['dayend'])) ? ' selected="selected"' : '')) . '>' . Time::formatTime($time) . '</option>' . "\n";
		  ?>
		  </select>
		  </td>
		</tr>
        <tr>
          <td class="formNames"><?php echo translate('Time Span')?></td>
          <td class="cellColor"><select name="timespan" class="textbox">
		  <?php
		  $spans = array (30, 10, 15, 60, 120, 180, 240);
		  for ($i = 0; $i < count($spans); $i++)
		  	echo '<option value="' . $spans[$i] . '"' . ((isset($rs['timespan']) && ($rs['timespan'] == $spans[$i])) ? (' selected="selected"') : '') . '>' . Time::minutes_to_hours($spans[$i]) . '</option>' . "\n";
		  ?>
		  </select>
		  </td>
        </tr>
        <tr>
          <td class="formNames"><?php echo translate('Weekday Start')?></td>
          <td class="cellColor"><select name="weekdaystart" class="textbox">
		  <?php
		  for ($i = 0; $i < 7; $i++)
		  	echo '<option value="' . $i . '"' . ( (isset($rs['weekdaystart']) && $rs['weekdaystart'] == $i) ? ' selected="selected"' : '') . '>' . CmnFns::get_day_name($i) . '</option>' . "\n";
		  ?>
		  </select>
		  </td>
        </tr>
        <tr>
          <td class="formNames"><?php echo translate('Days to Show')?></td>
          <td class="cellColor"><input type="text" name="viewdays" class="textbox" size="2" maxlength="2" value="<?php echo isset($rs['viewdays']) ? $rs['viewdays'] : '7' ?>" />
          </td>
        </tr>
		<tr>
		  <td class="formNames"><?php echo translate('Hidden')?></td>
		   <td class="cellColor"><select name="ishidden" class="textbox">
		  <?php
		  $yesNo = array(translate('No'), translate('Yes'));
		  for ($i = 0; $i < 2; $i++)
		  	echo '<option value="' . $i . '"' . ((isset($rs['ishidden']) && ($rs['ishidden'] == $i)) ? (' selected="selected"') : '') . '>' . $yesNo[$i]  . '</option>' . "\n";
		  ?>
		  </select>
		  </td>
		</tr>
		<tr>
		  <td class="formNames"><?php echo translate('Show Summary')?></td>
		   <td class="cellColor"><select name="showsummary" class="textbox">
		  <?php
		  for ($i = 1; $i >= 0; $i--)
		  	echo '<option value="' . $i . '"' . ((isset($rs['showsummary']) && ($rs['showsummary'] == $i)) ? (' selected="selected"') : '') . '>' . $yesNo[$i]  . '</option>' . "\n";
		  ?>
		  </select>
		  </td>
		</tr>
		<tr>
          <td class="formNames"><?php echo translate('Admin Email')?></td>
          <td class="cellColor"><input type="text" name="adminemail" maxlength="75" class="textbox" value="<?php echo isset($rs['adminemail']) ? $rs['adminemail'] : $conf['app']['adminEmail'] ?>" />
          </td>
        </tr>
      </table>
    </td>
  </tr>
</table>
<br />
<?php
        // Print out correct buttons
        if (!$edit) {
            echo submit_button(translate('Add Schedule'), 'scheduleid') . hidden_fn('addSchedule')
			. ' <input type="reset" name="reset" value="' . translate('Clear') . '" class="button" />' . "\n";
        }
		else {
            echo submit_button(translate('Edit Schedule'), 'scheduleid') . cancel_button($pager) . hidden_fn('editSchedule')
				. '<input type="hidden" name="scheduleid" value="' . $rs['scheduleid'] . '" />' . "\n";
        	// Unset variables
			unset($rs);
		}
		echo "</form>\n";
}

/**
* Prints out the user management table
* @param Object $pager pager object
* @param mixed $users array of user data
* @param string $err last database error
*/
function print_manage_users(&$pager, $users, $err) {
	global $link;
	global $conf;
	$util = new Utility();
	$isAdmin = Auth::isAdmin();

	if ($isAdmin) {
		print_additional_tools_box( array (
										array('Create User', 'register.php')
										)
							);
	$colspan = $isAdmin ? 9 : 8;
}
?>
<form name="manageUser" method="post" action="admin_update.php" onsubmit="return checkAdminForm();">
<table width="100%" border="0" cellspacing="0" cellpadding="1" align="center">
  <tr>
    <td class="tableBorder">
      <table width="100%" border="0" cellspacing="1" cellpadding="0">
        <tr>
          <td colspan="9" class="tableTitle">&#8250; <?php echo translate('All Users')?> </td>
        </tr>
		<?php echo "
        <tr class=\"rowHeaders\">
          <td width=\"21%\">" . $link->getLink($_SERVER['PHP_SELF'] . $util->getSortingUrl($_SERVER['QUERY_STRING'], 'lname'), translate('Name')) . "</td>
          <td width=\"22%\">" . $link->getLink($_SERVER['PHP_SELF'] . $util->getSortingUrl($_SERVER['QUERY_STRING'], 'email'), translate('Email')). "</td>
          <td width=\"14%\">" . $link->getLink($_SERVER['PHP_SELF'] . $util->getSortingUrl($_SERVER['QUERY_STRING'], 'institution'), translate('Institution')). "</td>
          <td width=\"11%\">" . translate('Phone') . "</td>
          <td width=\"8%\">" . translate('Password') . "</td>
		  <td width=\"5%\">" . translate('Admin') . "</td>
		  <td width=\"5%\">" . translate('Groups') . "</td>
          <td width=\"8%\">" . translate('Permissions') . "</td>"
		 . ($isAdmin ? '<td width="6%">' . translate('Delete') . '</td>' : '')
		 . "</tr>\n";

	if (!$users)
		echo '<tr class="cellColor0"><td colspan="9" style="text-align: center;">' . $err . '</td></tr>' . "\n";

	for ($i = 0; is_array($users) && $i < count($users); $i++) {
		$cur = $users[$i];
		$fname = $cur['fname'];
		$lname = $cur['lname'];
		$email = $cur['email'];

		$fname_lname = array($fname, $lname);

		$admin_text = (($cur['is_admin'] == 1) ? translate('Yes') : translate('No'));
		$admin_link = $isAdmin ? $link->getLink("admin_update.php?fn=adminToggle&amp;memberid={$cur['memberid']}&amp;status=" . (($cur['is_admin'] == 1) ? '0' : '1'), $admin_text) : $admin_text;

		$group_function = $isAdmin ? 'popGroupEdit' : 'popGroupView';
		$group_text = $isAdmin ? 'Edit' : 'View';

		echo "<tr class=\"cellColor" . ($i%2) . "\" align=\"center\" id=\"tr$i\">\n"
               . '<td style="text-align:left;">' . $link->getLink("register.php?edit=true&amp;memberid=". $cur['memberid'], $fname . ' ' . $lname, '', '', translate('View information about', $fname_lname)) . "</td>\n"
               . '<td style="text-align:left;">' . $link->getLink("mailto:$email", $email, '', '', translate('Send email to', array($fname, $lname))) . "</td>\n"
               . '<td style="text-align:left;\">' . $cur['institution'] . "</td>\n"
               . '<td style="text-align:left;">' . $cur['phone'] . "</td>\n"
               . '<td>' . $link->getLink("admin.php?tool=pwreset&amp;memberid=" . $cur['memberid'], translate('Reset'), '', '', translate('Reset password for', $fname_lname)) .  "</td>\n"
               . '<td>' . $admin_link . '</td>'
			   . '<td>' . $link->getLink("javascript:$group_function('" . $cur['memberid']. "');", translate($group_text)) . "</td>\n"
			   . '<td>' . $link->getLink("admin.php?tool=perms&amp;memberid=" . $cur['memberid'], translate('Edit'), '', '', translate('Edit permissions for', $fname_lname)) . "</td>\n"
               . ($isAdmin ? '<td><input type="checkbox" name="memberid[]" value="' . $cur['memberid'] . "\" onclick=\"adminRowClick(this,'tr$i',$i);\"/></td>\n" : '')
              . "</tr>\n";
    }

    // Close users table
    ?>
      </table>
    </td>
  </tr>
</table>
<br />
<?php
	echo ($isAdmin ? submit_button(translate('Delete')) . hidden_fn('deleteUsers') : '') . '</form>';
?>
<form name="name_search" action="<?php echo $_SERVER['PHP_SELF']?>" method="get">
	<p align="center">
	<?php print_lname_links(); ?>
	</p>
	<br />
	<p align="center">
	<?php echo translate('First Name')?> <input type="text" name="firstName" class="textbox" />
	<?php echo translate('Last Name')?> <input type="text" name="lastName" class="textbox" />
	<input type="hidden" name="searchUsers" value="true" />
	<input type="hidden" name="tool" value="<?php echo getTool();?>" />
	<input type="hidden" name="<?php echo $pager->getLimitVar();?>" value="<?php echo $pager->getLimit();?>" />
	<?php
	if (isset($_GET['order'])) {
		echo "<input type=\"hidden\" name=\"order\" value=\"{$_GET['order']}'\" />\n";
	}
	if (isset($_GET['vert'])) {
		echo "<input type=\"hidden\" name=\"vert\" value=\"{$_GET['vert']}\" />\n";
	}
	if (isset($_GET['groupid'])) {
		echo "<input type=\"hidden\" name=\"groupid\" value=\"{$_GET['groupid']}\" />\n";
	}
	?>
	<input type="submit" name="searchUsersBtn" value="<?php echo translate('Search Users');?>" class="button" />
	</p>
</form>
<?php
}


/**
* Prints out the links to select last names
* @param none
*/
function print_lname_links() {
	global $letters;
	echo '<a href="javascript: search_user_lname(\'\');">' . translate('All Users') . '</a>';
	foreach($letters as $letter) {
		echo '<a href="javascript: search_user_lname(\''. $letter . '\');" style="padding-left: 10px; font-size: 12px;">' . $letter . '</a>';
	}
}

/**
* Prints out list of current resources
* @param Pager $pager pager object
* @param mixed $resources array of resource data
* @param string $err last database error
*/
function print_manage_resources(&$pager, $resources, $err) {
	global $link;
	$util = new Utility();

print_additional_tools_box( array(
									array(
										'Manage Additional Resources', $_SERVER['PHP_SELF'] . '?tool=additional_resources') )
							);
?>

<form name="manageResource" method="post" action="admin_update.php" onsubmit="return checkAdminForm();">
<table width="100%" border="0" cellspacing="0" cellpadding="1" align="center">
  <tr>
    <td class="tableBorder">
      <table width="100%" border="0" cellspacing="1" cellpadding="0">
        <tr>
          <td colspan="8" class="tableTitle">&#8250; <?php echo translate('All Resources')?></td>
        </tr>
		<?php echo "
        <tr class=\"rowHeaders\">
          <td>" . $link->getLink($_SERVER['PHP_SELF'] . $util->getSortingUrl($_SERVER['QUERY_STRING'], 'name'), translate('Resource Name')) . "</td>
          <td width=\"18%\">" . $link->getLink($_SERVER['PHP_SELF'] . $util->getSortingUrl($_SERVER['QUERY_STRING'], 'location'), translate('Location')) . "</td>
		  <td width=\"12%\">" . $link->getLink($_SERVER['PHP_SELF'] . $util->getSortingUrl($_SERVER['QUERY_STRING'], 'scheduletitle'), translate('Schedule')) . "</td>
          <td width=\"10%\">" . translate('Phone') . "</td>
          <td width=\"25%\">" . translate('Notes') . "</td>
          <td width=\"5%\">" . translate('Edit') . "</td>
          <td width=\"9%\">" . translate('Status') . "</td>
          <td width=\"7%\">" . translate('Delete') . "</td>
        </tr>";

	if (!$resources)
		echo '<tr class="cellColor0"><td colspan="8" style="text-align: center;">' . $err . '</td></tr>' . "\n";

    for ($i = 0; is_array($resources) && $i < count($resources); $i++) {
		$cur = $resources[$i];
        echo "<tr class=\"cellColor" . ($i%2) . "\" align=\"center\" id=\"tr$i\">\n"
            . '<td style="text-align:left">' . $cur['name'] . "</td>\n"
            . '<td style="text-align:left">' . (isset($cur['location']) ?  $cur['location'] : '&nbsp;') . "</td>\n"
            . '<td style="text-align:left">' . $cur['scheduletitle'] . "</td>\n"
        	. '<td style="text-align:left">' . (isset($cur['rphone']) ?  $cur['rphone'] : '&nbsp;') . "</td>\n"
            . '<td style="text-align:left">'. (isset($cur['notes']) ?  $cur['notes'] : '&nbsp;') . "</td>\n"
            . '<td>' . $link->getLink($_SERVER['PHP_SELF'] . '?' . preg_replace("/&machid=[\d\w]*/", "", $_SERVER['QUERY_STRING']) . '&amp;machid=' . $cur['machid'] . ((strpos($_SERVER['QUERY_STRING'], $pager->getLimitVar())===false) ? '&amp;' . $pager->getLimitVar() . '=' . $pager->getLimit() : ''), translate('Edit'), '', '', translate('Edit data for', array($cur['name']))) . "</td>\n"
            . '<td>' . $link->getLink("admin_update.php?fn=togResource&amp;machid=" . $cur['machid'] . "&amp;status=" . $cur['status'], $cur['status'] == 'a' ? translate('Active') : translate('Inactive'), '', '', translate('Toggle this resource active/inactive')) . "</td>\n"
            . "<td><input type=\"checkbox\" name=\"machid[]\" value=\"" . $cur['machid'] . "\" onclick=\"adminRowClick(this,'tr$i',$i);\" /></td>\n"
            . "</tr>\n";
    }

    // Close table
    ?>
      </table>
    </td>
  </tr>
</table>
<br />
<?php
	echo submit_button(translate('Delete'), 'machid') . hidden_fn('delResource') . '</form>';
}


/**
* Interface to add or edit resource information
* @param mixed $rs array of resource data
* @param boolean $edit whether this is an edit or not
* @param object $pager Pager object
*/
function print_resource_edit($rs, $scheds, $edit, &$pager) {
	global $conf;
	$start = 0;
	$end   = 1440;
	$mins = array(0, 10, 15, 30);
	$disabled = ($edit && $rs['allow_multi'] == 1) ? 'disabled="disabled"' : '';

	if ($edit) {
		$minH = intval($rs['minres'] / 60);
		$minM = intval($rs['minres'] % 60);
		$maxH = intval($rs['maxres'] / 60);
		$maxM = intval($rs['maxres'] % 60);
		
		$minNotice = $rs['min_notice_time'];
		$maxNotice = $rs['max_notice_time'];
	}
	else {
		$maxH = 24;
		
		$minNotice = 0;
		$maxNotice = 0;
	}

    ?>
<form name="addResource" method="post" action="admin_update.php" <?php echo $edit ? "" : "onsubmit=\"return checkAddResource(this);\"" ?>>
<table width="100%" border="0" cellspacing="0" cellpadding="1" align="center">
  <tr>
    <td class="tableBorder">
      <table width="100%" border="0" cellspacing="1" cellpadding="0">
        <tr>
          <td width="200" class="formNames"><?php echo translate('Resource Name')?></td>
          <td class="cellColor"><input type="text" name="name" class="textbox" value="<?php echo isset($rs['name']) ? $rs['name'] : '' ?>" />
          </td>
        </tr>
        <tr>
          <td class="formNames"><?php echo translate('Location')?></td>
          <td class="cellColor"><input type="text" name="location" class="textbox" value="<?php echo isset($rs['location']) ? $rs['location'] : '' ?>" />
          </td>
        </tr>
        <tr>
          <td class="formNames"><?php echo translate('Phone')?></td>
          <td class="cellColor"><input type="text" name="rphone" class="textbox" value="<?php echo isset($rs['rphone']) ? $rs['rphone'] : '' ?>" />
          </td>
        </tr>
        <tr>
          <td class="formNames"><?php echo translate('Notes')?></td>
          <td class="cellColor"><textarea name="notes" class="textbox" rows="3" cols="30"><?php echo isset($rs['notes']) ? $rs['notes'] : '' ?></textarea>
          </td>
        </tr>
		<tr>
		<td class="formNames"><?php echo translate('Schedule')?></td>
		<td class="cellColor">
		<select name="scheduleid" class="textbox">
		<?php
		if (empty($scheds))
			echo '<option value="">Please add schedules</option>';
		else {
			for ($i = 0; $i < count($scheds); $i++)
				echo '<option value="' . $scheds[$i]['scheduleid'] . '"' . (isset($rs['scheduleid']) && $scheds[$i]['scheduleid'] == $rs['scheduleid'] ? ' selected="selected"' : '') . '>' . $scheds[$i]['scheduletitle'] . "</option>\n";
		}
		?>
		</select>
		</td>
		</tr>
		<tr>
		  <td class="formNames"><?php echo translate('Minimum Reservation Time')?></td>
		  <td class="cellColor">
		  <select name="minH" class="textbox" id="minH" <?php echo $disabled?>>
		  <?php
		  for ($h = 0; $h < 25; $h++)
		  	echo '<option value="' . $h . '"' . ((isset($minH) && $minH == $h) ? ' selected="selected"' : '') . '>' . $h . ' ' . translate('hours') . '</option>' . "\n";
		  ?>
		  </select>
		  <select name="minM" class="textbox" id="minM" <?php echo $disabled?>>
		  <?php
		  foreach ($mins as $m)
		  	echo '<option value="' . $m . '"' . ((isset($minM) && $minM == $m) ? ' selected="selected"' : '') . '>' . $m . ' ' . translate('minutes') . '</option>' . "\n";
		  ?>
		  </select>
		  </td>
		</tr>
		<tr>
		  <td class="formNames"><?php echo translate('Maximum Reservation Time')?></td>
		  <td class="cellColor">
		  <select name="maxH" class="textbox" id="maxH" <?php echo $disabled?>>
		  <?php
		  for ($h = 0; $h < 25; $h++)
		  	echo '<option value="' . $h . '"' . ((isset($maxH) && $maxH == $h) ? ' selected="selected"' : '') . '>' . $h . ' ' . translate('hours') . '</option>' . "\n";
		  ?>
		  </select>
		  <select name="maxM" class="textbox" id="maxM" <?php echo $disabled?>>
		  <?php
		  foreach ($mins as $m)
		  	echo '<option value="' . $m . '"' . ((isset($maxM) && $maxM == $m) ? ' selected="selected"' : '') . '>' . $m . ' ' . translate('minutes') . '</option>' . "\n";
		  ?>
		  </select>
		  </td>
		</tr>
		<tr>
			<td class="formNames"><?php echo translate('Minimum Booking Notice')?></td>
			<td class="cellColor">
				<input type="text" name="min_notice_time" id="min_notice_time" class="textbox" size="3" value="<?php echo $minNotice?>" /> <?php echo translate('hours prior to the start time') ?>
			</td>
		</tr>
		<tr>
			<td class="formNames"><?php echo translate('Maximum Booking Notice')?></td>
			<td class="cellColor">
				<input type="text" name="max_notice_time" id="max_notice_time" class="textbox" size="3" value="<?php echo $maxNotice?>" /> <?php echo translate('hours from the current time') ?>
			</td>
		</tr>
		<tr>
		  <td class="formNames"><?php echo translate('Maximum Participant Capacity')?></td>
		  <td class="cellColor"><input type="text" name="max_participants" size="3" class="textbox" value="<?php echo isset($rs['max_participants']) ? $rs['max_participants'] : ''?>"/>
		  * <?php echo translate('Leave blank for unlimited')?>
		  </td>
		</tr>
		<tr>
		  <td class="formNames"><?php echo translate('Auto-assign permission')?></td>
		  <td class="cellColor"><input type="checkbox" name="autoassign" <?php echo (isset($rs['autoassign']) && ($rs['autoassign'] == 1)) ? 'checked="checked"' : ''?>/>
		  </td>
		</tr>
        <tr>
		  <td class="formNames"><?php echo translate('Approval Required')?></td>
		  <td class="cellColor"><input type="checkbox" name="approval" <?php echo (isset($rs['approval']) && ($rs['approval'] == 1)) ? 'checked="checked"' : ''?>/>
		  </td>
		</tr>
		<tr>
		  <td class="formNames"><?php echo translate('Allow Multiple Day Reservations')?></td>
		  <td class="cellColor"><input type="checkbox" name="allow_multi" <?php echo (isset($rs['allow_multi']) && ($rs['allow_multi'] == 1)) ? 'checked="checked"' : ''?> onclick="showHideMinMax(this);" />
		  </td>
		</tr>
      </table>
    </td>
  </tr>
</table>
<br />
<?php
        // Print out correct buttons
        if (!$edit) {
            echo submit_button(translate('Add Resource'), 'machid') . hidden_fn('addResource')
			. ' <input type="reset" name="reset" value="' . translate('Clear') . '" class="button" />' . "\n";
        }
		else {
            echo submit_button(translate('Edit Resource'), 'machid') . cancel_button($pager) . hidden_fn('editResource')
				. '<input type="hidden" name="machid" value="' . $rs['machid'] . '" />' . "\n";
        	// Unset variables
			unset($rs);
		}
		echo "</form>\n";
}

/**
* Prints out list of current additional resources
* @param Pager $pager pager object
* @param mixed $resources array of resource data
* @param string $err last database error
*/
function print_manage_additional_resources($pager, $resources, $err) {
	global $link;
	$util = new Utility();
?>

<form name="manageAdditionalResource" method="post" action="admin_update.php" onsubmit="return checkAdminForm();">
<table width="100%" border="0" cellspacing="0" cellpadding="1" align="center">
  <tr>
    <td class="tableBorder">
      <table width="100%" border="0" cellspacing="1" cellpadding="0">
        <tr>
          <td colspan="4" class="tableTitle">&#8250; <?php echo translate('All Accessories')?></td>
        </tr>
		<?php echo "
        <tr class=\"rowHeaders\">
          <td>" . $link->getLink($_SERVER['PHP_SELF'] . $util->getSortingUrl($_SERVER['QUERY_STRING'], 'name'), translate('Accessory Name')) . "</td>
          <td width=\"15%\">" . translate('Number Available') . "</td>
          <td width=\"7%\">" . translate('Edit') . "</td>
		  <td width=\"7%\">" . translate('Delete') . "</td>
        </tr>";

	if (!$resources)
		echo '<tr class="cellColor0"><td colspan="4" style="text-align: center;">' . $err . '</td></tr>' . "\n";

    for ($i = 0; is_array($resources) && $i < count($resources); $i++) {
		$cur = $resources[$i];
		if ($cur['number_available'] == -1)  { $cur['number_available'] = translate('Unlimited'); }
        echo "<tr class=\"cellColor" . ($i%2) . "\" align=\"center\" id=\"tr$i\">\n"
            . '<td style="text-align:left">' . $cur['name'] . "</td>\n"
        	. '<td>' . $cur['number_available'] ."</td>\n"
			. "</td>\n"
            . '<td>' . $link->getLink($_SERVER['PHP_SELF'] . '?' . preg_replace("/&resourceid=[\d\w]*/", "", $_SERVER['QUERY_STRING']) . '&amp;resourceid=' . $cur['resourceid'] . ((strpos($_SERVER['QUERY_STRING'], $pager->getLimitVar())===false) ? '&amp;' . $pager->getLimitVar() . '=' . $pager->getLimit() : ''), translate('Edit'), '', '', translate('Edit data for', array($cur['name']))) . "</td>\n"
            . "<td><input type=\"checkbox\" name=\"resourceid[]\" value=\"" . $cur['resourceid'] . "\" onclick=\"adminRowClick(this,'tr$i',$i);\" /></td>\n"
            . "</tr>\n";
    }

    // Close table
    ?>
      </table>
    </td>
  </tr>
</table>
<br />
<?php
	echo submit_button(translate('Delete'), 'resourceid') . hidden_fn('delAddResource') . '</form>';
}

/**
* Interface to add or edit resource information
* @param AdditionalResource $resource AdditionalResource object
* @param boolean $edit whether this is an edit or not
* @param Pager $pager Pager object
*/
function print_additional_resource_edit($resource, $edit, &$pager) {
	global $conf;
    ?>
<form name="addAdditionalResource" method="post" action="admin_update.php" <?php echo $edit ? "" : "onsubmit=\"return checkAddResource(this);\"";?>>
<table width="100%" border="0" cellspacing="0" cellpadding="1" align="center">
  <tr>
    <td class="tableBorder">
      <table width="100%" border="0" cellspacing="1" cellpadding="0">
        <tr>
          <td width="200" class="formNames"><?php echo translate('Accessory Name');?></td>
          <td class="cellColor"><input type="text" name="name" class="textbox" value="<?php echo $resource->get_name() ?>" />
          </td>
        </tr>
        <tr>
          <td class="formNames"><?php echo translate('Number Available');?></td>
          <td class="cellColor"><input type="text" name="number_available" class="textbox" size="5" value="<?php echo ($resource->get_number_available() != -1) ? $resource->get_number_available() : ''; ?>" />
          * <?php echo translate('Leave blank for unlimited');?>
          </td>
        </tr>
      </table>
    </td>
  </tr>
</table>
<br />
<?php
        // Print out correct buttons
        if (!$edit) {
            echo submit_button(translate('Add Additional Resource'), 'resourceid') . hidden_fn('addAdditionalResource')
			. ' <input type="reset" name="reset" value="' . translate('Clear') . '" class="button" />' . "\n";
        }
		else {
            echo submit_button(translate('Edit Additional Resource'), 'resourceid') . cancel_button($pager) . hidden_fn('editAdditionalResource')
				. '<input type="hidden" name="resourceid" value="' . $resource->get_id() . '" />' . "\n";
		}
		echo "</form>\n";
}

/**
* Interface for managing user training
* Provide interface for viewing and managing
*  user training information
* @param object $user User object of user to manage
* @param array $rs list of resources
*/
function print_manage_perms(&$user, $rs, $err) {
	global $link;

	if (!$user->is_valid()) {
		CmnFns::do_error_box($user->get_error() . '<br /><a href="' . $_SERVER['PHP_SELF'] . '?tool=users">' . translate('Back') . '</a>', '', false);
		return;
	}

	echo '<h3>' . $user->get_name() . '</h3>';
    ?>
<form name="train" method="post" action="admin_update.php">
  <table border="0" cellspacing="0" cellpadding="1">
    <tr>
      <td class="tableBorder">
        <table cellspacing="1" cellpadding="2" border="0" width="100%">
          <tr class="rowHeaders">
            <td width="240"><?php echo translate('Resource Name')?></td>
            <td width="60"><?php echo translate('Allowed')?></td>
          </tr>
		<?php
			if (!$rs) echo '<tr class="cellColor0" style="text-align: center;"><td colspan="2">' . $err . '</td></tr>';

			for ($i = 0; is_array($rs) && $i < count($rs); $i++) {
				echo '<tr class="cellColor"><td>' . $rs[$i]['name'] . '</td><td style="text-align: center;">'
					. '<input type="checkbox" name="machid[]" value="' . $rs[$i]['machid'] . '"';
				if ($user->has_perm($rs[$i]['machid']))
					echo ' checked="checked"';
				echo '/></td></tr>';
		  	}

		// Close off tables/forms.  Print buttons and hidden field
		?>
          <tr class="cellColor1">
            <td>&nbsp;</td>
            <td style="text-align: center;">
              <input type="checkbox" name="checkAll" onclick="checkAllBoxes(this);" />
            </td>
          </tr>
        </table>
      </td>
    </tr>
  </table>
  <input type="hidden" name="memberid" value="<?php echo $user->get_id()?>" />
  <p style="padding-top: 5px; padding-bottom: 5px;"><input type="checkbox" name="notify_user" value="true" /><?php echo translate('Notify user')?></p>
  <?php echo submit_button(translate('Save')) . hidden_fn('editPerms')?>
  <input type="button" name="cancel" value="<?php echo translate('Manage Users')?>" class="button" onclick="document.location='<?php echo $_SERVER['PHP_SELF']?>?tool=users';" />
</form>
<?php
}

/**
* Interface for approving reservations
* Provide a table to allow admin to approve or delete reservations
* @param Object $pager pager object
* @param mixed $res reservation data
* @param string $err last database error
*/
function print_approve_reservations($pager, $res, $err) {
	global $link;
	$util = new Utility();

?>
<form name="approve" id="approve" method="post" action="reserve.php" style="margin: 0px;">
<table width="100%" border="0" cellspacing="0" cellpadding="1" align="center">
  <tr>
    <td class="tableBorder">
      <table width="100%" border="0" cellspacing="1" cellpadding="0">
        <tr>
          <td colspan="9" class="tableTitle">&#8250; <?php echo translate('Pending User Reservations')?></td>
        </tr>
		<?php echo"
        <tr class=\"rowHeaders\">
          <td width=\"10%\">" . $link->getLink($_SERVER['PHP_SELF'] . $util->getSortingUrl($_SERVER['QUERY_STRING'], 'start_date'), translate('Start Date')) . "</td>
		  <td width=\"10%\">" . $link->getLink($_SERVER['PHP_SELF'] . $util->getSortingUrl($_SERVER['QUERY_STRING'], 'end_date'), translate('End Date')) . "</td>
          <td width=\"20%\">" . $link->getLink($_SERVER['PHP_SELF'] . $util->getSortingUrl($_SERVER['QUERY_STRING'], 'lname'), translate('User')) . "</td>
          <td width=\"19%\">" . $link->getLink($_SERVER['PHP_SELF'] . $util->getSortingUrl($_SERVER['QUERY_STRING'], 'name'), translate('Resource')) . "</td>
          <td width=\"10%\">" . $link->getLink($_SERVER['PHP_SELF'] . $util->getSortingUrl($_SERVER['QUERY_STRING'], 'starttime'), translate('Start Time')) . "</td>
          <td width=\"10%\">" . $link->getLink($_SERVER['PHP_SELF'] . $util->getSortingUrl($_SERVER['QUERY_STRING'], 'endtime'), translate('End Time')) . "</td>
          <td width=\"7%\">" . translate('View') . "</td>
          <td width=\"7%\">" . translate('Approve') . "</td>
          <td width=\"7%\">" . translate('Delete') . "</td>
        </tr>";

	// Write message if they have no reservations
	if (!$res)
		echo '<tr class="cellColor"><td colspan="9" align="center">' . $err . '</td></tr>';

	// For each reservation, clean up the date/time and print it
	for ($i = 0; is_array($res) && $i < count($res); $i++) {
		$cur = $res[$i];
		$fname = $cur['fname'];
		$lname = $cur['lname'];
        echo "<tr class=\"cellColor" . ($i%2) . "\" align=\"center\">\n"
					. '<td>' . Time::formatDate($cur['start_date']) . '</td>'
					. '<td>' . Time::formatDate($cur['end_date']) . '</td>'
					. '<td style="text-align:left">' . $link->getLink("javascript: viewUser('" . $cur['memberid'] . "');", $fname . ' ' . $lname, '', '', translate('View information about', array($fname,$lname))) . '</td>'
                    . '<td style="text-align:left">' . $cur['name'] . "</td>"
					. '<td>' . Time::formatTime($cur['starttime']) . '</td>'
					. '<td>' . Time::formatTime($cur['endtime']) . '</td>'
                    . '<td>' . $link->getLink("javascript: reserve('v','','','" . $cur['resid']. "');", translate('View'), '', '', translate('View this reservation information')) . '</td>'
					. '<td>' . $link->getlink("javascript: reserve('a','','','" . $cur['resid'] ."');", translate('Approve'), '', '', translate('Approve this reservation')) . '</td>'
					. '<td>' . $link->getLink("javascript: reserve('d','','','" . $cur['resid']. "');", translate('Delete'), '', '', translate('Delete this reservation')) . '</td>'
					. "</tr>\n";
	}
    ?>
      </table>
    </td>
  </tr>
</table>
</form>
<br />
<?php
}

/**
* Interface for managing reservations
* Provide a table to allow admin to modify or delete reservations
* @param Object $pager pager object
* @param mixed $res reservation data
* @param string $err last database error
*/
function print_manage_reservations(&$pager, $res, $err) {
	global $link;
	$util = new Utility();

?>
<table width="100%" border="0" cellspacing="0" cellpadding="1" align="center">
  <tr>
    <td class="tableBorder">
      <table width="100%" border="0" cellspacing="1" cellpadding="0">
        <tr>
          <td colspan="9" class="tableTitle">&#8250; <?php echo translate('User Reservations')?></td>
        </tr>
		<?php echo "
        <tr class=\"rowHeaders\">
          <td width=\"10%\">" . $link->getLink($_SERVER['PHP_SELF'] . $util->getSortingUrl($_SERVER['QUERY_STRING'], 'start_date'), translate('Start Date')) . "</td>
		  <td width=\"10%\">" . $link->getLink($_SERVER['PHP_SELF'] . $util->getSortingUrl($_SERVER['QUERY_STRING'], 'end_date'), translate('End Date')) . "</td>
          <td width=\"20%\">" . $link->getLink($_SERVER['PHP_SELF'] . $util->getSortingUrl($_SERVER['QUERY_STRING'], 'lname'), translate('User')) . "</td>
          <td width=\"19%\">" . $link->getLink($_SERVER['PHP_SELF'] . $util->getSortingUrl($_SERVER['QUERY_STRING'], 'name'), translate('Resource Name')) . "</td>
          <td width=\"10%\">" . $link->getLink($_SERVER['PHP_SELF'] . $util->getSortingUrl($_SERVER['QUERY_STRING'], 'starttime'), translate('Start Time')) . "</td>
          <td width=\"10%\">" . $link->getLink($_SERVER['PHP_SELF'] . $util->getSortingUrl($_SERVER['QUERY_STRING'], 'endtime'), translate('End Time')) . "</td>
          <td width=\"7%\">" . translate('View') . "</td>
          <td width=\"7%\">" . translate('Modify') . "</td>
          <td width=\"7%\">" . translate('Delete') . "</td>
        </tr>";

	// Write message if they have no reservations
	if (!$res)
		echo '<tr class="cellColor"><td colspan="9" align="center">' . $err . '</td></tr>';

	// For each reservation, clean up the date/time and print it
	for ($i = 0; is_array($res) && $i < count($res); $i++) {
		$cur = $res[$i];
		$fname = $cur['fname'];
		$lname = $cur['lname'];
        echo "<tr class=\"cellColor" . ($i%2) . "\" align=\"center\">\n"
					. '<td>' . Time::formatDate($cur['start_date']) . '</td>'
					. '<td>' . Time::formatDate($cur['end_date']) . '</td>'
					. '<td style="text-align:left">' . $link->getLink("javascript: viewUser('" . $cur['memberid'] . "');", $fname . ' ' . $lname, '', '', translate('View information about', array($fname,$lname))) . "</td>"
                    . '<td style="text-align:left">' . $cur['name'] . "</td>"
					. '<td>' . Time::formatTime($cur['starttime']) . '</td>'
					. '<td>' . Time::formatTime($cur['endtime']) . '</td>'
                    . '<td>' . $link->getLink("javascript: reserve('v','','','" . $cur['resid']. "');", translate('View')) . '</td>'
					. '<td>' . $link->getlink("javascript: reserve('m','','','" . $cur['resid']. "');", translate('Modify')) . '</td>'
					. '<td>' . $link->getLink("javascript: reserve('d','','','" . $cur['resid']. "');", translate('Delete')) . '</td>'
					. "</tr>\n";
	}
    ?>
      </table>
    </td>
  </tr>
</table>
<br />
<?php
}


/**
* Prints out list of current announcements
* @param Object $pager pager object
* @param mixed $announcements array of announcement data
* @param string $err last database error
*/
function print_manage_announcements(&$pager, $announcements, $err) {
	global $link;

?>
<form name="manageAnnouncement" method="post" action="admin_update.php" onsubmit="return checkAnnouncementForm();">
<table width="100%" border="0" cellspacing="0" cellpadding="1" align="center">
  <tr>
    <td class="tableBorder">
      <table width="100%" border="0" cellspacing="1" cellpadding="0">
        <tr>
          <td colspan="4" class="tableTitle">&#8250; <?php echo translate('All Announcements')?></td>
        </tr>
		<?php echo "
        <tr class=\"rowHeaders\">
          <td>" . translate('Announcement') . "</td>
          <td width=\"7%\">" .translate('Number') . "</td>
		  <td width=\"5%\">" .translate('Edit') . "</td>
          <td width=\"7%\">" .translate('Delete') . "</td>
        </tr>";

	if (!$announcements)
		echo '<tr class="cellColor0"><td colspan="4" style="text-align: center;">' . $err . '</td></tr>' . "\n";

    for ($i = 0; is_array($announcements) && $i < count($announcements); $i++) {
		$cur = $announcements[$i];
        echo "<tr class=\"cellColor" . ($i%2) . "\" align=\"center\" id=\"tr$i\">\n"
            . '<td style="text-align:left">' . htmlspecialchars($cur['announcement']) . "</td>\n"
            . '<td style="text-align:left">';
	    echo $cur['number'];
		echo "</td>\n"
            . '<td>' . $link->getLink($_SERVER['PHP_SELF'] . '?' . preg_replace("/&announcmentid=[\d\w]*/", "", $_SERVER['QUERY_STRING']) . '&amp;announcementid=' . $cur['announcementid'] . ((strpos($_SERVER['QUERY_STRING'], $pager->getLimitVar())===false) ? '&amp;' . $pager->getLimitVar() . '=' . $pager->getLimit() : ''), translate('Edit'), '', '', translate('Edit data for', array($cur['announcementid']))) . "</td>\n"
            . "<td><input type=\"checkbox\" name=\"announcementid[]\" value=\"" . $cur['announcementid'] . "\" onclick=\"adminRowClick(this,'tr$i',$i);\" /></td>\n"
            . "</tr>\n";
    }

    // Close table
    ?>
      </table>
    </td>
  </tr>
</table>
<br />
<?php
	echo submit_button(translate('Delete Announcements'), 'announcementid') . hidden_fn('delAnnouncement');
?>
</form>
<?php
}

/**
* Interface to add or edit announcement information
* @param mixed $rs array of schedule data
* @param boolean $edit whether this is an edit or not
* @param object $pager Pager object
*/
function print_announce_edit($rs, $edit, &$pager) {
	global $conf;
	$start_date_ok = (isset($rs['start_datetime']) && !empty($rs['start_datetime']));
	$end_date_ok = (isset($rs['end_datetime']) && !empty($rs['end_datetime']));

	$start_date = ($start_date_ok) ? $rs['start_datetime'] : mktime();
	$end_date = ($end_date_ok) ? $rs['end_datetime'] : mktime();
    ?>
<form name="addAnnouncement" method="post" action="admin_update.php" <?php echo $edit ? "" : "onsubmit=\"return checkAddAnnouncement();\"" ?>>
<table width="100%" border="0" cellspacing="0" cellpadding="1" align="center">
  <tr>
    <td class="tableBorder">
      <table width="100%" border="0" cellspacing="1" cellpadding="0">
        <tr>
          <td class="formNames"><?php echo translate('Announcement'); ?></td>
          <td class="cellColor"><input type="text" name="announcement" class="textbox" size="50" maxlength="300" value="<?php echo isset($rs['announcement']) ? htmlspecialchars($rs['announcement']) : '' ?>" />
          </td>
        </tr>
        <tr>
          <td width="200" class="formNames"><?php echo translate('Number'); ?></td>
          <td class="cellColor"><input type="text" name="number" class="textbox" size="3" maxlength="3" value="<?php echo isset($rs['number']) ? $rs['number'] : '' ?>" />
          </td>
        </tr>
		<tr>
			<td class="formNames"><?php echo translate('Start Date'); ?></td>
			<td class="cellColor">
				<?php  echo '<div id="div_start_date" style="float:left;width:70px;">' . Time::formatDate($start_date) . '</div><input type="hidden" id="hdn_start_date" name="start_date" value="' . date('m' . INTERNAL_DATE_SEPERATOR . 'd' . INTERNAL_DATE_SEPERATOR . 'Y', $start_date) . '"/> <a href="javascript:void(0);"><img src="img/calendar.gif" border="0" id="img_start_date" alt="' . translate('Start') . '"/></a>';
					$s_hour = ($start_date_ok) ? date('h', $rs['start_datetime']) : '';
					$s_min = ($start_date_ok) ? date('i', $rs['start_datetime']) : '';
					$s_pm = ($start_date_ok) ? intval(date('H', $rs['start_datetime'])) >= 12 : false;
					echo ' @ <input type="text" maxlength="2" size="2" class="textbox" name="start_hour" value="' . $s_hour . '"/> : <input type="text" maxlength="2" size="2" class="textbox" name="start_min" value="' . $s_min . '"/>';
					echo ' <select name="start_ampm" class="textbox"><option value="am">' . translate('am') . '</option><option value="pm"' . (($s_pm) ? ' selected="selected"' : '') . '>' . translate('pm') . '</option></select>';
					echo ' <input type="checkbox" name="use_start_time"' . ($start_date_ok ? ' checked="checked"' : ''). '/> ' . translate('Use start date/time?');
				?>
			</td>
		</tr>
		<tr>
			<td class="formNames"><?php echo translate('End Date'); ?></td>
			<td class="cellColor">
				<?php  echo '<div id="div_end_date" style="float:left;width:70px;">' . Time::formatDate($end_date) . '</div><input type="hidden" id="hdn_end_date" name="end_date" value="' . date('m' . INTERNAL_DATE_SEPERATOR . 'd' . INTERNAL_DATE_SEPERATOR . 'Y', $end_date) . '"/> <a href="javascript:void(0);"><img src="img/calendar.gif" border="0" id="img_end_date" alt="' . translate('End') . '"/></a>';
					$s_hour = ($end_date_ok) ? date('h', $rs['end_datetime']) : '';
					$s_min = ($end_date_ok) ? date('i', $rs['end_datetime']) : '';
					$s_pm = ($end_date_ok) ? intval(date('H', $rs['end_datetime'])) >= 12 : false;
					echo ' @ <input type="text" maxlength="2" size="2" class="textbox" name="end_hour" value="' . $s_hour . '"/> : <input type="text" maxlength="2" size="2" class="textbox" name="end_min" value="' . $s_min . '"/>';
					echo ' <select name="end_ampm" class="textbox"><option value="am">' . translate('am') . '</option><option value="pm"' . (($s_pm) ? ' selected="selected"' : '') . '>' . translate('pm') . '</option></select>';
					echo ' <input type="checkbox" name="use_end_time"' . ($end_date_ok ? ' checked="checked"' : ''). '/> ' . translate('Use end date/time?');
				?>
			</td>
		</tr>
	  </table>
    </td>
  </tr>
</table>
<br />
<?php
        // Print out correct buttons
        if (!$edit) {
            echo submit_button(translate('Add Announcement'), 'announcementid') . hidden_fn('addAnnouncement')
			. ' <input type="reset" name="reset" value="' . translate('Clear') . '" class="button" />' . "\n";
        }
		else {
            echo submit_button(translate('Edit Announcement'), 'announcementid') . cancel_button($pager) . hidden_fn('editAnnouncement')
				. '<input type="hidden" name="announcementid" value="' . $rs['announcementid'] . '" />' . "\n";
		}
		echo "</form>\n";
		print_jscalendar_setup($start_date_ok ? $rs['start_datetime'] : null, $end_date_ok ? $rs['end_datetime'] : null);		// Set up the javascript calendars
		// Unset variables
		unset($rs);
}

function print_manage_groups(&$pager, $groups, $err) {
	global $link;

?>
<form name="manageGroups" method="post" action="admin_update.php">
<table width="100%" border="0" cellspacing="0" cellpadding="1" align="center">
  <tr>
    <td class="tableBorder">
      <table width="100%" border="0" cellspacing="1" cellpadding="0">
        <tr>
          <td colspan="4" class="tableTitle">&#8250; <?php echo translate('All Groups'); ?></td>
        </tr>
		<?php echo "
        <tr class=\"rowHeaders\">
          <td>" . translate('Group Name') . "</td>
          <td width=\"17%\">" . translate('Administrator') . "</td>
		  <td width=\"10%\">" . translate('Manage Users') . "</td>
		  <td width=\"5%\">" . translate('Edit') . "</td>
          <td width=\"7%\">" . translate('Delete') . "</td>
        </tr>";

	if (!$groups)
		echo '<tr class="cellColor0"><td colspan="5" style="text-align: center;">' . $err . '</td></tr>' . "\n";

    for ($i = 0; is_array($groups) && $i < count($groups); $i++) {
		$cur = $groups[$i];
        echo "<tr class=\"cellColor" . ($i%2) . "\" align=\"center\" id=\"tr$i\">\n"
            . '<td style="text-align:left">' . $cur['group_name'] . "</td>\n"
            . '<td style="text-align:left">' . ( !empty($cur['lname']) ? ($cur['lname'] . ', ' . $cur['fname']) : translate('None') ) . "</td>\n"
            . '<td>' . $link->getLink('admin.php?tool=users&amp;groupid=' . $cur['groupid'], (intval($cur['user_count']))) . '</td>'
			. '<td>' . $link->getLink($_SERVER['PHP_SELF'] . '?' . preg_replace("/&groupid=[\d\w]*/", "", $_SERVER['QUERY_STRING']) . '&amp;groupid=' . $cur['groupid'] . ((strpos($_SERVER['QUERY_STRING'], $pager->getLimitVar())===false) ? '&amp;' . $pager->getLimitVar() . '=' . $pager->getLimit() : ''), translate('Edit'), '', '', translate('Edit data for', array($cur['groupid']))) . "</td>\n"
            . "<td><input type=\"checkbox\" name=\"groupid[]\" value=\"" . $cur['groupid'] . "\" onclick=\"adminRowClick(this,'tr$i',$i);\" /></td>\n"
            . "</tr>\n";
    }

    // Close table
    ?>
      </table>
    </td>
  </tr>
</table>
<br />
<?php
	echo submit_button(translate('Delete Groups'), 'groupid') . hidden_fn('delGroup');
?>
</form>
<?php
}

/**
* Interface to add or edit announcement information
* @param Group $group array of schedule data
* @param boolean $edit whether this is an edit or not
* @param object $pager Pager object
*/
function print_group_edit($group, $edit, &$pager, $group_users = array()) {
	global $conf;
    ?>
<form name="addGroup" method="post" action="admin_update.php">
<table width="100%" border="0" cellspacing="0" cellpadding="1" align="center">
  <tr>
    <td class="tableBorder">
      <table width="100%" border="0" cellspacing="1" cellpadding="0">
        <tr>
          <td class="formNames"><?php echo translate('Group Name');?></td>
          <td class="cellColor"><input type="text" name="group_name" class="textbox" size="50" maxlength="50" value="<?php echo !empty($group->name) ? $group->name : ''; ?>" />
          </td>
        </tr>
        <tr>
          <td width="200" class="formNames"><?php echo translate('Administrator');?></td>
          <td class="cellColor"><select name="group_admin" class="textbox">
			<?php
				echo '<option value="">' . translate('None') . '</option>';
				for ($i = 0; $i < count($group_users); $i++) {
					echo "<option value=\"{$group_users[$i]['memberid']}\"";
					if ($group_users[$i]['memberid'] == $group->adminid) {
						echo ' selected="selected"';
					}
					echo ">{$group_users[$i]['lname']}, {$group_users[$i]['fname']}</option>\n";
				}
			?>
		  </select>
          </td>
        </tr>
	  </table>
    </td>
  </tr>
</table>
<br />
<?php
        // Print out correct buttons
        if (!$edit) {
            echo submit_button(translate('Save'), 'groupid') . hidden_fn('addGroup')
			. ' <input type="reset" name="reset" value="' . translate('Clear') . '" class="button" />' . "\n";
        }
		else {
            echo submit_button(translate('Edit'), 'groupid') . cancel_button($pager) . hidden_fn('editGroup')
				. '<input type="hidden" name="groupid" value="' . $group->id . '" />' . "\n";
		}
		echo "</form>\n";
}

/**
* Prints out GUI list to of email addresses
* Prints out a table with option to email users,
*  and prints form to enter subject and message of email
* @param array $users user data
* @param string $sub subject of email
* @param string $msg message of email
* @param array $usr users to send to
* @param string $err last database error
*/
function print_manage_email($users, $sub, $msg, $usr, $err) {
	?>
<form name="emailUsers" method="post" action="<?php echo $_SERVER['PHP_SELF'] . '?tool=' . $_GET['tool']?>">
  <table width="60%" border="0" cellspacing="0" cellpadding="1">
    <tr>
      <td class="tableBorder">
        <table width="100%" border="0" cellspacing="1" cellpadding="0">
          <tr>
            <td colspan="3" class="tableTitle">&#8250; <?php echo translate('Email Users')?></td>
          </tr>
		  <?php echo "
          <tr class=\"rowHeaders\">
            <td width=\"15%\">&nbsp;</td>
            <td width=\"40%\">" . translate('User') . "</td>
            <td width=\"45%\">" . translate('Email') . "</td>
          </tr>";

	if (!$users)
		echo '<tr class="cellColor0" style="text-align: center;"><td colspan="3">' . $err . '</td></tr>';
    // Print users out in table
    for ($i = 0; is_array($users) && $i < count($users); $i++) {
		$cur = $users[$i];
        echo '<tr class="cellColor' . ($i%2) . "\">\n"
            . '<td style="text-align: center;"><input type="checkbox" ';
		if ( empty($usr) || in_array($cur['email'], $usr) )
			echo 'checked="checked" ';
		echo 'name="emailIDs[]" value="' . $cur['email'] . "\" /></td>\n"
            . '<td>&lt;' . $cur['lname'] . ', ' . $cur['fname'] . '&gt;</td>'
            . '<td>' . $cur['email'] . '</td>'
            . "</tr>\n";
    }
    ?>
          <tr>
            <td class="cellColor0" style="text-align: center;">
              <input type="checkbox" name="checkAll" checked="checked" onclick="checkAllBoxes(this);" />
            </td>
			<td colspan="2" class="cellColor0">&nbsp;</td>
          </tr>
        </table>
      </td>
    </tr>
  </table>
  <br />
  <table width="60%" border="0" cellspacing="0" cellpadding="5">
    <tr>
      <td width="15%"><p><?php echo translate('Subject')?></p>
      </td>
      <td><input type="text" name="subject" size="60" class="textbox" value="<?php echo $sub?>"/>
      </td>
    </tr>
    <tr>
      <td valign="top"><p><?php echo translate('Message')?></p>
      </td>
      <td><textarea rows="10" cols="60" name="message" class="textbox"><?php echo $msg?></textarea>
      </td>
    </tr>
  </table>
  <input type="submit" name="previewEmail" value="<?php echo translate('Next')?> &gt;" class="button" />
</form>
<?php
}

/**
* Prints out a preview of the email to be sent
* @param string $sub subject of email
* @param string $msg message of email
* @param array $usr array of users to send the email to
*/
function preview_email($sub, $msg, $usr) {
?>
<table width="60%" cellpadding="0" cellspacing="0" border="0">
  <tr>
    <td bgcolor="#DEDEDE">
      <table width="100%" cellpadding="3" cellspacing="1" border="0">
        <tr class="cellColor0">
          <td><?php echo $sub?>
          </td>
        </tr>
        <tr class="cellColor0">
          <td><?php echo $msg?>
          </td>
        </tr>
		<tr class="cellColor0">
		  <td>
		  <?php
		  if (empty($usr)) echo translate('Please select users');
		  foreach ($usr as $email) { echo $email . '<br />'; }
		  ?>
		  </td>
		</tr>
      </table>
    </td>
  </tr>
</table>
<br />
<form action="<?php echo $_SERVER['PHP_SELF'] . '?tool=' . $_GET['tool']?>" method="post" name="send_email">
<input type="button" name="goback" value="&lt; <?php echo translate('Back')?>" class="button" onclick="history.back();" />
<input type="submit" name="sendEmail" value="<?php echo translate('Send Email')?>" class="button" />
</form>
<?php
}


/**
* Actually sends the email to all addresses in POST
* @param string $subject subject of email
* @param string $msg email message
* @param array $success array of users that email was successful for
*/
function print_email_results($subject, $msg, $success) {
    if (!$success)
		CmnFns::do_error_box(translate('problem sending email'), '', false);
	else {
		CmnFns::do_message_box(translate('The email sent successfully.'));
	}

    echo '<h4 align="center">' . translate('do not refresh page') . '<br/>'
        . '<a href="' . $_SERVER['PHP_SELF'] . '?tool=email">' . translate('Return to email management') . '</a></h4>';
}

/**
* Prints out a list of tables and all the fields in them
*  with an option to select which tables and fields should be exported
*  and in which format
* @param array $tables array of tables
* @param array $fields array of fields for each table
*/
function show_tables($tables, $fields) {
	echo '<h5>' . translate('Please select which tables and fields to export') . '</h5>'
		. '<form name="get_fields" action="' . $_SERVER['PHP_SELF'] . '?' . $_SERVER['QUERY_STRING'] . '" method="post">' . "\n";
	for ($i = 0; $i < count($tables); $i++) {
		echo '<p><input type="checkbox" name="table[]" value="' . $tables[$i] . '"  checked="checked" onclick="javascript: toggle_fields(this);" />' . $tables[$i] . "</p>\n";

		echo '<select name="table,' . $tables[$i] . '[]" multiple="multiple" size="5" class="textbox">' . "\n";
		echo '<option value="all" selected="selected">' . translate('all fields') . "</option>\n";
		for ($k = 0; $k < count($fields[$tables[$i]]); $k++)
			echo  '<option value="' . $fields[$tables[$i]][$k] . '">' . $fields[$tables[$i]][$k] . '</option>' . "\n";

		echo "</select><br />\n";
	}
	echo '<p><input type="radio" name="type" value="xml" checked="checked" />' . translate('XML')
		. '<input type="radio" name="type" value="csv" />' . translate('CSV')
		. '</p><br /><input type="submit" name="submit" value="' . translate('Export Data') . '" class="button" /></form>';
}

/**
* Begins the line of table data
* @param boolean $xml if this is in XML or not
* @param string $table_name name of this table
*/
function start_exported_data($xml, $table_name) {
	echo '<pre>';
	echo ($xml) ? "&lt;$table_name&gt;\r\n" : '';
}

/**
* Prints out the exported data in XML or CSV format
* @param array $data array of data to print out
* @param boolean $xml whether to print XML or not
*/
function print_exported_data($data, $xml) {
	$first_row = true;
	for ($x = 0; $x < count($data); $x++) {
		echo ($xml) ? "\t&lt;record&gt;\r\n" : '';

		if (!$xml && $first_row) {				// Print out names of fields for first row of CSV
				$keys = array_keys($data[$x]);
				for ($i = 0; $i < count($keys); $i++) {
					echo '"' . $keys[$i] . '"';
					if ($i < count($keys)-1) echo ',';
				}
				echo "\r\n";
		}

		$first_row = false;

		$first_csv = '"';
		foreach ($data[$x] as $k => $v) {
			echo ($xml) ? "\t\t&lt;$k&gt;$v&lt;/$k&gt;\r\n" : $first_csv . addslashes($v) . '"';
			$first_csv = ',"';
		}
		echo ($xml) ? "\t&lt;/record&gt;\r\n" : "\r\n";
	}
}

/**
* Prints out an interface to manage blackout times for this resource
* @param array $resource array of resource data
* @param array $blackouts array of blackout data
*/
function print_blackouts($resource, $blackouts) {
	for ($i = 0; $i < count($resource); $i++)
		echo $resouce[$i] . '<br />';
}

/**
* Ends the line of table data
* @param boolean $xml if this is in XML or not
* @param string $table_name name of this table
*/
function end_exported_data($xml, $table_name) {
	echo ($xml) ? "&lt;/$table_name&gt;\r\n" : '';
	echo '</pre>';
}

/**
* Prints the form to reset a users password
* @param object $user user object
*/
function print_reset_password(&$user) {
?>
<form name="resetpw" method="post" action="admin_update.php">
  <table border="0" cellspacing="0" cellpadding="1" width="50%">
    <tr>
      <td class="tableBorder">
        <table cellspacing="1" cellpadding="2" border="0" width="100%">
          <tr class="rowHeaders">
		  	<td colspan="2"><?php echo translate('Reset Password for', array($user->get_name()))?></td>
		  </tr>
		  <tr class="cellColor">
            <td width="15%" valign="top"><?php echo translate('Password')?></td>
			<td><input type="password" value="" class="textbox" name="password" />
			<br />
			<i><?php echo translate('If no value is specified, the default password set in the config file will be used.')?></i>
			</td>
		  <tr class="cellColor">
		    <td colspan="2"><input type="checkbox" name="notify_user" value="true" checked="checked"/><?php echo translate('Notify user that password has been changed?')?></td>
		  </tr>
          </tr>
        </table>
      </td>
    </tr>
  </table>
  <input type="hidden" name="memberid" value="<?php echo $user->get_id()?>" />
  <br />
  <?php echo submit_button(translate('Save')) . hidden_fn('resetPass')?>
  <input type="button" name="cancel" value="<?php echo translate('Manage Users')?>" class="button" onclick="document.location='<?php echo $_SERVER['PHP_SELF']?>?tool=users';" />
</form>
<?php
}

/**
* Prints out a message that the current user cannot perform the function
* @param none
*/
function print_not_allowed() {
	echo translate('This is only accessable to the administrator');
}

/**
* Returns a button to cancel editing
* @param none
* @return string of html for a cancel button
*/
function cancel_button(&$pager) {
	return '<input type="button" name="cancel" value="' . translate('Cancel') . '" class="button" onclick="javascript: document.location=\'' . $_SERVER['PHP_SELF'] . '?tool=' . $_GET['tool'] . '&amp;' . $pager->getLimitVar() . '=' . $pager->getLimit() . '&amp;' . $pager->getPageVar() . '=' . $pager->getPageNum() . '\';" />' . "\n";
}

/**
* Returns a submit button with $value value
* @param string $value value of button
* @param string $get_value value in the query string for editing an item (ie, to edit a resource its machid)
* @return string of html for a submit button
*/
function submit_button($value, $get_value = '') {
	return '<input type="submit" name="submit" value="' . $value . '" class="button" />' . "\n"
			. '<input type="hidden" name="get" value="' . $get_value  . '" />' . "\n";
}

/**
* Returns a hidden fn field
* @param string $value value of the hidden field
* @return string of html for hidden fn field
*/
function hidden_fn($value) {
	return '<input type="hidden" name="fn" value="'. $value . '" />' . "\n";
}

/**
* Prints out the javascript necessary to set up the calendars for choosing start/end dates
* @param int $start initial start date time
* @param int $end initial end date time
*/
function print_jscalendar_setup($start = null, $end = null) {
	global $dates;
	if ($start == null) { $start = mktime(); }
	if ($end == null) { $end = mktime(); }
	?>
	<script type="text/javascript">
	var start = new Date(<?php echo date('Y', $start) . ',' . (intval(date('m', $start))-1) . ',' . date('d', $start)?>);
	// Start date calendar
	Calendar.setup(
	{
	inputField : "hdn_start_date", // ID of the input field
	ifFormat : "<?php echo '%m' . INTERNAL_DATE_SEPERATOR . '%d' . INTERNAL_DATE_SEPERATOR . '%Y'?>", // the date format
	daFormat : "<?php echo $dates['general_date']?>", // the date format
	button : "img_start_date", // ID of the button
	date : start,
	displayArea : "div_start_date"
	}
	);
	var end = new Date(<?php echo date('Y', $end) . ',' . (intval(date('m', $end))-1) . ',' . date('d', $end)?>);
	// End date calendar
	Calendar.setup(
	{
	inputField : "hdn_end_date", // ID of the input field
	ifFormat : "<?php echo '%m' . INTERNAL_DATE_SEPERATOR . '%d' . INTERNAL_DATE_SEPERATOR . '%Y'?>", // the date format
	daFormat : "<?php echo $dates['general_date']?>", // the date format
	button : "img_end_date", // ID of the button
	date : end,
	displayArea : "div_end_date"
	}
	);
	</script>
<?php
}

function print_additional_tools_box($links) {
?>
<table border="0" cellspacing="0" cellpadding="2" class="additionalTools">
  <tr>
    <td class="additionalToolsHead"><h5 align="center"><?php echo translate('Additional Tools')?></h5></td>
  </tr>
  <tr>
<?php
	for ($i = 0; $i < count($links); $i++) {
    	echo " <td>- <a href=\"{$links[$i][1]}\">" . translate($links[$i][0]) . " </td>\n";
	}
?>
  </tr>
</table>
<?php
}
?>