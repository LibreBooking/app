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
{include file='globalheader.tpl' cssFiles='css/participation.css,css/jquery.qtip.min.css'}
<h1>{translate key=OpenInvitations} ({$Reservations|count})</h1>

<ul class="no-style participation">
{foreach from=$Reservations item=reservation name=invitations}
	{assign var=referenceNumber value=$reservation->ReferenceNumber}
	<li class="actions row{$smarty.foreach.invitations.index%2}">
		<h3>{$reservation->Title}</h3>
		<h3><a href="{Pages::RESERVATION}?{QueryStringKeys::REFERENCE_NUMBER}={$referenceNumber}" class="reservation" referenceNumber="{$referenceNumber}">
		{formatdate date=$reservation->StartDate->ToTimezone($Timezone) key=dashboard} - {formatdate date=$reservation->EndDate->ToTimezone($Timezone) key=dashboard}</a></h3>
		<input type="hidden" value="{$referenceNumber}" class="referenceNumber" />
		<button value="{InvitationAction::Accept}" class="button participationAction">{html_image src="ticket-plus.png"} {translate key="Accept"}</button>
		<button value="{InvitationAction::Decline}" class="button participationAction">{html_image src="ticket-minus.png"} {translate key="Decline"}</button>
	</li>
{foreachelse}
	<li class="no-data"><h2>{translate key='None'}</h2></li>
{/foreach}
</ul>

<div class="dialog" style="display:none;">
	
</div>

<script type="text/javascript" src="scripts/js/jquery.qtip.min.js"></script>
<script type="text/javascript" src="scripts/reservationPopup.js"></script>
<script type="text/javascript" src="scripts/participation.js"></script>

<script type="text/javascript">

	$(document).ready(function() {

		var participationOptions = {
			responseType: 'json'
		};

		var participation = new Participation(participationOptions);
		participation.initParticipation();
	});

</script>

{include file='globalfooter.tpl'}