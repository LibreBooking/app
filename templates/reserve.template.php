<?php
/**
* This file provides output functions for reserve.php
* No data manipulation is done in this file
* @author Nick Korbel <lqqkout13@users.sourceforge.net>
* @author David Poole <David.Poole@fccc.edu>
* @version 10-05-06
* @package Templates
*
* Copyright (C) 2003 - 2006 phpScheduleIt
* License: GPL, see LICENSE
*/

/**
* Print out the resource name
* @param string $name name of the resource
*/
function print_title($name) {
	echo "<h3 align=\"center\">$name</h3>\n";
}

/**
* Opens form for reserve
* @param bool $show_repeat whether to show the repeat box
* @param bool $is_blackout if this is a blackout
*/
function begin_reserve_form($show_repeat, $is_blackout = false) {
	echo '<form name="reserve" id="reserve" method="post" action="' . $_SERVER['PHP_SELF'] . '?is_blackout=' . intval($is_blackout) . '" style="margin: 0px"' . " onsubmit=\"return check_reservation_form(this);\">\n";	
}

/**
* Begins the outer reservation table.  This prints out the tabs for basic/advanced
* and switches between them
* @param none
*/
function begin_container() {
?>
<!-- begin_container() -->
<table width="100%" cellspacing="0" cellpadding="0" border="0" id="tab-container">
<tr class="tab-row">
<td class="tab-selected" id="tab_basic" onclick="javacript: clickTab(this, 'pnl_basic');"><a href="javascript:void(0);"><?php echo translate('Basic')?></a></td>
<td class="tab-not-selected" id="tab_advanced" onclick="javacript: clickTab(this, 'pnl_advanced');" style="border-left-width:0px;"><a href="javascript:void(0);"><?php echo translate('Participants')?></a></td>
<td class="tab-not-selected" id="tab_additional" onclick="javacript: clickTab(this, 'pnl_additional');" style="border-left-width:0px;"><a href="javascript:void(0);"><?php echo translate('Accessories')?></a></td>
<td class="tab-filler">&nbsp;</td>
</tr>
</table>
<table width="100%" cellspacing="0" cellpadding="0" border="0" class="tab-main">
  <tr>
    <td id="main-tab-panel" style="padding:7px;">
<?php
}

/**
* Prints the basic reservation form elements
* This contains: resource data, time information/select, user info, create/modify times, recurring selection, pending info
* @param object $res Reservation object to work with
* @param array $rs resource data array
* @param bool $is_private if the privacy mode is on and we should hide personal data
*/
function print_basic_panel(&$res, &$rs, $is_private) {
		global $conf;
?>
	<!-- Begin basic panel -->
      <div id="pnl_basic" style="display:table; width:100%; position: relative;">
        <table width="100%" cellpadding="0" cellspacing="0" border="0">
          <tr>
            <td width="330">
			<!-- Content begin -->
<?php
	print_resource_data($rs, ($res->type == RES_TYPE_ADD ? 2 : 1));		// Print resource info

	print_time_info($res, $rs, !$res->is_blackout, (isset($rs['allow_multi']) && $rs['allow_multi'] == 1));	// Print time information

	if (!$res->is_blackout && !$is_private) {
		print_user_info($res->type, $res->user);	// Print user info
	}

	if (!empty($res->id)) {			// Print created/modified times (if applicable)
		print_create_modify($res->created, $res->modified);
	}

	print_summary($res->summary, $res->type);

	if (!empty($res->parentid) && ($res->type == RES_TYPE_MODIFY || $res->type == RES_TYPE_DELETE || $res->type == RES_TYPE_APPROVE)) {
		print_recur_checkbox($res->parentid);
	}

	if ($res->type == RES_TYPE_MODIFY) {
		print_del_checkbox();
	}

	if ($res->type == RES_TYPE_ADD || $res->type == RES_TYPE_MODIFY) {		// Print out repeat reservation box, if applicable
		divide_table();
		if ($res->type == RES_TYPE_ADD) {
			print_repeat_box(date('m', $res->start_date), date('Y', $res->start_date));
	
			if( $res->is_pending ) {
				 print_pending_approval_msg();
			}
		}
		$reminder_times = $conf['app']['allowed_reminder_times'];
		print_reminder_box($reminder_times, $res->reminder_minutes_prior, $res->reminderid);
	}
?>
			<!-- Content end -->
			</td>
          </tr>
        </table>
      </div>
	  <!-- End basic panel -->
<?php
}

