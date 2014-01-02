{*
Copyright 2013-2014 Nick Korbel

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

<form id="editBlackoutForm" method="post">
	<div id="updateBlackout">
		<ul>
			<li>
				<label for="updateStartDate" class="wideLabel">{translate key=BeginDate}</label>
				<input type="text" id="updateStartDate" class="textbox" size="10"
					   value="{formatdate date=$BlackoutStartDate}"/>
				<input {formname key=BEGIN_DATE} id="formattedUpdateStartDate" type="hidden"
												 value="{formatdate date=$BlackoutStartDate key=system}"/>
				<input {formname key=BEGIN_TIME} type="text" id="updateStartTime" class="textbox" size="7"
												 value="{formatdate date=$BlackoutStartDate format='h:i A'}"/>
			</li>
			<li>
				<label for="updateEndDate" class="wideLabel">{translate key=EndDate}</label>
				<input type="text" id="updateEndDate" class="textbox" size="10"
					   value="{formatdate date=$BlackoutEndDate}"/>
				<input {formname key=END_DATE} type="hidden" id="formattedUpdateEndDate"
											   value="{formatdate date=$BlackoutEndDate key=system}"/>
				<input {formname key=END_TIME} type="text" id="updateEndTime" class="textbox" size="7"
											   value="{formatdate date=$BlackoutEndDate format='h:i A'}"/>
			</li>
			<li class="blackoutResources">
				<label for="addResourceId" class="wideLabel">{translate key=Resources}</label>
				{foreach from=$Resources item=resource}
					{assign var=checked value=""}
					{if in_array($resource->GetId(), $BlackoutResourceIds)}
						{assign var=checked value="checked='checked'"}
					{/if}
					<label class="resourceItem"><input {formname key=RESOURCE_ID multi=true} type="checkbox" value="{$resource->GetId()}" {$checked} /> {$resource->GetName()}</label>
				{/foreach}
			</li>
			<li>
				<label for="blackoutReason" class="wideLabel">{translate key=Reason}</label>
				<input {formname key=SUMMARY} type="text" id="blackoutReason" class="textbox required" size="100"
											  maxlength="85" value="{$BlackoutTitle}"/>
			</li>
			<li>
				{control type="RecurrenceControl" RepeatTerminationDate=$RepeatTerminationDate prefix='edit'}
			</li>
			<li>
				<input {formname key=CONFLICT_ACTION} type="radio" id="notifyExisting" name="existingReservations"
													  checked="checked"
													  value="{ReservationConflictResolution::Notify}"/>
				<label for="notifyExisting">{translate key=BlackoutShowMe}</label>

				<input {formname key=CONFLICT_ACTION} type="radio" id="deleteExisting" name="existingReservations"
													  value="{ReservationConflictResolution::Delete}"/>
				<label for="deleteExisting">{translate key=BlackoutDeleteConflicts}</label>
			</li>
		</ul>

		{if $IsRecurring}
			<div>{translate key=ApplyUpdatesTo}</div>
			<button type="button" class="button save btnUpdateThisInstance">
				{html_image src="disk-black.png"}
				{translate key='ThisInstance'}
			</button>
			<button type="button" class="button save btnUpdateAllInstances">
				{html_image src="disks-black.png"}
				{translate key='AllInstances'}
			</button>
		{else}
			<button type="button" class="button save update btnUpdateAllInstances">
				{html_image src="disk-black.png"}
				{translate key='Update'}
			</button>
		{/if}

		<button type="button" class="button" id="cancelUpdate">
			{html_image src="slash.png"}
			{translate key='Cancel'}
		</button>

		<input type="hidden" {formname key=BLACKOUT_INSTANCE_ID} value="{$BlackoutId}" />
		<input type="hidden" {formname key=SERIES_UPDATE_SCOPE} class="hdnSeriesUpdateScope" value="{SeriesUpdateScope::FullSeries}"/>
	</div>
</form>

<script type="text/javascript">
	var recurOpts = {
		repeatType: '{$RepeatType}',
		repeatInterval: '{$RepeatInterval}',
		repeatMonthlyType: '{$RepeatMonthlyType}',
		repeatWeekdays: [{foreach from=$RepeatWeekdays item=day}{$day}, {/foreach}]
	};

	var recurrence = new Recurrence(recurOpts, {}, 'edit');
	recurrence.init();
</script>

{control type="DatePickerSetupControl" ControlId="updateStartDate" AltId="formattedUpdateStartDate"}
{control type="DatePickerSetupControl" ControlId="updateEndDate" AltId="formattedUpdateEndDate"}
{control type="DatePickerSetupControl" ControlId="editEndRepeat" AltId="editformattedEndRepeat"}