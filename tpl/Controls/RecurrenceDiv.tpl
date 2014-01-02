{*
Copyright 2012-2014 Nick Korbel

This file is part of Booked Scheduler.

Booked Scheduler is free software: you can redistribute it and/or modify
it under the terms of the GNU General Public License as published by
the Free Software Foundation, either version 3 of the License, or
(at your option) any later version.

Booked Scheduler is distributed in the hope that it will be useful,
but WITHOUT ANY WARRANTY; without even the implied warranty of
MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
GNU General Public License for more details.

You should have received a copy of the GNU General Public License
along with Booked Scheduler.  If not, see <http://www.gnu.org/licenses/>.
*}
<div id="{$prefix}repeatDiv">
	<label>{translate key="RepeatPrompt"}</label>
	<select id="{$prefix}repeatOptions" {formname key=repeat_options} class="pulldown input" style="width:250px">
	{foreach from=$RepeatOptions key=k item=v}
		<option value="{$k}">{translate key=$v['key']}</option>
	{/foreach}
	</select>

	<div id="{$prefix}repeatEveryDiv" style="display:none;" class="days weeks months years">
		<label>{translate key="RepeatEveryPrompt"}</label>
		<select id="{$prefix}repeatInterval" {formname key=repeat_every} class="pulldown input" style="width:55px">
		{html_options values=$RepeatEveryOptions output=$RepeatEveryOptions}
		</select>
		<span class="days">{translate key=$RepeatOptions['daily']['everyKey']}</span>
		<span class="weeks">{translate key=$RepeatOptions['weekly']['everyKey']}</span>
		<span class="months">{translate key=$RepeatOptions['monthly']['everyKey']}</span>
		<span class="years">{translate key=$RepeatOptions['yearly']['everyKey']}</span>
	</div>
	<div id="{$prefix}repeatOnWeeklyDiv" style="display:none;" class="weeks">
		<label>{translate key="RepeatDaysPrompt"}</label>
		<input type="checkbox"
			   id="{$prefix}repeatDay0" {formname key=repeat_sunday} /><label
			for="repeatDay0">{translate key="DaySundayAbbr"}</label>
		<input type="checkbox"
			   id="{$prefix}repeatDay1" {formname key=repeat_monday} /><label
			for="repeatDay1">{translate key="DayMondayAbbr"}</label>
		<input type="checkbox"
			   id="{$prefix}repeatDay2" {formname key=repeat_tuesday} /><label
			for="repeatDay2">{translate key="DayTuesdayAbbr"}</label>
		<input type="checkbox"
			   id="{$prefix}repeatDay3" {formname key=repeat_wednesday} /><label
			for="repeatDay3">{translate key="DayWednesdayAbbr"}</label>
		<input type="checkbox"
			   id="{$prefix}repeatDay4" {formname key=repeat_thursday} /><label
			for="repeatDay4">{translate key="DayThursdayAbbr"}</label>
		<input type="checkbox"
			   id="{$prefix}repeatDay5" {formname key=repeat_friday} /><label
			for="repeatDay5">{translate key="DayFridayAbbr"}</label>
		<input type="checkbox"
			   id="{$prefix}repeatDay6" {formname key=repeat_saturday} /><label
			for="repeatDay6">{translate key="DaySaturdayAbbr"}</label>
	</div>
	<div id="repeatOnMonthlyDiv" style="display:none;" class="months">
		<input type="radio" {formname key=REPEAT_MONTHLY_TYPE} value="{RepeatMonthlyType::DayOfMonth}"
			   id="{$prefix}repeatMonthDay" checked="checked"/>
		<label for="repeatMonthDay">{translate key="repeatDayOfMonth"}</label>
		<input type="radio" {formname key=REPEAT_MONTHLY_TYPE} value="{RepeatMonthlyType::DayOfWeek}"
			   id="{$prefix}repeatMonthWeek"/>
		<label for="repeatMonthWeek">{translate key="repeatDayOfWeek"}</label>
	</div>
	<div id="{$prefix}repeatUntilDiv" style="display:none;">
		<label for="formattedEndRepeat">{translate key="RepeatUntilPrompt"}</label>
		<input type="text" id="{$prefix}EndRepeat" class="dateinput" value="{formatdate date=$RepeatTerminationDate}"/>
		<input type="hidden" id="{$prefix}formattedEndRepeat" {formname key=end_repeat_date}
			   value="{formatdate date=$RepeatTerminationDate key=system}"/>
	</div>
</div>