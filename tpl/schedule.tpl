{include file='header.tpl'}

{literal}
<script type="text/javascript">
  $(document).ready(function(){
    
    $(".clickres").click(function () { 
      $(this).addClass("clicked"); 
    });
    
    $(".clickres").hover(
	    function () {
	      $(this).addClass("hilite");
	    }, 
	    function () {
	      $(this).removeClass("hilite");
	    }
	);

  });
  </script>
{/literal}

<select name="type_id">
    {object_html_options options=$Schedules key="GetId" label="GetName"}
</select>

{foreach from=$BoundDates item=date}
<table id="reservations" border="1" cellpadding="0">
	<tr>
		<td style="width: 150px;">{$date->Format('Y-m-d')}</td>
		{foreach from=$Layout->GetLayout() item=period}
			<td style="padding-left:2px;">{$period->Label()}</td>
			<!-- pass format in? -->
		{/foreach}
	</tr>
	{foreach from=$Resources item=resource name=resource_loop}
		{assign var=resourceId value=$resource->Id}
		{assign var=slots value=$DailyLayout->GetLayout($date, $resourceId)}
		<tr>
			<td>
				{if $resource->CanAccess}
					<a href="#" onclick="CreateReservation({$resource->Id}">{$resource->Name}</a>
				{else}
					{$resource->Name}
				{/if}
			</td>
			{foreach from=$slots item=slot}
				<td colspan="{$slot->PeriodSpan()}">{control type="ScheduleReservationControl" Slot=$slot}</td>				
			{/foreach}
		</tr>
	{/foreach}
</table>
<br/>
{/foreach}


  

{include file='footer.tpl'}