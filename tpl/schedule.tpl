{include file='globalheader.tpl' cssFiles='css/schedule.css,css/jquery.qtip.css'}

<div>
	<div class="schedule_title">
	<span>{$ScheduleName}</span>
	{if $Schedules|@count gt 0}
	<ul class="schedule_drop">
		<li><a href="#" id="show_schedule">{html_image src="down_sm_blue.png" alt="Change Schedule"}</a></li>
		<ul style="display:none;" id="schedule_list">
		{foreach from=$Schedules item=schedule}
			<li><a href="#" onclick="ChangeSchedule({$schedule->GetId()}); return false;">{$schedule->GetName()}</a></li>
		{/foreach}
		</ul>
	</ul>
	{/if}
	<a href="#" id="calendar_toggle">
		{html_image src="calendar.png" altKey="ShowHideNavigation"}
		
	</a>
	</div>
	
	<div class="schedule_dates">
		{assign var=FirstDate value=$DisplayDates->GetBegin()}
		{assign var=LastDate value=$DisplayDates->GetEnd()}
		<a href="#" onclick="ChangeDate({formatdate date=$PreviousDate format="Y, m, d"}); return false;"><img src="img/arrow_large_left.png" alt="Back" /></a> 
		{formatdate date=$FirstDate} - {formatdate date=$LastDate}
		<a href="#" onclick="ChangeDate({formatdate date=$NextDate format="Y, m, d"}); return false;"><img src="img/arrow_large_right.png" alt="Forward" /></a>
	</div>
</div>

<div type="text" id="datepicker" style="display:none;"></div>

<div style="height:10px">&nbsp;</div>

{assign var=TodaysDate value=Date::Now()}
{foreach from=$BoundDates item=date}
<table class="reservations" border="1" cellpadding="0" width="100%">
	{if $TodaysDate->DateEquals($date) eq true}
		<tr class="today">
		{else}
		<tr>
		{/if}
		<td class="resdate">{formatdate date=$date key="schedule_daily"}</td>
		{foreach from=$Periods item=period}
			<td class="reslabel">{$period}</td>
		{/foreach}
	</tr>
	{foreach from=$Resources item=resource name=resource_loop}
		{assign var=resourceId value=$resource->Id}
		{assign var=slots value=$DailyLayout->GetLayout($date, $resourceId)}
		{assign var=href value="{Pages::RESERVATION}?rid={$resource->Id}&sid={$ScheduleId}&rd={formatdate date=$date key="url"}"}
		<tr>
			<td class="resourcename">
				{if $resource->CanAccess && $DailyLayout->IsDateReservable($date)}
					<a href="{$href}">{$resource->Name}</a>
				{else}
					{$resource->Name}
				{/if}
			</td>
			{foreach from=$slots item=slot}
				{control type="ScheduleReservationControl" Slot=$slot AccessAllowed=$resource->CanAccess Href="$href"}				
			{/foreach}
		</tr>
	{/foreach}
</table>
{/foreach}

<script type="text/javascript" src="scripts/js/jquery.qtip.min.js"></script>
<script type="text/javascript" src="scripts/schedule.js"></script>

<script type="text/javascript">
$(document).ready(function() {

	var scheduleOpts = {
		reservationUrlTemplate: "{Pages::RESERVATION}?{QueryStringKeys::REFERENCE_NUMBER}=[referenceNumber]",
		summaryPopupUrl: "ajax/respopup.php"
	};

	var schedule = new Schedule(scheduleOpts);
	schedule.init(); 
});
</script>
 
{control type="DatePickerSetupControl"
  	ControlId='datepicker' 
  	DefaultDate=$FirstDate 
  	NumberOfMonths='3' 
  	ShowButtonPanel='true' 
  	OnSelect='dpDateChanged'
  	FirstDay=$FirstWeekday}

{include file='globalfooter.tpl'}