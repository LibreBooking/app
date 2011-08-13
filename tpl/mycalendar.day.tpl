{include file='globalheader.tpl' cssFiles='css/calendar.css,css/jquery.qtip.css'}

<div class="calendarHeading">

	<div style="float:left;">
		<a href="{$PrevLink}"><img src="img/arrow_large_left.png" alt="Back" /></a>
		{$DayName}, {$MonthName} {$DisplayDate->Day()}, {$DisplayDate->Year()}
		<a href="{$NextLink}"><img src="img/arrow_large_right.png" alt="Forward" /></a>
	</div>

	<div style="float:right;">
		<a href="{CalendarUrl::Create($Today, CalendarTypes::Day)}" alt="Today" title="Today">{html_image src="calendar-day.png"}</a>
		<a href="{CalendarUrl::Create($DisplayDate, CalendarTypes::Month)}" alt="View Month" title="View Month">{html_image src="calendar-select-month.png"}</a>
	</div>

	<div class="clear">&nbsp;</div>
</div>

<div>
	{foreach from=$Calendar->Reservations() item=reservation}
		<div style='border-bottom: solid 1px #ededed;'>
			<h3>
				<a class="reservation" refNum="{$reservation->ReferenceNumber}" href="{Pages::RESERVATION}?{QueryStringKeys::REFERENCE_NUMBER}={$reservation->ReferenceNumber}">
					{formatdate key='period_time' date=$Calendar->GetAdjustedStartDate($reservation)} {$reservation->ResourceName}
				</a>
			</h3>
			<h5>{$reservation->Title}</h5>
			<h5>{$reservation->Description}</h5>

			{if $reservation->Invited}
				<button value="{InvitationAction::Accept}" class="button participationAction">{html_image src="ticket-plus.png"} {translate key="Accept"}</button>
				<button value="{InvitationAction::Decline}" class="button participationAction">{html_image src="ticket-minus.png"} {translate key="Decline"}</button>
			{/if}
		</div>
	{foreachelse}
		<div class="noresults">No reservations</div>
	{/foreach}
</div>

<script type="text/javascript" src="scripts/js/jquery.qtip.min.js"></script>
<script type="text/javascript" src="scripts/reservationPopup.js"></script>
<script type="text/javascript" src="scripts/calendar.js"></script>
<script type="text/javascript">
$(document).ready(function() {

	var calendar = new Calendar();
	calendar.init();

});
</script>

{include file='globalfooter.tpl'}