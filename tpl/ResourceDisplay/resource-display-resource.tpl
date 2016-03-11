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

<div class="col-xs-6 resource-display-name">{$ResourceName}</div>
<div class="col-xs-6 resource-display-date">{formatdate date=$Today key=schedule_daily}</div>

{assign var=AvailableNow value=true}
{assign var=NextAvailable value=false}
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
					{if $slot->CollidesWith($Today)}
						{assign var=AvailableNow value=false}
					{/if}
					{assign var="class" value="reserved"}
				{elseif $slot->IsReservable()}
					{if $NextAvailable == false && !$slot->IsPastDate($Today)}
						{assign var=NextAvailable value=$slot->BeginDate()}
					{/if}
					{assign var="class" value="reservable"}
				{else}
					{if $slot->CollidesWith($Today)}
						{assign var=AvailableNow value=false}
					{/if}
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
		<div class="resource-display-available reservePrompt"
			 data-next-time="{formatdate date=$NextAvailable key=url_full}">
			{translate key=Available} - {translate key=Reserve}
		</div>
	</div>
{else}
	<div class="col-xs-12">
		{if $NextAvailable != false}
			<div class="resource-display-unavailable reservePrompt" data-next-time="{formatdate date=$NextAvailable key=url_full}">
		{else}
			<div class="resource-display-unavailable">
		{/if}
			{translate key=Unavailable}{if $NextAvailable != false} - {translate key=Reserve}{/if}
		</div>
	</div>
{/if}

{if $NextAvailable != false}
<div id="process-reservation">

	<form role="form" method="post" id="formReserve" action="{$smarty.server.SCRIPT_NAME}?action=reserve">
	<div class="col-xs-12 margin-top-25">
	<div class="clearfix"></div>
		<div id="validationErrors" class="validationSummary alert alert-danger no-show">
			<ul>
			{validator id="emailformat" key="ValidEmailRequired"}
			</ul>
		</div>

		<div id="reserveResults" class="no-show">
		</div>

		<div class="input-group input-group-lg">
			<span class="input-group-addon" id="email-addon"><span class="glyphicon glyphicon-envelope"></span></span>
			<input id="emailAddress" type="email" class="form-control" placeholder="{translate key=Email}"
				   aria-describedby="email-addon" required="required" {formname key=EMAIL}>
		</div>
	</div>
	<div class="clearfix"></div>
	<div class="margin-top-25">
		<div class="col-xs-6">
			<div class="input-group input-group-lg has-feedback">
				<span class="input-group-addon" id="starttime-addon"><span
							class="glyphicon glyphicon-time"></span></span>
				<select class="form-control" aria-describedby="starttime-addon" {formname key=BEGIN_PERIOD}>
					{foreach from=$slots item=slot}
						{if $slot->IsReservable() && !$slot->IsPastDate($Today)}
							<option value="{$slot->Begin()}">{$slot->Begin()->Format($TimeFormat)}</option>
						{/if}
					{/foreach}
				</select>
			</div>
		</div>
		<div class="col-xs-6">
			<div class="input-group input-group-lg">
				<span class="input-group-addon" id="endtime-addon"><span
							class="glyphicon glyphicon-time"></span></span>
				<select class="form-control input-lg" aria-describedby="endtime-addon" {formname key=END_PERIOD}>
					{foreach from=$slots item=slot}
						{if $slot->IsReservable() && !$slot->IsPastDate($Today)}
							<option value="{$slot->End()}">{$slot->End()->Format($TimeFormat)}</option>
						{/if}
					{/foreach}
				</select>
			</div>
		</div>
	</div>
	<input type="hidden" {formname key=RESOURCE_ID} value="{$ResourceId}" />
	<input type="hidden" {formname key=SCHEDULE_ID} value="{$ScheduleId}" />
	<input type="hidden" {formname key=TIMEZONE} value="{$Timezone}" />
</form>
</div>
{/if}