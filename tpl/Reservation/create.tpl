{*
Copyright 2011-2012 Nick Korbel

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
			<span id="userName">{$ReservationUserName}</span> <input id="userId" type="hidden" {formname key=USER_ID} value="{$UserId}"/>
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
							<input type="hidden" {formname key=SCHEDULE_ID} value="{$ScheduleId}"/>
						</div>
						{if $ShowAdditionalResources}
							<a href="#" onclick="$('#dialogAddResources').dialog('open'); return false;">({translate key=MoreResources})</a>
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
				<input type="hidden" id="formattedBeginDate" {formname key=BEGIN_DATE} value="{formatdate date=$StartDate key=system}"/>
				<select id="BeginPeriod" {formname key=BEGIN_PERIOD} class="pulldown" style="width:150px">
				{foreach from=$Periods item=period}
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
				<input type="hidden" id="formattedEndDate" {formname key=END_DATE} value="{formatdate date=$EndDate key=system}"/>
				<select id="EndPeriod" {formname key=END_PERIOD} class="pulldown" style="width:150px">
				{foreach from=$Periods item=period}
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
			<li>
				<div id="repeatDiv">
					<label>{translate key="RepeatPrompt"}</label>
					<select id="repeatOptions" {formname key=repeat_options} class="pulldown" style="width:250px">
					{foreach from=$RepeatOptions key=k item=v}
						<option value="{$k}">{translate key=$v['key']}</option>
					{/foreach}
					</select>

					<div id="repeatEveryDiv" style="display:none;" class="days weeks months years">
						<label>{translate key="RepeatEveryPrompt"}</label>
						<select id="repeatInterval" {formname key=repeat_every} class="pulldown" style="width:55px">
						{html_options values=$RepeatEveryOptions output=$RepeatEveryOptions}
						</select>
						<span class="days">{translate key=$RepeatOptions['daily']['everyKey']}</span>
						<span class="weeks">{translate key=$RepeatOptions['weekly']['everyKey']}</span>
						<span class="months">{translate key=$RepeatOptions['monthly']['everyKey']}</span>
						<span class="years">{translate key=$RepeatOptions['yearly']['everyKey']}</span>
					</div>
					<div id="repeatOnWeeklyDiv" style="display:none;" class="weeks">
						<label>{translate key="RepeatDaysPrompt"}</label>
						<input type="checkbox"
							   id="repeatDay0" {formname key=repeat_sunday} /><label for="repeatDay0">{translate key="DaySundaySingle"}</label>
						<input type="checkbox"
							   id="repeatDay1" {formname key=repeat_monday} /><label for="repeatDay1">{translate key="DayMondaySingle"}</label>
						<input type="checkbox"
							   id="repeatDay2" {formname key=repeat_tuesday} /><label for="repeatDay2">{translate key="DayTuesdaySingle"}</label>
						<input type="checkbox"
							   id="repeatDay3" {formname key=repeat_wednesday} /><label for="repeatDay3">{translate key="DayWednesdaySingle"}</label>
						<input type="checkbox"
							   id="repeatDay4" {formname key=repeat_thursday} /><label for="repeatDay4">{translate key="DayThursdaySingle"}</label>
						<input type="checkbox"
							   id="repeatDay5" {formname key=repeat_friday} /><label for="repeatDay5">{translate key="DayFridaySingle"}</label>
						<input type="checkbox"
							   id="repeatDay6" {formname key=repeat_saturday} /><label for="repeatDay6">{translate key="DaySaturdaySingle"}</label>
					</div>
					<div id="repeatOnMonthlyDiv" style="display:none;" class="months">
						<input type="radio" {formname key=REPEAT_MONTHLY_TYPE} value="{RepeatMonthlyType::DayOfMonth}"
							   id="repeatMonthDay" checked="checked"/>
						<label for="repeatMonthDay">{translate key="repeatDayOfMonth"}</label>
						<input type="radio" {formname key=REPEAT_MONTHLY_TYPE} value="{RepeatMonthlyType::DayOfWeek}"
							   id="repeatMonthWeek"/>
						<label for="repeatMonthWeek">{translate key="repeatDayOfWeek"}</label>
					</div>
					<div id="repeatUntilDiv" style="display:none;">
					{translate key="RepeatUntilPrompt"}
						<input type="text" id="EndRepeat" class="dateinput" value="{formatdate date=$RepeatTerminationDate}"/>
						<input type="hidden" id="formattedEndRepeat" {formname key=end_repeat_date} value="{formatdate date=$RepeatTerminationDate key=system}" />
					</div>
				</div>
			</li>
			<li class="rsv-req">
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
			<li>
				<label>{translate key=AttachFile}
						<input type="file" {formname key=RESERVATION_FILE} /> <span class="note">({$MaxUploadSize}MB {translate key=Maximum})</span>
					</label>
			</li>
		</ul>
	</div>

	{if $ShowUserDetails}
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
	<input type="hidden" {formname key=SERIES_UPDATE_SCOPE} id="hdnSeriesUpdateScope" value="{SeriesUpdateScope::FullSeries}"/>

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

	<div style="clear:both">&nbsp;</div>

	<div class="res-attachments">
	<span class="heading">{translate key=Attachments}</span>
	{if $Attachments|count > 0}
		<a href="#" class="remove" id="btnRemoveAttachment">({translate key="Remove"})</a><br/>
		{foreach from=$Attachments item=attachment}
			<a href="attachments/{Pages::RESERVATION_FILE}?{QueryStringKeys::ATTACHMENT_FILE_ID}={$attachment->FileId()}&{QueryStringKeys::REFERENCE_NUMBER}={$ReferenceNumber}" target="_blank">{$attachment->FileName()}</a>&nbsp;
		{/foreach}
	</div>
	{/if}
</form>

<div id="dialogAddResources" class="dialog" title="{translate key=AddResources}" style="display:none;">

{foreach from=$AvailableResources item=resource}
	{if $resource->CanAccess}
		{assign var='checked' value=''}
		{if is_array($AdditionalResourceIds) && in_array($resource->Id, $AdditionalResourceIds)}
			{assign var='checked' value='checked="checked"'}
		{/if}

		<p>
			<input type="checkbox" {formname key=ADDITIONAL_RESOURCES multi=true} id="additionalResource{$resource->Id}" value="{$resource->Id}" {$checked} />
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
					<input type="hidden" class="name" value="{$accessory->Name}" />
					<input type="hidden" class="id" value="{$accessory->Id}"}" />
					{if $accessory->QuantityAvailable == 1}
						<input type="checkbox" name="accessory{$accessory->Id}" value="1" size="3" />
					{else}
						<input type="text" name="accessory{$accessory->Id}" value="0" size="3" />
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
		<img src="{$Path}img/reservation_submitting.gif" alt="Creating reservation"/>
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
<script type="text/javascript" src="scripts/js/jquery.form-3.09.js"></script>
<script type="text/javascript" src="scripts/resourcePopup.js"></script>
<script type="text/javascript" src="scripts/reservation.js"></script>
<script type="text/javascript" src="scripts/autocomplete.js"></script>