/**
* Prints out the advanced reservation functions
* @param Object $res Reservation object that is being printed out
* @param array $users array of all users fname, lname, memberid
* @param bool $is_owner if the current user is the reservations owner
* @param string $max_participants the maximum number of participants for this resource
* @param bool $viewable if the advanced panel shows anything
* @param bool $day_has_passed if the day being displayed is already in the past
*/
function print_users_panel($res, $users, $is_owner, $max_participants, $viewable = true, $day_has_passed) {
?>
	<!-- Begin advanced panel -->
     <div id="pnl_advanced" style="display:none; width:100%; position: relative;">
        <table width="100%" cellpadding="0" cellspacing="0" border="0">
          <tr>
		  <!-- Begin content -->
		  <?php
		    if (!$viewable) {
				echo '<td>' . translate('No advanced options available') . '</td>';
			}
			else {
				$user_info = $res->users;
				$total_users = 0;

				if ($max_participants != '' && $is_owner) {
					echo '<p class="warningText">' . translate('Maximum of participants', array($max_participants)) . '</p>';
				}
				else if ($max_participants != '' && !$is_owner) {
					// Show how many openings are taken
					for ($i = 0; $i < count($user_info); $i++) {
						if ($user_info[$i]['invited'] != 1 && $user_info[$i]['owner'] != 1) {
							$total_users++;
						}
					}
					echo "<p class=\"warningText\">$total_users/$max_participants " . translate('Participants') . '</p>';
				}

				if ($is_owner && $res->type != RES_TYPE_APPROVE && $res->type != RES_TYPE_DELETE) {
					print_invite_selectboxes($res, $users, $user_info);
					print_participating_users($user_info);
					print_participation_checkboxes((bool)$res->allow_participation, (bool)$res->allow_anon_participation);
				}
				else {
					print_invited_particpating_users($user_info);
					if (
						((bool)$res->get_allow_participation() || (bool)$res->get_allow_anon_participation())
						&& ( ($max_participants == '') || ($total_users < intval($max_participants)) )
						&& !$day_has_passed
						) {
							print_join_form($res->get_allow_participation(), $res->get_allow_anon_participation(), $res->get_parentid());
					}
				}
			}
		  ?>
			<!-- End content -->
          </tr>
        </table>
      </div>
	  <!-- End advanced panel -->
<?php
}

function print_additional_tab($res, $all_resources, $is_owner, $viewable) {
?>
<!-- Begin additional panel -->
     <div id="pnl_additional" style="display:none; width:100%; position: relative;">
        <table width="100%" cellpadding="0" cellspacing="0" border="0">
          <tr>
		  <!-- Begin content -->
		  <?php
		    if (!$viewable) {
				echo '<td>' . translate('No advanced options available') . '</td>';
			}
			else {
				if ($is_owner && $res->type != RES_TYPE_APPROVE && $res->type != RES_TYPE_DELETE) {
					echo '<td width="200" align="center">';
				
					// Print select boxes
					echo translate('All Accessories');
					?>
					<br/><select name="all_resources[]" id="all_resources" class="textbox" multiple="multiple" size="10" style="width:195px;">
					<?php
					for ($i = 0; $i < count($all_resources); $i++) {
						echo "<option value=\"{$all_resources[$i]['resourceid']}\">{$all_resources[$i]['name']}</option>\n";
					}
					?>
					</select>
					</td>
					<td valign="middle" align="center">
					<button type="button" id="add_to_additionalresource" class="button" onclick="javascript: moveSelectItems('all_resources','selected_resources');" style="width:75px;font-size:12px;">&raquo;&raquo;</button>
					<br/><br/>
					<?php echo translate('Hold CTRL to select multiple')?>
					<br/><br/>
					<button type="button" id="remove_from_additionalresource" class="button" onclick="javascript: moveSelectItems('selected_resources','all_resources');" style="width:75px;font-size:12px;">&laquo;&laquo;</button>
					</td>
					<td width="200" align="center">
					<?php echo translate('Added Accessories')?><br/>
					<select name="selected_resources[]" id="selected_resources" class="textbox" multiple="multiple" size="10" style="width:195px;">
						<?php
						for ($i = 0; $i < count($res->resources); $i++) {
							echo "<option value=\"{$res->resources[$i]['resourceid']}\">{$res->resources[$i]['name']}</option>";
						}
						?>
					</select>
					<select style="visibility:hidden;display:none;" id="orig_resources" name="orig_resources[]" multiple="multiple">
					<?php
					// Original reservations used for array_diff to make sure we update the right ones
					for ($i = 0; $i < count($res->resources); $i++) {
							echo "<option value=\"{$res->resources[$i]['resourceid']}\" selected=\"selected\">{$res->resources[$i]['name']}</option>";
						}
					?>
					</select>
					</td>
					<?php
				}
				else {
					echo '<td><p style="font-weight:bold;">' . translate('Resources') . '</p>';
					if (count($res->resources) <= 0) {
						echo translate('None');
					}
					
					// Print additional resource info
					for ($i = 0; $i < count($res->resources); $i++) {
						echo "<p>{$res->resources[$i]['name']}</p>";
					}
					echo '</td>';
				}
			}
		  ?>
			<!-- End content -->
          </tr>
        </table>
      </div>
	  <!-- End additional panel -->
<?php
}

