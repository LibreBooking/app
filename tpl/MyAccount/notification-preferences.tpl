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

<div id="page-notification-preferences">

    <div class="row">

        {if $PreferencesUpdated}
            <div class="col s12 m8 offset-m2 card-panel success hidden">
                <ul>
                    <li>
                        <span class="fa fa-check-circle-o"></span> {translate key=YourSettingsWereUpdated}
                    </li>
                </ul>
            </div>
        {/if}

        {if !$EmailEnabled}
            <div class="col s12 m8 offset-m2 card-panel error">
                <ul>
                    <li>
                        {translate key=EmailDisabled}
                    </li>
                </ul>
            </div>
        {else}
            <div id="notification-preferences-box" class="col s12 m8 offset-m2 ">
                <h5>{translate key=NotificationPreferences}</h5>

                <form id="notification-preferences-form" method="post" action="{$smarty.server.SCRIPT_NAME}">

                    <div class="notification-row">
                        <div class="notification-type">
                            {translate key=ReservationCreatedPreference}
                        </div>

                        <div class="switch">
                            <label>
                                {translate key=PreferenceNoEmail}
                                <input id="created" type="checkbox" name="{ReservationEvent::Created}" value="1"
                                       {if $Created}checked="checked"{/if}/>
                                <span class="lever"></span>
                                {translate key=PreferenceSendEmail}
                            </label>
                        </div>
                    </div>

                    <div class="notification-row alt">
                        <div class="notification-type">
                            {translate key=ReservationUpdatedPreference}
                        </div>

                        <div class="switch">
                            <label>
                                {translate key=PreferenceNoEmail}
                                <input id="updated" type="checkbox" name="{ReservationEvent::Updated}" value="1"
                                       {if $Updated}checked="checked"{/if}/>
                                <span class="lever"></span>
                                {translate key=PreferenceSendEmail}
                            </label>
                        </div>
                    </div>

                    <div class="notification-row">
                        <div class="notification-type">
                            {translate key=ReservationDeletedPreference}
                        </div>

                        <div class="switch">
                            <label>
                                {translate key=PreferenceNoEmail}
                                <input id="deleted" type="checkbox" name="{ReservationEvent::Deleted}" value="1"
                                       {if $Deleted}checked="checked"{/if}/>
                                <span class="lever"></span>
                                {translate key=PreferenceSendEmail}
                            </label>
                        </div>
                    </div>

                    <div class="notification-row alt">
                        <div class="notification-type">
                            {translate key=ReservationApprovalPreference}
                        </div>

                        <div class="switch">
                            <label>
                                {translate key=PreferenceNoEmail}
                                <input id="approved" type="checkbox" name="{ReservationEvent::Approved}" value="1"
                                       {if $Approved}checked="checked"{/if}/>
                                <span class="lever"></span>
                                {translate key=PreferenceSendEmail}
                            </label>
                        </div>
                    </div>

                    <div class="notification-row">
                        <div class="notification-type">
                            {translate key=ReservationParticipationActivityPreference}
                        </div>

                        <div class="switch">
                            <label>
                                {translate key=PreferenceNoEmail}
                                <input id="participating" type="checkbox" name="{ReservationEvent::ParticipationChanged}" value="1"
                                       {if $ParticipantChanged}checked="checked"{/if}/>
                                <span class="lever"></span>
                                {translate key=PreferenceSendEmail}
                            </label>
                        </div>
                    </div>

                    <div class="notification-row alt">
                        <div class="notification-type">
                            {translate key=ReservationSeriesEndingPreference}
                        </div>

                        <div class="switch">
                            <label>
                                {translate key=PreferenceNoEmail}
                                <input id="participating" type="checkbox" name="{ReservationEvent::SeriesEnding}" value="1"
                                       {if $SeriesEnding}checked="checked"{/if}/>
                                <span class="lever"></span>
                                {translate key=PreferenceSendEmail}
                            </label>
                        </div>
                    </div>

                    <div class="clearfix">&nbsp;</div>

                    <div class="col s12">
                        <button type="submit" class="btn btn-primary waves-effect waves-light update prompt right" name="{Actions::SAVE}">
                            {translate key='Update'}
                        </button>
                    </div>
                </form>
            </div>
        {/if}
    </div>
</div>

{include file="javascript-includes.tpl"}
{include file='globalfooter.tpl'}
