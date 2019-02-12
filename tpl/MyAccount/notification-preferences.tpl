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
{include file='globalheader.tpl' cssFiles="my-account.css"}

<div class="page-notification-preferences">

	{if $PreferencesUpdated}
		<div class="success alert alert-success col-xs-12 col-sm-8 col-sm-offset-2">
			<span class="glyphicon glyphicon-ok-sign"></span> {translate key=YourSettingsWereUpdated}
		</div>
	{/if}

	{if !$EmailEnabled}
		<div class="error">{translate key=EmailDisabled}</div>
	{else}
		<div id="notification-preferences-box" class="default-box col-xs-12 col-sm-8 col-sm-offset-2">
			<h1>{translate key=NotificationPreferences}</h1>

			<form id="notification-preferences-form" method="post" action="{$smarty.server.SCRIPT_NAME}">
				<div>
					<div class="notification-row">
						<div class="notification-type">
							{translate key=ReservationCreatedPreference}
						</div>

						<div class="btn-group form-group" data-toggle="buttons">
							<label class="btn btn-default btn-xs {if $Created}active{/if}">
								<input id="createdYes" type="radio" name="{ReservationEvent::Created}" value="1"
									   {if $Created}checked="checked"{/if}/> {translate key=PreferenceSendEmail}
							</label>
							<label class="btn btn-default btn-xs {if !$Created}active{/if}">
								<input id="createdNo" type="radio" name="{ReservationEvent::Created}" value="0"
									   {if !$Created}checked="checked"{/if}/>{translate key=PreferenceNoEmail}</label>
						</div>
					</div>

					<div class="notification-row">
						<div class="notification-type">
							{translate key=ReservationUpdatedPreference}
						</div>

						<div class="btn-group form-group" data-toggle="buttons">
							<label class="btn btn-default btn-xs {if $Updated}active{/if}">
								<input id="updatedYes" type="radio" name="{ReservationEvent::Updated}" value="1"
									   {if $Updated}checked="checked"{/if}/> {translate key=PreferenceSendEmail}
							</label>
							<label class="btn btn-default btn-xs {if !$Updated}active{/if}">
								<input id="updatedNo" type="radio" name="{ReservationEvent::Updated}" value="0"
									   {if !$Updated}checked="checked"{/if}/>{translate key=PreferenceNoEmail}</label>
						</div>
					</div>

					<div class="notification-row">
						<div class="notification-type">
							{translate key=ReservationDeletedPreference}
						</div>

						<div class="btn-group form-group" data-toggle="buttons">
							<label class="btn btn-default btn-xs {if $Deleted}active{/if}">
								<input id="deletedYes" type="radio" name="{ReservationEvent::Deleted}" value="1"
									   {if $Deleted}checked="checked"{/if}/> {translate key=PreferenceSendEmail}
							</label>
							<label class="btn btn-default btn-xs {if !$Deleted}active{/if}">
								<input id="deletedNo" type="radio" name="{ReservationEvent::Deleted}" value="0"
									   {if !$Deleted}checked="checked"{/if}/>{translate key=PreferenceNoEmail}</label>
						</div>
					</div>

					<div class="notification-row alt">
						<div class="notification-type">
							{translate key=ReservationApprovalPreference}
						</div>

						<div class="btn-group form-group" data-toggle="buttons">
							<label class="btn btn-default btn-xs {if $Approved}active{/if}">
								<input id="approvedYes" type="radio" name="{ReservationEvent::Approved}" value="1"
									   {if $Approved}checked="checked"{/if}/> {translate key=PreferenceSendEmail}
							</label>
							<label class="btn btn-default btn-xs {if !$Approved}active{/if}">
								<input id="approvedNo" type="radio" name="{ReservationEvent::Approved}" value="0"
									   {if !$Approved}checked="checked"{/if}/>{translate key=PreferenceNoEmail}</label>
						</div>
					</div>

                    <div class="notification-row">
                        <div class="notification-type">
                            {translate key=ReservationParticipationActivityPreference}
                        </div>

                        <div class="btn-group form-group" data-toggle="buttons">
                            <label class="btn btn-default btn-xs {if $ParticipantChanged}active{/if}">
                                <input id="endingYes" type="radio" name="{ReservationEvent::ParticipationChanged}" value="1"
                                       {if $ParticipantChanged}checked="checked"{/if}/> {translate key=PreferenceSendEmail}
                            </label>
                            <label class="btn btn-default btn-xs {if !$ParticipantChanged}active{/if}">
                                <input id="endingNo" type="radio" name="{ReservationEvent::ParticipationChanged}" value="0"
                                       {if !$ParticipantChanged}checked="checked"{/if}/>{translate key=PreferenceNoEmail}</label>
                        </div>
                    </div>

                    <div class="notification-row-alt">
                        <div class="notification-type">
                            {translate key=ReservationSeriesEndingPreference}
                        </div>

                        <div class="btn-group form-group" data-toggle="buttons">
                            <label class="btn btn-default btn-xs {if $SeriesEnding}active{/if}">
                                <input id="endingYes" type="radio" name="{ReservationEvent::SeriesEnding}" value="1"
                                       {if $SeriesEnding}checked="checked"{/if}/> {translate key=PreferenceSendEmail}
                            </label>
                            <label class="btn btn-default btn-xs {if !$SeriesEnding}active{/if}">
                                <input id="endingNo" type="radio" name="{ReservationEvent::SeriesEnding}" value="0"
                                       {if !$SeriesEnding}checked="checked"{/if}/>{translate key=PreferenceNoEmail}</label>
                        </div>
                    </div>
				</div>

				<div class="form-group">
					<button type="submit" class="btn btn-primary update prompt" name="{Actions::SAVE}">
						{translate key='Update'}
					</button>
				</div>
			</form>
		</div>
	{/if}

</div>

{include file="javascript-includes.tpl"}
{include file='globalfooter.tpl'}