/**
* Prints out select boxes so that the reservation owner/creator can
*  invite or uninvite users
* @param Object $res Reservation object of current reservation
* @param array $users array of all users in the database
* @param array $user_info the users array of the Reservation object
*/
function print_invite_selectboxes($res, $users, $user_info) {
	?>
	<td colspan="3"><p align="center" style="font-weight: bold;">
	<?php
	echo translate('Invite Users');
	?>
	</p>
	</td>
	</tr>
	<tr>
	<td width="200" align="center">
	<?php echo translate('All Users')?><br/>
	<select name="all_users[]" id="all_users" class="textbox" multiple="multiple" size="10" style="width:195px;">
	<?php
	for ($i = 0; $i < count($users); $i++) {
		echo "<option value=\"{$users[$i]['memberid']}|{$users[$i]['email']}\">{$users[$i]['lname']}, {$users[$i]['fname']}</option>";
	}
	?>
	</select>
	</td>
	<td valign="middle" align="center">
	<button type="button" id="add_to_invite" class="button" onclick="javascript: moveSelectItems('all_users','invited_users'); javascript: addInvitedUserHidden('all_users', 'users_to_add', 'orig_invited_users');" style="width:75px;font-size:12px;">&raquo;&raquo;</button>
	<br/><br/>
	<?php echo translate('Hold CTRL to select multiple')?>
	<br/><br/>
	<button type="button" id="remove_from_invite" class="button" onclick="javascript: moveSelectItems('invited_users','all_users');" style="width:75px;font-size:12px;">&laquo;&laquo;</button>
	</td>
	<td width="200" align="center">
	<?php echo translate('Invited Users')?><br/>
	<select name="invited_users[]" id="invited_users" class="textbox" multiple="multiple" size="10" style="width:195px;">
	<?php
	for ($i = 0; $i < count($user_info); $i++) {
		if ($user_info[$i]['invited'] == 1) {
			echo "<option value=\"{$user_info[$i]['memberid']}|{$user_info[$i]['email']}\">{$user_info[$i]['lname']}, {$user_info[$i]['fname']}</option>";
		}
	}
	?>
	</select>
	<select style="visibility:hidden;display:none;" id="orig_invited_users" name="orig_invited_users[]" multiple="multiple">
	<?php
	for ($i = 0; $i < count($user_info); $i++) {
		if ($user_info[$i]['invited'] == 1) {
			echo "<option value=\"{$user_info[$i]['memberid']}|{$user_info[$i]['email']}\" selected=\"selected\">{$user_info[$i]['lname']}, {$user_info[$i]['fname']}</option>";
		}
	}
	?>
	</select>
	</td>
	<?php
}

/**
* Prints out select boxes so that the reservation owner/creator can
*  remove users from participating in this reservation
* @param array $user_info the users array of the Reservation object
*/
function print_participating_users($user_info) {
	?>
	</tr><tr><td colspan="3"><p align="center" style="font-weight: bold;padding-top:10px;">
	<?php echo translate('Remove Participants'); ?>
	</p>
	</td>
	</tr><tr>
	<td width="200" align="center">
	<?php echo translate('All Users'); ?><br/>
	<select name="removed_users[]" id="removed_users" class="textbox" multiple="multiple" size="10" style="width:195px;">
	</select>
	</td>
	<td valign="middle" align="center">
	<button type="button" id="add_to_participate" class="button" onclick="javascript: moveSelectItems('removed_users','participating_users');" style="width:75px;font-size:12px;">&raquo;&raquo;</button>
	<br/><br/>
	<?php echo translate('Hold CTRL to select multiple'); ?>
	<br/><br/>
	<button type="button" id="remove_from_participate" class="button" onclick="javascript: moveSelectItems('participating_users','removed_users');" style="width:75px;font-size:12px;">&laquo;&laquo;</button>
	</td>
	<td width="200" align="center">
	<?php echo translate('Particpating Users'); ?><br/>
	<select name="participating_users[]" id="participating_users" class="textbox" multiple="multiple" size="10" style="width:195px;">
	<?php
	for ($i = 0; $i < count($user_info); $i++) {
		if ($user_info[$i]['invited'] != 1 && $user_info[$i]['owner'] != 1) {
			echo "<option value=\"{$user_info[$i]['memberid']}|{$user_info[$i]['email']}\">{$user_info[$i]['lname']}, {$user_info[$i]['fname']}</option>";
		}
	}
	?>
	</select>
	</td>
	<?php
}


/**
* Prints out lists of all of the invited and all of the participating users
* @param array $user_info users array from the Reservation object
*/
function print_invited_particpating_users($user_info){
	$invited = $participating = '';
	for ($i = 0; $i < count($user_info); $i++) {
		if ($user_info[$i]['invited'] == 1) {
			$invited .= "<p>{$user_info[$i]['lname']} , {$user_info[$i]['fname']}</p>";
		}
		else if ($user_info[$i]['owner'] != 1){
			$participating .= "<p>{$user_info[$i]['lname']} , {$user_info[$i]['fname']}</p>";
		}
	}
?>
	<td style="width:48%; vertical-align:top;">
		<p style="font-weight:bold;"><?php echo translate('Invited Users')?></p>
		<?php echo $invited?>
	</td>
	<td>&nbsp;</td>
	<td style="width:48%; vertical-align:top;">
		<p style="font-weight:bold;"><?php echo translate('Particpating Users')?></p>
		<?php echo $participating?>
	</td>
<?php
}

