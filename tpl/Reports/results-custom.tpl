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
{if $Report->ResultCount() > 0}
	<div id="report-actions">
		{if !$HideSave}<a href="#" id="btnSaveReportPrompt">{html_image src="disk-black.png"} {translate key=SaveThisReport}</a> | {/if}<a href="#" id="btnCsv">{html_image src="table-export.png"} {translate key=ExportToCSV}</a> | <a href="#" id="btnPrint">{html_image src="printer.png"}{translate key=Print}</a>
	</div>
	<table width="100%" id="report-results">
		<tr>
		{foreach from=$Definition->GetColumnHeaders() item=column}
			<th>{translate key=$column->TitleKey()}</th>
		{/foreach}
		</tr>
		{foreach from=$Report->GetData()->Rows() item=row}
			{cycle values=',alt' assign=rowCss}
			<tr class="{$rowCss}">
				{foreach from=$Definition->GetRow($row) item=data}
					<td>{$data|escape}</td>
				{/foreach}
			</tr>
		{/foreach}
	</table>
	<h4>{$Report->ResultCount()} {translate key=Rows}
		{if $Definition->GetTotal() != ''}
			| {$Definition->GetTotal()} {translate key=Total}
		{/if}
	</h4>

{else}
	<h2 class="no-data" style="text-align: center;">{translate key=NoResultsFound}</h2>
{/if}