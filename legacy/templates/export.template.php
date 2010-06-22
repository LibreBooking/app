<?php
/**
* Provides ability to generate an iCalendar export file for a reservation or reservations within a date range
* @author Nick Korbel <lqqkout13@users.sourceforge.net>
* @version 04-24-06
* @package phpScheduleIt.iCalendar
*
* Copyright (C) 2003 - 2006 phpScheduleIt
* License: GPL, see LICENSE
*/

function print_export_table() {
?>
<table width="100%" cellspacing="0" cellpadding="0" border="0" style="margin-bottom:10px;">
	<tr>
		<td class="tableTitle">
		<?php echo translate('Select reservations to export') ?>
		</td>
	</tr>
</table>
<table style="background-color:#CCCCCC;" cellspacing="1">
	<tr class="cellColor">
		<td width="70" class="formNames" style="font-weight:bold;"><?php echo translate('Starting Date') ?></td>
		<td width="120">	
			<div id="div_start_date" style="float:left;" class="textbox"><?php echo Time::formatDate(mktime()) ?></div><a href="javascript:void(0);"><img src="img/calendar.gif" style="padding-left:10px;" border="0" id="img_start_date" alt="' <?php echo translate('Start'); ?>"/></a>
			<input type="hidden" id="hdn_start_date" name="start_date" value="<?php echo date('m' . INTERNAL_DATE_SEPERATOR . 'd' . INTERNAL_DATE_SEPERATOR . 'Y', mktime()); ?>"/>	
		</td>
		<td width="70" class="formNames" style="font-weight:bold;"><?php echo translate('Ending Date') ?></td>
		<td width="120">	
			<div id="div_end_date" style="float:left;" class="textbox"><?php echo Time::formatDate(mktime()) ?></div><a href="javascript:void(0);"><img src="img/calendar.gif" style="padding-left:10px;" border="0" id="img_end_date" alt="' <?php echo translate('End'); ?>" /></a>
			<input type="hidden" id="hdn_end_date" name="end_date" value="<?php echo date('m' . INTERNAL_DATE_SEPERATOR . 'd' . INTERNAL_DATE_SEPERATOR . 'Y', mktime()); ?>" />	
		</td>
		<td width="70" class="formNames" style="font-weight:bold;"><?php echo translate('Export Format') ?>:</td>
		<td width="120">
			<select name="type" id="type" class="textbox">
				<option value="ical">iCalendar</option>
				<option value="vcal">vCalendar</option>
			</select>
		</td>
	</tr>
	<tr class="cellColor">
		<td colspan="2"><?php echo translate('None')?> <input type="checkbox" name="nostart" id="nostart" value="nostart" onclick="blurDiv(this, 'div_start_date');" /></td>
		<td colspan="2"><?php echo translate('None')?> <input type="checkbox" name="noend" id="noend" value="noend" onclick="blurDiv(this, 'div_end_date');" /></td>
		<td colspan="2">&nbsp;</td>
	</tr>
	<tr class="cellColor">
		<td colspan="6" align="right">
			<input type="button" value="<?php echo translate('Export'); ?>" class="button" onclick="exportSearch();" />
		</td>
	</tr>
</table>
<?php
}



/**
* Prints out the javascript necessary to set up the calendars for choosing recurring dates, start/end dates
* @param Reservation $res reservation to populate the calendar dates with
*/
function print_jscalendar_setup() {
	global $dates;
?>
<script type="text/javascript">
var now = new Date();

// Start date calendar
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
</script>
<?php
}
?>