function print_participation_checkboxes($allow_part, $allow_anon) {
?>
</tr><tr><td colspan="3">
<input type="checkbox" name="allow_participation" <?php echo ($allow_part) ? 'checked="checked"' : ''?>/><?php echo translate('Allow registered users to join?')?><br/>
<input type="checkbox" name="allow_anon_participation" <?php echo ($allow_anon) ? 'checked="checked"' : ''?>/><?php echo translate('Allow non-registered users to join?')?>
</td>
<?php
}

/**
* Prints out the textboxes and buttons for the self registration
* @param bool $allow_participation if self registration is allowed for registered users
* @param bool $allow_anon_participation if self registration is allowed for non registered users
*/
function print_join_form($allow_participation, $allow_anon_participation, $parentid) {
	$join = translate('Join');
	$allow_participation = ($allow_participation && Auth::is_logged_in());
	$allow_anon_participation = ($allow_anon_participation && !Auth::is_logged_in());
?>
</tr><tr><td colspan="3">
<p align="center" style="margin-top:10px;"><a href="javascript:showHide('join_options');"><?php echo translate('My Participation Options')?></a></p>
<div id="join_options" style="display:none;">
<?php
if ($allow_participation) {
	echo '<input type="hidden" name="join_userid" id="join_userid" value="' . Auth::getCurrentID() . '"/>';
}
else if ($allow_anon_participation) {
?>
<table width="100%" border="0" style="border: dashed 1px #DDDDDD;background-color:#FFFFFF;" align="center">
<tr>
	<td align="right" width="20%"><?php echo translate('First Name')?></td>
	<td><input type="text" name="join_fname" id="join_fname" class="textbox" maxlength="30"/></td>
</tr>
<tr>
	<td align="right"><?php echo translate('Last Name')?></td>
	<td><input type="text" name="join_lname" id="join_lname" class="textbox" maxlength="30"/></td>
</tr>
<tr>
	<td align="right"><?php echo translate('Email')?></td>
	<td><input type="text" name="join_email" id="join_email" class="textbox" maxlength="75"/></td>
</tr>
</table>
<?php
}

if ($allow_participation || $allow_anon_participation) {
	echo '<p align="center">';
	echo '<button type="button" name="btn_join" value="' . $join . '" class="button" onclick="submitJoinForm(' . (int)$allow_participation . ');">' . $join . '</button>';
	echo ($parentid != null) ? ' <input type="checkbox" name="join_parentid"/> ' . translate('Join All Recurring') : '';
	echo '</p>';
}
?>
</div>
</td>
<?php
}

/**
* Prints out a form of hidden values for the self registration
* @param none
*/
function print_join_form_tags() {
?>
<form name="join_form" method="post" action="join.php" style="margin:0px;" id="join_form">
	<input type="hidden" name="h_join_fname" value=""/>
	<input type="hidden" name="h_join_lname" value=""/>
	<input type="hidden" name="h_join_email" value=""/>
	<input type="hidden" name="h_join_userid" value=""/>
	<input type="hidden" name="h_join_resid" value=""/>
</form>
<form name="reserve_check" id="reserve_check" method="post" action="reserve.php" style="margin:0px;">
</form>
<?php
}

/**
* Closes all tags opened by begin_container()
* @param none
*/
function end_container() {
?>
	<!-- end_container() -->
    </td>
  </tr>
</table>
<?php
}

/**
* Prints all the buttons and hidden fields
* @param object $res Reservation object to work with
*/
function print_buttons_and_hidden(&$res) {
?>
<table width="100%" cellpadding="0" cellspacing="0" border="0">
  <tr>
    <td>
<?php
	$is_owner = ($res->user->get_id() == Auth::getCurrentID());
	$type = $res->get_type();
      // Print buttons depending on type
    echo '<p>';
	switch($type) {
  	    case RES_TYPE_MODIFY :
            echo '<input type="submit" name="btnSubmit" value="' . translate('Save') . '" class="button" onclick="selectAllOptions(this);"/>'
				. '<input type="hidden" name="fn" value="modify" />';
	    break;
        case RES_TYPE_DELETE :
            echo '<input type="submit" name="btnSubmit" value="' . translate('Delete') . '" class="button" />'
					. '<input type="hidden" name="fn" value="delete" />';
	    break;
        case RES_TYPE_VIEW :
            echo '<input type="button" name="close" value="' . translate('Close Window') . '" class="button" onclick="window.close();" />';
	    break;
        case RES_TYPE_ADD :
            echo '<input type="submit" name="btnSubmit" value="' . translate('Save') . '" class="button" onclick="selectAllOptions(this);"/>'
					. '<input type="hidden" name="fn" value="create" />';
        break;
		case RES_TYPE_APPROVE :
			echo '<input type="submit" name="btnSubmit" value="' . translate('Approve') . '" class="button"/>'
				. '<input type="hidden" name="fn" value="approve" />';
    }
    // Print cancel button as long as type is not "view"
	if ($type != RES_TYPE_VIEW) {
		echo '&nbsp;&nbsp;&nbsp;<input type="button" name="close" value="' . translate('Cancel') . '" class="button" onclick="window.close();" />';
	}
	if ($type != RES_TYPE_ADD && $is_owner) {
		echo '&nbsp;&nbsp;';
		print_export_button($res->id);
	}
	
	echo '</p>';
	
	if ($type == RES_TYPE_ADD || $type == RES_TYPE_MODIFY) {
		echo '</td><td align="right"><button type="button" name="check" value="' . translate('Check Availability') . '" class="button" onclick="checkReservation(\'check.php\', \'reserve\', \'' . translate('Checking') . '\');">' . translate('Check Availability') . '</button></td><td>';	
	}

	// print hidden fields
	if ($res->get_type() == RES_TYPE_ADD) {
        echo '<input type="hidden" name="machid" value="' . $res->get_machid(). '" />' . "\n"
			  . '<input type="hidden" name="scheduleid" value="' . $res->sched['scheduleid'] . '" />' . "\n"
			  . '<input type="hidden" name="pending" value="' . $res->get_pending(). '" />' . "\n"
			  . '<input type="hidden" name="memberid" value="' . Auth::getCurrentID() . '" />' . "\n";;
    }
    else {
        echo '<input type="hidden" name="resid" id="resid" value="' . $res->get_id() . '" />' . "\n"
			. '<input type="hidden" name="memberid" value="' . $res->get_memberid() . '" />' . "\n";;
    }
?>
    </td>
  </tr>
  <?php 
	if ($type == RES_TYPE_ADD || $type == RES_TYPE_MODIFY) {
  		echo '<tr><td colspan="2"><div id="checkDiv" style="display:none;width:100%;padding-top:15px;"></div></td></tr>';
	}
  ?>
</table>
<?php
}

