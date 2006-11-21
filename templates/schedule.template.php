<?php
/**
* This file provides the output functions for
*  an interface for reserving resources,
*  viewing other reservations and modifying their own.
* @author Nick Korbel <lqqkout13@users.sourceforge.net>
* @author David Poole <David.Poole@fccc.edu>
* @author Richard Cantzler <rmcii@users.sourceforge.net>
* @version 04-06-06
* @package Templates
*
* Copyright (C) 2003 - 2006 phpScheduleIt
* License: GPL, see LICENSE
*/

// Get Link object
$link = CmnFns::getNewLink();

/**
* Print out week being viewed above schedule tables
* @param array $d array of date information about this schedule
* @param string $title title of schedule
*/
function print_date_span($d, $title) {
    // Print out current week being viewed
    echo '<h3 align="center">' . $title . '<br/>' . Time::formatDate($d['firstDayTs']) . ' - ' . Time::formatDate($d['lastDayTs']) . '</h3>';
}

/**
* Prints out a jump menu for the schedules
* @param array $links array of schedule links
*/
function print_schedule_list($links, $currentid) {
?>
<table width="100%" align="center" border="0" cellpadding="0" cellspacing="0" style="padding-bottom: 5px;">
<tr><td style="text-align: center; width: 50%;">
<p style="font-weight: bold; text-align: right;"><?php echo translate('View schedule')?></p>
</td>
<td align="left">
<select name="choose_schedule" class="textbox" onchange="javascript: changeSchedule(this);">
<?php
for ($i = 0; $i < count($links); $i++)
    echo '<option value="' . $links[$i]['scheduleid'] . '"' . ($links[$i]['scheduleid'] == $currentid ? ' selected="selected"' : '') . '>' . $links[$i]['scheduletitle'] . "</option>\n";
?>
</select>
</td></tr>
</table>
<?php
}

/**
* Print out a key to identify what the colors mean
* @param none
*/
function print_color_key() {
    global $conf;
?>
<table align="center" cellpadding="5" cellspacing="10">
  <tr style="font-size: 10px; font-weight: bold; text-align: center; vertical-align: center;">
    <td style="width: 75px; height: 38px; background-color:#<?php echo $conf['ui']['my_res'][0]['color']?>; border: 2px #000000 solid;"><?php echo translate('My Reservations')?></td>
    <td style="width: 75px; height: 38px; background-color:#<?php echo $conf['ui']['my_past_res'][0]['color']?>; border: 2px #000000 solid;"><?php echo translate('My Past Reservations')?></td>
    <td style="width: 75px; height: 38px; background-color:#<?php echo $conf['ui']['participant_res'][0]['color']?>; border: 2px #000000 solid;"><?php echo translate('My Participation')?></td>
    <td style="width: 75px; height: 38px; background-color:#<?php echo $conf['ui']['participant_past_res'][0]['color']?>; border: 2px #000000 solid; color: #CCCCCC;"><?php echo translate('My Past Participation')?></td>
	<td style="width: 75px; height: 38px; background-color:#<?php echo $conf['ui']['other_res'][0]['color']?>; border: 2px #000000 solid;"><?php echo translate('Other Reservations')?></td>
    <td style="width: 75px; height: 38px; background-color:#<?php echo $conf['ui']['other_past_res'][0]['color']?>; border: 2px #000000 solid;"><?php echo translate('Other Past Reservations')?></td>
	<td style="width: 75px; height: 38px; background-color:#<?php echo $conf['ui']['pending'][0]['color']?>; border: 2px #000000 solid;"><?php echo translate('Pending Approval')?></td>
	<td style="width: 75px; height: 38px; background-color:#<?php echo $conf['ui']['blackout'][0]['color']?>; border: 2px #000000 solid; color: #CCCCCC;"><?php echo translate('Blacked Out Time')?></td>
  </tr>
</table>
<?php
}


/**
* Start table for one day on schedule
* This function starts the table for each day
* on the schedule, printing out it's date
* and the time value cells
* @param string $displayDate date string to print
*/
function start_day_table($displayDate, $hour_header) {
?>
    <table width="100%" border="0" cellspacing="0" cellpadding="1">
     <tr class="tableBorder">
      <td>
       <table width="100%" border="0" cellspacing="1" cellpadding="0">
        <tr class="scheduleTimes">
         <td rowspan="2" width="15%" class="scheduleDate"><?php echo $displayDate ?></td>
<?php
    echo $hour_header ."</tr>\n";
}

