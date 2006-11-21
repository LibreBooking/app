<?php
/**
* Calendar navigator window
*
* This is a calendar applicaion that simply
* provides a visual way for users to choose
* a day to jump to on the scheduler app
* It prints out a XHTML 1.1 standard calendar
*
* The calendar should be opened using a javascript
* window.open() function.  The recommended syntax would be:
* window.open('calendar_opening_file.php','calendar','width=###,height=###,scrollbars=no,location=no,menubar=no,toolbar=no,resizable=yes');
* subbing actual calendar opener filename and width/height size
* Note: void(0); is needed after the window.open() function if used in a link
* Ex) <a href="javascript: window.open('cal_test.php','calendar','width=280,height=280,scrollbars=no,location=no,menubar=no,toolbar=no'); void(0);">Link to open calendar</a>
*
* Extend the class and override any functions to add/change functionality
*
* @author Nick Korbel <lqqkout13@users.sourceforge.net>
* @version 08-08-06
* @package Calendar
*
* Copyright (C) 2003 - 2006 phpScheduleIt
* License: GPL, see LICENSE
*/
class Calendar {

	var $isPopup = true;
	var $day;
	var $month;
	var $year;
	var $monthName;
	var $daysInMonth;
	var $weekstart;
	var $scheduleid = '';

	var $javascript = "changeScheduler(%d,%d,%d,%d,'%s');";

    /**
    * Create a new Calendar object with default values
    *
    * This will create a new Calendar using default
    * colors, font sizes, and other attributes
    * @param none
    */
    function Calendar($isPopup = true, $month = null, $year = null, $weekstart = null) {
		//$this->setupStyleRules();
		global $months_full;
		global $conf;

		$this->isPopup = $isPopup;
		$this->weekstart = (!is_null($weekstart)) ? $weekstart : $conf['app']['calFirstDay'];
		$this->day = 1;

		if ($this->isPopup) {
			if (isset($_POST['month']) && isset($_POST['year'])) {
				$month = $_POST['month'];
				$year = $_POST['year'];
				$this->scheduleid = $_POST['scheduleid'];
			}
			else {
				$month = date('m');
			}
		}

		// Go forward or back a year if needed
		if ($month !== null && $year !== null) {
			if ($month < 1) {
				$month = 12;
				$year = $year - 1;
			}
			if ($month > 12) {
				$month = 1;
				$year = $year + 1;
			}
		}
		else  {
			$month = date('m');
			$year = date('Y');
		}

		$dateTS = mktime(0,0,0,$month,1,$year);

		$this->month = $month;
		$this->year = $year;

        // Number value of the first day of the week of the month
        $this->firstWeekDay = (7 + (date('w', $dateTS) - $this->weekstart)) % 7;

        // Number of days in this month
        $this->daysInMonth = date('t', $dateTS);
        // String name of this month
        $this->monthName = $months_full[date('n', $dateTS)-1];
    }

	function setupStyleRules() {

	}

    /**
    * Print the actual calendar and jump functions
    *
    * This function prints out the calendar and calls all
    * the associated functions to print the calendar,
    * links and forms used to jump to a new month
    *
    * (This is the only function that needs to be called
    * after a Calendar has been created)
    * @param none
    */
    function printCalendar() {
		$today = getdate(Time::getAdjustedTime(mktime()));

		$this->printCalendarBody($today);

		if ($this->isPopup) {
			$this->printJumpForm();
		}
    }

	/**
	* Prints the calendar body
	* @param int $today timestamp for todays date
	*/
	function printCalendarBody($today) {
		global $days_letter;
		$days = $days_letter;//array ('S', 'M', 'T', 'W', 'T', 'F', 'S');
	    ?>
        <table border="0" cellspacing="0" cellpadding="0">
          <tr>
            <td class="borderColor">
        	  <table border="0" cellspacing="1" cellpadding="0">
			  	<tr><td colspan="7" class="monthNameStyle"><?php echo $this->monthName . ' ' . $this->year ?></td></tr>
        		<tr class="dayNamesStyle">
				 <?php
				 for ($i = $this->weekstart; $i < $this->weekstart + 7; $i++) {
					echo '<td>' . $days[$i%7] . '</td>';
				}
				?>
        		</tr>
        <?php
            // Move to first day of the month
            echo "<tr>";

			for ($day = 0; $day < $this->firstWeekDay; $day++)
                echo "<td class=\"emptyDayStyle\">&nbsp;</td>";

			// Initialize day
            //$day = $this->firstWeekDay + $this->weekstart;
			$day += $this->weekstart;

			// Initialize printRow
            $printRow = false;

            // Print out days for all weeks
            for ($currentDay = 0; $currentDay < $this->daysInMonth; /* No change needed */ ) {
                // See if we should start a new row
                // (will be for each time except first)
                if ($printRow) {
                    echo "<tr>";
                }
                $printRow = true;
                // Print out each day of this week
                for ( /* Day already set */ ; $day < $this->weekstart + 7; $day++) {
                    // If there are still more days to print, do it
                    if (++$currentDay <= $this->daysInMonth) {
						if ($currentDay == $today['mday'] && $this->month == $today['mon'] && $this->year == $today['year'])
							$class = 'currentDayBoxStyle';
						else
							$class = 'dayBoxStyle';
                        echo "<td class=\"$class\"><a href=\"javascript: " . sprintf($this->javascript, $this->month, $currentDay, $this->year, intval($this->isPopup), $this->scheduleid) . "\">" . ($currentDay) . "</a></td>";
                    }
					else {
                        // Else print out empty cells
                        for ( /* Day already set */ ; $day < $this->weekstart + 7; $day++)
                            echo "<td class=\"emptyDayStyle\">&nbsp;</td>";
                    }
                }

                // Reset day counter
                $day = $this->weekstart;
                echo "</tr>\n";
            }
        ?>
        	  </table>
            </td>
          </tr>
        </table>
		<?php
	}

