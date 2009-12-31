{include file='header.tpl'}

{literal}
<style type="text/css">
.ui-datepicker
{
	margin-left: auto; margin-right: auto;
}

.schedule_drop
{
	list-style: none;
	margin: 0;
	padding: 0;
	display: inline-block;
}

.schedule_drop ul
{
	display: block;
	list-style: none;
	position:absolute;
	padding: 0;
	margin: 0;
	width: 125px;
	border: solid 1px black;
	background-color: white;
}

.schedule_drop ul li
{
	font-size: 10pt;
	padding: 4px;
	text-align: left;
}

.schedule_drop a
{
	text-decoration: none;
}

.schedule_drop ul li a
{
	color: #666;
	width: 125px;
}

.schedule_drop ul li a:hover
{
	color: #000;
}

.schedule_title
{
	text-align: center; 
	padding-bottom: 10px;
}

.schedule_title span
{
	font-size:18pt;
}

.schedule_dates 
{
	text-align: center; 
	font-size: 14pt; 
	padding-bottom: 10px;
}
</style>
{/literal}

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
				<a href="#" onclick="javascript: ChangeDate({$PreviousDate->Year()}, {$PreviousDate->Month()}, {$PreviousDate->Day()});">img: Prev arrow</a> 
				{$FirstDate->Format("m-d-Y")} - {$LastDate->Format("m-d-Y")}
				<a href="#" onclick="javascript: ChangeDate({$NextDate->Year()}, {$NextDate->Month()}, {$NextDate->Day()});">img: Next arrow</a>
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
		<td class="resdate">{$date->Format('l, Y-m-d')}</td>
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
					<a href="#" onclick="CreateReservation({$resource->Id});">{$resource->Name}</a>
				{else}
					{$resource->Name}
				{/if}
			</td>
			{foreach from=$slots item=slot}
				{control type="ScheduleReservationControl" Slot=$slot AccessAllowed=$resource->CanAccess}				
			{/foreach}
		</tr>
	{/foreach}
</table>
<br/>
{/foreach}

<script type="text/javascript" src="scripts/js/jquery.qtip-1.0.0-rc3.min.js"></script>

<script type="text/javascript">
{literal}
  $(document).ready(function() {

	$('.reserved').each(function() { 
		var resid = $(this).attr('id');
		
		$(this).qtip({
		   show: { delay:700 },
		   hide: 'mouseout',
		   position: { corner: { target: 'topLeft', tooltip: 'bottomLeft'}, adjust: {screen:true, y:-5} } ,
		   style: { padding: 10, name: 'cream' },
		   content: 
		   {
		      url: 'respopup.php',
		      data: { id: resid },
		      method: 'get'
	   	  }
		});
	});
	
	$('.clickres')
    	.mousedown(
    		function () { $(this).addClass('clicked'); }
    	)
    	.mouseup(
    		function () { $(this).removeClass('clicked'); }
   	);
    
	$('.clickres').hover(
	    function () { $(this).addClass('hilite'); }, 
	    function () { $(this).removeClass('hilite'); }
	);
	
	$("div:not(#schedule_list)").click(function () {
	 	$("#schedule_list").hide();
	 });

  });
 
  function ShowScheduleList()
  {
  	$("#schedule_list").toggle();
  }
  
  function dpDateChanged(dateText, inst)
  {
  	ChangeDate(inst.selectedYear, inst.selectedMonth+1, inst.selectedDay);
  }
  
  function ChangeDate(year, month, day)
  {
  	RedirectToSelf("sd", /sd=\d{4}-\d{1,2}-\d{1,2}/i, "sd=" + year + "-" + month + "-" + day);
  }
  
  function ChangeSchedule(scheduleId)
  {
  	RedirectToSelf("sid", /sid=\d+/i, "sid=" + scheduleId);
  }
  
  function RedirectToSelf(queryStringParam, regexMatch, substitution)
  {
  	var url = window.location.href;
  	var newUrl = window.location.href;
  	
  	if (url.indexOf(queryStringParam + "=") != -1)
  	{
  	 	newUrl = url.replace(regexMatch, substitution);
  	}
  	else if (url.indexOf("?") != -1)
  	{
  		newUrl = url + "&" + substitution;
  	}
  	else
  	{
  		newUrl = url + "?" + substitution;
  	}
  	
  	window.location = newUrl;
  }
  
  {/literal}
  
  {include file='datepickersetup.tpl' 
  	ControlId='datepicker' 
  	DefaultDate=$FirstDate 
  	NumberOfMonths='3' 
  	ShowButtonPanel='true' 
  	OnSelect='dpDateChanged'}
  
</script>

{include file='footer.tpl'}