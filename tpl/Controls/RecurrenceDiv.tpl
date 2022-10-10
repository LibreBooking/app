<div id="{if isset($prefix)}{$prefix}{/if}repeatDiv" class="repeat-div">
	<div class="form-group">
		<div class="col-xs-12">
			<label for="{if isset($prefix)}{$prefix}{/if}repeatOptions">{translate key="RepeatPrompt"}</label>
			<select id="{if isset($prefix)}{$prefix}{/if}repeatOptions" {formname key=repeat_options}
					class="form-control input-sm repeat-drop inline-block">
				{foreach from=$RepeatOptions key=k item=v}
					<option value="{$k}">{translate key=$v['key']}</option>
				{/foreach}
			</select>
		</div>

		<div class="col-sm-4 col-xs-12">
			<div id="{if isset($prefix)}{$prefix}{/if}repeatEveryDiv" class="recur-toggle no-show days weeks months years">
				<label for="{if isset($prefix)}{$prefix}{/if}repeatInterval">{translate key="RepeatEveryPrompt"}</label>
				<select id="{if isset($prefix)}{$prefix}{/if}repeatInterval" {formname key=repeat_every}
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
			<div id="{if isset($prefix)}{$prefix}{/if}repeatOnWeeklyDiv" class="recur-toggle weeks no-show">
				<div class="btn-group" data-toggle="buttons">
					<label class="btn btn-default btn-sm">
						<input type="checkbox" id="{if isset($prefix)}{$prefix}{/if}repeatDay0" {formname key=repeat_sunday} />
						{translate key="DaySundayAbbr"}
					</label>
					<label class="btn btn-default btn-sm">
						<input type="checkbox" id="{if isset($prefix)}{$prefix}{/if}repeatDay1" {formname key=repeat_monday} />
						{translate key="DayMondayAbbr"}
					</label>
					<label class="btn btn-default btn-sm">
						<input type="checkbox" id="{if isset($prefix)}{$prefix}{/if}repeatDay2" {formname key=repeat_tuesday} />
						{translate key="DayTuesdayAbbr"}
					</label>
					<label class="btn btn-default btn-sm">
						<input type="checkbox" id="{if isset($prefix)}{$prefix}{/if}repeatDay3" {formname key=repeat_wednesday} />
						{translate key="DayWednesdayAbbr"}
					</label>
					<label class="btn btn-default btn-sm">
						<input type="checkbox" id="{if isset($prefix)}{$prefix}{/if}repeatDay4" {formname key=repeat_thursday} />
						{translate key="DayThursdayAbbr"}
					</label>
					<label class="btn btn-default btn-sm">
						<input type="checkbox" id="{if isset($prefix)}{$prefix}{/if}repeatDay5" {formname key=repeat_friday} />
						{translate key="DayFridayAbbr"}
					</label>
					<label class="btn btn-default btn-sm">
						<input type="checkbox" id="{if isset($prefix)}{$prefix}{/if}repeatDay6" {formname key=repeat_saturday} />
						{translate key="DaySaturdayAbbr"}
					</label>
				</div>
			</div>

			<div id="{if isset($prefix)}{$prefix}{/if}repeatOnMonthlyDiv" class="recur-toggle months no-show">
				<div class="btn-group" data-toggle="buttons">
					<label class="btn btn-default btn-sm active">
						<input type="radio" {formname key=REPEAT_MONTHLY_TYPE}
							   value="{RepeatMonthlyType::DayOfMonth}"
							   id="{if isset($prefix)}{$prefix}{/if}repeatMonthDay" checked="checked"/>
						{translate key="repeatDayOfMonth"}
					</label>
					<label class="btn btn-default btn-sm">
						<input type="radio" {formname key=REPEAT_MONTHLY_TYPE}
							   value="{RepeatMonthlyType::DayOfWeek}"
							   id="{if isset($prefix)}{$prefix}{/if}repeatMonthWeek"/>
						{translate key="repeatDayOfWeek"}
					</label>
				</div>
			</div>
		</div>

		<div id="{if isset($prefix)}{$prefix}{/if}repeatUntilDiv" class="col-xs-12 no-show recur-toggle">
			<label for="{if isset($prefix)}{$prefix}{/if}EndRepeat">{translate key="RepeatUntilPrompt"}</label>
			<input type="text" id="{if isset($prefix)}{$prefix}{/if}EndRepeat" class="form-control input-sm inline-block dateinput"
				   value="{if isset($RepeatTerminationDate)}{formatdate date=$RepeatTerminationDate}{/if}"/>
			<input type="hidden" id="{if isset($prefix)}{$prefix}{/if}formattedEndRepeat" {formname key=end_repeat_date}
				   value="{if isset($RepeatTerminationDate)}{formatdate date=$RepeatTerminationDate key=system}{/if}"/>
		</div>

        <div id="{if isset($prefix)}{$prefix}{/if}customDatesDiv" class="col-xs-12 no-show specific-dates">
            <label for="{if isset($prefix)}{$prefix}{/if}RepeatDate">{translate key=RepeatOn}</label>
            <input type="text" id="{if isset($prefix)}{$prefix}{/if}RepeatDate" class="form-control input-sm inline-block dateinput" value=""/>
            <input type="hidden" id="{if isset($prefix)}{$prefix}{/if}formattedRepeatDate" key=system}"/>
            <a href="#" role="button" id="{if isset($prefix)}{$prefix}{/if}AddDate">{translate key=AddDate} <i class="fa fa-plus-square"></i></a>
            <div class="repeat-date-list">

            </div>
        </div>
	</div>
</div>