	/**
	* Prints out the form to jump to the next day
	* @param none
	*/
	function printJumpForm() {
		global $months_full;
		?>
         <form id="changeMonth" name="changeMonth" action="<?php echo $_SERVER['PHP_SELF'] . '?' . $this->scheduleid ?>" method="post" style="margin-bottom: 0px;">
            <table width="100%" border="0" cellspacing="0" cellpadding="3">
        	  <tr align="center">
        <?php
        // Set values for prev/next month/year variables
        $nextMonth = $this->month+1;
        $nextYear = $prevYear = $this->year;

		$prevMonth = $this->month-1;
        ?>
        		<td style="width: 33%;" class="navMonthStyle"><a href="javascript: changeDate(<?php echo $prevMonth . ',' . $prevYear?>);"><?php echo "&lt; " . substr($months_full[date('n',mktime(0,0,0,$prevMonth,1,$prevYear))-1],0,3)  ?></a></td>
        		<td style="width: 33%">
        		  <select name="monthselect" onchange="document.forms[0].month.value=document.forms[0].monthselect.options[monthselect.selectedIndex].value; document.forms[0].submit();" class="selectBoxStyle">
        <?php
        for ($m = 1; $m < 13; $m++) {
            echo '<option value="' . $m . '"';
            if ($m == $this->month)
                echo ' selected="selected"';
            echo '>' . $months_full[date('n',mktime(0,0,0,$m,1))-1] . "</option>\n";
        }
        ?>
        		  </select>
        		  <input type="hidden" name="year" value="<?php echo $this->year ?>" />
				  <input type="hidden" name="month" value="<?php echo $this->month ?>" />
				  <input type="hidden" name="scheduleid" value="<?php echo $this->scheduleid?>" />
        		</td>
        		<td style="width: 33%;" class="navMonthStyle"><a href="javascript: changeDate(<?php echo $nextMonth . ',' . $nextYear?>);"><?php echo substr($months_full[date('n',mktime(0,0,0,$nextMonth,1,$nextYear))-1],0,3) . " &gt;" ?></a></td>
        	  </tr>
            </table>
          </form>
	<?php
	}


    /**
    * Sets the border color of the Calendar
    *
    * @param string $color HTML color
    */
    function setBorderColor($color) {
        $this->borderColor = $color;
    }

    /**
    * Sets the background color of the empty day cell of the Calendar
    *
    * @param string $color HTML color
    */
    function setEmptyDayBGColor($color) {
        $this->ed_bgcolor = $color;
    }

    /**
    * Sets the background color of the full day cell of the Calendar
    *
    * @param string $color HTML color
    */
    function setFullDayBGColor($color) {
        $this->fd_bgcolor = $color;
    }

    /**
    * Sets the cell box size of the Calendar
    * Min size = 20
    * Max size = 80
    *
    * @param int $size box size (in pixels)
    */
    function setBoxSize($size) {
        $size = intval($size);
        if ($size < 20)
            $size = 20;
        if ($size > 80)
            $size = 80;
        $this->boxSize = $size . 'px';
    }

    /**
    * Sets the color of the day links of the Calendar
    *
    * @param string $color HTML color
    */
    function setLinkColor($color) {
        $this->linkColor = $color;
    }

    /**
    * Sets the hover color of day links of the Calendar
    *
    * @param string $color HTML color
    */
    function setLinkHover($color) {
        $this->linkHover = $color;
    }

    /**
    * Sets the color month links of the Calendar
    *
    * @param string $color HTML color
    */
    function setMonthColor($color) {
        $this->monthColor = $color;
    }

    /**
    * Sets the hover color month links of the Calendar
    *
    * @param string $color HTML color
    */
    function setMonthHover($color) {
        $this->monthHover = $color;
    }

    /**
    * Sets the background color the month select of the Calendar
    *
    * @param string $color HTML color
    */
    function setSelectBGColor($color) {
        $this->select_bgcolor = $color;
    }

    /**
    * Sets the background color the month select of the Calendar
    *
    * @param int $size font size (in pixels)
    */
    function setSelectSize($size) {
        $this->selectSize = $size . 'px';
    }

    /**
    * Sets the text color the month select of the Calendar
    *
    * @param string $color HTML color
    */
    function setSelectTextColor($color) {
        $this->select_textcolor = $color;
    }

    /**
    * Sets the common font size of the Calendar
    *
    * @param int $size font size (in pixels)
    */
    function setTextSize($size) {
        $this->textSize = intval($size) . 'px';
    }
}
?>