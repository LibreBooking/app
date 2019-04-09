{*
Copyright 2013-2019 Nick Korbel

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

{*<form id="editBlackoutForm" role="form" method="post">*}
    <div id="updateBlackout">
        <div class="col s6">
            <div class="input-field inline">
                <label for="updateStartDate">{translate key=BeginDate}</label>
                <input type="text" id="updateStartDate" class="dateinput"
                       value="{formatdate date=$BlackoutStartDate}"/>
                <input {formname key=BEGIN_DATE} id="formattedUpdateStartDate" type="hidden"
                                                 value="{formatdate date=$BlackoutStartDate key=system}"/>
            </div>
            <div class="input-field inline">
                <label for="updateStartTime"></label>
                <input {formname key=BEGIN_TIME} type="text" id="updateStartTime"
                                                 class="dateinput timepicker"
                                                 value="{formatdate date=$BlackoutStartDate format='h:i A'}"/>
            </div>
        </div>

        <div class="col s6">
            <div class="input-field inline">
                <label for="updateEndDate">{translate key=EndDate}</label>
                <input type="text" id="updateEndDate" class="dateinput" size="10"
                       value="{formatdate date=$BlackoutEndDate}"/>
                <input {formname key=END_DATE} type="hidden" id="formattedUpdateEndDate"
                                               value="{formatdate date=$BlackoutEndDate key=system}"/>
            </div>
            <div class="input-field inline">
                <label for="updateEndTime">&nbsp;</label>
                <input {formname key=END_TIME} type="text" id="updateEndTime"
                                               class="dateinput timepicker"
                                               value="{formatdate date=$BlackoutEndDate format='h:i A'}"/>
            </div>
        </div>

        <div class="col s12 blackouts-edit-resources">
            <span class="bold">{translate key=Resources}</span>
            {foreach from=$Resources item=resource}
                {assign var=checked value=""}
                {if in_array($resource->GetId(), $BlackoutResourceIds)}
                    {assign var=checked value="checked='checked'"}
                {/if}
                <div class="resourceItem">
                    <label for="r{$resource->GetId()}">
                        <input {formname key=RESOURCE_ID  multi=true}
                                type="checkbox"
                                value="{$resource->GetId()}" {$checked}
                                id="r{$resource->GetId()}"/>
                        <span>{$resource->GetName()}</span>
                    </label>
                </div>
            {/foreach}
        </div>

        <div class="input-field col s12">
            <label for="blackoutReason">{translate key=Reason} <i class="fa fa-asterisk"></i></label>
            <input {formname key=SUMMARY} type="text" id="blackoutReason" required
                                          class="required" value="{$BlackoutTitle}"/>
        </div>

        <div>
            {control type="RecurrenceControl" RepeatTerminationDate=$RepeatTerminationDate prefix='edit'}
        </div>

        <div class="col s12">
            <label for="bookAroundUpdate">
                <input {formname key=CONFLICT_ACTION} type="radio" id="bookAroundUpdate"
                                                      name="existingReservations"
                                                      checked="checked"
                                                      value="{ReservationConflictResolution::BookAround}"/>
                <span>{translate key=BlackoutAroundConflicts}</span>
            </label>
            <label for="notifyExistingUpdate">
                <input {formname key=CONFLICT_ACTION} type="radio" id="notifyExistingUpdate"
                                                      name="existingReservations"
                                                      value="{ReservationConflictResolution::Notify}"/>
                <span>{translate key=BlackoutShowMe}</span>
            </label>

            <label for="deleteExistingUpdate">
                <input {formname key=CONFLICT_ACTION} type="radio" id="deleteExistingUpdate"
                                                      name="existingReservations"
                                                      value="{ReservationConflictResolution::Delete}"/>
                <span>{translate key=BlackoutDeleteConflicts}</span>
            </label>
        </div>

        <div id="update-blackout-buttons" class="col s12 margin-bottom-25">
            <div class="pull-right">
                {cancel_button}
                {if $IsRecurring}
                    <button type="button" class="btn btn-primary save btnUpdateThisInstance">
                        <span class="fa fa-check-circle-o"></span>
                        {translate key='ThisInstance'}
                    </button>
                    <button type="button" class="btn btn-primary save btnUpdateAllInstances">
                        <span class="fa fa-check-circle-o"></span>
                        {translate key='AllInstances'}
                    </button>
                {else}
                    <button type="button" class="btn btn-primary save update btnUpdateAllInstances">
                        <span class="fa fa-check-circle-o"></span>
                        {translate key='Update'}
                    </button>
                {/if}
            </div>
        </div>

        <input type="hidden" {formname key=BLACKOUT_INSTANCE_ID} value="{$BlackoutId}"/>
        <input type="hidden" {formname key=SERIES_UPDATE_SCOPE} class="hdnSeriesUpdateScope"
               value="{SeriesUpdateScope::FullSeries}"/>
    </div>
    {csrf_token}
{*</form>*}

<script type="text/javascript">
    $(function () {
        var recurOpts = {
            repeatType: '{$RepeatType}',
            repeatInterval: '{$RepeatInterval}',
            repeatMonthlyType: '{$RepeatMonthlyType}',
            repeatWeekdays: [{foreach from=$RepeatWeekdays item=day}{$day}, {/foreach}]
        };

        var recurrence = new Recurrence(recurOpts, {}, 'edit');
        recurrence.init();
    });
</script>

{control type="DatePickerSetupControl" ControlId="updateStartDate" AltId="formattedUpdateStartDate"}
{control type="DatePickerSetupControl" ControlId="updateEndDate" AltId="formattedUpdateEndDate"}
{control type="DatePickerSetupControl" ControlId="editEndRepeat" AltId="editformattedEndRepeat"}