<script type="text/javascript">

	$(document).ready(function() {
	var scopeOptions = {
		instance: '{SeriesUpdateScope::ThisInstance}',
		full: '{SeriesUpdateScope::FullSeries}',
		future: '{SeriesUpdateScope::FutureInstances}'
	};

	var reservationOpts = {
		additionalResourceElementId: '{FormKeys::ADDITIONAL_RESOURCES}',
		accessoryListInputId: '{FormKeys::ACCESSORY_LIST}[]',
		repeatType: '{$RepeatType}',
		repeatInterval: '{$RepeatInterval}',
		repeatMonthlyType: '{$RepeatMonthlyType}',
		repeatWeekdays: [{foreach from=$RepeatWeekdays item=day}{$day},{/foreach}],
		returnUrl: '{$ReturnUrl}',
		scopeOpts: scopeOptions,
		createUrl: 'ajax/reservation_save.php',
		updateUrl: 'ajax/reservation_update.php',
		deleteUrl: 'ajax/reservation_delete.php',
		userAutocompleteUrl: "ajax/autocomplete.php?type={AutoCompleteType::User}",
		changeUserAutocompleteUrl: "ajax/autocomplete.php?type={AutoCompleteType::MyUsers}"
	};

	$('#description').TextAreaExpander();

	var reservation = new Reservation(reservationOpts);
	reservation.init('{$UserId}');

	{foreach from=$Participants item=user}
		reservation.addParticipant("{$user->FullName|escape:'javascript'}", "{$user->UserId|escape:'javascript'}");
	{/foreach}

	{foreach from=$Invitees item=user}
		reservation.addInvitee("{$user->FullName|escape:'javascript'}", '{$user->UserId}');
	{/foreach}

	{foreach from=$Accessories item=accessory}
		reservation.addAccessory('{$accessory->AccessoryId}', '{$accessory->QuantityReserved}', "{$accessory->Name|escape:'javascript'}");
	{/foreach}

	var options = {
		target: '#result',   // target element(s) to be updated with server response
		beforeSubmit: reservation.preSubmit,  // pre-submit callback
		success: reservation.showResponse  // post-submit callback
	};

	$('#reservationForm').submit(function() {
		$(this).ajaxSubmit(options);
		return false;
	});


	});
</script>

{include file='globalfooter.tpl'}