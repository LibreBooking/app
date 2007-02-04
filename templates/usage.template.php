<?php
/**
* This file provides output functions and relies
*  on /db_query/usage_db.php for database access
* No data manipulation is done in this file
* @author Nick Korbel <lqqkout13@users.sourceforge.net>
* @author Attila <atoth@cmr.sote.hu>
* @version 05-04-06
* @package Templates
*
* Copyright (C) 2003 - 2006 phpScheduleIt
* License: GPL, see LICENSE
*/

/**
* Print out a form for searching.
* This function prints out a form for the administrator
*  to enter search criteria.  Start date will default
*  to first reservation's date, end date will default
*  to last reservation's date.  Start time will default
*  to $conf['app']['starttime'], end time will default to
*  $conf['app']['endtime'].
* @param array $min_max array of min and max reservation date values
* @param array $users array of user data
* @param array $machs array of resource data
* @global $conf
*/
function showForm($min_max, $users, $machs, $schedules) {
	global $conf;
	global $months_full;

    $startDay   = 0;
    $endDay     = 1440;
	$interval   = 30;

    // Set up array for month names
    $month  = $months_full;
    ?>
    <form name="searchForm" method="post" action="<?php echo $_SERVER['PHP_SELF']?>">
      <table width="100%" border="0" cellspacing="0" cellpadding="1" align="center">
		<tr>
		<td class="tableBorder">
		<table width="100%" border="0" cellspacing="1" cellpadding="0">
          <tr>
            <td colspan="2" class="tableTitle">&#8250; <?php echo translate('Select Search Criteria')?></td>
          </tr>
		  <tr class="cellColor">
            <td width="15%" class="formNames"><?php echo translate('Schedules')?></td>
            <td>
              <select name="scheduleid[]" size="4" multiple="multiple" class="textbox">
                <option selected="selected" value="all"><?php echo translate('All Schedules')?></option>
                <?php
                // Write out all users
                foreach ($schedules as $schedule)
                    echo '<option value="' . $schedule['scheduleid'] . '">' . $schedule['scheduletitle'] . "</option>\n";
				?>
              </select>
              <br /><?php echo translate('Hold CTRL to select multiple')?>
            </td>
          </tr>
          <tr class="cellColor">
            <td width="15%" class="formNames"><?php echo translate('Users')?></td>
            <td>
              <select name="memberid[]" size="4" multiple="multiple" class="textbox">
                <option selected="selected" value="all"><?php echo translate('All Users')?></option>
                <?php
                // Write out all users
                foreach ($users as $user)
                    echo '<option value="' . $user['memberid'] . '">' . $user['lname'] . ', ' . $user['fname'] . "</option>\n";
				?>
              </select>
              <br /><?php echo translate('Hold CTRL to select multiple')?>
            </td>
          </tr>
          <tr class="cellColor">
            <td class="formNames"><?php echo translate('Resources')?>:</td>
            <td>
              <select name="machid[]" size="4" multiple="multiple" class="textbox">
			    <option selected="selected" value="all"><?php echo translate('All Resources')?></option>
                <?php
                // Write out all resources
                foreach ($machs as $mach)
                    echo '<option value="'. $mach['machid'] . '">' . $mach['name'] . "</option>\n";
				?>
              </select>
              <br /><?php echo translate('Hold CTRL to select multiple')?>
            </td>
          </tr>
          <tr class="cellColor">
            <td class="formNames"><?php echo translate('Starting Date')?></td>
            <td>
			  <?php echo translate('Minimum')?>
              <select name="startMonthMin" class="textbox">
              <?php

              for ($i = 1; $i < 13; $i++) {
                echo "<option value=\"$i\"";
                if ($i == $min_max['startmin']['mon'])
                    echo ' selected="selected"';
                echo '>' . $month[$i-1] . "</option>\n";
              }
              ?>
              </select>
              <select name="startDayMin" class="textbox">
              <?php
              for ($i = 1; $i < 32; $i++) {
                echo "<option value=\"$i\"";
                if ($i == $min_max['startmin']['day'])
                    echo ' selected="selected"';
                echo ">$i</option>\n";
              }
              ?>
              </select>
              ,
              <select name="startYearMin" class="textbox">
              <?php
              for ($i = $min_max['startmin']['year']; $i < $min_max['startmax']['year']+1; $i++) {
                echo "<option value=\"$i\"";
                if ($i == $min_max['startmin']['year'])
                    echo ' selected="selected"';
                echo ">$i</option>\n";
              }
              ?>
              </select>
			  <span style="width:30px;">&nbsp;</span>
			  <?php echo translate('Maximum')?>
              <select name="startMonthMax" class="textbox">
              <?php

              for ($i = 1; $i < 13; $i++) {
                echo "<option value=\"$i\"";
                if ($i == $min_max['startmax']['mon'])
                    echo ' selected="selected"';
                echo '>' . $month[$i-1] . "</option>\n";
              }
              ?>
              </select>
              <select name="startDayMax" class="textbox">
              <?php
              for ($i = 1; $i < 32; $i++) {
                echo "<option value=\"$i\"";
                if ($i == $min_max['startmax']['day'])
                    echo ' selected="selected"';
                echo ">$i</option>\n";
              }
              ?>
              </select>
              ,
              <select name="startYearMax" class="textbox">
              <?php
              for ($i = $min_max['startmin']['year']; $i < $min_max['startmax']['year']+1; $i++) {
                echo "<option value=\"$i\"";
                if ($i == $min_max['startmax']['year'])
                    echo ' selected="selected"';
                echo ">$i</option>\n";
              }
              ?>
              </select>
            </td>
          </tr>
          <tr class="cellColor">
            <td class="formNames"><?php echo translate('Ending Date')?></td>
            <td>
			  <?php echo translate('Minimum')?>
              <select name="endMonthMin" class="textbox">
              <?php
              for ($i = 0; $i < 12; $i++) {
                echo '<option value="' . ($i+1) . '"';
                if ( ($i+1) == $min_max['endmin']['mon'])
                    echo ' selected="selected"';
                echo ">{$month[$i]}</option>\n";
              }
              ?>
              </select>
              <select name="endDayMin" class="textbox">
              <?php
              for ($i = 1; $i < 32; $i++) {
                echo "<option value=\"$i\"";
                if ( ($i) == $min_max['endmin']['day'])
                    echo ' selected="selected"';
                echo ">$i</option>\n";
              }
              ?>
              </select>
              ,
              <select name="endYearMin" class="textbox">
              <?php
              for ($i = $min_max['endmin']['year']; $i < $min_max['endmax']['year']+1; $i++) {
                echo "<option value=\"$i\"";
                if ( ($i) == $min_max['endmin']['year'])
                    echo ' selected="selected"';
                echo ">$i</option>\n";
              }
              ?>
              </select>
			  <span style="width:30px;">&nbsp;</span>
			  <?php echo translate('Maximum')?>
              <select name="endMonthMax" class="textbox">
              <?php
              for ($i = 0; $i < 12; $i++) {
                echo '<option value="' . ($i+1) . '"';
                if ( ($i+1) == $min_max['endmax']['mon'])
                    echo ' selected="selected"';
                echo ">{$month[$i]}</option>\n";
              }
              ?>
              </select>
              <select name="endDayMax" class="textbox">
              <?php
              for ($i = 1; $i < 32; $i++) {
                echo "<option value=\"$i\"";
                if ( ($i) == $min_max['endmax']['day'])
                    echo ' selected="selected"';
                echo ">$i</option>\n";
              }
              ?>
              </select>
              ,
              <select name="endYearMax" class="textbox">
              <?php
              for ($i = $min_max['endmin']['year']; $i < $min_max['endmax']['year']+1; $i++) {
                echo "<option value=\"$i\"";
                if ( ($i) == $min_max['endmax']['year'])
                    echo ' selected="selected"';
                echo ">$i</option>\n";
              }
              ?>
              </select>
            </td>
          </tr>
          <tr class="cellColor">
            <td class="formNames"><?php echo translate('Starting Time')?></td>
            <td>
			  <?php echo translate('Minimum')?>
              <select name="starttimeMin" class="textbox">
              <?php
              // Print out first time and select it
              echo "<option value=\"$startDay\" selected=\"selected\">" . Time::formatTime($startDay, false) . "</option>\n";
              // Print out rest of times
              for ($i = $startDay+$interval; $i < $endDay; $i+=$interval) {
                echo "<option value=\"$i\">" . Time::formatTime($i, false) . "</option>\n";
              }
              ?>
              </select>
			  <span style="width:30px;">&nbsp;</span>
			  <?php echo translate('Maximum')?>
              <select name="starttimeMax" class="textbox">
              <?php
              // Print out all times except last
              for ($i = $startDay+$interval; $i < $endDay; $i+=$interval) {
                echo "<option value=\"$i\">" . Time::formatTime($i, false) . "</option>\n";
              }
              // Print out last time and select it
              echo "<option value=\"$endDay\" selected=\"selected\">" . Time::formatTime($endDay, false) . "</option>\n";
              ?>
              </select>
            </td>
          </tr>
          <tr class="cellColor">
            <td class="formNames"><?php echo translate('Ending Time')?></td>
             <td>
			  <?php echo translate('Minimum')?>
              <select name="endtimeMin" class="textbox">
              <?php
              // Print out first time and select it
              echo "<option value=\"$startDay\" selected=\"selected\">" . Time::formatTime($startDay, false) . "</option>\n";
              // Print out rest of times
              for ($i = $startDay+$interval; $i < $endDay; $i+=$interval) {
                echo "<option value=\"$i\">" . Time::formatTime($i, false) . "</option>\n";
              }
              ?>
              </select>
			  <span style="width:30px;">&nbsp;</span>
			  <?php echo translate('Maximum')?>
              <select name="endtimeMax" class="textbox">
              <?php
              // Print out all times except last
              for ($i = $startDay+$interval; $i < $endDay; $i+=$interval) {
                echo "<option value=\"$i\">" . Time::formatTime($i, false) . "</option>\n";
              }
              // Print out last time and select it
              echo "<option value=\"$endDay\" selected=\"selected\">" . Time::formatTime($endDay, false) . "</option>\n";
              ?>
              </select>
            </td>
          </tr>
		  <tr class="cellColor">
			<td class="formNames"><?php echo translate('Summary')?>:</td>
			<td>
				<input type="radio" name="summarytype" value="anywhere" checked="checked" /><?php echo translate('Contains')?>
				<input type="radio" name="summarytype" value="beginning" /><?php echo translate('Begins with')?>
				<input type="text" name="summarysearch" class="textbox" />
			</td>
		</tr>
		  <tr class="cellColor">
		    <td class="formNames"><?php echo translate('Output Type')?></td>
			<td>
			<input type="radio" name="outputtype" value="html" checked="checked" /><?php echo translate('HTML')?>
			<input type="radio" name="outputtype" value="text" /><?php echo translate('Plain text')?>
			<input type="radio" name="outputtype" value="xml" /><?php echo translate('XML')?>
			<input type="radio" name="outputtype" value="csv" /><?php echo translate('CSV')?>
			</td>
		  </tr>
        </table>
 </td>
 </tr>
</table>
<p>&nbsp;</p>
  <input type="submit" name="search" value="<?php echo translate('Search')?>" class="button" />
  <input type="reset" name="Reset" value="<?php echo translate('Clear')?>" class="button" />
</form>
<?php
}



