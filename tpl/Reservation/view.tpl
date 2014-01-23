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
{include file='globalheader.tpl' TitleKey='ViewReservationHeading' TitleArgs=$ReferenceNumber cssFiles='css/reservation.css'}
<div id="reservationbox" class="readonly">
	<div id="reservationFormDiv">
		<div class="reservationHeader">
			<h3>{translate key="ViewReservationHeading" args=$ReferenceNumber}</h3>
		</div>
		<div id="reservationDetails">
			<ul class="no-style">
				<li>
					<label>{translate key='User'}</label>
				{if $ShowUserDetails}
					{$ReservationUserName}
				{else}
					{translate key=Private}
				{/if}
				</li>
				<li>
					<label>{translate key='Resources'}</label> {$ResourceName}
					{foreach from=$AvailableResources item=resource}
						{if is_array($AdditionalResourceIds) && in_array($resource->Id, $AdditionalResourceIds)}
							,{$resource->Name}
						{/if}
					{/foreach}
				</li>
				<li>
					<label>{translate key='Accessories'}</label>
					{foreach from=$Accessories item=accessory name=accessoryLoop}
						({$accessory->QuantityReserved})
						{if $smarty.foreach.accessoryLoop.last}
							{$accessory->Name}
						{else}
							{$accessory->Name},
						{/if}
					{/foreach}
				</li>
				<li class="section">
					<label>{translate key='BeginDate'}</label> {formatdate date=$StartDate}
					<input type="hidden" id="formattedBeginDate" value="{formatdate date=$StartDate key=system}"/>
					{foreach from=$StartPeriods item=period}
						{if $period eq $SelectedStart}
							{$period->Label()} <br/>
							<input type="hidden" id="BeginPeriod" value="{$period->Begin()}"/>
						{/if}
					{/foreach}
				</li>
				<li>
					<label>{translate key='EndDate'}</label> {formatdate date=$EndDate}
					<input type="hidden" id="formattedEndDate" value="{formatdate date=$EndDate key=system}" />
					{foreach from=$EndPeriods item=period}
						{if $period eq $SelectedEnd}
							{$period->LabelEnd()} <br/>
							<input type="hidden" id="EndPeriod" value="{$period->End()}"/>
						{/if}
					{/foreach}
				</li>
				<li>
						<label>{translate key=ReservationLength}</label>

						<div class="durationText">
							<span id="durationDays">0</span> {translate key='days'},
							<span id="durationHours">0</span> {translate key='hours'}
						</div>
					</li>
				<li>
					<label>{translate key='RepeatPrompt'}</label> {translate key=$RepeatOptions[$RepeatType]['key']}
				{if $IsRecurring}
					<div class="repeat-details">
						<label>{translate key='RepeatEveryPrompt'}</label> {$RepeatInterval} {$RepeatOptions[$RepeatType]['everyKey']}
						{if $RepeatMonthlyType neq ''}
							({$RepeatMonthlyType})
						{/if}
						{if count($RepeatWeekdays) gt 0}
							<br/><label>{translate key='RepeatDaysPrompt'}</label> {foreach from=$RepeatWeekdays item=day}{translate key=$DayNames[$day]} {/foreach}
						{/if}
						<br/><label>{translate key='RepeatUntilPrompt'}</label> {formatdate date=$RepeatTerminationDate}
					</div>
				{/if}
				{if $ShowReservationDetails}
					</li>
					<li class="section">
						<label>{translate key='ReservationTitle'}</label>
						{if $ReservationTitle neq ''}
							{$ReservationTitle}
						{else}
							<span class="no-data">{translate key='None'}</span>
						{/if}
					</li>

					<li>
						<label>{translate key='ReservationDescription'}</label>
						{if $Description neq ''}
							<br/>{$Description|nl2br}
						{else}
							<span class="no-data">{translate key='None'}</span>
						{/if}
					</li>
				{/if}
		</div>

		{if $ShowParticipation}
		<div id="reservationParticipation">
			<ul class="no-style">
				{if $ShowUserDetails}
					<li class="section">
						<label>{translate key='ParticipantList'}</label>
						{foreach from=$Participants item=participant}
							<br/>{$participant->FullName}
						{foreachelse}
							<span class="no-data">{translate key='None'}</span>
						{/foreach}
					</li>

					<li>
						<label>{translate key='InvitationList'}</label>
						{foreach from=$Invitees item=invitee}
							<br/>{$invitee->FullName}
						{foreachelse}
							<span class="no-data">{translate key='None'}</span>
						{/foreach}
					</li>
				{/if}
				<li>
					{if $IAmParticipating}
						{translate key=CancelParticipation}?
						</li>
						<li>
						{if $IsRecurring}
							<button value="{InvitationAction::CancelAll}" class="button participationAction">{html_image src="user-minus.png"} {translate key=AllInstances}</button>
							<button value="{InvitationAction::CancelInstance}" class="button participationAction">{html_image src="user-minus.png"} {translate key=ThisInstance}</button>
						{/if}
						<button value="{InvitationAction::CancelInstance}" class="button participationAction">{html_image src="user-minus.png"} {translate key=CancelParticipation}</button>
					{/if}

					{if $IAmInvited}
						{translate key=Attending}?
						</li>
						<li>
						<button value="{InvitationAction::Accept}" class="button participationAction">{html_image src="ticket-plus.png"} {translate key=Yes}</button>
						<button value="{InvitationAction::Decline}" class="button participationAction">{html_image src="ticket-minus.png"} {translate key=No}</button>
					{/if}
					{html_image id="indicator" src="admin-ajax-indicator.gif" style="display:none;"}
				</li>
			</ul>
		</div>
		{/if}
		<div style="clear:both;">&nbsp;</div>

		{if $ShowReservationDetails}
			{if $Attributes|count > 0}
			<div class="customAttributes">
				<span>{translate key=AdditionalAttributes}</span>
				<ul>
				{foreach from=$Attributes item=attribute}
					<li class="customAttribute">
						{control type="AttributeControl" attribute=$attribute readonly=true}
					</li>
				{/foreach}
				</ul>
			</div>
			<div style="clear:both;">&nbsp;</div>
			{/if}
		{/if}

		{if $ShowReservationDetails}
			<div style="float:left;">
				{block name="deleteButtons"}
					<a href="{$Path}export/{Pages::CALENDAR_EXPORT}?{QueryStringKeys::REFERENCE_NUMBER}={$ReferenceNumber}">
					{html_image src="calendar-plus.png"}
					{translate key=AddToOutlook}</a>
				{/block}
			</div>
		{/if}
		<div style="float:right;">
			{block name="submitButtons"}
				&nbsp
			{/block}
			<button type="button" class="button" onclick="window.location='{$ReturnUrl}'">
				<img src="img/slash.png"/>
				{translate key='Close'}
			</button>
					<button type="button" class="button">
				<img src="img/printer.png" />
				{translate key='Print'}
			</button>
		</div>

		{if $ShowReservationDetails}
			{if $Attachments|count > 0}
				<div style="clear:both">&nbsp;</div>
				<div class="res-attachments">
				<span class="heading">{translate key=Attachments}</span>
					{foreach from=$Attachments item=attachment}
						<a href="attachments/{Pages::RESERVATION_FILE}?{QueryStringKeys::ATTACHMENT_FILE_ID}={$attachment->FileId()}&{QueryStringKeys::REFERENCE_NUMBER}={$ReferenceNumber}" target="_blank">{$attachment->FileName()}</a>&nbsp;
					{/foreach}
				</div>
			{/if}
		{/if}
		<input type="hidden" id="referenceNumber" {formname key=reference_number} value="{$ReferenceNumber}"/>
	</div>
