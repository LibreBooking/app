{*
Copyright 2017-2019 Nick Korbel

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
{include file='globalheader.tpl' cssFiles='css/participation.css'}

{if $IsMissingInformation}
	<div class="error">This invitation is incorrect or does not exist</div>
{/if}

{if $InvitationAccepted ||  $InvitationDeclined}
	<div class="success">Thanks, we've recorded your response
		{if $IsGuest || $AllowRegistration}
			<div><a href="{Pages::REGISTRATION}">{translate key=CreateAnAccount}</a></div>
		{/if}
	</div>
{/if}

{if $CapacityReached}
	<div class="error">{$CapacityErrorMessage}</div>
{/if}
{include file="javascript-includes.tpl"}
{include file='globalfooter.tpl'}