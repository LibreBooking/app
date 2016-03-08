{*
Copyright 2016 Nick Korbel

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

{include file='globalheader.tpl' HideNavBar=true}

<div id="page-resource-display-resource">

	{*<div class="col-xs-12">*}
		<div class="col-xs-6 resource-display-name">{$ResourceName}</div>
		<div class="col-xs-6 resource-display-date">{formatdate date=$Today key=schedule_daily}</div>
	{*</div>*}

	<div class="col-xs-12">


		<table class="reservations">
			<thead>
			<tr>
				{foreach from=$DailyLayout->GetPeriods($Today, true) item=period}
					<td class="reslabel" colspan="{$period->Span()}">{$period->Label($Today)}</td>
				{/foreach}
			</tr>
			</thead>
			<tbody>
			<tr>
				{assign var=slots value=$DailyLayout->GetLayout($Today, $ResourceId)}
				{foreach from=$slots item=slot}
					{if $slot->IsReserved()}
						{assign var="class" value="reserved"}
					{elseif $slot->IsReservable()}
						{assign var="class" value="reservable"}
					{else}
						{assign var="class" value="unreservable"}
					{/if}
					{if $slot->HasCustomColor()}
						{assign var=color value='style="background-color:'|cat:$slot->Color()|cat:';color:'|cat:$slot->TextColor()|cat:';"'}
					{/if}
					<td colspan="{$slot->PeriodSpan()}" $color
						class="slot {$class}">{$slot->Label($SlotLabelFactory)|escape|default:'&nbsp;'}</td>
				{/foreach}
			</tr>
			</tbody>
		</table>
	</div>

	{if $AvailableNow}
		<div class="col-xs-12">
			<div class="resource-display-available">
				Book Now
			</div>
		</div>
	{/if}
</div>

<div id="wait-box" class="wait-box">
	{indicator id="waitIndicator"}
</div>

{jsfile src="resourceDisplay.js"}
{jsfile src="ajax-helpers.js"}

<script type="text/javascript">
	$(function () {
		var resourceDisplay = new ResourceDisplay();
		resourceDisplay.init();
	});
</script>

{include file='globalfooter.tpl'}