</div>

<div id="dialogSave" style="display:none;">
	<div id="creatingNotification" style="position:relative; top:170px;">
	{block name="ajaxMessage"}
		{translate key=UpdatingReservation}...<br/>
	{/block}
		<img src="{$Path}img/reservation_submitting.gif" alt="Creating reservation"/>
	</div>
	<div id="result" style="display:none;"></div>
</div>

<div style="display: none">
	<form id="reservationForm" method="post" enctype="application/x-www-form-urlencoded">
		<input type="hidden" {formname key=reservation_id} value="{$ReservationId}"/>
		<input type="hidden" {formname key=reference_number} value="{$ReferenceNumber}"/>
		<input type="hidden" {formname key=reservation_action} value="{$ReservationAction}"/>
		<input type="hidden" {formname key=SERIES_UPDATE_SCOPE} id="hdnSeriesUpdateScope" value="{SeriesUpdateScope::FullSeries}"/>
	</form>
</div>
{jsfile src="participation.js"}
{jsfile src="approval.js"}
{jsfile src="js/jquery.form-3.09.min.js"}
{jsfile src="js/moment.min.js"}
{jsfile src="date-helper.js"}
{jsfile src="reservation.js"}
{jsfile src="autocomplete.js"}

	<script type="text/javascript">

	$(document).ready(function() {

		var participationOptions = {
			responseType: 'json'
		};

		var participation = new Participation(participationOptions);
		participation.initReservation();

		var approvalOptions = {
			responseType: 'json',
			url: "{$Path}ajax/reservation_approve.php"
		};

		var approval = new Approval(approvalOptions);
		approval.initReservation();

		var scopeOptions = {
				instance: '{SeriesUpdateScope::ThisInstance}',
				full: '{SeriesUpdateScope::FullSeries}',
				future: '{SeriesUpdateScope::FutureInstances}'
			};

		var reservationOpts = {
			returnUrl: '{$ReturnUrl}',
			scopeOpts: scopeOptions,
			deleteUrl: 'ajax/reservation_delete.php',
			userAutocompleteUrl: "ajax/autocomplete.php?type={AutoCompleteType::User}",
			changeUserAutocompleteUrl: "ajax/autocomplete.php?type={AutoCompleteType::MyUsers}"
		};
		var reservation = new Reservation(reservationOpts);
		reservation.init('{$UserId}');

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