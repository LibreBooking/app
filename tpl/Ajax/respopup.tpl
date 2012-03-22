{*
Copyright 2011-2012 Nick Korbel

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
{if $authorized}
<div class="res_popup_details">
	<div class="user">{fullname first=$fname last=$lname}</div>
	<div class="dates">{formatdate date=$startDate key=res_popup} - {formatdate date=$endDate key=res_popup}</div>	

    <div class="title">{$title}</div>

	<div class="resources">
	{translate key="Resources"} ({$resources|@count})
	{foreach from=$resources item=resource name=resource_loop}
		{$resource->Name()}
		{if !$smarty.foreach.resource_loop.last},{/if}
	{/foreach}
	</div>
	
	<div class="users">
	{translate key="Participants"} ({$participants|@count})
	{foreach from=$participants item=user name=participant_loop}
		{if !$user->IsOwner()}
			{fullname first=$user->FirstName last=$user->LastName}
		{/if}
		{if !$smarty.foreach.participant_loop.last},{/if}
	{/foreach}
	</div>
	
	<div class="summary">{$summary|truncate:300:"..."|nl2br}</div>	
	<!-- {$ReservationId} -->
</div>
{else}
	{translate key='InsufficientPermissionsError'}
{/if}