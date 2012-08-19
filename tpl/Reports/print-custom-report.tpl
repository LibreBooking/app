{*
Copyright 2012 Nick Korbel

This file is part of phpScheduleIt.

phpScheduleIt is free software: you can redistribute it and/or modify
it under the terms of the GNU General Public License as published by
the Free Software Foundation, either version 3 of the License, or
(at your option) any later version.

phpScheduleIt is distributed in the hope that it will be useful,
but WITHOUT ANY WARRANTY; without even the implied warranty of
MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
GNU General Public License for more details.

You should have received a copy of the GNU General Public License
along with phpScheduleIt.  If not, see <http://www.gnu.org/licenses/>.
*}
{translate key=Created}: {format_date date=Date::Now() key=general_datetime}
<table width="100%" border="1">
	<tr>
	{foreach from=$Definition->GetColumnHeaders() item=column}
		<th>{translate key=$column->TitleKey()}</th>
	{/foreach}
	</tr>
	{foreach from=$Report->GetData()->Rows() item=row}
		<tr>
			{foreach from=$Definition->GetRow($row) item=data}
				<td>{$data->Value()|escape}&nbsp;</td>
			{/foreach}
		</tr>
	{/foreach}
</table>
{$Report->ResultCount()} {translate key=Rows}
{if $Definition->GetTotal() != ''}
	| {$Definition->GetTotal()} {translate key=Total}
{/if}

<script type="text/javascript" >
	window.print();
</script>

