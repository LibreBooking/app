{*
Copyright 2012-2020 Nick Korbel

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
    <div class="">
        <div class="col s12 input-field">
            <label for="{$prefix}repeatOptions" class="active">{translate key="RepeatPrompt"}</label>
            <select id="{$prefix}repeatOptions" {formname key=repeat_options}
                    class="input-sm repeat-drop">
                {foreach from=$RepeatOptions key=k item=v}
                    <option value="{$k}">{translate key=$v['key']}</option>
                {/foreach}
            </select>
        </div>

        <div class="col s12 m4">
            <div id="{$prefix}repeatEveryDiv" class="input-field col s6 recur-toggle no-show days weeks months years">
                <label for="{$prefix}repeatInterval" class="active">{translate key="RepeatEveryPrompt"}</label>
                <select id="{$prefix}repeatInterval" {formname key=repeat_every}
                        class="input-sm repeat-interval-drop">
                    {html_options values=$RepeatEveryOptions output=$RepeatEveryOptions}
                </select>
            </div>
            <div class="col s6 recur-toggle no-show days weeks months years">
                <span class="days">{translate key=$RepeatOptions['daily']['everyKey']}</span>
                <span class="weeks">{translate key=$RepeatOptions['weekly']['everyKey']}</span>
                <span class="months">{translate key=$RepeatOptions['monthly']['everyKey']}</span>
                <span class="years">{translate key=$RepeatOptions['yearly']['everyKey']}</span>
            </div>
        </div>

        <div class="col s12 m8">
            <div id="{$prefix}repeatOnWeeklyDiv" class="recur-toggle weeks no-show">
                <div class="">
                    <label class="">
                        <input type="checkbox" id="{$prefix}repeatDay0" {formname key=repeat_sunday} />
                        <span>{translate key="DaySundayAbbr"}</span>
                    </label>
                    <label class="">
                        <input type="checkbox" id="{$prefix}repeatDay1" {formname key=repeat_monday} />
                        <span>{translate key="DayMondayAbbr"}</span>
                    </label>
                    <label class="">
                        <input type="checkbox" id="{$prefix}repeatDay2" {formname key=repeat_tuesday} />
                        <span>{translate key="DayTuesdayAbbr"}</span>
                    </label>
                    <label class="">
                        <input type="checkbox" id="{$prefix}repeatDay3" {formname key=repeat_wednesday} />
                        <span>{translate key="DayWednesdayAbbr"}</span>
                    </label>
                    <label class="">
                        <input type="checkbox" id="{$prefix}repeatDay4" {formname key=repeat_thursday} />
                        <span>{translate key="DayThursdayAbbr"}</span>
                    </label>
                    <label class="">
                        <input type="checkbox" id="{$prefix}repeatDay5" {formname key=repeat_friday} />
                        <span>{translate key="DayFridayAbbr"}</span>
                    </label>
                    <label class="">
                        <input type="checkbox" id="{$prefix}repeatDay6" {formname key=repeat_saturday} />
                        <span>{translate key="DaySaturdayAbbr"}</span>
                    </label>
                </div>
            </div>

            <div id="{$prefix}repeatOnMonthlyDiv" class="recur-toggle months no-show">
                <div class="">
                    <label class="">
                        <input type="radio" {formname key=REPEAT_MONTHLY_TYPE}
                               value="{RepeatMonthlyType::DayOfMonth}"
                               id="{$prefix}repeatMonthDay" checked="checked"/>
                        <span>{translate key="repeatDayOfMonth"}</span>
                    </label>
                    <label class="">
                        <input type="radio" {formname key=REPEAT_MONTHLY_TYPE}
                               value="{RepeatMonthlyType::DayOfWeek}"
                               id="{$prefix}repeatMonthWeek"/>
                        <span>{translate key="repeatDayOfWeek"}</span>
                    </label>
                </div>
            </div>
        </div>

        <div id="{$prefix}repeatUntilDiv" class="input-field col s12 no-show recur-toggle">
            <label for="{$prefix}EndRepeat" class="active">{translate key="RepeatUntilPrompt"}</label>
            <input type="text" id="{$prefix}EndRepeat" class="input-sm dateinput"
                   value="{formatdate date=$RepeatTerminationDate}"/>
            <input type="hidden" id="{$prefix}formattedEndRepeat" {formname key=end_repeat_date}
                   value="{formatdate date=$RepeatTerminationDate key=system}"/>
        </div>

        <div id="{$prefix}customDatesDiv" class="col-xs-12 no-show specific-dates">
            <label for="{$prefix}RepeatDate">{translate key=RepeatOn}</label>
            <input type="text" id="{$prefix}RepeatDate" class="form-control input-sm inline-block dateinput" value=""/>
            <input type="hidden" id="{$prefix}formattedRepeatDate" key=system}"/>
            <a href="#" role="button" id="{$prefix}AddDate">{translate key=AddDate} <i class="fa fa-plus-square"></i></a>
            <div class="repeat-date-list">

    </div>
        </div>
	</div>
</div>
