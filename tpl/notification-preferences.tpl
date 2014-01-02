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
{include file='globalheader.tpl'}

{if $PreferencesUpdated}
<div class="success">{translate key=YourSettingsWereUpdated}</div>
{/if}

{if !$EmailEnabled}
<div class="error">{translate key=EmailDisabled}</div>
	{else}
<div id="notificationPreferences" class="box-form">
	<form class="box-form" method="post" action="{$smarty.server.SCRIPT_NAME}">
		<div class="header">
			<h3 class="header">{translate key=NotificationPreferences}</h3>
		</div>

		<div style="display: table;">
			<div class="notification-row">
				<div class="notification-type">
					{translate key=ReservationCreatedPreference}
				</div>
				<div class="notification-status">
					<input id="createdYes" type="radio" name="{ReservationEvent::Created}" value="1"
						   {if $Created}checked="checked"{/if}/><label
						for="createdYes">{translate key=PreferenceSendEmail}</label>
					<br/>
					<input id="createdNo" type="radio" name="{ReservationEvent::Created}" value="0"
						   {if !$Created}checked="checked"{/if}/><label
						for="createdNo">{translate key=PreferenceNoEmail}</label>
				</div>
			</div>

			<div class="notification-row alt">
				<div class="notification-type">
					{translate key=ReservationUpdatedPreference}
				</div>
				<div class="notification-status">
					<input id="updatedYes" type="radio" name="{ReservationEvent::Updated}" value="1"
						   {if $Updated}checked="checked"{/if}/><label
						for="updatedYes">{translate key=PreferenceSendEmail}</label>
					<br/>
					<input id="updatedNo" type="radio" name="{ReservationEvent::Updated}" value="0"
						   {if !$Updated}checked="checked"{/if}/><label
						for="updatedNo">{translate key=PreferenceNoEmail}</label>
				</div>
			</div>

			<div class="notification-row">
				<div class="notification-type">
					{translate key=ReservationDeletedPreference}
				</div>
				<div class="notification-status">
					<input id="deletedYes" type="radio" name="{ReservationEvent::Deleted}" value="1"
						   {if $Deleted}checked="checked"{/if}/><label
						for="deletedYes">{translate key=PreferenceSendEmail}</label>
					<br/>
					<input id="deletedNo" type="radio" name="{ReservationEvent::Deleted}" value="0"
						   {if !$Deleted}checked="checked"{/if}/><label
						for="deletedNo">{translate key=PreferenceNoEmail}</label>
				</div>
			</div>

			<div class="notification-row alt">
				<div class="notification-type">
					{translate key=ReservationApprovalPreference}
				</div>
				<div class="notification-status">
					<input id="approvedYes" type="radio" name="{ReservationEvent::Approved}" value="1"
						   {if $Approved}checked="checked"{/if}/><label
						for="approvedYes">{translate key=PreferenceSendEmail}</label>
					<br/>
					<input id="approvedNo" type="radio" name="{ReservationEvent::Approved}" value="0"
						   {if !$Approved}checked="checked"{/if}/><label
						for="approvedNo">{translate key=PreferenceNoEmail}</label>
				</div>
			</div>
		</div>

		<div style="clear:both;margin-top: 15px;">
			<button type="submit" class="button update prompt" name="{Actions::SAVE}">
				<img src="img/tick-circle.png"/>
				{translate key='Update'}
			</button>
		</div>
	</form>
</div>
{/if}


{include file='globalfooter.tpl'}