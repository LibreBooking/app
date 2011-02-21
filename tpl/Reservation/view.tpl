{include file='globalheader.tpl' DisplayWelcome='false' TitleKey='ViewReservationHeading' TitleArgs=$ReferenceNumber}
<style type="text/css">
	@import url({$Path}css/reservation.css);
</style>
<a href="{$ReturnUrl}">&lt; {translate key="BackToCalendar"}</a><br/>
<div id="reservationbox" class="readonly">

	<div class="reservationHeader">
		<h3>{translate key="ViewReservationHeading" args=$ReferenceNumber}</h3>
	</div>
	<div>
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
				<label>{translate key='Start'}</label> {formatdate date=$StartDate}
				{foreach from=$Periods item=period}
					{if $period->Begin()->Equals($StartTime)}
						{$period->Label()} <br/>
					{/if}
				{/foreach}
			</li>
			<li>
				<label>{translate key='End'}</label> {formatdate date=$EndDate}
				{foreach from=$Periods item=period}
					{if $period->Begin()->Equals($EndTime)}
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
			
			<li class="section">
				<label>{translate key='ParticipantList'}</label>
				{foreach from=$ParticipantListOutput item=participant}
					{$participant}<br/>
				{foreachelse}
					<span class="no-data">{translate key='None'}</span>
				{/foreach}
			</li>
			
			<li>
				<label>{translate key='InvitationList'}</label>
				{foreach from=$InvitationListOutput item=invitee}
					{$invitee}<br/>
				{foreachelse}
					<span class="no-data">{translate key='None'}</span>
				{/foreach}
			</li>
		</ul>
	</div>
	<br/>
	<input type="button" value="{translate key='Close'}" class="button" onclick="window.location='{$ReturnUrl}'"></input>
	<input type="button" value="{translate key='Print'}" class="button"></input>
</div>
{include file='globalfooter.tpl'}