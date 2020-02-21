{*
Copyright 2013-2020 Nick Korbel

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

<form id="editBlackoutForm" class="form-inline" role="form" method="post">
	<div id="updateBlackout">
		<div class="form-group col-xs-6">
			<label for="updateStartDate">{translate key=BeginDate}</label>
			<input type="text" id="updateStartDate" class="form-control dateinput inline-block "
				   value="{formatdate date=$BlackoutStartDate}"/>
			<input {formname key=BEGIN_DATE} id="formattedUpdateStartDate" type="hidden"
											 value="{formatdate date=$BlackoutStartDate key=system}"/>
			<input {formname key=BEGIN_TIME} type="text" id="updateStartTime"
											 class="form-control dateinput inline-block timepicker"
											 value="{formatdate date=$BlackoutStartDate format='h:i A'}"/>
		</div>

		<div class="form-group col-xs-6">
			<label for="updateEndDate">{translate key=EndDate}</label>
			<input type="text" id="updateEndDate" class="form-control dateinput inline-block " size="10"
				   value="{formatdate date=$BlackoutEndDate}"/>
			<input {formname key=END_DATE} type="hidden" id="formattedUpdateEndDate"
										   value="{formatdate date=$BlackoutEndDate key=system}"/>
			<input {formname key=END_TIME} type="text" id="updateEndTime"
										   class="form-control dateinput inline-block timepicker"
										   value="{formatdate date=$BlackoutEndDate format='h:i A'}"/>
		</div>

		<div class="form-group col-xs-12 blackouts-edit-resources">
			<label>{translate key=Resources}</label>
			{foreach from=$Resources item=resource}
				{assign var=checked value=""}
				{if in_array($resource->GetId(), $BlackoutResourceIds)}
					{assign var=checked value="checked='checked'"}
				{/if}
				<label class="resourceItem">
					<div class="checkbox">
						<input {formname key=RESOURCE_ID  multi=true} type="checkbox"
																	  value="{$resource->GetId()}" {$checked}
																	  id="r{$resource->GetId()}"/>
						<label for="r{$resource->GetId()}">{$resource->GetName()}</label>
					</div>
				</label>
			{/foreach}
		</div>

		<div class="col-xs-12">
			<div class="form-group has-feedback">
				<label for="blackoutReason">{translate key=Reason}</label>
				<input {formname key=SUMMARY} type="text" id="blackoutReason" required
											  class="form-control required" value="{$BlackoutTitle}"/>
				<i class="glyphicon glyphicon-asterisk form-control-feedback" data-bv-icon-for="blackoutReason"></i>
			</div>
		</div>

		<div>
			{control type="RecurrenceControl" RepeatTerminationDate=$RepeatTerminationDate prefix='edit'}
		</div>

		<div class="form-group col-xs-12">
            <div class="radio">
                <input {formname key=CONFLICT_ACTION} type="radio" id="bookAroundUpdate"
                                                      name="existingReservations"
                                                      checked="checked"
                                                      value="{ReservationConflictResolution::BookAround}"/>
                <label for="notifyExisting">{translate key=BlackoutAroundConflicts}</label>
            </div>
            <div class="radio">
                <input {formname key=CONFLICT_ACTION} type="radio" id="notifyExistingUpdate"
                                                      name="existingReservations"
                                                      value="{ReservationConflictResolution::Notify}"/>
                <label for="notifyExisting">{translate key=BlackoutShowMe}</label>
            </div>
            <div class="radio">
                <input {formname key=CONFLICT_ACTION} type="radio" id="deleteExistingUpdate"
                                                      name="existingReservations"
                                                      value="{ReservationConflictResolution::Delete}"/>
                <label for="deleteExisting">{translate key=BlackoutDeleteConflicts}</label>
            </div>
		</div>

		<div id="update-blackout-buttons" class="col-xs-12 margin-bottom-25">
			<div class="pull-right">
				<button type="button" class="btn btn-default" id="cancelUpdate">
					{translate key='Cancel'}
				</button>
				{if $IsRecurring}
					<button type="button" class="btn btn-success save btnUpdateThisInstance">
						<span class="glyphicon glyphicon-ok-circle"></span>
						{translate key='ThisInstance'}
					</button>
					<button type="button" class="btn btn-success save btnUpdateAllInstances">
						<span class="glyphicon glyphicon-ok-circle"></span>
						{translate key='AllInstances'}
					</button>
				{else}
					<button type="button" class="btn btn-success save update btnUpdateAllInstances">
						<span class="glyphicon glyphicon-ok-circle"></span>
						{translate key='Update'}
					</button>
				{/if}

			</div>
		</div>

		<input type="hidden" {formname key=BLACKOUT_INSTANCE_ID} value="{$BlackoutId}"/>
		<input type="hidden" {formname key=SERIES_UPDATE_SCOPE} class="hdnSeriesUpdateScope"
			   value="{SeriesUpdateScope::FullSeries}"/>
	</div>
	{csrf_token}
</form>

<script type="text/javascript">
	$(function ()
	{
		var recurOpts = {
			repeatType: '{$RepeatType}',
			repeatInterval: '{$RepeatInterval}',
			repeatMonthlyType: '{$RepeatMonthlyType}',
			repeatWeekdays: [{foreach from=$RepeatWeekdays item=day}{$day}, {/foreach}],
            customRepeatExclusions: ['{formatdate date=$BlackoutStartDate key=system}']
		};

		var recurrence = new Recurrence(recurOpts, {}, 'edit');
		recurrence.init();
        {foreach from=$CustomRepeatDates item=date}
        recurrence.addCustomDate('{format_date date=$date key=system timezone=$Timezone}', '{format_date date=$date timezone=$Timezone}');
        {/foreach}
	});
</script>

{control type="DatePickerSetupControl" ControlId="updateStartDate" AltId="formattedUpdateStartDate"}
{control type="DatePickerSetupControl" ControlId="updateEndDate" AltId="formattedUpdateEndDate"}
{control type="DatePickerSetupControl" ControlId="editEndRepeat" AltId="editformattedEndRepeat"}
{control type="DatePickerSetupControl" ControlId="editRepeatDate" AltId="editformattedRepeatDate"}