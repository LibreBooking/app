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
	<ul class="no-style">
		<li>
			<label>{translate key="ParticipantList"}<br/>
				{translate key=Add} <input type="text" id="participantAutocomplete" class="input" style="width:250px;"/>
				or
				<button id="promptForParticipants" type="button" class="button" style="display:inline">
					<img src="img/user-plus.png"/>
				{translate key='SelectUser'}
				</button>
				<button id="promptForGroupParticipants" type="button" class="button" style="display:inline">
					<img src="img/users.png"/>
				{translate key='Groups'}
				</button>
			</label>

			<div id="participantList">
				<ul></ul>
			</div>
			<div id="participantDialog" title="{translate key=AddParticipants}" class="dialog"></div>
			<div id="participantGroupDialog" title="{translate key=AddParticipants}" class="dialog"></div>
		</li>
		<li>
			<label>{translate key="InvitationList"}<br/>
				{translate key=Add} <input type="text" id="inviteeAutocomplete" class="input" style="width:250px;"/>
				or
				<button id="promptForInvitees" type="button" class="button" style="display:inline">
					{html_image src="user-plus.png"}
				{translate key='SelectUser'}
				</button>
				<button id="promptForGroupInvitees" type="button" class="button" style="display:inline">
					<img src="img/users.png"/>
				{translate key='Groups'}
				</button>
			</label>

			<div id="inviteeList">
				<ul></ul>
			</div>
			<div id="inviteeDialog" title="{translate key=InviteOthers}" class="dialog"></div>
			<div id="inviteeGroupDialog" title="{translate key=InviteOthers}" class="dialog"></div>
		</li>
	</ul>
</div>