/**
* Print out information about this resource
* This function prints out a table containing
*  all information about a given resource
* @param array $rs array of resource information
*/
function print_resource_data(&$rs, $colspan = 1) {
?>
<table width="100%" border="0" cellspacing="0" cellpadding="1">
  <tr class="tableBorder">
    <td>
      <table width="100%" border="0" cellspacing="1" cellpadding="0">
        <tr>
          <td width="100" class="formNames"><?php echo translate('Location')?></td>
          <td class="cellColor"><?php echo $rs['location']?>
          </td>
        </tr>
        <tr>
          <td width="100" class="formNames"><?php echo translate('Phone')?></td>
          <td class="cellColor"><?php echo $rs['rphone']?>
          </td>
        </tr>
        <tr>
          <td width="100" class="formNames"><?php echo translate('Notes')?></td>
          <td class="cellColor"><?php echo $rs['notes']?>
          </td>
        </tr>
      </table>
    </td>
  </tr>
</table>
<p>&nbsp;</p>
<?php
}


/**
* Print out available times or current reservation's time
* This function will print out all available times to make
*  a reservation or will print out the selected reservation's time
*  (if this is a view).
* @param array $res resource data array
* @param object $rs reservation object
* @param bool $print_min_max bool whether to print the min_max cells
* @param bool $allow_multi bool if multiple day reseravtions are allowed
* @global $conf
*/
function print_time_info($res, $rs, $print_min_max = true, $allow_multi = false) {
	global $conf;

	$type = $res->get_type();
	$interval = $res->sched['timespan'];
	$startDay = $res->sched['daystart'];
	$endDay	  = $res->sched['dayend'];
?>
    <table width="100%" border="0" cellspacing="0" cellpadding="1">
     <tr class="tableBorder">
      <td>
       <table width="100%" border="0" cellspacing="1" cellpadding="0">
        <tr>
         <td colspan="2" class="cellColor">
         <h5 align='center'>
<?php
         // Print message depending on viewing type
         switch($type) {
            case RES_TYPE_ADD : $msg = translate('Please select the starting and ending times');
                break;
            case RES_TYPE_MODIFY : $msg = translate('Please change the starting and ending times');
                break;
            default : $msg = translate('Reserved time');
                break;
        }
		if ((bool)$res->get_pending()) {
			$msg .= ' (' . translate('Pending Approval') . ')';		
		}
        echo $msg;
?>
        </h5>
        </td>
       </tr>
	   <tr>
	   <td class="formNames"><?php echo translate('Start')?></td>
	   <td class="formNames"><?php echo translate('End')?></td>
	   </tr>
      <tr>
<?php
		$start_date = $res->get_start_date();
		$end_date = $res->get_end_date();
		
		$display_start_date = Time::getAdjustedDate($res->get_start_date(), $res->get_start());
		$display_end_date = Time::getAdjustedDate($res->get_end_date(), $res->get_end());
		
		// Show reserved time or select boxes depending on type
        if ( ($type == RES_TYPE_ADD) || ($type == RES_TYPE_MODIFY) || ($type == RES_TYPE_APPROVE) ) {
            // Start time select box
            echo '<td class="formNames" width="50%"><div id="div_start_date" style="float:left;width:86px;">' . Time::formatDate($display_start_date, '', false) . '</div><input type="hidden" id="hdn_start_date" name="start_date" value="' . date('m' . INTERNAL_DATE_SEPERATOR . 'd' . INTERNAL_DATE_SEPERATOR . 'Y', $start_date) . '" onchange="checkCalendarDates();"/>';
			if ($allow_multi) {
				echo '<a href="javascript:void(0);"><img src="img/calendar.gif" border="0" id="img_start_date" alt="' . translate('Start') . '"/></a>'
                   . '<br/><br/>';
			}
			echo "<select name=\"starttime\" class=\"textbox\">\n";
            // Start at startDay time, end 30 min before endDay
            for ($i = $startDay; $i < $endDay+$interval; $i += $interval) {
                echo '<option value="' . $i . '"';
                // If this is a modification, select corrent time
                if ( ($res->get_start() == $i) ) {
                    echo ' selected="selected" ';
				}
                echo '>' . Time::formatTime($i) . '</option>';
            }
            echo "</select>\n</td>\n";

            // End time select box
            echo '<td class="formNames"><div id="div_end_date" style="float:left;width:86px;">' . Time::formatDate($display_end_date, '', false) . '</div><input type="hidden" id="hdn_end_date" name="end_date" value="' . date('m' . INTERNAL_DATE_SEPERATOR . 'd' . INTERNAL_DATE_SEPERATOR . 'Y', $end_date) . '" onchange="checkCalendarDates();"/>';
			if ($allow_multi) {
			echo '<a href="javascript:void(0);"><img src="img/calendar.gif" border="0" id="img_end_date" alt="' . translate('End') . '"/></a>'
                   . '<br/><br/>';
            }
			echo "<select name=\"endtime\" class=\"textbox\">\n";
			// Start at 30 after startDay time, end 30 at endDay time
            for ($i = $startDay; $i < $endDay+$interval; $i += $interval) {
                echo "<option value=\"$i\"";
                // If this is a modification, select corrent time
                if ( ($res->get_end() == $i) ) {
                    echo ' selected="selected" ';
				}
                echo '>' . Time::formatTime($i) . "</option>\n";
            }
            echo "</select>\n</td>\n";
			if ($print_min_max & !$allow_multi) {
				echo '</tr><tr class="cellColor">'
						. '<td colspan="2">' . translate('Minimum Reservation Length') . ' ' . Time::minutes_to_hours($rs['minres'])
						. '</td></tr>'
						. '<tr class="cellColor">'
						. '<td colspan="2">' . translate('Maximum Reservation Length') . ' ' . Time::minutes_to_hours($rs['maxres'])
						. '</td>';
			}
        }
        else {
            echo '<td class="formNames" width="50%"><div id="div_start_date" style="float:left;width:86px;">' . Time::formatDate($start_date, '', false) . '</div>' . Time::formatTime($res->get_start()) . "</td>\n"
			      . '<td class="formNames"><div id="div_end_date" style="float:left;width:86px;">' . Time::formatDate($end_date, '', false) . '</div>' . Time::formatTime($res->get_end()) . "</td>\n";

        }
        // Close off table
        echo "</tr>\n</table>\n</td>\n</tr>\n</table>\n<p>&nbsp;</p>\n";
}

