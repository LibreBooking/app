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
{include file='globalheader.tpl' TitleKey='ViewReservationHeading' TitleArgs=$ReferenceNumber cssFiles='css/reservation.css'}
<div id="reservationbox" class="readonly">
	<div id="reservationForm">
		<div class="reservationHeader">
			<h3>{translate key="ViewReservationHeading" args=$ReferenceNumber}</h3>
		</div>
		<div id="reservationDetails">
			<ul class="no-style">
				<li>
					<label>{translate key='User'}</label>
				{if $ShowUserDetails}
					{$UserName}
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
				{foreach from=$Periods item=period}
					{if $period eq $SelectedStart}
						{$period->Label()} <br/>
					{/if}
				{/foreach}
				</li>
				<li>
					<label>{translate key='EndDate'}</label> {formatdate date=$EndDate}
				{foreach from=$Periods item=period}
					{if $period eq $SelectedEnd}
						{$period->LabelEnd()} <br/>
					{/if}
				{/foreach}
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
				</li>
				<li class="section">
					<label>{translate key='ReservationTitle'}</label>
				{if $ReservationTitle neq ''}{$ReservationTitle}
					{else}<span class="no-data">{translate key='None'}</span>
				{/if}
				</li>

				<li>
					<label>{translate key='ReservationDescription'}</label>
				{if $Description neq ''}<br/>{$Description|nl2br}
					{else}<span class="no-data">{translate key='None'}</span>
				{/if}
				</li>
		</div>

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
		<div style="clear:both;">&nbsp;</div>

		<div style="float:left;">
			{block name="deleteButtons"}
				<a href="{$Path}export/{Pages::CALENDAR_EXPORT}?{QueryStringKeys::REFERENCE_NUMBER}={$ReferenceNumber}">
				{html_image src="calendar-plus.png"}
				{translate key=AddToOutlook}</a>
			{/block}
		</div>
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
		<input type="hidden" id="referenceNumber" {formname key=reference_number} value="{$ReferenceNumber}"/>
	</div>
</div>
	<script type="text/javascript" src="scripts/participation.js"></script>
	<script type="text/javascript" src="scripts/approval.js"></script>
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
	});

	</script>
{include file='globalfooter.tpl'}