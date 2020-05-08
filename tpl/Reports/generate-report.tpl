{*
Copyright 2012-2020 Nick Korbel

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

{include file='globalheader.tpl' cssFiles="css/Chart-2.8.0.min.css" Select2=true FullWidth=true}

<div id="page-generate-report" class="page-report row">
    <div id="customReportInput-container">
        <form role="form" id="customReportInput">
            <div class="col s12 card" id="report-filter-panel">
                <div class="card-content">
                    <div>
                        <strong>{translate key=GenerateReport}</strong>
                        <a href="#">
                            <span class="no-show">Collapse</span>
                            <span class="icon show-hide fa fa-chevron-up"></span>
                        </a>
                    </div>
                    <div class="panel-body no-padding">
                        <div id="custom-report-input">
                            <div class="row input-set" id="selectDiv">
                                <div class="col s12 m1">
                                    <span>{translate key=Select}</span>
                                </div>
                                <div class="col s12 m11">
                                    <div class="inline">
                                        <label for="results_list">
                                            <input type="radio" {formname key=REPORT_RESULTS}
                                                   value="{Report_ResultSelection::FULL_LIST}"
                                                   id="results_list" checked="checked"/>
                                            <span>{translate key=List}</span>
                                        </label>
                                    </div>
                                    <div class="inline">
                                        <label for="results_time">
                                            <input type="radio" {formname key=REPORT_RESULTS}
                                                   value="{Report_ResultSelection::TIME}"
                                                   id="results_time"/>
                                            <span>{translate key=TotalTime}</span>
                                        </label>
                                    </div>
                                    <div class="inline">
                                        <label for="results_count">
                                            <input type="radio" {formname key=REPORT_RESULTS}
                                                   value="{Report_ResultSelection::COUNT}"
                                                   id="results_count"/>
                                            <span>{translate key=Count}</span>
                                        </label>
                                    </div>
                                    <div class="inline">
                                        <label for="results_utilization">
                                            <input type="radio" {formname key=REPORT_RESULTS}
                                                   value="{Report_ResultSelection::UTILIZATION}"
                                                   id="results_utilization"/>
                                            <span>{translate key=Utilization}</span>
                                        </label>
                                    </div>
                                </div>
                            </div>

                            <div class="row input-set select-toggle" id="listOfDiv">
                                <div class="col s12 m1">
                                    <span>{translate key=Usage}</span>
                                </div>
                                <div class="col s12 m11">
                                    <div class="inline">
                                        <label for="usage_resources">
                                            <input type="radio" {formname key=REPORT_USAGE}
                                                   value="{Report_Usage::RESOURCES}"
                                                   id="usage_resources"
                                                   checked="checked">
                                            <span>{translate key=Resources}</span>
                                        </label>
                                    </div>
                                    <div class="inline">
                                        <label for="usage_accessories">
                                            <input type="radio" {formname key=REPORT_USAGE}
                                                   value="{Report_Usage::ACCESSORIES}"
                                                   id="usage_accessories">
                                            <span>{translate key=Accessories}</span>
                                        </label>
                                    </div>
                                </div>
                            </div>

                            <div class="row input-set select-toggle" id="aggregateDiv" style="display:none;">
                                <div class="col s12 m1">
                                    <span class="">{translate key=AggregateBy}</span>
                                </div>
                                <div class="col s12 m11">
                                    <div class="inline">
                                        <label for="groupby_none">
                                            <input type="radio" {formname key=REPORT_GROUPBY}
                                                   value="{Report_GroupBy::NONE}"
                                                   id="groupby_none" checked="checked"/>
                                            <span>{translate key=None}</span>
                                        </label>
                                    </div>
                                    <div class="inline">
                                        <label for="groupby_resource">
                                            <input type="radio" {formname key=REPORT_GROUPBY}
                                                   value="{Report_GroupBy::RESOURCE}"
                                                   id="groupby_resource" class="utilization-eligible"/>
                                            <span>{translate key=Resource}</span>
                                        </label>
                                    </div>
                                    <div class="inline">
                                        <label for="groupby_schedule">
                                            <input type="radio" {formname key=REPORT_GROUPBY}
                                                   value="{Report_GroupBy::SCHEDULE}"
                                                   id="groupby_schedule" class="utilization-eligible"/>
                                            <span>{translate key=Schedule}</span>
                                        </label>
                                    </div>
                                    <div class="inline">
                                        <label for="groupby_user">
                                            <input type="radio" {formname key=REPORT_GROUPBY}
                                                   value="{Report_GroupBy::USER}"
                                                   id="groupby_user"/>
                                            <span>{translate key=User}</span>
                                        </label>
                                    </div>
                                    <div class="inline">
                                        <label for="groupby_group">
                                            <input type="radio" {formname key=REPORT_GROUPBY}
                                                   value="{Report_GroupBy::GROUP}"
                                                   id="groupby_group"/>
                                            <span>{translate key=Group}</span>
                                        </label>
                                    </div>
                                </div>
                            </div>
                            <div class="row input-set" id="rangeDiv">
                                <div class="col s12 m1">
                                    <span class="">{translate key=Range}</span>
                                </div>
                                <div class="col s12 m11">
                                    <div>
                                        <div class="inline">
                                            <label for="current_month">
                                                <input type="radio" {formname key=REPORT_RANGE}
                                                       value="{Report_Range::CURRENT_MONTH}" id="current_month"
                                                       checked="checked"/>
                                                <span>{translate key=CurrentMonth}</span>
                                            </label>
                                        </div>
                                        <div class="inline">
                                            <label for="current_week">
                                                <input type="radio" {formname key=REPORT_RANGE}
                                                       value="{Report_Range::CURRENT_WEEK}"
                                                       id="current_week"/>
                                                <span>{translate key=CurrentWeek}</span>
                                            </label>
                                        </div>
                                        <div class="inline">
                                            <label for="today">
                                                <input type="radio" {formname key=REPORT_RANGE}
                                                       value="{Report_Range::TODAY}"
                                                       id="today"/>
                                                <span>{translate key=Today}</span>
                                            </label>
                                        </div>
                                        <div class="inline">
                                            <label for="range_all"><input type="radio" {formname key=REPORT_RANGE}
                                                                          value="{Report_Range::ALL_TIME}"
                                                                          id="range_all"/>
                                                <span>{translate key=AllTime}</span>
                                            </label>
                                        </div>
                                    </div>
                                    <div>
                                        <label for="range_within" style="">
                                            <input type="radio" {formname key=REPORT_RANGE}
                                                   value="{Report_Range::DATE_RANGE}"
                                                   id="range_within"/>
                                            <span>{translate key=Between}</span>
                                        </label>
                                        <div class="input-field inline">
                                            <label for="startDate" class="active">{translate key=BeginDate}</label>
                                            <input type="text" class="dateinput inline" id="startDate"/>
                                            <input type="hidden" id="formattedBeginDate" {formname key=REPORT_START}/>
                                        </div>
                                        -
                                        <div class="input-field inline">
                                            <label for="endDate" class="active">{translate key=EndDate}</label>
                                            <input type="text" class="dateinput inline" id="endDate"/>
                                            <input type="hidden" id="formattedEndDate" {formname key=REPORT_END} />
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <div class="row input-set">
                                <div class="col s12 m1">
                                    <span class="">{translate key=FilterBy}</span>
                                </div>
                                <div class="col s12 m11">
                                    <div class="col s12">
                                        <label for="resourceId" class="no-show">{translate key=Resource}</label>
                                        <select class="browser-default" {formname key=RESOURCE_ID multi=true}
                                                multiple="multiple" id="resourceId">
                                            {foreach from=$Resources item=resource}
                                                <option value="{$resource->GetId()}">{$resource->GetName()}</option>
                                            {/foreach}
                                        </select>
                                    </div>
                                    <div class="col s12 m6">
                                        <label for="resourceTypeId" class="no-show">{translate key=ResourceType}</label>
                                        <select class="browser-default" {formname key=RESOURCE_TYPE_ID multi=true}
                                                multiple="multiple" id="resourceTypeId">
                                            {foreach from=$ResourceTypes item=resourceType}
                                                <option value="{$resourceType->Id()}">{$resourceType->Name()}</option>
                                            {/foreach}
                                        </select>
                                    </div>
                                    <div class="col s12 m6">
                                        <label for="accessoryId" class="no-show">{translate key=Accessory}</label>
                                        <select class="browser-default" {formname key=ACCESSORY_ID multi=true}
                                                multiple="multiple" id="accessoryId">
                                            {foreach from=$Accessories item=accessory}
                                                <option value="{$accessory->Id}">{$accessory->Name}</option>
                                            {/foreach}
                                        </select>
                                    </div>
                                    <div class="col s12 m6">
                                        <label for="scheduleId" class="no-show">{translate key=Schedule}</label>
                                        <select class="browser-default" {formname key=SCHEDULE_ID multi=true}
                                                multiple="multiple" id="scheduleId">
                                            {foreach from=$Schedules item=schedule}
                                                <option value="{$schedule->GetId()}">{$schedule->GetName()}</option>
                                            {/foreach}
                                        </select>
                                    </div>
                                    <div class="col s12 m6">
                                        <label for="groupId" class="no-show">{translate key=Group}</label>
                                        <select class="browser-default" {formname key=GROUP_ID multi=true}
                                                multiple="multiple"
                                                id="groupId">
                                            {foreach from=$Groups item=group}
                                                <option value="{$group->Id}">{$group->Name}</option>
                                            {/foreach}
                                        </select>
                                    </div>
                                    {*<div class="col m6 hide-on-small-only">&nbsp;</div>*}
                                    <div class="clearfix">&nbsp;</div>
                                    {*</div>*}
                                    {*<div class="col s12 m11 offset-m1">*}
                                    <div class="col s12 m6">
                                        <div id="user-filter-div">
                                            <div class="">
                                                <label class="control-label sr-only"
                                                       for="user-filter">{translate key=AllUsers}</label>
                                                <input id="user-filter" type="search"
                                                       placeholder="{translate key=AllUsers}"/>
                                                <input id="user_id" class="filter-id"
                                                       type="hidden" {formname key=USER_ID}/>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col s12 m6">
                                        <div id="participant-filter-div">
                                            <div class="form-group">
                                                <label class="control-label sr-only"
                                                       for="participant-filter">{translate key=AllParticipants}</label>
                                                <input id="participant-filter" type="search"
                                                       placeholder="{translate key=AllParticipants}"/>
                                                <input id="participant_id" class="filter-id"
                                                       type="hidden" {formname key=PARTICIPANT_ID}/>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="card-action">
                    <label for="chkIncludeDeleted">
                        <input type="checkbox" id="chkIncludeDeleted" {formname key=INCLUDE_DELETED}/>
                        <span>{translate key=IncludeDeleted}</span>
                    </label>

                    <input type="submit" value="{translate key=GetReport}" class="btn btn-primary btn-sm right"
                           id="btnCustomReport" asyncAction=""/>
                </div>
            </div>
            {csrf_token}
        </form>
    </div>
</div>

<div id="saveMessage" class="card success" style="display:none;">
    <div class="card-content">
        <strong>{translate key=ReportSaved}</strong> <a
                href="{$Path}reports/{Pages::REPORTS_SAVED}">{translate key=MySavedReports}</a>
    </div>
</div>

<div id="resultsDiv">
</div>

<div id="indicator" style="display:none; text-align: center;">
    <h3>{translate key=Working}</h3>
    {html_image src="admin-ajax-indicator.gif"}
</div>

{include file="Reports/chart.tpl"}

<div class="modal" id="saveDialog" tabindex="-1" role="dialog" aria-labelledby="saveDialogLabel"
     aria-hidden="true">

    <form id="saveReportForm" method="post">
        <div class="modal-content">
            <div class="modal-header">
                <h4 class="modal-title" id="saveDialogLabel">{translate key=SaveThisReport}</h4>
            </div>
            <div class="modal-body">
                <div class="form-group">
                    <label for="saveReportName">{translate key=Name}</label>
                    <input type="text" id="saveReportName" {formname key=REPORT_NAME} class="form-control"
                           placeholder="{translate key=NoTitleLabel}"/>
                </div>
            </div>
        </div>
        <div class="modal-footer">
            {cancel_button class="btnClearAddResources"}
            <button type="button" class="btn btn-primary btnConfirmAddResources waves-effect waves-light">
                {translate key='SaveThisReport'}
            </button>
            {indicator}
        </div>
    </form>

</div>

{include file="javascript-includes.tpl" Select2=true}
{jsfile src="autocomplete.js"}
{jsfile src="ajax-helpers.js"}
{jsfile src="reports/generate-reports.js"}
{jsfile src="reports/common.js"}
{jsfile src="reports/chart.js"}

<script type="text/javascript">
    $(document).ready(function () {
        var reportOptions = {
            userAutocompleteUrl: "{$Path}ajax/autocomplete.php?type={AutoCompleteType::User}",
            groupAutocompleteUrl: "{$Path}ajax/autocomplete.php?type={AutoCompleteType::Group}",
            customReportUrl: "{$smarty.server.SCRIPT_NAME}?{QueryStringKeys::ACTION}={ReportActions::Generate}",
            printUrl: "{$smarty.server.SCRIPT_NAME}?{QueryStringKeys::ACTION}={ReportActions::PrintReport}&",
            csvUrl: "{$smarty.server.SCRIPT_NAME}?{QueryStringKeys::ACTION}={ReportActions::Csv}&",
            saveUrl: "{$smarty.server.SCRIPT_NAME}?{QueryStringKeys::ACTION}={ReportActions::Save}"
        };

        var reports = new GenerateReports(reportOptions);
        reports.init();

        var common = new ReportsCommon({
            scriptUrl: '{$ScriptUrl}',
            chartOpts: {
                dateAxisFormat: '{$DateAxisFormat}'
            }
        });
        common.init();

        $('#resourceId').select2({
            placeholder: '{translate key=AllResources}'
        });
        $('#resourceTypeId').select2({
            placeholder: '{translate key=AllResourceTypes}'
        });
        $('#accessoryId').select2({
            placeholder: '{translate key=AllAccessories}'
        });
        $('#scheduleId').select2({
            placeholder: '{translate key=AllSchedules}'
        });
        $('#groupId').select2({
            placeholder: '{translate key=AllGroups}'
        });
    });

    $('#report-filter-panel').showHidePanel();


</script>

{control type="DatePickerSetupControl" ControlId="startDate" AltId="formattedBeginDate"}
{control type="DatePickerSetupControl" ControlId="endDate" AltId="formattedEndDate"}

</div>
{include file='globalfooter.tpl'}