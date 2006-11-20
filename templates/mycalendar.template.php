<?php
/**
* Provide all of the presentation functions for the MyCalendar class
* @author Nick Korbel <lqqkout13@users.sourceforge.net>
* @author Richard Cantzler <rmcii@users.sourceforge.net>
* @version 08-08-06
* @package Templates
*
* Copyright (C) 2003 - 2006 phpScheduleIt
* License: GPL, see LICENSE
*/

$link = CmnFns::getNewLink();

/**
* Prints out the navigational calendars
* @param Calendar $prev previous month calendar
* @param Calendar $next next month calendar
* @param Calendar $curr current month calendar
*/
function print_calendars(&$prev, &$next, &$curr) {
?>
<!-- Start calendars -->
<table width="100%" border="0" cellpadding="0" cellspacing="0">
  <tr>
    <td align="center" valign="top"><?php $prev->printCalendar()?></td>
	<?php
	if ($curr != null) {
		echo '<td align="center" valign="top">';
		$curr->printCalendar();
		echo '</td>';
	}
	?>
	<td align="center" valign="top"><?php $next->printCalendar()?></td>
  </tr>
</table>
<!-- End calendars -->
<?php
}

/**
* Prints out the proper datespan heading depending on $type
* @param $firstDate int datestamp of first date in calendar
* @param $lastDate int datestamp of last date in calendar
* @param $type int calendar view type
* @param $addl_params array list of additional querystring params
* @param $addl_values array list of additional querystring values that match the params
* @param $name string a name to print next to the date
*/
function print_date_span($firstDate, $lastDate, $type, $addl_params = array(), $addl_values = array(), $name = null) {
	global $months_full;
	global $link;
	
	$name_str = ($name == null) ? '' : $name . ' : ';
	
	$date_vars = getdate($firstDate);
	$link_string = $_SERVER['PHP_SELF'] . "?view=$type&amp;date=%s";
	
	// Attach all of the additional querystring params
	for ($pcount = 0; $pcount < count($addl_params); $pcount++) {
		$link_string .= "&amp;{$addl_params[$pcount]}={$addl_values[$pcount]}";
	}
	
	$move_month = $move_day = 0;		// How many months/days we should jump forward or back on the link clicks

	switch ($type) {
		case MYCALENDARTYPE_DAY :
			$move_day = 1;
			$date_string = translate_date('header', $firstDate);
			break;
		case MYCALENDARTYPE_MONTH :
			$move_month = 1;
			$date_string = $months_full[$date_vars['mon']-1] . ' ' . $date_vars['year'];
			break;
		default :
			$move_day = 7;
			$date_string = translate_date('general_date', $firstDate) . ' - ' . translate_date('general_date', $lastDate);
			break;
	}
		
	echo '<br/><h3 align="center">';	
	$link->doLink(sprintf($link_string, date('m-d-Y', mktime(0,0,0, $date_vars['mon'] - $move_month, $date_vars['mday'] - $move_day, $date_vars['year']))), '&lt;');
	echo "&nbsp;&nbsp;&nbsp;$name_str$date_string&nbsp;&nbsp;&nbsp;";
	$link->doLink(sprintf($link_string, date('m-d-Y', mktime(0,0,0, $date_vars['mon'] + $move_month, $date_vars['mday'] + $move_day, $date_vars['year']))), '&gt;');
	echo '</h3>';
}

/**
* Simply print out some links to change the view of the calendar
* @param int $datestamp the datestamp of the day we are focused on
* @param $type int calendar view type
* @param $addl_params array list of additional querystring params
* @param $addl_values array list of additional querystring values that match the params
*/
function print_view_links($datestamp, $current_view, $addl_params = array(), $addl_values = array()) {
	global $link;
	$date = date('m-d-Y', $datestamp);
	
	$day_image   = ($current_view == MYCALENDARTYPE_DAY) ? 'img/day_large.gif' : 'img/day_small.gif';
	$week_image  = ($current_view == MYCALENDARTYPE_WEEK) ? 'img/week_large.gif' : 'img/week_small.gif';
	$month_image = ($current_view == MYCALENDARTYPE_MONTH) ? 'img/month_large.gif' : 'img/month_small.gif';
	
	$link_string = $_SERVER['PHP_SELF'] . "?view=%d&amp;date=%s";
	
	// Attach all of the additional querystring params
	for ($pcount = 0; $pcount < count($addl_params); $pcount++) {
		$link_string .= "&amp;{$addl_params[$pcount]}={$addl_values[$pcount]}";
	}
	
	echo '<table width="270px" align="center" border="0"><tr align="center"><td>';
	$link->doImageLink(sprintf($link_string, MYCALENDARTYPE_DAY, $date), $day_image, translate('Day View'));
	echo '</td><td>';
	$link->doImageLink(sprintf($link_string, MYCALENDARTYPE_WEEK, $date), $week_image, translate('Week View'));
	echo '</td><td>';
	$link->doImageLink(sprintf($link_string, MYCALENDARTYPE_MONTH, $date), $month_image, translate('Month View'));	
	echo '</td></tr></table><p align="center">';
	$link->doLink(sprintf($link_string, $current_view, date('m-d-Y')), translate('[today]'));
	echo '</p>';
}

