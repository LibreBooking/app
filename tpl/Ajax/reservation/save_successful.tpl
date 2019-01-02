{*
Copyright 2011-2019 Nick Korbel

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

<div id="{$divId|default:'reservation-created'}" class="reservationResponseMessage">
	<div id="reservation-response-image">
	{if $RequiresApproval}
		<span class="fa fa-flag fa-5x warning"></span>
	{else}
		<span class="fa fa-check fa-5x success"></span>
	{/if}
	</div>

	<div id="created-message" class="reservation-message">{translate key=$messageKey|default:"ReservationCreated"}</div>
	<div id="reference-number">{translate key=YourReferenceNumber args=$ReferenceNumber}</div>

	<div class="dates" style="max-height: 15em;display: block;overflow-y: auto;margin: 0.5em 0;">
		<span class="bold">{translate key=Dates}:</span>
		{foreach from=$Instances item=instance name=date_list}
			<span class="date">{format_date date=$instance->StartDate() timezone=$Timezone}{if !$smarty.foreach.date_list.last}, {/if}</span>
		{/foreach}
	</div>

	<div class="resources">
		<span class="bold">{translate key=Resources}:</span>
		{foreach from=$Resources item=resource name=resource_list}
			<span class="resource">{$resource->GetName()}{if !$smarty.foreach.resource_list.last}, {/if}</span>
		{/foreach}
	</div>

	{if $RequiresApproval}
		<div id="approval-message">{translate key=ReservationRequiresApproval}</div>
	{/if}

	<input type="button" id="btnSaveSuccessful" value="{translate key='Close'}" class="btn btn-success" />
</div>