/**
* Prints out user name and PI name
* This function prints out links to view
* the user info or email their PI (if HTML)
* or just as text (if not HTML)
* @param string $fname user first name
* @param string $lname user last name
* @param int $memberid user memberID
* @param string $type output type
*/
function printUserInfo($fname, $lname, $memberid, $type) {
    global $link;

    switch ($type) {
		case 'html' :
    		echo '<h4 align="center">' . $link->getLink("javascript: viewUser('$memberid');", $fname . ' ' . $lname, '', '', translate('View information about', array($fname, $lname)));
			break;
		case 'text' :
			// Print to text output
			echo $GLOBALS['dblStr']
				. $fname . ' ' . $lname . "\n"
				. $GLOBALS['dblStr'] . "\n";
			break;
		case 'xml' :
			break;
		case 'csv' :
			break;
    }
}


/**
* Start a new table
* This functin starts a new result table in either
* text or HTML, printing out user name and resource name.
* @param string $fname user first name
* @param string $lname user last name
* @param string $name resource name
* @param string $type output type
* @param string $schedule name of schedule
*/
function printTableHeader($fname, $lname, $name, $type, $schedule) {
    if ($type == 'html') {
?>
    <table width="100%" border="0" cellspacing="0" cellpadding="1" align="center">
     <tr><td class="tableBorder">
      <table width="100%" border="0" cellspacing="1" cellpadding="0">
       <tr>
        <td colspan="8" class="tableTitle">
        <?php echo "$fname $lname - $name ($schedule)"?>
		</td></tr>
	   <tr class="rowHeaders" align="center">
        <td width="4%">#</td>
        <td width="9%"><?php echo translate('Start Date')?></td>
		<td width="9%"><?php echo translate('End Date')?></td>
        <td width="19%"><?php echo translate('Created')?></td>
        <td width="19%"><?php echo translate('Last Modified')?></td>
        <td width="10%"><?php echo translate('Start Time')?></td>
        <td width="10%"><?php echo translate('End Time')?></td>
        <td width="10%"><?php echo translate('Manage')?></td>
        <td width="10%"><?php echo translate('Total Time')?></td>
	   </tr>
<?php
	}
	else if ($type == 'text') {
			// Print to text output
			echo "$fname $lname - $name ($schedule)\n"
				. "#\t" . translate('Start Date') . "\t" . translate('End Date') . "\t" . translate('Created') . "\t\t\t\t" . translate('Last Modified'). "\t\t\t" . translate('Start Time') . "\t" . translate('End Time') . "\t" . translate('Total Time') . "\n";
	}
	// No implementation for xml or csv
}


