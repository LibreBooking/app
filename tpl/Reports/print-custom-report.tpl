{*
Copyright 2012-2017 Nick Korbel

This file is part of Booked Scheduler.

Booked Scheduler is free software: you can redistribute it and/or modify
it under the terms of the GNU General Public License as published by
the Free Software Foundation, either version 3 of the License, or
(at your option) any later version.

Booked Scheduler is distributed in the hope that it will be useful,
but WITHOUT ANY WARRANTY; without even the implied warranty of
MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
GNU General Public License for more details.

You should have received a copy of the GNU General Public License
along with Booked Scheduler.  If not, see <http://www.gnu.org/licenses/>.
*}
<!DOCTYPE HTML>
<html lang="{$HtmlLang}" dir="{$HtmlTextDirection}">
<head>
	<title>{if $TitleKey neq ''}{translate key=$TitleKey args=$TitleArgs}{else}{$Title}{/if}</title>
	<meta http-equiv="Content-Type" content="text/html; charset={$Charset}"/>
</head>
<body>
{translate key=Created}: {format_date date=Date::Now() key=general_datetime}
<table width="100%" border="1">
	<tr>
		{foreach from=$Definition->GetColumnHeaders() item=column}
			{capture name="columnTitle"}{if $column->HasTitle()}{$column->Title()}{else}{translate key=$column->TitleKey()}{/if}{/capture}
			<th data-columnTitle="{$smarty.capture.columnTitle}">
				{$smarty.capture.columnTitle}
			</th>
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

{jsfile src="reports/common.js"}

<script type="text/javascript">
	var common = new ReportsCommon(
			{
				scriptUrl: '{$ScriptUrl}'
			}
	);
	common.init();
	window.print();
</script>

</body>
</html>