/**
* Prints all reservations for a given day
* @param array $reservations array of all reservation data for this day
* @param int $datestamp the unix datestamp for the first day shown
* @param int $days number of days to print out
* @param bool $is_private if we are in privacy mode and should hide user details
*/
function print_day_reservations($reservations, $datestamp, $days, $show_owner_icon = true, $is_private = false) {
	echo "<table border=\"0\" width=\"100%\" cellspacing=\"0\" cellpadding=\"0\"><tr><td class=\"tableBorder\">\n<table border=\"0\" width=\"100%\" cellspacing=\"1\" cellpadding=\"0\">\n";
	$date_vars = getdate($datestamp);
	$hour_line = array();
	$col_width = intval(100/($days));
	
	for ($i = 0; $i < count($reservations); $i++) {	
		$date = $reservations[$i]['start_date'];
		$day = ($date >= $datestamp) ? round((($date - $datestamp)/SECONDS_IN_DAY)) : 0;						// This will tell how many days ahead of the first day this reservation occurs
		
		// If the reservation starts on a day other than the first day shown then just show it at midnight of the first day
		$start_hour = ($date >= $datestamp) ? Time::getAdjustedHour( ( $reservations[$i]['starttime'] - ($reservations[$i]['starttime']%60) )/60 ) : 0;		// This trims off any minutes and just gets the whole hour
		$hour_line[$start_hour][$day][] = &$reservations[$i];		
		
		if ($reservations[$i]['start_date'] != $reservations[$i]['end_date']) {
			// This makes sure that the reservation appears on every day that it is part of
			$start_date = $reservations[$i]['start_date'] < $datestamp ? $datestamp : $reservations[$i]['start_date'];
			$day_diff = ($reservations[$i]['end_date'] - $start_date)/SECONDS_IN_DAY;
			
			for ($d = 1; $d <= $day_diff && $d < $days; $d++) {
				$hour_line[0][$day + $d][] = &$reservations[$i];
			}
		}
	}
	
	$datestamps = array();		// This will store the datestamp for each date on the calendar
	// Print out a date header for each date in the calendar view
	echo '<tr><td class="scheduleDateHeader">&nbsp;</td>';
	for ($day_count = 0; $day_count < $days; $day_count++) {
		$datestamps[$day_count] = mktime(0,0,0, $date_vars['mon'], $date_vars['mday'] + $day_count, $date_vars['year']);
		echo '<td width="' . $col_width . '%" class="scheduleDateHeader"><a href="schedule.php?date=' . sprintf('%d-%d-%d', $date_vars['mon'], $date_vars['mday'], $date_vars['year']) . '">' . translate_date('schedule_daily', $datestamps[$day_count]) . '</a></td>';
	}
	echo "</tr>\n";
	
	// The reservation data is stored in a 2D array of time (x axis) and date (y axis)
	// This simply loops through all time/date possibilities and prints out the reservation data for each cell
	for ($time = 0; $time < 24; $time++) {
		echo '<tr><td valign="top" class="resourceName">' . Time::formatTime($time*60, false) . '</td>';
		for ($date = 0; $date < $days; $date++) {
			echo '<td valign="top" class="MyCalCellColor">';
			if (isset($hour_line[$time][$date])) {
				for ($res_count = 0; $res_count < count($hour_line[$time][$date]); $res_count++) {
					$res = $hour_line[$time][$date][$res_count];
					
					if ($is_private) {
						$res['fname'] = 'Private';
						$res['lname'] = '';
					}
				
					$js = "onmouseover=\"showsummary('details', event, '" . build_reservation_detail_div($res) . "');\" onmouseout=\"hideSummary('details');\" onmousemove=\"moveSummary('details', event);\"";	
						
					echo "<p>&#8226; <a $js href=\"javascript:reserve('" . RES_TYPE_MODIFY. "','','','{$res['resid']}','{$res['scheduleid']}');\">" . Time::formatTime($res['starttime']) . (($res['start_date'] < $datestamps[$date]) ? ' [' . translate_date('general_date', $res['start_date']) . ']' : '') . ' - '  . Time::formatTime($res['endtime']) . (($res['end_date'] > $datestamps[$date]) ? ' [' . translate_date('general_date', $res['end_date']) . ']' : '') . ' ' . $res['name'] . '</a>';
					if ($show_owner_icon) {
						echo ($res['owner'] == 1) ? ' <img src="img/owner.gif" alt="' . translate('Owner') . '" title="' . translate('Owner') . '"/>' : ' <img src="img/participant.gif" alt="' . translate('Participant') . '" title="' . translate('Participant') . '"/>';
					}
					if (isset($res['parentid'])) echo ' <img src="img/recurring.gif" width="15" height="15" alt="' . translate('Recurring') . '" title="' . translate('Recurring') . '"/>';
					if ($res['start_date'] != $res['end_date']) echo ' <img src="img/multiday.gif" width="8" height="9" alt="' . translate('Multiple Day') . '" title="' . translate('Multiple Day') . '"/>';
					echo "</p>\n";
				}				
			}
			else {
				echo '&nbsp;';	// There is no reservation for this time, print out an empty cell
			}
			echo '</td>';		// End the time/date cell
		}
		echo "</tr>\n";			// End the time row
	}	
	echo "</table>\n</td></tr><table>\n";
}

