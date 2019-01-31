{*
Copyright 2012-2019 Nick Korbel

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
		<label for="participantAutocomplete">{translate key="ParticipantList"}</label>
        <span class="badge" id="participantBadge">0</span>
        <br/>
		<div class="participationText">
			<span class="hidden-xs">{translate key=Add}</span>
			<input type="text" id="participantAutocomplete" class="form-control inline-block user-search" placeholder="{translate key=NameOrEmail}"/>
			<span class="hidden-xs">|</span>
		</div>
		<div class="participationButtons">
			<button id="promptForParticipants" type="button" class="btn btn-link inline">
				<i class="fa fa-user"></i>
				{translate key='Users'}
			</button>
			<button id="promptForGroupParticipants" type="button" class="btn btn-link inline">
				<i class="fa fa-users"></i>
				{translate key='Groups'}
			</button>
		</div>

		<div id="participantList">
		</div>
	</div>
	<div class="row">
		<label for="inviteeAutocomplete">{translate key="InvitationList"}</label>
        <span class="badge" id="inviteeBadge">0</span>
		<br/>
		<div class="participationText">
			<span class="hidden-xs">{translate key=Add}</span>
			<input type="text" id="inviteeAutocomplete" class="form-control inline-block user-search" placeholder="{translate key=NameOrEmail}"/>
			<span class="hidden-xs">|</span>
		</div>
		<div class="participationButtons">
			<button id="promptForInvitees" type="button" class="btn btn-link inline">
				<i class="fa fa-user"></i>
				{translate key='Users'}
			</button>
			<button id="promptForGroupInvitees" type="button" class="btn btn-link inline">
				<i class="fa fa-users"></i>
				{translate key='Groups'}
			</button>
			{if $AllowGuestParticipation}
				<button id="promptForGuests" type="button" class="btn btn-link inline">
					<i class="fa fa-user-plus"></i>
					{translate key='Guest'}
				</button>
			{/if}
		</div>

		<div id="inviteeList">
		</div>

		<div id="allowParticipation">
			<div class="checkbox">
				<input type="checkbox" {if $AllowParticipantsToJoin}checked="checked"{/if} {formname key=ALLOW_PARTICIPATION} id="allowParticipationCheckbox">
				<label for="allowParticipationCheckbox">{translate key=AllowParticipantsToJoin}</label>
			</div>
		</div>

		<div class="modal fade" id="inviteeDialog" tabindex="-1" role="dialog" aria-labelledby="inviteeModalLabel" aria-hidden="true">
			<div class="modal-dialog">
				<div class="modal-content">
					<div class="modal-header">
						<button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
						<h4 class="modal-title" id="inviteeModalLabel">{translate key=InviteOthers}</h4>
					</div>
					<div class="modal-body scrollable-modal-content">
					</div>
					<div class="modal-footer">
						<button type="button" class="btn btn-primary" data-dismiss="modal">{translate key='Done'}</button>
					</div>
				</div>
			</div>
		</div>

		<div class="modal fade" id="inviteeGuestDialog" tabindex="-1" role="dialog" aria-labelledby="inviteeGuestModalLabel" aria-hidden="true">
			<div class="modal-dialog">
				<div class="modal-content">
					<div class="modal-header">
						<button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
						<h4 class="modal-title" id="inviteeGuestModalLabel">{translate key=InviteOthers}</h4>
					</div>
					<div class="modal-body">
						<div class="form-group row">
							<label for="txtGuestEmail" class="col-xs-2 form-control-label">{translate key=Email}</label>
							<div class="col-xs-8">
								<input id="txtGuestEmail" type="email" class="form-control"/>
							</div>
							<div class="col-xs-2">
								<button id="btnAddGuest" class="btn btn-link" type="button"><span class="no-show">{translate key='Guest'}</span><i class="fa fa-user-plus icon add"></i></button>
							</div>
						</div>
					</div>
					<div class="modal-footer">
						<button type="button" class="btn btn-primary" data-dismiss="modal">{translate key='Done'}</button>
					</div>
				</div>
			</div>
		</div>

		<div class="modal fade" id="inviteeGroupDialog" tabindex="-1" role="dialog" aria-labelledby="inviteeGroupModalLabel" aria-hidden="true">
			<div class="modal-dialog">
				<div class="modal-content">
					<div class="modal-header">
						<button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
						<h4 class="modal-title" id="inviteeGroupModalLabel">{translate key=InviteOthers}</h4>
					</div>
					<div class="modal-body scrollable-modal-content">
					</div>
					<div class="modal-footer">
						<button type="button" class="btn btn-primary" data-dismiss="modal">{translate key='Done'}</button>
					</div>
				</div>
			</div>
		</div>

	</div>

	<div class="modal fade" id="participantDialog" tabindex="-1" role="dialog" aria-labelledby="participantModalLabel" aria-hidden="true">
		<div class="modal-dialog">
			<div class="modal-content">
				<div class="modal-header">
					<button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
					<h4 class="modal-title" id="participantModalLabel">{translate key=AddParticipants}</h4>
				</div>
				<div class="modal-body scrollable-modal-content">
				</div>
				<div class="modal-footer">
					<button type="button" class="btn btn-primary" data-dismiss="modal">{translate key='Done'}</button>
				</div>
			</div>
		</div>
	</div>

	<div class="modal fade" id="participantGroupDialog" tabindex="-1" role="dialog" aria-labelledby="participantGroupModalLabel" aria-hidden="true">
		<div class="modal-dialog">
			<div class="modal-content">
				<div class="modal-header">
					<button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
					<h4 class="modal-title" id="participantGroupModalLabel">{translate key=AddParticipants}</h4>
				</div>
				<div class="modal-body scrollable-modal-content">
				</div>
				<div class="modal-footer">
					<button type="button" class="btn btn-primary" data-dismiss="modal">{translate key='Done'}</button>
				</div>
			</div>
		</div>
	</div>
</div>
