{*
Copyright 2011-2014 Nick Korbel

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
{block name="header"}
	{include file='globalheader.tpl'}
{/block}

<div id="page-reservation">

<div id="reservationbox">

<form id="reservationForm" method="post" enctype="multipart/form-data" role="form" class="form-horizontal">

<div class="row">
	<div class="col-xs-6 col-top reservationHeader">
		<h3>{block name=reservationHeader}{translate key="CreateReservationHeading"}{/block}</h3>
	</div>

	<div class="col-xs-6 col-top">
		<div class="pull-right">
			{block name="submitButtons"}
				<button type="button" class="button save create">
					{html_image src="tick-circle.png"}
					{translate key='Create'}
				</button>
			{/block}
			<button type="button" class="button" onclick="window.location='{$ReturnUrl}'">
				{html_image src="slash.png"}
				{translate key='Cancel'}
			</button>
		</div>
	</div>
</div>

<div class="row">
	{assign var="detailsCol" value="col-xs-12"}
	{assign var="participantCol" value="col-xs-12"}

	{if $ShowParticipation && $AllowParticipation}
		{assign var="detailsCol" value="col-xs-6"}
		{assign var="participantCol" value="col-xs-6"}
	{/if}

	<div id="reservationDetails" class="{$detailsCol}">
		<div class="row">
			<div class="col-xs-12">
				<span id="userName">{$ReservationUserName}</span> <input id="userId"
																		 type="hidden" {formname key=USER_ID}
																		 value="{$UserId}"/>
				{if $CanChangeUser}
					<a href="#" id="showChangeUsers"
					   class="small-action">{translate key=Change}{html_image src="user-small.png"}</a>
					<div id="changeUserDialog" title="{translate key=ChangeUser}" class="dialog"></div>
				{/if}
			</div>
		</div>

		<div class="row" id="changeUsers">
			<div class="col-xs-12">
				<input type="text" id="changeUserAutocomplete" class="input" style="width:250px;"/>
				|
				<button id="promptForChangeUsers" type="button" class="button" style="display:inline">
					{html_image src="users.png"}
					{translate key='AllUsers'}
				</button>
			</div>
		</div>

		<div class="row">
			<div class="col-xs-12">
				<div class="pull-left"><span class="like-label">{translate key="ResourceList"}</span><br/>

					<div id="resourceNames" style="display:inline">
						<a href="#" class="resourceDetails">{$ResourceName}</a>
						<input class="resourceId" type="hidden" {formname key=RESOURCE_ID} value="{$ResourceId}"/>
						<input type="hidden" id="scheduleId" {formname key=SCHEDULE_ID} value="{$ScheduleId}"/>
					</div>
					{if $ShowAdditionalResources}
						<a id="btnAddResources" href="#"
						   class="small-action">{translate key=MoreResources}{html_image src="plus-small-white.png"}</a>
					{/if}
					<div id="additionalResources">
						{foreach from=$AvailableResources item=resource}
							{if is_array($AdditionalResourceIds) && in_array($resource->Id, $AdditionalResourceIds)}
								<p><a href="#" class="resourceDetails">{$resource->Name}</a><input
											class="resourceId" type="hidden"
											name="{FormKeys::ADDITIONAL_RESOURCES}[]" value="{$resource->Id}"/></p>
							{/if}
						{/foreach}
					</div>
				</div>
				<div class="pull-right">{if $AvailableAccessories|count > 0}
						<label>{translate key="Accessories"}</label>
						<a href="#" id="addAccessoriesPrompt"
						   class="small-action">{translate key='Add'}{html_image src="plus-small-white.png"}</a>
						<div id="accessories"></div>
					{/if}</div>
			</div>
		</div>

		<ul class="no-style">
			<li>
				<div class="form-group">
                                        <label for="BeginDate" class="reservationDate">{translate key='BeginDate'}</label>
                                        <input type="text" id="BeginDate" class="form-control dateinput"
                                                   value="{formatdate date=$StartDate}"/>
                                        <input type="hidden" id="formattedBeginDate" {formname key=BEGIN_DATE}
                                                   value="{formatdate date=$StartDate key=system}"/>
                                        <select id="BeginPeriod" {formname key=BEGIN_PERIOD} class="form-control timeinput" title="Begin time">
                                                {foreach from=$StartPeriods item=period}
                                                        {if $period->IsReservable()}
                                                                {assign var='selected' value=''}
                                                                {if $period eq $SelectedStart}
                                                                        {assign var='selected' value=' selected="selected"'}
                                                                {/if}
                                                                <option value="{$period->Begin()}"{$selected}>{$period->Label()}</option>
                                                        {/if}
                                                {/foreach}
                                        </select>
                                </div>
			</li>
			<li>
				<div class="form-group">
					<label for="EndDate" class="reservationDate">{translate key='EndDate'}</label>
					<input type="text" id="EndDate" class="form-control dateinput" value="{formatdate date=$EndDate}"/>
					<input type="hidden" id="formattedEndDate" {formname key=END_DATE}
						   value="{formatdate date=$EndDate key=system}" />
					<select id="EndPeriod" {formname key=END_PERIOD} class="form-control timeinput" title="End time">
						{foreach from=$EndPeriods item=period name=endPeriods}
							{if $period->BeginDate()->IsMidnight()}
								<option value="{$period->Begin()}"{$selected}>{$period->Label()}</option>
							{/if}
							{if $period->IsReservable()}
								{assign var='selected' value=''}
								{if $period eq $SelectedEnd}
									{assign var='selected' value=' selected="selected"'}
								{/if}
								<option value="{$period->End()}"{$selected}>{$period->LabelEnd()}</option>
							{/if}
						{/foreach}
					</select>
				</div>
			</li>
			<li>
				<div class="form-group">
				<span class="like-label">{translate key=ReservationLength}</span>

				<div class="durationText">
					<span id="durationDays">0</span> {translate key=days},
					<span id="durationHours">0</span> {translate key=hours}
				</div>
				</div>
			</li>
			{if $HideRecurrence}
			<li style="display:none">
				{else}
			<li>
				{/if}
				<div class="form-group">
				{control type="RecurrenceControl" RepeatTerminationDate=$RepeatTerminationDate}
				</div>
			</li>
			<li class="form-horizontal">
				<div class="form-group ">
					<label for="reservationTitle">{translate key="ReservationTitle"}</label>
					{textbox name="RESERVATION_TITLE" class="form-control" value="ReservationTitle" id="reservationTitle"}
				</div>
			</li>
			<li class="form-horizontal">
				<div class="form-group">
					<label for="description">{translate key="ReservationDescription"}</label>
					<textarea id="description" name="{FormKeys::DESCRIPTION}"
							  class="form-control">{$Description}</textarea>
				</div>
			</li>
		</ul>
	</div>

	<div class={$participantCol}>
		{if $ShowParticipation && $AllowParticipation}
			{include file="Reservation/participation.tpl"}
		{else}
			{include file="Reservation/private-participation.tpl"}
		{/if}
	</div>
</div>

{if $RemindersEnabled}
	<div class="row">
		<div class="reservationReminders">
			<div id="reminderOptionsStart">
				<label>{translate key=SendReminder}</label>
				<input type="checkbox" class="reminderEnabled" {formname key=START_REMINDER_ENABLED}/>
				<input type="text" size="3" maxlength="3" value="15"
					   class="reminderTime textbox" {formname key=START_REMINDER_TIME}/>
				<select class="reminderInterval textbox" {formname key=START_REMINDER_INTERVAL}>
					<option value="{ReservationReminderInterval::Minutes}">{translate key=minutes}</option>
					<option value="{ReservationReminderInterval::Hours}">{translate key=hours}</option>
					<option value="{ReservationReminderInterval::Days}">{translate key=days}</option>
				</select>
				<span class="reminderLabel">{translate key=ReminderBeforeStart}</span>
			</div>
			<div id="reminderOptionsEnd">
				<input type="checkbox" class="reminderEnabled" {formname key=END_REMINDER_ENABLED}/>
				<input type="text" size="3" maxlength="3" value="15"
					   class="reminderTime textbox" {formname key=END_REMINDER_TIME}/>
				<select class="reminderInterval textbox" {formname key=END_REMINDER_INTERVAL}>
					<option value="{ReservationReminderInterval::Minutes}">{translate key=minutes}</option>
					<option value="{ReservationReminderInterval::Hours}">{translate key=hours}</option>
					<option value="{ReservationReminderInterval::Days}">{translate key=days}</option>
				</select>
				<span class="reminderLabel">{translate key=ReminderBeforeEnd}</span>
			</div>
			<div class="clear">&nbsp;</div>
		</div>
	</div>
{/if}

{if $Attributes|count > 0}
	<div class="row">
		<div class="customAttributes">
			<span>{translate key=AdditionalAttributes}</span>
			<ul>
				{foreach from=$Attributes item=attribute}
					<li class="customAttribute">
						{control type="AttributeControl" attribute=$attribute}
					</li>
				{/foreach}
			</ul>
		</div>
	</div>
{/if}

{if $UploadsEnabled}
	<div class="row">
		<div class="reservationAttachments">
			<ul>
				<li>
					<label>{translate key=AttachFile} <span class="note">({$MaxUploadSize}
							MB {translate key=Maximum})</span><br/> </label>
					<ul style="list-style:none;" id="reservationAttachments">
						<li class="attachment-item">
							<input type="file" {formname key=RESERVATION_FILE multi=true} />
							<a class="add-attachment" href="#">{html_image src="plus-button.png"}</a>
							<a class="remove-attachment" href="#">{html_image src="minus-gray.png"}</a>
						</li>
					</ul>
				</li>
			</ul>
		</div>
	</div>
{/if}


<input type="hidden" {formname key=reservation_id} value="{$ReservationId}"/>
<input type="hidden" {formname key=reference_number} value="{$ReferenceNumber}"/>
<input type="hidden" {formname key=reservation_action} value="{$ReservationAction}"/>
<input type="hidden" {formname key=SERIES_UPDATE_SCOPE} id="hdnSeriesUpdateScope"
	   value="{SeriesUpdateScope::FullSeries}"/>

<div class="row">
	<div class="reservationButtons">
		<div class="reservationDeleteButtons">
			{block name="deleteButtons"}
				&nbsp;
			{/block}
		</div>
		<div class="reservationSubmitButtons">
			{block name="submitButtons"}
				<button type="button" class="button save create">
					{html_image src="tick-circle.png"}
					{translate key='Create'}
				</button>
			{/block}
			<button type="button" class="button" onclick="window.location='{$ReturnUrl}'">
				{html_image src="slash.png"}
				{translate key='Cancel'}
			</button>
		</div>
	</div>
</div>

{if $UploadsEnabled}
	{block name='attachments'}
	{/block}
{/if}
</form>
</div>

<div class="modal fade" id="dialogResourceGroups" tabindex="-1" role="dialog" aria-labelledby="resourcesModalLabel"
	 aria-hidden="true">
	<div class="modal-dialog">
		<div class="modal-content">
			<div class="modal-header">
				<button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
				<h4 class="modal-title" id="resourcesModalLabel">{translate key=AddResources}</h4>
			</div>
			<div class="modal-body">
				<div id="resourceGroups"></div>
			</div>
			<div class="modal-footer">
				<button type="button" class="btn btn-default btnClearAddResources"
						data-dismiss="modal">{translate key='Cancel'}</button>
				<button type="button"
						class="btn btn-primary btnConfirmAddResources">{translate key='Done'}</button>
			</div>
		</div>
	</div>
</div>

<div class="modal fade" id="dialogAddAccessories" tabindex="-1" role="dialog" aria-labelledby="accessoryModalLabel"
	 aria-hidden="true">

	<div class="modal-dialog">
		<div class="modal-content">
			<div class="modal-header">
				<button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
				<h4 class="modal-title" id="accessoryModalLabel">{translate key=AddAccessories}</h4>
			</div>
			<div class="modal-body">
				{*<div id="dialogAddAccessories" class="dialog" title="{translate key=AddAccessories}" style="display:none;">*}
				<table style="width:100%">
					<tr>
						<td>{translate key=Accessory}</td>
						<td>{translate key=QuantityRequested}</td>
						<td>{translate key=QuantityAvailable}</td>
					</tr>
					{foreach from=$AvailableAccessories item=accessory}
						<tr>
							<td>{$accessory->Name}</td>
							<td>
								<input type="hidden" class="name" value="{$accessory->Name}"/>
								<input type="hidden" class="id" value="{$accessory->Id}"/>
								{if $accessory->QuantityAvailable == 1}
									<input type="checkbox" name="accessory{$accessory->Id}" value="1" size="3"/>
								{else}
									<input type="text" name="accessory{$accessory->Id}" value="0" size="3"/>
								{/if}
							</td>
							<td>{$accessory->QuantityAvailable|default:'&infin;'}</td>
						</tr>
					{/foreach}
				</table>

			</div>
			<div class="modal-footer">
				<button id="btnCancelAddAccessories" type="button" class="btn btn-default"
						data-dismiss="modal">{translate key='Cancel'}</button>
				<button id="btnConfirmAddAccessories" type="button"
						class="btn btn-primary">{translate key='Done'}</button>
			</div>
		</div>
	</div>
</div>

<div id="dialogSave" style="display:none;">
	<div id="creatingNotification" style="position:relative; top:170px;">
		{block name="ajaxMessage"}
			{translate key=CreatingReservation}...
			<br/>
		{/block}
		{html_image src="reservation_submitting.gif" alt="Creating reservation"}
	</div>

</div>

</div>
{control type="DatePickerSetupControl" ControlId="BeginDate" AltId="formattedBeginDate" DefaultDate=$StartDate}
{control type="DatePickerSetupControl" ControlId="EndDate" AltId="formattedEndDate" DefaultDate=$EndDate}
{control type="DatePickerSetupControl" ControlId="EndRepeat" AltId="formattedEndRepeat" DefaultDate=$RepeatTerminationDate}

{jsfile src="js/jquery.autogrow.js"}
{jsfile src="js/jquery.qtip.min.js"}
{jsfile src="js/jquery.form-3.09.min.js"}
{jsfile src="js/moment.min.js"}
{jsfile src="resourcePopup.js"}
{jsfile src="date-helper.js"}
{jsfile src="recurrence.js"}
{jsfile src="reservation.js"}
{jsfile src="autocomplete.js"}
{jsfile src="force-numeric.js"}
{jsfile src="reservation-reminder.js"}
{jsfile src="js/tree.jquery.js"}

<script type="text/javascript">

	$(document).ready(function ()
	{
		var scopeOptions = {
			instance: '{SeriesUpdateScope::ThisInstance}',
			full: '{SeriesUpdateScope::FullSeries}',
			future: '{SeriesUpdateScope::FutureInstances}'
		};

		var reservationOpts = {
			additionalResourceElementId: '{FormKeys::ADDITIONAL_RESOURCES}',
			accessoryListInputId: '{FormKeys::ACCESSORY_LIST}[]',
			returnUrl: '{$ReturnUrl}',
			scopeOpts: scopeOptions,
			createUrl: 'ajax/reservation_save.php',
			updateUrl: 'ajax/reservation_update.php',
			deleteUrl: 'ajax/reservation_delete.php',
			userAutocompleteUrl: "ajax/autocomplete.php?type={AutoCompleteType::User}",
			groupAutocompleteUrl: "ajax/autocomplete.php?type={AutoCompleteType::Group}",
			changeUserAutocompleteUrl: "ajax/autocomplete.php?type={AutoCompleteType::MyUsers}",
			maxConcurrentUploads: '{$MaxUploadCount}'
		};

		var recurOpts = {
			repeatType: '{$RepeatType}',
			repeatInterval: '{$RepeatInterval}',
			repeatMonthlyType: '{$RepeatMonthlyType}',
			repeatWeekdays: [{foreach from=$RepeatWeekdays item=day}{$day}, {/foreach}]
		};

		var reminderOpts = {
			reminderTimeStart: '{$ReminderTimeStart}',
			reminderTimeEnd: '{$ReminderTimeEnd}',
			reminderIntervalStart: '{$ReminderIntervalStart}',
			reminderIntervalEnd: '{$ReminderIntervalEnd}'
		};

		var recurrence = new Recurrence(recurOpts);
		recurrence.init();

		var reservation = new Reservation(reservationOpts);
		reservation.init('{$UserId}');

		var reminders = new Reminder(reminderOpts);
		reminders.init();

		{foreach from=$Participants item=user}
		reservation.addParticipant("{$user->FullName|escape:'javascript'}", "{$user->UserId|escape:'javascript'}");
		{/foreach}

		{foreach from=$Invitees item=user}
		reservation.addInvitee("{$user->FullName|escape:'javascript'}", '{$user->UserId}');
		{/foreach}

		{foreach from=$Accessories item=accessory}
		reservation.addAccessory('{$accessory->AccessoryId}', '{$accessory->QuantityReserved}', "{$accessory->Name|escape:'javascript'}");
		{/foreach}

		reservation.addResourceGroups({$ResourceGroupsAsJson});

		var ajaxOptions = {
			target: '#result', // target element(s) to be updated with server response
			beforeSubmit: reservation.preSubmit, // pre-submit callback
			success: reservation.showResponse  // post-submit callback
		};

		$('#reservationForm').submit(function ()
		{
			$(this).ajaxSubmit(ajaxOptions);
			return false;
		});
		$('#description').autogrow();
	});
</script>

{include file='globalfooter.tpl'}
