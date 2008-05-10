{include file='header.tpl'}
<table width="100%">
	<tr>
		<th>
			Announcements
		</th>
	</tr>
	<tr>
		<td>
			<ul>
				{foreach from=$Announcements item=each}
				    <li>{$each}</li>
				{/foreach}
			</ul>
		</td>
	</tr>
</table>
{include file='footer.tpl'}