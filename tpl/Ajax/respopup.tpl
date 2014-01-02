{*
Copyright 2011-2014 Nick Korbel

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
{if $authorized}
<div class="res_popup_details" style="margin:0">
	<div class="user">
		{if $hideUserInfo}
			{translate key=Private}
		{else}
			{$fullName}
		{/if}
	</div>
	<div class="dates">{formatdate date=$startDate key=res_popup} - {formatdate date=$endDate key=res_popup}</div>

	{if !$hideDetails}
    <div class="title">{if $title neq ''}{$title}{else}{translate key=NoTitleLabel}{/if}</div>
	{/if}

	<div class="resources">
	{translate key="Resources"} ({$resources|@count}):
	{foreach from=$resources item=resource name=resource_loop}
		{$resource->Name()}
		{if !$smarty.foreach.resource_loop.last}, {/if}
	{/foreach}
	</div>

	{if !$hideUserInfo}
	<div class="users">
	{translate key="Participants"} ({$participants|@count}):
	{foreach from=$participants item=user name=participant_loop}
		{if !$user->IsOwner()}
			{fullname first=$user->FirstName last=$user->LastName}
		{/if}
		{if !$smarty.foreach.participant_loop.last}, {/if}
	{/foreach}
	</div>
	{/if}

	<div class="accessories">
	{translate key="Accessories"} ({$accessories|@count}):
	{foreach from=$accessories item=accessory name=accessory_loop}
		{$accessory->Name} ({$accessory->QuantityReserved})
		{if !$smarty.foreach.accessory_loop.last}, {/if}
	{/foreach}
	</div>

	{if !$hideDetails}
		<div class="summary">{if $summary neq ''}{$summary|truncate:300:"..."|nl2br}{else}{translate key=NoDescriptionLabel}{/if}</div>
		{if $attributes|count > 0}
			<br/>
			{foreach from=$attributes item=attribute}
				<div>{control type="AttributeControl" attribute=$attribute readonly=true}</div>
			{/foreach}
		{/if}
	{/if}
	<!-- {$ReservationId} -->
</div>
{else}
	{translate key='InsufficientPermissionsError'}
{/if}