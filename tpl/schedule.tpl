{include file='globalheader.tpl'}

<style type="text/css">
	@import url({$Path}css/schedule.css);
	@import url({$Path}css/jquery.qtip.css);
</style>

<table>
	<tr>
		<td style="vertical-align:top; width:50%">
			<div class="schedule_title">
			<span>{$ScheduleName}</span>
			<ul class="schedule_drop">
				<li><a href="#" onclick="ShowScheduleList(); return false;">img: Down arrow</a></li>
				<ul style="display:none;" id="schedule_list">
				{foreach from=$Schedules item=schedule}
					<li><a href="#" onclick="ChangeSchedule({$schedule->GetId()}); return false;">{$schedule->GetName()}</a></li>
				{/foreach}
				</ul>
			</ul>
			</div>
			<div class="schedule_dates">
				{assign var=FirstDate value=$DisplayDates->GetBegin()}
				{assign var=LastDate value=$DisplayDates->GetEnd()}
				<a href="#" onclick="ChangeDate({formatdate date=$PreviousDate format="Y, m, d"}); return false;">img: Prev arrow</a> 
				{formatdate date=$FirstDate} - {formatdate date=$LastDate}
				<a href="#" onclick="ChangeDate({formatdate date=$NextDate format="Y, m, d"}); return false;">img: Next arrow</a>
			</div>
		</td>
		<td>
			<div type="text" id="datepicker"></div>
		</td>
	</tr>
</table>

<div style="height:10px">&nbsp;</div>

{foreach from=$BoundDates item=date}
<table class="reservations" border="1" cellpadding="0" width="100%">
	<tr>
		<td class="resdate">{formatdate date=$date key="schedule_daily"}</td>
		{foreach from=$Periods item=period}
			<td class="reslabel">{$period->Label()}</td>
			<!-- pass format in? -->
		{/foreach}
	</tr>
	{foreach from=$Resources item=resource name=resource_loop}
		{assign var=resourceId value=$resource->Id}
		{assign var=slots value=$DailyLayout->GetLayout($date, $resourceId)}
		<tr>
			<td class="resourcename">
				{if $resource->CanAccess}
					<a href="reservation.php?rid={$resource->Id}&sid={$ScheduleId}&rd={formatdate date=$date key="url"}">{$resource->Name}</a>
				{else}
					{$resource->Name}
				{/if}
			</td>
			{foreach from=$slots item=slot}
				{control type="ScheduleReservationControl" Slot=$slot AccessAllowed=$resource->CanAccess SlotDate=$date}				
			{/foreach}
		</tr>
	{/foreach}
</table>
<br/>
{/foreach}

<script type="text/javascript" src="scripts/js/jquery.qtip.min.js"></script>
<script type="text/javascript" src="scripts/schedule.js"></script>

<script type="text/javascript">
$(document).ready(function() {

	var scheduleOpts = {
		reservationUrlTemplate: "{Pages::RESERVATION}?{QueryStringKeys::REFERENCE_NUMBER}=[referenceNumber]"
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