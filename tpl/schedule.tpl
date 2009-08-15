{include file='header.tpl'}

<select name="type_id">
    {object_html_options options=$Schedules key="GetId" label="GetName"}
</select>

<table>
{section loop=$Resources name=test}
	<tr>
		<td>{$Resources[test]->GetName()}</td>
	</tr>
{/section}

{foreach from=$DisplayDates item=date}
	<tr>
		<td>{$date->Format('Y-m-d H:i:s')}</td>
		{foreach from=$LayoutPeriods item=period}
			<td colspan="$period->Span()">$period->Label()</td>
		{/foreach}
	</tr>
	{foreach from=$Resources item=resource name=resource_loop}
		{assign var=currentReservations value=$reservations->OnDate($date)->ForResource($resource)}
		<tr>
			<td>{$resource->GetName()}</td>
			{foreach from=$currentReservations item=reservation}
				<td colspan="$reservation->Span()">res</td>
			{/foreach}
		</tr>
	{/foreach}
{/foreach}

</table>

{include file='footer.tpl'}