{*
Copyright 2012-2015 Nick Korbel

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
{if $Report->ResultCount() > 0}
	<div id="report-actions">
		<a href="#" id="btnChart">{html_image src="chart.png"}{translate key=ViewAsChart}</a> {if !$HideSave}<a href="#"
																												id="btnSaveReportPrompt">{html_image src="disk-black.png"}{translate key=SaveThisReport}</a> | {/if}
		<a href="#" id="btnCsv">{html_image src="table-export.png"}{translate key=ExportToCSV}</a> | <a href="#"
																										id="btnPrint">{html_image src="printer.png"}{translate key=Print}</a>
	</div>
	<table width="100%" id="report-results" chart-type="{$Definition->GetChartType()}">
		<tr>
			{foreach from=$Definition->GetColumnHeaders() item=column}
				<th>{if $column->HasTitle()}
						{$column->Title()}
					{else}
						{translate key=$column->TitleKey()}
					{/if}
				</th>
			{/foreach}
		</tr>
		{foreach from=$Report->GetData()->Rows() item=row}
			{cycle values=',alt' assign=rowCss}
			<tr class="{$rowCss}">
				{foreach from=$Definition->GetRow($row) item=cell}
					<td chart-value="{$cell->ChartValue()}" chart-column-type="{$cell->GetChartColumnType()}"
						chart-group="{$cell->GetChartGroup()}">{$cell->Value()|escape}</td>
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
	<h2 id="report-no-data" class="no-data" style="text-align: center;">{translate key=NoResultsFound}</h2>
{/if}

<script type="text/javascript">
	$(document).ready(function ()
	{
		$('#report-no-data, #report-results').trigger('loaded');
	});
</script>