/**
* Prints out the navigational calendars
* @param Calendar $prev previous month calendar
* @param Calendar $curr current month calendar
* @param Calendar $next next month calendar
*/
function print_calendars(&$prev, &$curr, &$next) {
?>
<table width="100%" border="0" cellpadding="0" cellspacing="0">
  <tr>
    <td align="center" valign="top"><?php $prev->printCalendar()?></td>
    <td align="center" valign="top"><?php $curr->printCalendar()?></td>
    <td align="center" valign="top"><?php $next->printCalendar()?></td>
  </tr>
</table>
<?php
}

/**
* Formats and returns the time header of the table (it is the same for every one)
* @param array $th array of time values and their rowspans
* @param int $startDay starting time of day
* @param int $endDay ending time of day
* @param int $timespan time intervals
* @global $conf
*/
function get_hour_header($th, $startDay, $endDay, $timespan) {
    global $conf;
    $header = '';

    // Write out the available times
    foreach ($th as $time => $cols) {
        $header .= "<td colspan=\"$cols\">$time</td>";
    }

    // Close row, start next
    $header .= "</tr>\n<tr class=\"scheduleTimes\">\n";

    // Compute total # of cols
    $totCol = intval(($endDay - $startDay) / $timespan);
    // Create the fraction hour minute marks
    for ($x = 0; $x < $totCol; $x++)
        $header .= '<td>&nbsp;</td>';

    return $header;
}


/**
* Close off table for each day
* This function simply prints out the HTML to close off
* the rows and tables for each day
* @param none
*/
function end_day_table() {
?>
    </table>
   </td>
  </tr>
</table>
<p>&nbsp;</p>
<?php
}


/**
* Prints out the cell containing all the resource information
* @param int $ts timestamp for the current day
* @param string $id id of this resource
* @param string $name name of this resource
* @param boolean $shown whether this resource can be reserved
* @param boolean $is_blackout whether this is a blackout schedule or not
* @param string $scheduleid id of the current schedule
* @param boolean $pending is reservation pending approval
* @param string $color background color of row
*/
function print_name_cell($ts, $id, $name, $shown, $is_blackout, $scheduleid, $pending = false, $color = '') {
    global $link;

    $color = (empty($color)) ? 'cellColor': $color;

    // Start a new row and print out resource name
    echo "<tr class=\"$color\">\n"
           . '<td class="resourceName">';

    if ($is_blackout) {
        $link->doLink("javascript: reserve('r', '$id','$ts', '', '$scheduleid', '1', '0', '$pending');", $name);
    }
    else {
        // If the user is allowed to make reservations on this resource
        // then provide a link
        // Else do not
        if ($shown)
            $link->doLink("javascript: reserve('r','$id','$ts','', '$scheduleid', '0', '$pending');", $name);
        else
            echo '<span class="inact">' . $name . '</span>';
    }
    // Close cell
    echo "</td>";
}

/**
* Prints out blank columns
* @param int $cols number of columns to print out
* @param int $start starting time of the first column printed out
* @param int $span time span of the schedule
* @param int $ts timestamp for the reservation start date
* @param string $machid id of the resource on this table row
* @param string $scheduleid id of the current schedule
* @param int $scheduleType type of the current schedule
* @param bool $clickable if this row can be clicked
* @param string $color class of column background
*/
function print_blank_cols($cols, $start, $span, $ts, $machid, $scheduleid, $scheduleType, $clickable, $class = '') {
    $is_blackout = intval($scheduleType == BLACKOUT_ONLY);

    $js = '';
    for ($i = 0; $i <= $cols; $i++) {
        if ($scheduleType != READ_ONLY && ($clickable || $is_blackout)) {
            $tstart = $start + ($i * $span);
            $tend = $tstart + $span;
            $js = "onmouseover=\"blankOver(this);\" onmouseout=\"blankOut(this, '$class');\" onclick=\"reserve('r','$machid','$ts','','$scheduleid',$is_blackout,'','',$tstart,$tend);\"";
        }
        echo "<td $js>&nbsp;</td>";
    }
}

