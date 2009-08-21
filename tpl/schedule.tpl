{include file='header.tpl'}

<select name="type_id">
    {object_html_options options=$Schedules key="GetId" label="GetName"}
</select>

<table>

{foreach from=$BoundDates item=date}
	<tr>
		<td>{$date->Format('Y-m-d H:i:s')}</td>
		{foreach from=$Layout->GetLayout() item=period}
			<td>{$period->Label()}</td>
		{/foreach}
	</tr>
	{foreach from=$Resources item=resource name=resource_loop}
		{assign var=curResTmp value=$Reservations->OnDate($date)}
		{assign var=currentReservations value=$curResTmp->ForResource($resource->Id)}
		<tr>
			<td>
				{if $resource->CanAccess}
					<a href="#" onclick="CreateReservation({$resource->Id}">{$resource->Name}</a>
				{else}
					{$resource->Name}
				{/if}
			</td>
			{foreach from=$currentReservations item=reservation}
				<td colspan="{$reservation->Span()}">res</td>
			{/foreach}
		</tr>
	{/foreach}
{/foreach}

</table>

{include file='footer.tpl'}