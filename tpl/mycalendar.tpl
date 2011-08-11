{include file='globalheader.tpl'}

Day Week Month List

<table width="100%" border="1">
	<tr>
		{foreach from=$HeaderLabels item=label}
			<th width="14%">{$label}</th>
		{/foreach}
	</tr>
{foreach from=$Weeks item=week}
	<tr>
		{foreach from=$week->Days() item=day}
			<td>{$day->Number}</td>
		{/foreach}
	</tr>
{/foreach}
</table>

{include file='globalfooter.tpl'}