/**
* Prints the closing tr tag
* @param none
*/
function print_closing_tr() {
    echo "</tr>\n";
}

/**
* Writes out the reservation cell
* @param int $colspan column span of this reservation
* @param string $color_select array identifier for which color to use
* @param string $mod_view indentifying character for javascript reserve function to mod or view reservation
* @param string $resid id of this reservation
* @param Summary $summary summary for this reservation
* @param string $viewable whether the user can click on this reservation and bring up a details box
* @param int $read_only whether this is a read only schedule
* @param boolean $pending is this reservation pending approval
*/
function write_reservation($colspan, $color_select, $mod_view, $resid, $summary = '', $viewable = false, $read_only = false, $pending = 0) {
    global $conf;

    $js = '';
    $color = '#' . $conf['ui'][$color_select][0]['color'];
    $hover = '#' . $conf['ui'][$color_select][0]['hover'];
    $text  = '#' . $conf['ui'][$color_select][0]['text'];
    $chars = ($colspan > 1) ? 4 * $colspan : 0;

    $read_only = intval($read_only);

    if ($viewable) {
        $js = "onclick=\"reserve('$mod_view','','','$resid','','0','$read_only','$pending');\" ";
        if ($summary->isVisible()) {
            $js .= "onmouseover=\"resOver(this, '$hover'); showsummary('summary', event, '" . preg_replace("/[\n\r]+/", '<br/>', addslashes($summary->toScheduleHover())) . "');\" onmouseout=\"resOut(this, '$color'); hideSummary('summary');\" onmousemove=\"moveSummary('summary', event);\"";
		}
        else {
            $js .="onmouseover=\"resOver(this, '$hover');\" onmouseout=\"resOut(this, '$color');\"";
		}
    }
    else {
        if ($summary->isVisible()) {
            $js = "onmouseover=\"showsummary('summary', event, '" . preg_replace("/[\n\r]+/", '<br/>', addslashes($summary->toScheduleHover())) . "');\" onmouseout=\"hideSummary('summary');\" onmousemove=\"moveSummary('summary', event);\"";
		}
    }

    $summary_text = $summary->toScheduleCell($chars);

    // Write reserved time cell
    echo "<td colspan=\"$colspan\" style=\"color: $text; background-color: $color;\" $js>$summary_text</td>";
}

/**
* Writes out the blackout cell
* @param int $colspan column span of the blackout
* @param bool $edit if the user can edit it
* @param string $blackoutid id of this blackout
* @param string $summary blackout summary text
* @param int $showsummary whether to show the summary or not
*/
function write_blackout($colspan, $viewable, $blackoutid, $summary = '', $showsummary = 0) {
    global $conf;
    $color = '#' . $conf['ui']['blackout'][0]['color'];
    $hover = '#' . $conf['ui']['blackout'][0]['hover'];
    $text  = '#' . $conf['ui']['blackout'][0]['text'];
    $chars = 4 * $colspan;
    $js = '';

    if ($viewable) {
        $js = "onclick=\"reserve('m','','','$blackoutid','','1');\" ";
        if ($showsummary && $summary != '')
            $js .= "onmouseover=\"resOver(this, '$hover'); showsummary('summary', event, '" . preg_replace("/[\n\r]+/", '<br/>', addslashes($summary)) . "');\" onmouseout=\"resOut(this, '$color'); hideSummary('summary');\" onmousemove=\"moveSummary('summary', event);\"";
        else
            $js .="onmouseover=\"resOver(this, '$hover');\" onmouseout=\"resOut(this, '$color');\"";
    }
    else {
        if ($showsummary != 0 && $summary != '')
            $js = "onmouseover=\"showsummary('summary', event, '" . preg_replace("/[\n\r]+/", '<br/>', addslashes($summary)) . "');\" onmouseout=\"hideSummary('summary');\" onmousemove=\"moveSummary('summary', event);\"";
    }

    if ($showsummary) {
        $summary_text = ($summary != '' && $colspan > 1) ? substr($summary, 0, $chars) . ((strlen($summary) > $chars) ? '...' : '') : '&nbsp;';
    }
    else
        $summary_text = '&nbsp;';

    echo "<td colspan=\"$colspan\" style=\"color: $text; background-color: $color;\" $js>$summary_text</td>\n";
}

