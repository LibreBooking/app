{*
Copyright 2012-2019 Nick Korbel

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
<div id="{$prefix}repeatDiv" class="repeat-div">
	<div class="form-group">
		<div class="col-xs-12">
			<label for="{$prefix}repeatOptions">{translate key="RepeatPrompt"}</label>
			<select id="{$prefix}repeatOptions" {formname key=repeat_options}
					class="form-control input-sm repeat-drop inline-block">
				{foreach from=$RepeatOptions key=k item=v}
					<option value="{$k}">{translate key=$v['key']}</option>
				{/foreach}
			</select>
		</div>

		<div class="col-sm-4 col-xs-12">
			<div id="{$prefix}repeatEveryDiv" class="recur-toggle no-show days weeks months years">
				<label for="{$prefix}repeatInterval">{translate key="RepeatEveryPrompt"}</label>
				<select id="{$prefix}repeatInterval" {formname key=repeat_every}
						class="form-control input-sm repeat-interval-drop inline-block">
					{html_options values=$RepeatEveryOptions output=$RepeatEveryOptions}
				</select>
				<span class="days">{translate key=$RepeatOptions['daily']['everyKey']}</span>
				<span class="weeks">{translate key=$RepeatOptions['weekly']['everyKey']}</span>
				<span class="months">{translate key=$RepeatOptions['monthly']['everyKey']}</span>
				<span class="years">{translate key=$RepeatOptions['yearly']['everyKey']}</span>
			</div>
		</div>

		<div class="col-sm-8 col-xs-12">
			<div id="{$prefix}repeatOnWeeklyDiv" class="recur-toggle weeks no-show">
				<div class="btn-group" data-toggle="buttons">
					<label class="btn btn-default btn-sm">
						<input type="checkbox" id="{$prefix}repeatDay0" {formname key=repeat_sunday} />
						{translate key="DaySundayAbbr"}
					</label>
					<label class="btn btn-default btn-sm">
						<input type="checkbox" id="{$prefix}repeatDay1" {formname key=repeat_monday} />
						{translate key="DayMondayAbbr"}
					</label>
					<label class="btn btn-default btn-sm">
						<input type="checkbox" id="{$prefix}repeatDay2" {formname key=repeat_tuesday} />
						{translate key="DayTuesdayAbbr"}
					</label>
					<label class="btn btn-default btn-sm">
						<input type="checkbox" id="{$prefix}repeatDay3" {formname key=repeat_wednesday} />
						{translate key="DayWednesdayAbbr"}
					</label>
					<label class="btn btn-default btn-sm">
						<input type="checkbox" id="{$prefix}repeatDay4" {formname key=repeat_thursday} />
						{translate key="DayThursdayAbbr"}
					</label>
					<label class="btn btn-default btn-sm">
						<input type="checkbox" id="{$prefix}repeatDay5" {formname key=repeat_friday} />
						{translate key="DayFridayAbbr"}
					</label>
					<label class="btn btn-default btn-sm">
						<input type="checkbox" id="{$prefix}repeatDay6" {formname key=repeat_saturday} />
						{translate key="DaySaturdayAbbr"}
					</label>
				</div>
			</div>

			<div id="{$prefix}repeatOnMonthlyDiv" class="recur-toggle months no-show">
				<div class="btn-group" data-toggle="buttons">
					<label class="btn btn-default btn-sm active">
						<input type="radio" {formname key=REPEAT_MONTHLY_TYPE}
							   value="{RepeatMonthlyType::DayOfMonth}"
							   id="{$prefix}repeatMonthDay" checked="checked"/>
						{translate key="repeatDayOfMonth"}
					</label>
					<label class="btn btn-default btn-sm">
						<input type="radio" {formname key=REPEAT_MONTHLY_TYPE}
							   value="{RepeatMonthlyType::DayOfWeek}"
							   id="{$prefix}repeatMonthWeek"/>
						{translate key="repeatDayOfWeek"}
					</label>
				</div>
			</div>
		</div>

		<div id="{$prefix}repeatUntilDiv" class="col-xs-12 no-show recur-toggle">
			<label for="{$prefix}EndRepeat">{translate key="RepeatUntilPrompt"}</label>
			<input type="text" id="{$prefix}EndRepeat" class="form-control input-sm inline-block dateinput"
				   value="{formatdate date=$RepeatTerminationDate}"/>
			<input type="hidden" id="{$prefix}formattedEndRepeat" {formname key=end_repeat_date}
				   value="{formatdate date=$RepeatTerminationDate key=system}"/>
		</div>
	</div>
</div>