/**
* Prints all reservations for a given day
* @param array $reservations array of all reservation data for this day
* @param int $datestamp the unix datestamp for the first day shown
* @param array $fields fields of the reservation to print after the times appear
* @param bool $ownerParticipantImage whether to show the owner/participant images
* @param bool $is_private if we are in privacy mode and should hide user details
*/
function print_month_reservations($reservations, $datestamp, $fields = array('name'), $ownerParticipantImage = true, $is_private = false) {
	global $conf;
	global $days_full;
	
	$today = getdate(mktime());
	$date_vars = explode(' ',date('d m Y t w W', $datestamp));
	$last_month_num_days = date('t', mktime(0,0,0, $date_vars[1]-1, $date_vars[0], $date_vars[2]));		// Number of days in the last month
	$week_start = $conf['app']['calFirstDay'];
	$firstWeekDay = (7 + (date('w', $datestamp) - $week_start)) % 7;
	
	// Put all reservations in a new array stored by date
	$reservations_by_date = array();
	
	for ($i = 0; $i < count($reservations); $i++) {
		$start_date = $reservations[$i]['start_date'];
		if ($reservations[$i]['start_date'] != $reservations[$i]['end_date']) {
			// This makes sure that the reservation appears on every day that it is part of
			list($month, $day, $year) = split(' ', date('m j Y', $reservations[$i]['start_date']));
			$day_diff = ($reservations[$i]['end_date'] - $reservations[$i]['start_date'])/86400;
			for ($d = 0; $d <= $day_diff; $d++) {
				$date = mktime(0,0,0, $month, $day + $d, $year);
				$reservations_by_date[$date][] = &$reservations[$i];
			}
		}
		else {
			$date = $reservations[$i]['start_date'];
			$reservations_by_date[$date][] = &$reservations[$i];
		}
	}

	echo "<table border=\"0\" cellspacing=\"0\" cellpadding=\"0\" align=\"center\"><tr><td class=\"tableBorder\">\n<table border=\"0\" width=\"100%\" cellspacing=\"1\" cellpadding=\"0\"><tr>\n";
	for ($day = $week_start; $day < $week_start + 7; $day++) {
		echo '<td class="scheduleDateHeader">' . $days_full[$day%7] . '</td>';
	}
	echo '</tr>';
	
	$day = $week_start;		// Initialize day	
	$printRow = false;		// Initialize printRow
	
	// Print out days for all weeks
	for ($currentDay = -$firstWeekDay; $currentDay < $date_vars[3]; /* No change needed */ ) {
		echo "<tr>\n";
		
		// Print out each day of this week
		for ( /* Day already set */ ; $day < $week_start + 7; $day++) {
			// If there are still more days to print, do it
			++$currentDay;
			$actualCurrentDay = $currentDay;
			$actualCurrentMonth = $date_vars['1'];
			$actualCurrentYear = $date_vars['2'];
			if ($currentDay == $today['mday'] && $date_vars[1] == $today['mon'] && $date_vars[2] == $today['year']) {
				$class = 'MyCalCurrentDayBox';
			}
			elseif (($currentDay <= 0) or ($currentDay > $date_vars['3'])) {
				$class = 'MyCalEmptyDayBox';
				$actualCurrentDay = date('j',mktime(0,0,0,$date_vars['1'],$currentDay,$date_vars['2']));
				$actualCurrentMonth = date('m',mktime(0,0,0,$date_vars['1'],$currentDay,$date_vars['2']));
				$actualCurrentYear = date('Y',mktime(0,0,0,$date_vars['1'],$currentDay,$date_vars['2']));
			}
			else {
				$class = 'MyCalDayBox';
			}
			echo "<td class=\"$class\"><p align=\"right\"><a class=\"MyCalDateNumber\" href=\"schedule.php?date={$actualCurrentMonth}-$actualCurrentDay-{$actualCurrentYear}\">$actualCurrentDay</a></p>\n";
			$currentDate = mktime(0,0,0,$date_vars['1'], $currentDay, $date_vars['2']);
			if (isset($reservations_by_date[$currentDate])) {
				for ($resCount = 0; $resCount < count($reservations_by_date[$currentDate]); $resCount++) {
					$res = $reservations_by_date[$currentDate][$resCount];
					
					if ($is_private) {
						$res['fname'] = 'Private';
						$res['lname'] = '';
					}
					
					$js = "onmouseover=\"showsummary('details', event, '" . build_reservation_detail_div($res) . "');\" onmouseout=\"hideSummary('details');\" onmousemove=\"moveSummary('details', event);\"";	
					
					echo "<p align=\"left\">&#8226; <a $js href=\"javascript:reserve('" . RES_TYPE_MODIFY. "','','','{$res['resid']}','{$res['scheduleid']}');\">" . Time::formatTime($res['starttime']) . (($res['start_date'] < $currentDate) ? ' [' . translate_date('general_date', $res['start_date']) . ']' : '') . ' - '  . Time::formatTime($res['endtime']) . (($res['end_date'] > $currentDate) ? ' [' . translate_date('general_date', $res['end_date']) . ']' : '');
					foreach ($fields as $field) {
						echo ' ' . $res[$field];
					}
					echo '</a>';
					if ($ownerParticipantImage) {
						echo ($res['owner'] == 1) ? ' <img src="img/owner.gif" alt="' . translate('Owner') . '" title="' . translate('Owner') . '"/>' : ' <img src="img/participant.gif" alt="' . translate('Participant') . '" title="' . translate('Participant') . '"/>';
					}
					if (isset($res['parentid'])) echo ' <img src="img/recurring.gif" width="15" height="15" alt="' . translate('Recurring') . '" title="' . translate('Recurring') . '"/>';
					if ($res['start_date'] != $res['end_date']) echo ' <img src="img/multiday.gif" width="8" height="9" alt="' . translate('Multiple Day') . '" title="' . translate('Multiple Day') . '"/>';
					echo "</p>\n";
				}
			}
			echo "</td>\n";
		}

		// Reset day counter
		$day = $week_start;
		echo "</tr>\n";
	}

	echo "</table>\n</td></tr></table>\n";	
}

/**
* Writes out a div to be used for reservation summary mouseovers
* @param none
*/
function print_details_div() {
?>
<div id="details" class="mycal_div" style="width: 200px;"></div>
<?php
}

/**
* Builds the reservation details div and makes sure it is clean data
* @param array $res array of resrevation data
* @return formatted HTML string for the content of the div
*/
function build_reservation_detail_div($res) {
	$html = '';
	$html .= translate_date('general_date', $res['start_date']) . ' ' . Time::formatTime($res['starttime']) . ' -<br/>';
	$html .= translate_date('general_date', $res['end_date']) . ' ' . Time::formatTime($res['endtime']) . '<br/><br/>'; 
	$html .= $res['name'] . ' @ ' .  $res['location'] . '<br/>';
	$html .= $res['fname'] . ' ' . $res['lname'] . '<br/>';
	if (!empty($res['summary'])) {
		$html .= '<br/><br/><i>' . preg_replace("/[\n\r]+/", '<br/>', addslashes($res['summary'])) . '</i>';
	}
	return $html;
}
?>