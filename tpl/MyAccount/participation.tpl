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
{include file='globalheader.tpl' Qtip=true}

<div class="page-participation">
	{if !empty($result)}
		<div>{$result}</div>
	{/if}

	<div id="jsonResult" class="error no-show"></div>

	<div id="participation-box" class="default-box col-xs-12 col-sm-8 col-sm-offset-2">

		<h1>{translate key=OpenInvitations} <span class="label label-default">{$Reservations|count}</span></h1>

		<ul class="list-unstyled participation">
			{foreach from=$Reservations item=reservation name=invitations}
				{assign var=referenceNumber value=$reservation->ReferenceNumber}
				<li class="actions row{$smarty.foreach.invitations.index%2}">
					<h3>{$reservation->Title}</h3>

					<h3><a href="{Pages::RESERVATION}?{QueryStringKeys::REFERENCE_NUMBER}={$referenceNumber}" class="reservation"
						   referenceNumber="{$referenceNumber}">
							{formatdate date=$reservation->StartDate->ToTimezone($Timezone) key=dashboard}
							- {formatdate date=$reservation->EndDate->ToTimezone($Timezone) key=dashboard}</a></h3>
					<input type="hidden" value="{$referenceNumber}" class="referenceNumber"/>
					<button value="{InvitationAction::Accept}"
							class="btn btn-success participationAction"><i class="fa fa-check-circle"></i> {translate key="Accept"}</button>
					<button value="{InvitationAction::Decline}"
							class="btn btn-default participationAction"><i class="fa fa-times-circle"></i> {translate key="Decline"}</button>
				</li>
				{foreachelse}
				<li class="no-data"><p class="text-muted">{translate key='None'}</p></li>
			{/foreach}
		</ul>

	</div>
	<div class="dialog" style="display:none;">

	</div>

	{html_image src="admin-ajax-indicator.gif" id="indicator" style="display:none;"}

    {include file="javascript-includes.tpl" Qtip=true}
	{jsfile src="reservationPopup.js"}
	{jsfile src="participation.js"}

	<script type="text/javascript">

		$(document).ready(function () {

			var participationOptions = {
				responseType: 'json'
			};

			var participation = new Participation(participationOptions);
			participation.initParticipation();
		});

	</script>

</div>
{include file='globalfooter.tpl'}