{include file='globalheader.tpl' DisplayWelcome='false' TitleKey='ViewReservationHeading' TitleArgs=$ReferenceNumber cssFiles='css/reservation.css'}
<div id="reservationbox" class="readonly">
	<div id="reservationForm">
		<div class="reservationHeader">
			<h3>{translate key="ViewReservationHeading" args=$ReferenceNumber}</h3>
		</div>
		<div id="reservationDetails">
			<ul class="no-style">
				<li>
					<label>{translate key='User'}</label> {$UserName}
				</li>
				<li>
					<label>{translate key='Resources'}</label> {$ResourceName}
				{foreach from=$AvailableResources item=resource}
					{if is_array($AdditionalResourceIds) && in_array($resource->Id(), $AdditionalResourceIds)}
						,{$resource->Name()}
					{/if}
				{/foreach}
				</li>
				<li class="section">
					<label>{translate key='Start'}</label> {formatdate date=$SelectedStart}
				{foreach from=$Periods item=period}
					{if $period->BeginDate()->Equals($SelectedStart)}
						{$period->Label()} <br/>
					{/if}
				{/foreach}
				</li>
				<li>
					<label>{translate key='End'}</label> {formatdate date=$SelectedEnd}
				{foreach from=$Periods item=period}
					{if $period->EndDate()->Equals($SelectedEnd)}
						{$period->Label()} <br/>
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
		<div>
			<input type="button" value="{translate key='Close'}" class="button" onclick="window.location='{$ReturnUrl}'"/>
			<input type="button" value="{translate key='Print'}" class="button"/>
			<input type="hidden" id="referenceNumber" {formname key=reference_number} value="{$ReferenceNumber}"/>
		</div>
	</div>

	<script type="text/javascript" src="scripts/participation.js"></script>
	<script type="text/javascript">

	$(document).ready(function() {

		var participationOptions = {
			responseType: 'json'
		};
			
		var participation = new Participation(participationOptions);
		participation.init();
	});

	</script>
{include file='globalfooter.tpl'}