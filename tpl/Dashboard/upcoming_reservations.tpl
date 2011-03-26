<div class="dashboard" id="upcomingReservationsDashboard">
	<div class="dashboardHeader">
		<a href="javascript:void(0);" title="{translate key='ShowHide'}">{translate key="UpcomingReservations"}</a> ({$Total})
	</div>
	<div class="dashboardContents">
		{assign var=colspan value="3"}
		{if $Total > 0}
		<table>
			<tr class="timespan">
				<td colspan="{$colspan}">{translate key="Today"} ({$TodaysReservations|count})</td>
			</tr>
			{foreach $TodaysReservations item=reservation}
			<tr class="reservation" id="{$reservation->ReferenceNumber}">
				<td>{formatdate date=$reservation->StartDate->ToTimezone($Timezone) key=dashboard}</td>
				<td>{formatdate date=$reservation->EndDate->ToTimezone($Timezone) key=dashboard}</td>
				<td>{$reservation->ResourceName}</td>
			</tr>
			{/foreach}
			
			<tr class="timespan">
				<td colspan="{$colspan}">{translate key="Tomorrow"} ({$TomorrowsReservations|count})</td>
			</tr>
			{foreach $TomorrowsReservations item=reservation}
			<tr class="reservation" id="{$reservation->ReferenceNumber}">
				<td>{formatdate date=$reservation->StartDate->ToTimezone($Timezone) key=dashboard}</td>
				<td>{formatdate date=$reservation->EndDate->ToTimezone($Timezone) key=dashboard}</td>
				<td>{$reservation->ResourceName}</td>
			</tr>
			{/foreach}
			
			<tr class="timespan">
				<td colspan="{$colspan}">{translate key="LaterThisWeek"} ({$ThisWeeksReservations|count})</td>
			</tr>
			{foreach $ThisWeeksReservations item=reservation}
			<tr class="reservation" id="{$reservation->ReferenceNumber}">
				<td>{formatdate date=$reservation->StartDate->ToTimezone($Timezone) key=dashboard}</td>
				<td>{formatdate date=$reservation->EndDate->ToTimezone($Timezone) key=dashboard}</td>
				<td>{$reservation->ResourceName}</td>
			</tr>
			{/foreach}
			
			<tr class="timespan">
				<td colspan="{$colspan}">{translate key="NextWeek"} ({$NextWeeksReservations|count})</td>
			</tr>
			{foreach $NextWeeksReservations item=reservation}
			<tr class="reservation" id="{$reservation->ReferenceNumber}">
				<td>{formatdate date=$reservation->StartDate->ToTimezone($Timezone) key=dashboard}</td>
				<td>{formatdate date=$reservation->EndDate->ToTimezone($Timezone) key=dashboard}</td>
				<td>{$reservation->ResourceName}</td>
			</tr>
			{/foreach}
		</table>
		{else}
			<div class="noresults">{translate key="NoUpcomingReservations"}</div>
		{/if}
	</div>
</div>