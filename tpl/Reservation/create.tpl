{*
Copyright 2011-2013 Nick Korbel

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
{block name="header"}
{include file='globalheader.tpl' cssFiles='css/reservation.css,css/jquery.qtip.min.css'}
{/block}

<div id="reservationbox">

<form id="reservationForm" method="post" enctype="multipart/form-data">
<div class="reservationHeader">
    <h3>{block name=reservationHeader}{translate key="CreateReservationHeading"}{/block}</h3>
</div>
<div id="reservationDetails">
    <ul class="no-style">
        <li>
            <span id="userName">{$ReservationUserName}</span> <input id="userId"
                                                                     type="hidden" {formname key=USER_ID}
                                                                     value="{$UserId}"/>
		{if $CanChangeUser}
            <a href="#" id="showChangeUsers">({translate key=Change})</a>

            <div id="changeUserDialog" title="{translate key=ChangeUser}" class="dialog"></div>
		{/if}
        </li>
        <li style="display:none;" id="changeUsers">
            <input type="text" id="changeUserAutocomplete" class="input" style="width:250px;"/>
            |
            <button id="promptForChangeUsers" type="button" class="button" style="display:inline">
                <img src="img/users.png"/>
			{translate key='AllUsers'}
            </button>
        </li>
    </ul>
    <ul class="no-style">
        <li class="inline">
            <div>
                <div style="float:left;">
                    <label>{translate key="ResourceList"}</label><br/>

                    <div id="resourceNames" style="display:inline">
                        <a href="#" class="resourceDetails">{$ResourceName}</a>
                        <input class="resourceId" type="hidden" {formname key=RESOURCE_ID} value="{$ResourceId}"/>
                        <input type="hidden" id="scheduleId" {formname key=SCHEDULE_ID} value="{$ScheduleId}"/>
                    </div>
				{if $ShowAdditionalResources}
                    <a href="#"
                       onclick="$('#dialogAddResources').dialog('open'); return false;">({translate key=MoreResources}
                        )</a>
				{/if}
                    <div id="additionalResources"></div>
                </div>
                <div style="float:right;">
				{if $AvailableAccessories|count > 0}
                    <label>{translate key="Accessories"}</label>
                    <a href="#" id="addAccessoriesPrompt">({translate key='Add'})</a>

                    <div id="accessories"></div>
				{/if}
                </div>
            </div>
            <div style="clear:both;height:0;">&nbsp;</div>
        </li>
        <li>
            <label for="BeginDate" style="width:50px;display:inline-block;">{translate key='BeginDate'}</label>
            <input type="text" id="BeginDate" class="dateinput" value="{formatdate date=$StartDate}"/>
            <input type="hidden" id="formattedBeginDate" {formname key=BEGIN_DATE}
                   value="{formatdate date=$StartDate key=system}"/>
            <select id="BeginPeriod" {formname key=BEGIN_PERIOD} class="pulldown" style="width:150px">
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
        </li>
        <li>
            <label for="EndDate" style="width:50px;display:inline-block;">{translate key='EndDate'}</label>
            <input type="text" id="EndDate" class="dateinput" value="{formatdate date=$EndDate}"/>
            <input type="hidden" id="formattedEndDate" {formname key=END_DATE}
                   value="{formatdate date=$EndDate key=system}"/>
            <select id="EndPeriod" {formname key=END_PERIOD} class="pulldown" style="width:150px">
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
        </li>
        <li>
            <label>{translate key=ReservationLength}</label>

            <div class="durationText">
                <span id="durationDays">0</span> {translate key=days},
                <span id="durationHours">0</span> {translate key=hours}
            </div>
        </li>
	{if $HideRecurrence}
        <li style="display:none">
			{else}
    <li>
	{/if}
	{control type="RecurrenceControl" RepeatTerminationDate=$RepeatTerminationDate}
    </li>
        <li class="rsv-box-l">
            <label>{translate key="ReservationTitle"}<br/>
			{textbox name="RESERVATION_TITLE" class="input" tabindex="100" value="ReservationTitle"}
            </label>
        </li>
        <li class="rsv-box-l">
            <label>{translate key="ReservationDescription"}<br/>
                <textarea id="description" name="{FormKeys::DESCRIPTION}" class="input-area" rows="2" cols="52"
                          tabindex="110">{$Description}</textarea>
            </label>
        </li>
	{if $UploadsEnabled}
        <li>
            <label>{translate key=AttachFile}<br/>
                <input type="file" {formname key=RESERVATION_FILE} /> <span class="note">({$MaxUploadSize}
                    MB {translate key=Maximum})</span>
            </label>
        </li>
	{/if}
	{if $RemindersEnabled}
        <li>
            <label>{translate key=SendReminder}</label> <br/>

            <div id="reminderOptionsStart">
                <input type="checkbox" class="reminderEnabled" {formname key=START_REMINDER_ENABLED}/>
                <input type="text" size="3" maxlength="3" value="15" class="reminderTime textbox" {formname key=START_REMINDER_TIME}/>
                <select class="reminderInterval textbox" {formname key=START_REMINDER_INTERVAL}>
                    <option value="{ReservationReminderInterval::Minutes}">{translate key=minutes}</option>
                    <option value="{ReservationReminderInterval::Hours}">{translate key=hours}</option>
                    <option value="{ReservationReminderInterval::Days}">{translate key=days}</option>
                </select>
                <span class="reminderLabel">{translate key=ReminderBeforeStart}</span>
            </div>
            <div id="reminderOptionsEnd">
                <input type="checkbox" class="reminderEnabled" {formname key=END_REMINDER_ENABLED}/>
                <input type="text" size="3" maxlength="3" value="15" class="reminderTime textbox" {formname key=END_REMINDER_TIME}/>
                <select class="reminderInterval textbox" {formname key=END_REMINDER_INTERVAL}>
					<option value="{ReservationReminderInterval::Minutes}">{translate key=minutes}</option>
					<option value="{ReservationReminderInterval::Hours}">{translate key=hours}</option>
					<option value="{ReservationReminderInterval::Days}">{translate key=days}</option>
                </select>
                <span class="reminderLabel">{translate key=ReminderBeforeEnd}</span>
            </div>
        </li>
	{/if}
    </ul>
</div>

{if $ShowUserDetails && $ShowParticipation}
{include file="Reservation/participation.tpl"}
	{else}
{include file="Reservation/private-participation.tpl"}
{/if}

<div style="clear:both;">&nbsp;</div>

{if $Attributes|count > 0}
<div class="customAttributes">
    <h3>{translate key=AdditionalAttributes}</h3>
    <ul>
		{foreach from=$Attributes item=attribute}
            <li class="customAttribute">
				{control type="AttributeControl" attribute=$attribute}
            </li>
		{/foreach}
    </ul>
</div>
<div style="clear:both;">&nbsp;</div>
{/if}

<input type="hidden" {formname key=reservation_id} value="{$ReservationId}"/>
<input type="hidden" {formname key=reference_number} value="{$ReferenceNumber}"/>
<input type="hidden" {formname key=reservation_action} value="{$ReservationAction}"/>
<input type="hidden" {formname key=SERIES_UPDATE_SCOPE} id="hdnSeriesUpdateScope"
       value="{SeriesUpdateScope::FullSeries}"/>

<div style="float:left;">
{block name="deleteButtons"}
    &nbsp;
{/block}
</div>
<div style="float:right;">
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

{if $UploadsEnabled}
	{block name='attachments'}
	{/block}
{/if}
</form>

<div id="dialogAddResources" class="dialog" title="{translate key=AddResources}" style="display:none;">

{foreach from=$AvailableResources item=resource}
	{if $resource->CanAccess}
		{assign var='checked' value=''}
		{if is_array($AdditionalResourceIds) && in_array($resource->Id, $AdditionalResourceIds)}
			{assign var='checked' value='checked="checked"'}
		{/if}
		{if $resource->Id == $ResourceId}
			{assign var='checked' value='checked="checked"'}
		{/if}

        <p>
            <input type="checkbox" {formname key=ADDITIONAL_RESOURCES multi=true} id="additionalResource{$resource->Id}"
                   value="{$resource->Id}" {$checked} />
            <label for="additionalResource{$resource->Id}">{$resource->Name}</label>
        </p>
	{/if}
{/foreach}
    <br/>
    <button id="btnConfirmAddResources" class="button">{translate key='Done'}</button>
    <button id="btnClearAddResources" class="button">{translate key='Cancel'}</button>
</div>

<div id="dialogAddAccessories" class="dialog" title="{translate key=AddAccessories}" style="display:none;">
    <table width="100%">
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
    <br/>
    <button id="btnConfirmAddAccessories" class="button">{translate key='Done'}</button>
    <button id="btnCancelAddAccessories" class="button">{translate key='Cancel'}</button>
</div>

<div id="dialogSave" style="display:none;">
    <div id="creatingNotification" style="position:relative; top:170px;">
	{block name="ajaxMessage"}
		{translate key=CreatingReservation}...<br/>
	{/block}
	{html_image src="reservation_submitting.gif" alt="Creating reservation"}
    </div>
    <div id="result" style="display:none;"></div>
</div>
<!-- reservationbox ends -->
</div>

{control type="DatePickerSetupControl" ControlId="BeginDate" AltId="formattedBeginDate" DefaultDate=$StartDate}
{control type="DatePickerSetupControl" ControlId="EndDate" AltId="formattedEndDate" DefaultDate=$EndDate}
{control type="DatePickerSetupControl" ControlId="EndRepeat" AltId="formattedEndRepeat" DefaultDate=$RepeatTerminationDate}

<script type="text/javascript" src="scripts/js/jquery.textarea-expander.js"></script>
<script type="text/javascript" src="scripts/js/jquery.qtip.min.js"></script>
<script type="text/javascript" src="scripts/js/jquery.form-3.09.min.js"></script>
<script type="text/javascript" src="scripts/resourcePopup.js"></script>
<script type="text/javascript" src="scripts/date-helper.js"></script>
<script type="text/javascript" src="scripts/recurrence.js"></script>
<script type="text/javascript" src="scripts/reservation.js"></script>
<script type="text/javascript" src="scripts/autocomplete.js"></script>
<script type="text/javascript" src="scripts/force-numeric.js"></script>
<script type="text/javascript" src="scripts/reservation-reminder.js"></script>

<script type="text/javascript">

    $(document).ready(function ()
    {
        var scopeOptions = {
            instance:'{SeriesUpdateScope::ThisInstance}',
            full:'{SeriesUpdateScope::FullSeries}',
            future:'{SeriesUpdateScope::FutureInstances}'
        };

        var reservationOpts = {
            additionalResourceElementId:'{FormKeys::ADDITIONAL_RESOURCES}',
            accessoryListInputId:'{FormKeys::ACCESSORY_LIST}[]',
            returnUrl:'{$ReturnUrl}',
            scopeOpts:scopeOptions,
            createUrl:'ajax/reservation_save.php',
            updateUrl:'ajax/reservation_update.php',
            deleteUrl:'ajax/reservation_delete.php',
            userAutocompleteUrl:"ajax/autocomplete.php?type={AutoCompleteType::User}",
            changeUserAutocompleteUrl:"ajax/autocomplete.php?type={AutoCompleteType::MyUsers}"
        };

        var recurOpts = {
            repeatType:'{$RepeatType}',
            repeatInterval:'{$RepeatInterval}',
            repeatMonthlyType:'{$RepeatMonthlyType}',
            repeatWeekdays:[{foreach from=$RepeatWeekdays item=day}{$day},{/foreach}]
        };

        var reminderOpts = {
            reminderTimeStart:'{$ReminderTimeStart}',
            reminderTimeEnd:'{$ReminderTimeEnd}',
            reminderIntervalStart:'{$ReminderIntervalStart}',
            reminderIntervalEnd:'{$ReminderIntervalEnd}'
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

        var ajaxOptions = {
            target:'#result', // target element(s) to be updated with server response
            beforeSubmit:reservation.preSubmit, // pre-submit callback
            success:reservation.showResponse  // post-submit callback
        };

        $('#reservationForm').submit(function ()
        {
            $(this).ajaxSubmit(ajaxOptions);
            return false;
        });
        $('#description').TextAreaExpander();


    });
</script>

{include file='globalfooter.tpl'}