/**
* Print out information about reservation's owner
* This function will print out information about
*  the selected reservation's user.
* @param string $type viewing type
* @param Object $user User object of this user
*/
function print_user_info($type, $user) {
	if (!$user->is_valid()) {
		$user->get_error();
	}
	$user = $user->get_user_data();
?>
   <table width="100%" border="0" cellspacing="0" cellpadding="1">
    <tr class="tableBorder">
     <td>
      <table width="100%" border="0" cellspacing="1" cellpadding="0">
       <tr>
        <td colspan="2" class="cellColor"><h5 align="center"><?php echo ($type=='v' || $type=='d') ? translate('Reserved for') : translate('Will be reserved for')?></h5></td></tr>
       <tr>
        <td width="100" class="formNames"><?php echo translate('Name')?></td>
         <td class="cellColor"><div id="name" style="position: relative;float:left;"><?php echo $user['fname'] . ' ' . $user['lname']?></div><?php if (Auth::isAdmin() && ($type == RES_TYPE_MODIFY || $type == RES_TYPE_ADD)) { echo "&nbsp;&nbsp;<a href=\"javascript:window.open('user_select.php','selectuser','height=430,width=570,resizable');void(0);\">" . translate('Change') . '</a>'; } ?></td>
          </tr>
          <tr>
           <td width="100" class="formNames"><?php echo translate('Phone')?></td>
           <td class="cellColor"><div id="phone" style="position: relative;"><?php echo $user['phone']?></div></td>
          </tr>
          <tr>
           <td width="100" class="formNames"><?php echo translate('Email')?></td>
           <td class="cellColor"><div id="email" style="position: relative;"><?php echo $user['email']?></div></td>
          </tr>
        </table>
      </td>
     </tr>
    </table>
    <p>&nbsp;</p>
    <?php
}


/**
* Print out created and modifed times in a table, if they exist
* @param int $c created timestamp
* @param int $m modified stimestamp
*/
function print_create_modify($c, $m) {
?>
    <table width="100%" border="0" cellspacing="0" cellpadding="1">
    <tr class="tableBorder">
     <td>
      <table width="100%" border="0" cellspacing="1" cellpadding="0">
       <tr>
       <td class="formNames" width="100"><?php echo translate('Created')?></td>
       <td class="cellColor"><?php echo Time::formatDateTime($c)?></td>
	   </tr>
       <tr>
       <td class="formNames"><?php echo translate('Last Modified')?></td>
       <td class="cellColor"><?php echo !empty($m) ? Time::formatDateTime($m) : translate('N/A') ?></td>
       </tr>
      </table>
     </td>
    </tr>
   </table>
   <p>&nbsp;</p>
<?php
}

