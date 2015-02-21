{*
Copyright 2012-2014 Nick Korbel

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
<div id="reservationParticipation">
	<div class="row">
		<div>
		<label>{translate key="ParticipantList"}<br/>
			{translate key=Add} <input type="text" id="participantAutocomplete" class="form-control inline-block user-search"/>
			or
			<button id="promptForParticipants" type="button" class="btn inline">
				<i class="fa fa-user"></i>
				{translate key='SelectUser'}
			</button>
			<button id="promptForGroupParticipants" type="button" class="btn inline">
				<i class="fa fa-users"></i>
				{translate key='Groups'}
			</button>
		</label>
		</div>
		<div id="participantList">
			<ul></ul>
		</div>
		<div id="participantDialog" title="{translate key=AddParticipants}" class="dialog"></div>
		<div id="participantGroupDialog" title="{translate key=AddParticipants}" class="dialog"></div>
	</div>
	<div class="row">
		<div>
		<label>{translate key="InvitationList"}<br/>
			{translate key=Add} <input type="text" id="inviteeAutocomplete" class="form-control inline-block user-search"/>
			or
			<button id="promptForInvitees" type="button" class="btn inline">
				<i class="fa fa-user"></i>
				{translate key='SelectUser'}
			</button>
			<button id="promptForGroupInvitees" type="button" class="btn inline">
				<i class="fa fa-users"></i>
				{translate key='Groups'}
			</button>
		</label>
		</div>
		<div id="inviteeList">
			<ul></ul>
		</div>
		<div id="inviteeDialog" title="{translate key=InviteOthers}" class="dialog"></div>
		<div id="inviteeGroupDialog" title="{translate key=InviteOthers}" class="dialog"></div>
	</div>
</div>
