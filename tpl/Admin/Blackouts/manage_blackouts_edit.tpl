{*
Copyright 2013 Nick Korbel

This file is part of phpScheduleIt.

phpScheduleIt is free software: you can redistribute it and/or modify
it under the terms of the GNU General Public License as published by
the Free Software Foundation, either version 3 of the License, or
(at your option) any later version.

phpScheduleIt is distributed in the hope that it will be useful,
but WITHOUT ANY WARRANTY; without even the implied warranty of
MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
GNU General Public License for more details.

You should have received a copy of the GNU General Public License
along with phpScheduleIt.  If not, see <http://www.gnu.org/licenses/>.
*}

<div id="updateBlackout">
	<ul>
		<li>
			<label for="addStartDate" class="wideLabel">{translate key=BeginDate}</label>
			<input type="text" id="addStartDate" class="textbox" size="10" value="{formatdate date=$BlackoutStartDate}"/>
			<input {formname key=BEGIN_DATE} id="formattedAddStartDate" type="hidden" value="{formatdate date=$BlackoutStartDate key=system}"/>
			<input {formname key=BEGIN_TIME} type="text" id="addStartTime" class="textbox" size="7" value="{formatdate date=$BlackoutStartDate format='h:i A'}" />
		</li>
		<li>
			<label for="addEndDate" class="wideLabel">{translate key=EndDate}</label>
			<input type="text" id="addEndDate" class="textbox" size="10" value="{formatdate date=$BlackoutEndDate}"/>
			<input {formname key=END_DATE} type="hidden" id="formattedAddEndDate" value="{formatdate date=$BlackoutEndDate key=system}"/>
			<input {formname key=END_TIME} type="text" id="addEndTime" class="textbox" size="7" value="{formatdate date=$BlackoutEndDate format='h:i A'}" />
		</li>
		<li>
			<label for="addResourceId" class="wideLabel">{translate key=Resources}</label>
			<select {formname key=RESOURCE_ID} class="textbox" id="addResourceId">
				{object_html_options options=$Resources key='GetId' label="GetName" selected=$ResourceId}
			</select>
		</li>
		<li>
			<label for="blackoutReason" class="wideLabel">{translate key=Reason}</label>
			<input {formname key=SUMMARY} type="text" id="blackoutReason" class="textbox required" size="100" maxlength="85" value="{$BlackoutTitle}"/>
		</li>
		<li>
			{control type="RecurrenceControl" RepeatTerminationDate=$RepeatTerminationDate }
		</li>
		<li>
			<input {formname key=CONFLICT_ACTION} type="radio" id="notifyExisting" name="existingReservations" checked="checked" value="{ReservationConflictResolution::Notify}" />
			<label for="notifyExisting">{translate key=BlackoutShowMe}</label>

			<input {formname key=CONFLICT_ACTION} type="radio" id="deleteExisting" name="existingReservations" value="{ReservationConflictResolution::Delete}" />
			<label for="deleteExisting">{translate key=BlackoutDeleteConflicts}</label>
		</li>
	</ul>

	{if $IsRecurring}
		<span>{translate key=ApplyUpdatesTo}</span>

		<button type="button" id="btnUpdateThisInstance" class="button save">
			{html_image src="disk-black.png"}
			{translate key='ThisInstance'}
		</button>
		<button type="button" id="btnUpdateAllInstances" class="button save">
			{html_image src="disks-black.png"}
			{translate key='AllInstances'}
		</button>
	{else}
		<button type="button" id="btnCreate" class="button save update">
			{html_image src="disk-black.png"}
			{translate key='Update'}
		</button>
	{/if}

	<button type="button" class="button" id="cancelUpdate">
		{html_image src="slash.png"}
		{translate key='Cancel'}
	</button>
</div>

<script type="text/javascript">
var recurOpts = {
     repeatType:'{$RepeatType}',
     repeatInterval:'{$RepeatInterval}',
     repeatMonthlyType:'{$RepeatMonthlyType}',
     repeatWeekdays:[{foreach from=$RepeatWeekdays item=day}{$day},{/foreach}]
 };

 var recurrence = new Recurrence(recurOpts);
 recurrence.init();
</script>