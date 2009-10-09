{include file='header.tpl'}

<select name="type_id">
    {object_html_options options=$Schedules key="GetId" label="GetName"}
</select>

{foreach from=$BoundDates item=date}
<table style="border-collapse:collapse; border: solid black 1px; width:100%" border="1">
	<tr>
		<td style="width: 150px;">{$date->Format('Y-m-d')}</td>
		{foreach from=$Layout->GetLayout() item=period}
			<td>{$period->Label()}</td>
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