/**
* Prints out a checkbox to modify all recurring reservations associated with this one
* @param string $parentid id of parent reservation
*/
function print_recur_checkbox($parentid) {
	?>
	<p align="left"><input type="checkbox" name="mod_recur" value="<?php echo $parentid?>" /><?php echo translate('Update all recurring records in group')?></p>
	<?php
}

function print_del_checkbox() {
?>
	<p align="left"><input type="checkbox" name="del" value="true" /><?php echo translate('Delete?')?></p>
<?php
}

/**
* Prints a box where users can select if they want
*  to repeat a reservation
* @param int $month month of current reservation
* @param int $year year of current reservation
*/
function print_repeat_box($month, $year) {
	global $days_abbr;
?>
<table width="200" border="0" cellspacing="0" cellpadding="0" class="recur_box" id="repeat_table">
  <tr>
    <td style="padding: 5px;">
	 <p style="margin-bottom: 8px;">
	  <?php echo translate('Repeat every')?><br/>
	  <select name="frequency" class="textbox">
	    <option value="1">1</option>
		<option value="2">2</option>
		<option value="3">3</option>
		<option value="4">4</option>
		<option value="5">5</option>
		<option value="6">6</option>
		<option value="7">7</option>
		<option value="8">8</option>
		<option value="9">9</option>
		<option value="10">10</option>
	  </select>
      <select name="interval" class="textbox" onchange="javascript: showHideDays(this);">
	    <option value="none"><?php echo translate('Never')?></option>
	    <option value="day"><?php echo translate('Days')?></option>
	    <option value="week"><?php echo translate('Weeks')?></option>
		<option value="month_date"><?php echo translate('Months (date)')?></option>
	    <option value="month_day"><?php echo translate('Months (day)')?></option>
      </select>
    </p>
	<div id="week_num" style="position: relative; visibility: hidden; overflow: show; display: none;">
	<p>
	<select name="week_number" class="textbox">
	  <option value="1"><?php echo translate('First Days')?></option>
	  <option value="2"><?php echo translate('Second Days')?></option>
	  <option value="3"><?php echo translate('Third Days')?></option>
	  <option value="4"><?php echo translate('Fourth Days')?></option>
	  <option value="last"><?php echo translate('Last Days')?></option>
	</select>
	</p>
	</div>
	<div id="days" style="position: relative; visibility: hidden; overflow: show; display: none;">
        <p style="margin-bottom: 8px;">
		<?php echo translate('Repeat on')?><br/>
        <input type="checkbox" name="repeat_day[]" value="0" /><?php echo $days_abbr[0]?><br />
		<input type="checkbox" name="repeat_day[]" value="1" /><?php echo $days_abbr[1]?><br />
		<input type="checkbox" name="repeat_day[]" value="2" /><?php echo $days_abbr[2]?><br />
		<input type="checkbox" name="repeat_day[]" value="3" /><?php echo $days_abbr[3]?><br />
		<input type="checkbox" name="repeat_day[]" value="4" /><?php echo $days_abbr[4]?><br />
		<input type="checkbox" name="repeat_day[]" value="5" /><?php echo $days_abbr[5]?><br />
		<input type="checkbox" name="repeat_day[]" value="6" /><?php echo $days_abbr[6]?>
        </p>
	</div>
	<div id="until" style="position: relative;">
		<p>
		<?php echo translate('Repeat until date')?>
		<div id="_repeat_until" style="float:left;width:86px;font-size:11px;"><?php echo translate('Choose Date')?></div><input type="button" id="btn_choosedate" value="..." />
		<input type="hidden" id="repeat_until" name="repeat_until" value="" />
		</p>
	</div>
	</td>
  </tr>
</table>
<?php
}

/**
* Prints out the box where users can select when to get a reminder
* @param array $reminder_times the minutes that are shown in the selection box
* @param int $selected_minutes the currently selected minutes
* @param string $reminderid id of the reminder to modify
*/
function print_reminder_box($reminder_times, $selected_minutes, $reminderid) {
	if (empty($reminder_times)) {
		return;
	}
?>
<table width="200" border="0" cellspacing="0" cellpadding="0" class="recur_box" id="repeat_table" style="margin-top:5px;">
  <tr>
    <td style="padding: 5px;">
	 <?php
	 echo '<input type="hidden" name="reminderid" id="reminderid" value="' . $reminderid . '"/>';
	 echo translate('Reminder') . ' ';
	 echo '<select name="reminder_minutes_prior" id="reminder_minutes_prior" class="textbox">';
	 echo '<option value="0">' . translate('Never') . '</option>';
	 for ($i = 0; $i < count($reminder_times); $i++) {
	 	echo "<option value=\"{$reminder_times[$i]} " . ($selected_minutes == $reminder_times[$i] ? 'selected="selected"' : '') . "\">" . Time::minutes_to_hours($reminder_times[$i]) . "</option>\n";
	 }
	 echo '</select><br/>';
	 echo translate('before reservation')
	 ?>
	</td>
  </tr>
</table>
<?php
}

