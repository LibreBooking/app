{include file='header.tpl'}

<div style="text-align:center; padding-bottom:15px;">
	Schedule: <select name="type_id" class="schedule_list">
	    {object_html_options options=$Schedules key="GetId" label="GetName"}
	</select>
</div>

<div style="text-align:center; font-size:12pt;">
	{assign var=FirstDate value=$DisplayDates->GetBegin()}
	{assign var=LastDate value=$DisplayDates->GetEnd()}
	<a href="#">Prev</a> {$FirstDate->Format("m-d-Y")} - {$LastDate->Format("m-d-Y")} <a href="#">Next</a>
</div>

<div style="height:10px">&nbsp;</div>

{foreach from=$BoundDates item=date}
<table class="reservations" border="1" cellpadding="0">
	<tr>
		<td class="resdate">{$date->Format('Y-m-d')}</td>
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
					<a href="#" onclick="CreateReservation({$resource->Id}">{$resource->Name}</a>
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
{literal}

<script type="text/javascript">
  $(document).ready(function(){

	$('.reserved').each(function(){ 
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

  });
  </script>
{/literal}

{include file='footer.tpl'}