/**
* Writes out a div to be used for reservation summary mouseovers
* @param none
*/
function print_summary_div() {
?>
<div id="summary" class="summary_div" style="width: 150px;"></div>
<?php
}

/**
* Print links to jump to new dates
* This function prints out the HTML links to allow
*  users to navigate back/forward one week.
* It also prints the form for users to jump to
*  any given week.
* @param int $_date timestamp of first day of week on schedule
* @param bool $printAllCols whether or not to print the 5 column jump
*/
function print_jump_links($_date, $viewdays, $printAllCols) {
    global $link;
    global $dates;

    if (isset($_GET['scheduleid']))
        $scheduleid = $_GET['scheduleid'];
    else
        $scheduleid = '';

    $scheduleid = 'scheduleid=' . $scheduleid;        // Make querystring part

    $date = getdate($_date);
    $m = $date['mon'];
    $d = $date['mday'];
    $y = $date['year'];
    $boxes = $dates['jumpbox'];

    // Write out the previous, today and next links and the form to jump to a date
?>

    <table width="100%" border="0" cellspacing="0" cellpadding="5" align="center">
     <tr>
      <td align="center"><h5><?php $link->doLink($_SERVER['PHP_SELF'] . '?date=' . date('m-d-Y',mktime(0,0,0,$m, $d - 7, $y)) . "&amp;$scheduleid", translate('Prev Week'), '', '', translate('Jump 1 week back')) ?></h5></td>
      <?php if ($printAllCols) { ?>
      <td align="center"><h5><?php $link->doLink($_SERVER['PHP_SELF'] . '?date=' . date('m-d-Y',mktime(0,0,0,$m, $d - $viewdays, $y)) . "&amp;$scheduleid", translate('Prev days', array($viewdays)), '', '', translate('Previous days', array($viewdays))) ?></h5></td>
      <?php } ?>
      <td align="center"><h5><?php $link->doLink($_SERVER['PHP_SELF'] . "?$scheduleid", translate('This Week'), '', '', translate('Jump to this week')) ?></h5></td>
      <?php if ($printAllCols) { ?>
      <td align="center"><h5><?php $link->doLink($_SERVER['PHP_SELF'] . '?date=' . date('m-d-Y',mktime(0,0,0,$m, $d + $viewdays, $y)) . "&amp;$scheduleid", translate('Next days', array($viewdays))) ?></h5></td>
      <?php } ?>
      <td align="center"><h5><?php $link->doLink($_SERVER['PHP_SELF'] . '?date=' . date('m-d-Y',mktime(0,0,0,$m, $d + 7, $y)) . "&amp;$scheduleid", translate('Next Week'), '', '', 'Jump 1 week ahead') ?></h5></td>
     </tr>
     <tr>
      <td align="center" colspan="<?php echo ($printAllCols) ? '5' : '3';?>">
      <div name="jumpWeek" id="jumpWeek">
         <?php
         $boxes = str_replace('%m', '<input type="text" name="jumpMonth" id="jumpMonth" value="' . translate('mm') . '" class="textbox" size="3" maxlength="2" onclick="this.value = \'\';" />', $boxes);
         $boxes = str_replace('%d', '<input type="text" name="jumpDay" id="jumpDay" value="' . translate('dd') . '" class="textbox" size="3" maxlength="2" onclick="this.value = \'\';" />', $boxes);
         $boxes = str_replace('%Y', '<input type="text" name="jumpYear" id="jumpYear" value="' . translate('yyyy') . '" class="textbox" size="5" maxlength="4" onclick="this.value = \'\';" />', $boxes);
         echo $boxes;
         ?>
         <input name="jumpForm" type="button" value="<?php echo translate('Jump To Date')?>" class="button" onclick="checkDate();"/>
       </div>
      </td>
     </tr>
    </table>
    <h5 align="center"><?php $link->doLink("javascript: window.open('popCalendar.php?$scheduleid','calendar','width=260,height=250,scrollbars=no,location=no,menubar=no,toolbar=no,resizable=yes'); void(0);", translate('View Monthly Calendar'), '', '', translate('Open up a navigational calendar'))?></h5>
<?php
}
?>