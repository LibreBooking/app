{include file='header.tpl'}

<style type="text/css">
	@import url({$Path}css/schedule.css);
</style>

<table>
	<tr>
		<td style="vertical-align:top; width:50%">
			<div class="schedule_title">
			<span>{$ScheduleName}</span>
			<ul class="schedule_drop">
				<li><a href="javascript: ShowScheduleList();">img: Down arrow</a></li>
				<ul style="display:none;" id="schedule_list">
				{foreach from=$Schedules item=schedule}
					<li><a href="javascript: ChangeSchedule({$schedule->GetId()});">{$schedule->GetName()}</a></li>
				{/foreach}
				</ul>
			</ul>
			</div>
			<div class="schedule_dates">
				{assign var=FirstDate value=$DisplayDates->GetBegin()}
				{assign var=LastDate value=$DisplayDates->GetEnd()}
				<a href="#" onclick="javascript: ChangeDate({formatdate date=$PreviousDate format="Y, m, d"});">img: Prev arrow</a> 
				{formatdate date=$FirstDate} - {formatdate date=$LastDate}
				<a href="#" onclick="javascript: ChangeDate({formatdate date=$NextDate format="Y, m, d"});">img: Next arrow</a>
			</div>
		</td>
		<td>
			<div type="text" id="datepicker"></div>
		</td>
	</tr>
</table>

<div style="height:10px">&nbsp;</div>

{foreach from=$BoundDates item=date}
<table class="reservations" border="1" cellpadding="0">
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

<script type="text/javascript" src="scripts/js/jquery.qtip-1.0.0-rc3.min.js"></script>
<script type="text/javascript" src="scripts/schedule.js"></script>
 
{control type="DatePickerSetupControl"
  	ControlId='datepicker' 
  	DefaultDate=$FirstDate 
  	NumberOfMonths='3' 
  	ShowButtonPanel='true' 
  	OnSelect='dpDateChanged'
  	FirstDay=$FirstWeekday}

{include file='footer.tpl'}