/**
* Print out the header for a csv file
*/
function print_csv_header() {
	echo '"reservation id","member id","schedule title","first name","last name","resource name","start date","end date","created time","modified time","start time","end time","total reservation time"' . "\r\n";
}

/**
* Print table footer
* This function prints the closing row and tags
* (if HTML) or closing text (if not HTML).
* @param double $hours total user hours
* @param string $type output type
* @param double $percent percent of resource usage
*/
function printTableFooter($hours, $type, $percent) {
    $hours = Time::minutes_to_hours($hours);			// Format it nicely
	if ($type == 'html') {
    ?>
    <tr class="cellColor">
	<td colspan="9">
	<span style="font-weight: bold; margin-right: 15px;"><?php echo translate('Total hours')?> <?php echo $hours ?></span>
	<?php echo $percent . translate('% of total resource time')?></td>
    </tr>
   </table>
  </td>
 </tr>
</table>
<p>&nbsp;</p>
<?php
	}
	else if ($type == 'text') {
			// Print to text output
			echo $GLOBALS['sglStr']
				. translate('Total hours') . " $hours\n"
				. $percent . translate('% of total resource time') . "\n"
				. $GLOBALS['dblStr'] . "\n";
	}
	// No implementation for xml or csv
}

/**
* This function prints out the bulk of the reservation data for text and html output
*  and all of the data for xml and csv output types.
* This data is properly formatted for each output type
* @param string $type output type
* @param object $link Link object
* @param int $resNo reservation count number (not reservation id)
* @param string $start_date formatted reservation starting date string
* @param string $end_date formatted reservation ending date string
* @param string $created formatted reservation created datetime string
* @param string $modified formatted reservation modified datetime string
* @param string $starttime formatted reservation start time
* @param string $endtime formatted reservation end time
* @param float $totTime total reservation time
* @param string $resid reservation id
* @param string $fname user first name
* @param string $lname user last name
* @param string $name resource name
* @param string $memberid member id
* @param string $schedule schedule title
*/
function print_reservation_data($type, &$link, $resNo, $start_date, $end_date, $created, $modified, $starttime, $endtime, $totTime, $resid, $fname, $lname, $name, $memberid, $schedule) {
	global $conf;

	$totTime = Time::minutes_to_hours($totTime);
	switch ($type) {
			case 'html' :
				// Write out reservation info
				echo '<tr class="cellColor" align="center" style="font-weight: normal;">'
					. '<td>' . $resNo . "</td>\n"
					. '<td>' . $start_date . "</td>\n"
					. '<td>' . $end_date . "</td>\n"
					. '<td>' . $created . "</td>\n"
					. '<td>' . $modified . "</td>\n"
					. '<td>' . $starttime . "</td>\n"
					. '<td>' . $endtime . "</td>\n"
					. '<td>' . $link->getLink("javascript: reserve('m','','','" . $resid. "');", translate('Edit'), '', '', translate('Edit this reservation')) . "</td>\n"
					. '<td>' . $totTime . "</td>\n</tr>\n";
				break;
        	case 'text' :
					// Format modifed time so it tabs correctly
					if ($modified == translate('N/A')) {
						$modified = str_repeat('-', 23);
						if ($conf['app']['timeFormat'] != 24)
							$modified .= '-';
					}

					$extraTab = ($conf['app']['timeFormat'] == 24) ? "\t" : '';

					echo $resNo . "\t"
							. $start_date . "\t"
							. $end_date . "\t"
							. $created . "\t" . $extraTab
							. $modified . "\t" . $extraTab
							. $starttime . "\t\t"
							. $endtime . "\t\t"
							. $totTime . "\n";
					break;
			case 'xml' :
				echo "&lt;reservation id=\"$resid\"&gt;\r\n"
					. "\t&lt;memberid&gt;$memberid&lt;/memberid&gt;\r\n"
					. "\t&lt;scheduletitle&gt;$schedule&lt;/scheduletitle&gt;\r\n"
					. "\t&lt;fname&gt;$fname&lt;/fname&gt;\r\n"
					. "\t&lt;lname&gt;$lname&lt;/lname&gt;\r\n"
					. "\t&lt;resourcename&gt;$name&lt;/resourcename&gt;\r\n"
					. "\t&lt;start_date&gt;$start_date&lt;/start_date&gt;\r\n"
					. "\t&lt;end_date&gt;$end_date&lt;/end_date&gt;\r\n"
					. "\t&lt;created&gt;$created&lt;/created&gt;\r\n"
					. "\t&lt;modified&gt;$modified&lt;/modified&gt;\r\n"
					. "\t&lt;starttime&gt;$starttime&lt;/starttime&gt;\r\n"
					. "\t&lt;endtime&gt;$endtime&lt;/endtime&gt;\r\n"
					. "\t&lt;totTime&gt;$totTime&lt;/totTime&gt;\r\n"
					. "&lt;/reservation&gt;\r\n";
				break;
			case 'csv' :
				echo "\"$resid\","
					. "\"$memberid\","
					. '"' . addslashes($schedule) . '",'
					. '"' . addslashes($fname) . '",'
					. '"' . addslashes($lname) . '",'
					. '"' . addslashes($name) . '",'
					. "\"$start_date\","
					. "\"$end_date\","
					. "\"$created\","
					. "\"$modified\","
					. "\"$starttime\","
					. "\"$endtime\","
					. "\"$totTime\"\r\n";
				break;
        }
}