/**
* Prints a box where users can select if they want
*  to repeat a reservation
* @param int $month month of current reservation
* @param int $year year of current reservation
*/
function print_pending_approval_msg() {
?>
<br />
<table width="100%" border="0" cellspacing="0" cellpadding="1">
  <tr>
    <td>
      <table width="100%" border="0" cellspacing="1" cellpadding="0">
        <tr>
            <td style="padding: 5px;">
	           <p style="font-weight: bold;" align="center"><?php echo translate('This reservation must be approved by the administrator.')?></p>
	       </td>
        </tr>
      </table>
     </td>
    </tr>
</table>
<?php
}

/**
* Print out the reservation summary or a box to add/edit one
* @param string $summary summary to edit
* @param string $type type of reservation
*/
function print_summary($summary, $type) {
?>
   <table width="100%" border="0" cellspacing="0" cellpadding="1">
    <tr class="tableBorder">
     <td>
      <table width="100%" border="0" cellspacing="1" cellpadding="0">
       <tr>
	    <td class="cellColor"><h5 align="center"><?php echo translate('Summary')?></h5></td>
		</tr>
		<tr>
		<td class="cellColor" style="text-align: left;">
		<?php
		if ($type == RES_TYPE_ADD || $type == RES_TYPE_MODIFY || $type == RES_TYPE_APPROVE) {
			echo '<div style="text-align:center;" id="summary_div"><textarea class="textbox" name="summary" rows="3" cols="40">' . $summary . '</textarea></div>';
		}
		else {
			echo (!empty($summary) ? CmnFns::html_activate_links($summary) : translate('N/A'));
		}
		?>
		</td>
	   </tr>
      </table>
     </td>
    </tr>
   </table>
<?php
}

function print_export_button($id) {
?>
	<input type="button" onclick="showHere(this, 'export_menu');" class="button" value="<?php echo translate('Export')?>"></input>
	<div id="export_menu" class="export_menu" onMouseOut="showHide('export_menu');">
	<table width="100%" cellpadding="0" cellspacing="1" border="0">
		<tr>
			<td class="export_menu_out" onmouseover="switchStyle(this,'export_menu_over');" onmouseout="switchStyle(this, 'export_menu_out');" onclick="openExport('ical', '<?php echo $id ?>');">iCalendar</td>
		</tr>
		<tr>
			<td class="export_menu_out" onmouseover="switchStyle(this,'export_menu_over');" onmouseout="switchStyle(this, 'export_menu_out');" onclick="openExport('vcal', '<?php echo $id ?>');">vCalendar</td>
		</tr>
	</table>
	</div>
<?php
}

/**
* Closes reserve form
* @param none
*/
function end_reserve_form() {
	echo "</form>\n";
}

/**
* Splits the table into two columns
*/
function divide_table() {
?>
</td>
<td style="vertical-align: top; padding-left: 15px;">
<?php
}

/**
* Prints out the javascript necessary to set up the calendars for choosing recurring dates, start/end dates
* @param Reservation $res reservation to populate the calendar dates with
*/
function print_jscalendar_setup(&$res, $rs) {
	global $dates;
	$allow_multi = (isset($rs['allow_multi']) && $rs['allow_multi'] == 1);
?>
<script type="text/javascript">
var now = new Date(<?php echo date('Y', $res->start_date) . ',' . (intval(date('m', $res->start_date))-1) . ',' . date('d', $res->start_date)?>);
<?php
if ($res->get_type() == RES_TYPE_ADD) {
?>
// Recurring calendar
Calendar.setup(
{
inputField : "repeat_until", // ID of the input field
ifFormat : "<?php echo '%m' . INTERNAL_DATE_SEPERATOR . '%d' . INTERNAL_DATE_SEPERATOR . '%Y'?>", // the date format
button : "btn_choosedate", // ID of the button
date : now,
displayArea : "_repeat_until",
daFormat : "<?php echo $dates['general_date']?>" // the date format
}
);
<?php }  if ($allow_multi && ($res->get_type() == RES_TYPE_ADD || $res->get_type() == RES_TYPE_MODIFY)) { ?>
//php Start date calendar
Calendar.setup(
{
inputField : "hdn_start_date", // ID of the input field
ifFormat : "<?php echo '%m' . INTERNAL_DATE_SEPERATOR . '%d' . INTERNAL_DATE_SEPERATOR . '%Y'?>", // the date format
daFormat : "<?php echo $dates['general_date']?>", // the date format
button : "img_start_date", // ID of the button
date : now,
displayArea : "div_start_date"
}
);
// End date calendar
Calendar.setup(
{
inputField : "hdn_end_date", // ID of the input field
ifFormat : "<?php echo '%m' . INTERNAL_DATE_SEPERATOR . '%d' . INTERNAL_DATE_SEPERATOR . '%Y'?>", // the date format
daFormat : "<?php echo $dates['general_date']?>", // the date format
button : "img_end_date", // ID of the button
date : now,
displayArea : "div_end_date"
}
);
<?php
	}
echo '</script>';
}
?>