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
{include file='globalheader.tpl' Timepicker=true}
<div id="page-manage-quotas" class="admin-page row">
    <h4>{translate key=ManageQuotas}</h4>

    <form id="addQuotaForm" method="post" role="form">

        <div class="card" id="add-quota-panel">
            <div class="card-content">
                <div class="panel-heading">{translate key="AddQuota"} {showhide_icon}</div>
                <div class="panel-body" id="addQuota">
                    {capture name="schedules" assign="schedules"}
                        <div class='input-field inline'>
                            <label for='quotaSchedule' class='active'>{translate key=Schedule}</label>
                            <select {formname key=SCHEDULE_ID} id='quotaSchedule'>
                                <option selected='selected' value=''>{translate key=AllSchedules}</option>
                                {foreach from=$Schedules item=schedule}
                                    <option value='{$schedule->GetId()}'>{$schedule->GetName()|replace:',':' '}</option>
                                {/foreach}
                            </select>
                        </div>
                    {/capture}

                    {capture name="resources" assign="resources"}
                        <div class='input-field inline'>
                            <label for='quotaResource' class='active'>{translate key=Resource}</label>
                            <select {formname key=RESOURCE_ID} id='quotaResource'>
                                <option selected='selected' value=''>{translate key=AllResources}</option>
                                {foreach from=$Resources item=resource}
                                    <option value='{$resource->GetResourceId()}'>{$resource->GetName()|replace:',':' '}</option>
                                {/foreach}
                            </select>
                        </div>
                    {/capture}

                    {capture name="groups" assign="groups"}
                        <div class='input-field inline'>
                            <label for='quotaGroup' class='active'>{translate key=Group}</label>
                            <select {formname key=GROUP} id='quotaGroup'>
                                <option selected='selected' value=''>{translate key=AllGroups}</option>
                                {foreach from=$Groups item=group}
                                    <option value='{$group->Id}'>{$group->Name|replace:',':' '}</option>
                                {/foreach}
                            </select>
                        </div>
                    {/capture}

                    {capture name="amount" assign="amount"}
                        <div class='input-field inline'>
                            <label for='quotaLimit'></label>
                            <input id='quotaLimit' type='number' step='any' class='mid-number' min='0' max='10000'
                                   value='0' {formname key=LIMIT}/>
                        </div>
                    {/capture}

                    {capture name="unit" assign="unit"}
                        <div class='input-field inline'>
                            <label for='quotaUnit'></label>
                            <select {formname key=UNIT} title='Quota unit' id='quotaUnit'>
                                <option value='{QuotaUnit::Hours}'>{translate key=hours}</option>
                                <option value='{QuotaUnit::Reservations}'>{translate key=reservations}</option>
                            </select>
                        </div>
                    {/capture}

                    {capture name="duration" assign="duration"}
                        <div class='input-field inline'>
                            <label for='quotaFrequency'></label>
                            <select {formname key=DURATION} id='quotaFrequency'>
                                <option value='{QuotaDuration::Day}'>{translate key=day}</option>
                                <option value='{QuotaDuration::Week}'>{translate key=week}</option>
                                <option value='{QuotaDuration::Month}'>{translate key=month}</option>
                                <option value='{QuotaDuration::Year}'>{translate key=year}</option>
                            </select>
                        </div>
                    {/capture}

                    {capture name="enforceHours" assign="enforceHours"}
                        <label for='enforce-all-day'>
                            <input type='checkbox' id='enforce-all-day' checked='checked'
                                   value='1' {formname key=ENFORCE_ALL_DAY}/>
                            <span>{translate key=AllDay}</span>
                        </label>
                        <div id='enforce-hours-times' class='inline no-show'>
                            <div class='input-field inline'>
                                <label for='enforce-time-start'>&nbsp;</label>

                                <input type='text' class='time' id='enforce-time-start' size='6'
                                       value='12:00am' {formname key=BEGIN_TIME} aria-label='Start Time'/>
                            </div>
					<div id='enforce-hours-times' class='inline no-show'>
						<div class='form-group form-group-sm'>
							<span>{translate key=Between}</span>
                            <label for='enforce-time-start' class='no-show'>{translate key=StartTime}</label>
                            <label for='enforce-time-end' class='no-show'>{translate key=EndTime}</label>
                            <input type='text' class='form-control time' id='enforce-time-start' size='6' value='12:00am' {formname key=BEGIN_TIME}/>
                            -
                            <div class='input-field inline'>
                                <label for='enforce-time-end'>&nbsp;</label>
                                <input type='text' class='time' id='enforce-time-end' size='6'
                                       value='12:00am' {formname key=END_TIME} aria-label='End Time'/>
                            </div>
                        </div>
                    {/capture}

                    {capture name="enforceDays" assign="enforceDays"}
                        <label for='enforce-every-day'><input type='checkbox' id='enforce-every-day'
                                                              checked='checked'
                                                              value='1' {formname key=ENFORCE_EVERY_DAY}/>
                            <span>{translate key=Everyday}</span>
                        </label>
                        <div id='enforce-days' class='inline no-show'>
                            <label for='enforce-sun'>
                                <input type='checkbox' id='enforce-sun' value='0' {formname key=DAY multi=true}/>
                                <span>{translate key="DaySundayAbbr"}</span>
                            </label>
                            <label for='enforce-mon'><input type='checkbox' id='enforce-mon'
                                                            value='1' {formname key=DAY multi=true}/>
                                <span>{translate key="DayMondayAbbr"}</span>
                            </label>
                            <label for='enforce-tue'><input type='checkbox' id='enforce-tue'
                                                            value='2' {formname key=DAY multi=true}/>
                                <span>{translate key="DayTuesdayAbbr"}</span>
                            </label>
                            <label for='enforce-wed'><input type='checkbox' id='enforce-wed'
                                                            value='3' {formname key=DAY multi=true}/>
                                <span>{translate key="DayWednesdayAbbr"}</span>
                            </label>
                            <label for='enforce-thu'>
                                <input type='checkbox' id='enforce-thu'
                                       value='4' {formname key=DAY multi=true}/>
                                <span>{translate key="DayThursdayAbbr"}</span>
                            </label>
                            <label for='enforce-fri'>
                                <input type='checkbox'
                                       id='enforce-fri'
                                       value='5' {formname key=DAY multi=true}/>
                                <span>{translate key="DayFridayAbbr"}</span>
                            </label>
                            <label for='enforce-sat'>
                                <input type='checkbox'
                                       id='enforce-sat'
                                       value='6' {formname key=DAY multi=true}/>
                                <span>{translate key="DaySaturdayAbbr"}</span>
                            </label>
                        </div>
                    {/capture}

                    {capture name="scope" assign="scope"}
                        <label for='quotaScope'>
                            <input type='checkbox' checked='checked' {formname key=QUOTA_SCOPE} id='quotaScope'/>
                            <span>{translate key=IncludingCompletedReservations}</span>
                        </label>
                    {/capture}

                    <div class="add-quota-line">{translate key=QuotaConfiguration args="$schedules,$resources,$groups,$amount,$unit,$duration"} {$scope}</div>
                    <div class="add-quota-line">{translate key=QuotaEnforcement args="$enforceHours,$enforceDays"}</div>

                </div>
                <div class="clearfix">&nbsp;</div>
            </div>
            <div class="card-action align-right">
                <div class="note left">{translate key=QuotaReminder}</div>
                {reset_button class="btn-small"}
                {add_button class="btn-small"}
                {indicator}
            </div>
        </div>
    </form>

    <div class="card" id="list-quotas-panel">
        <div class="card-content">
            <div class="panel-heading">{translate key="AllQuotas"}</div>
            <div class="panel-body no-padding" id="quotaList">
                {foreach from=$Quotas item=quota}
                    {capture name="scheduleName" assign="scheduleName"}
                        <span class='bold'>{if $quota->ScheduleName ne ""}
                                {$quota->ScheduleName|replace:',':' '}
                            {else}
                                {translate key="AllSchedules"}
                            {/if}
					</span>
                    {/capture}
                    {capture name="resourceName" assign="resourceName"}
                        <span class='bold'>{if $quota->ResourceName ne ""}
                                {$quota->ResourceName|replace:',':' '}
                            {else}
                                {translate key="AllResources"}
                            {/if}
					</span>
                    {/capture}
                    {capture name="groupName" assign="groupName"}
                        <span class='bold'>
						{if $quota->GroupName ne ""}
                            {$quota->GroupName|replace:',':' '}
                        {else}
                            {translate key="AllGroups"}
                        {/if}
					</span>
                    {/capture}
                    {capture name="amount" assign="amount"}
                        <span class='bold'>{$quota->Limit}</span>
                    {/capture}
                    {capture name="unit" assign="unit"}
                        <span class='bold'>{translate key=$quota->Unit}</span>
                    {/capture}
                    {capture name="duration" assign="duration"}
                        <span class='bold'>{translate key=$quota->Duration}</span>
                    {/capture}
                    {capture name="enforceHours" assign="enforceHours"}
                        <span class='bold'>
					{if $quota->AllDay}
                        {translate key=AllDay}
                    {else}
                        {translate key=Between} {formatdate date=$quota->EnforcedStartTime key=period_time} - {formatdate date=$quota->EnforcedEndTime key=period_time}
                    {/if}
					</span>
                    {/capture}
                    {capture name="enforceDays" assign="enforceDays"}
                        <span class='bold'>
					{if $quota->Everyday}
                        {translate key=Everyday}
                    {else}
                        {foreach from=$quota->EnforcedDays item=day}
                            {translate key=$DayNames[$day]}
                        {/foreach}
                    {/if}
					</span>
                    {/capture}
                    {capture name="scope" assign="scope"}
                        {if $quota->Scope == QuotaScope::IncludeCompleted}
                            {translate key=IncludingCompletedReservations}
                        {else}
                            {translate key=NotCountingCompletedReservations}
                        {/if}
                    {/capture}
                    {cycle values='row0,row1' assign=rowCss}
                    <div class="quotaItem {$rowCss}">
                        {translate key=QuotaConfiguration args="$scheduleName,$resourceName,$groupName,$amount,$unit,$duration"}
                        <span class="bold">{$scope}</span>.
                        {translate key=QuotaEnforcement args="$enforceHours,$enforceDays"}
                        <a href="#" quotaId="{$quota->Id}" class="delete pull-right"><span
                                    class="fa fa-trash icon remove"></span></a>
                    </div>
                    {foreachelse}
                    {translate key=None}
                {/foreach}
            </div>
        </div>
    </div>

    <div class="modal" id="deleteDialog" tabindex="-1" role="dialog" aria-labelledby="deleteModalLabel"
         aria-hidden="true">
        <div class="modal-content">
            <div class="modal-header">
                <h4 class="modal-title" id="deleteModalLabel">{translate key=Delete}</h4>
            </div>
            <div class="modal-body">
                <div class="card warning">
                    <div class="card-content">
                        {translate key=DeleteWarning}
                    </div>
                </div>
            </div>
            <div class="modal-footer">
                <form id="deleteQuotaForm" method="post">
                    {cancel_button}
                    {delete_button}
                    {indicator}
                </form>
            </div>
        </div>
    </div>

    {csrf_token}
    {include file="javascript-includes.tpl" Timepicker=true}
    {jsfile src="ajax-helpers.js"}
    {jsfile src="admin/quota.js"}
    {jsfile src="js/jquery.form-3.09.min.js"}

    <script type="text/javascript">
        $(document).ready(function () {

            $('#deleteDialog').modal();

            var actions = {
                addQuota: '{ManageQuotasActions::AddQuota}',
                deleteQuota: '{ManageQuotasActions::DeleteQuota}'
            };

            var quotaOptions = {
                submitUrl: '{$smarty.server.SCRIPT_NAME}',
                saveRedirect: '{$smarty.server.SCRIPT_NAME}',
                actions: actions
            };

            $('#enforce-time-start').timepicker({
				timeFormat: '{$TimeFormat}'
            });
            $('#enforce-time-end').timepicker({
				timeFormat: '{$TimeFormat}'
            });

            var quotaManagement = new QuotaManagement(quotaOptions);
            quotaManagement.init();

            $('#add-quota-panel').showHidePanel();
        });
    </script>
</div>
{include file='globalfooter.tpl'}