/**
* Print out a jump menu to show search results in a different output form
* @param array $form all form values submitted
*/
function print_change_output($form, $obj_name = '') {
	echo '<div style="text-align: center;"><form name="jump_output" method="post" action="' . $_SERVER['PHP_SELF'] . '" style="margin: 5px;">' . "\n";

	foreach ($form as $name => $val) {
		if ($name == 'outputtype')	// Dont print this out if it is 'outputtype'
			continue;

		if (is_array($val)) {		// If this object has many values, print them all out
			foreach ($val as $val2)
				echo '<input type="hidden" name="' . $name . '[]" value="' . $val2 . '" />' . "\n";
		}
		else {
			echo '<input type="hidden" name="' . $name . '" value="' . $val . '" />' . "\n";
		}
	}
	echo '<span style="font-size: 11px;">' . translate('View these results as') . ' </span><select name="outputtype" onchange="javascript: document.jump_output.submit();" class="textbox">'
		. '<option value="html"' . (($form['outputtype'] == 'html') ? ' selected="selected"' : '') . '>' . translate('HTML') . '</option>'
		. '<option value="text"' . (($form['outputtype'] == 'text') ? ' selected="selected"' : '') . '>' . translate('Plain text') . '</option>'
		. '<option value="xml"' . (($form['outputtype'] == 'xml') ? ' selected="selected"' : '') . '>' . translate('XML') . '</option>'
		. '<option value="csv"' . (($form['outputtype'] == 'csv') ? ' selected="selected"' : '') . '>' . translate('CSV') . '</option>'
		. '</select>';
	echo '</form></div>';

}

?>