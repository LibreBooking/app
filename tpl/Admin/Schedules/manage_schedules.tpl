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
{include file='globalheader.tpl' InlineEdit=true Fullcalendar=true Timepicker=true}

<div id="page-manage-schedules" class="admin-page">

    <h1>{translate key=ManageSchedules}</h1>

    <div class="panel panel-default admin-panel" id="list-schedules-panel">
        <div class="panel-heading">{translate key="AllSchedules"}
            <a href="#" class="add-link pull-right" id="add-schedule">{translate key="AddSchedule"}
                <span class="fa fa-plus-circle icon add"></span>
            </a>
        </div>
        <div class="panel-body no-padding" id="scheduleList">
            {foreach from=$Schedules item=schedule}
                {assign var=id value=$schedule->GetId()}
                {capture name=daysVisible}<span class='propertyValue daysVisible inlineUpdate' data-type='number'
                                                data-pk='{$id}'
                                                data-name='{FormKeys::SCHEDULE_DAYS_VISIBLE}'
                                                data-min='0'>{$schedule->GetDaysVisible()}</span>{/capture}
                {assign var=dayOfWeek value=$schedule->GetWeekdayStart()}
                {capture name=dayName}<span class='propertyValue dayName inlineUpdate' data-type='select'
                                            data-pk='{$id}'
                                            data-name='{FormKeys::SCHEDULE_WEEKDAY_START}'
                                            data-value='{$dayOfWeek}'>{if $dayOfWeek == Schedule::Today}{$Today}{else}{$DayNames[$dayOfWeek]}{/if}</span>{/capture}
                <div class="scheduleDetails" data-schedule-id="{$id}">
                    <div class="col-xs-12 col-sm-6">
                        <input type="hidden" class="id" value="{$id}"/>
                        <input type="hidden" class="daysVisible" value="{$daysVisible}"/>
                        <input type="hidden" class="dayOfWeek" value="{$dayOfWeek}"/>

                        <div>
					<span class="title scheduleName" data-type="text" data-pk="{$id}"
                          data-name="{FormKeys::SCHEDULE_NAME}">{$schedule->GetName()}</span>
                            <a class="update renameButton" href="#"><span class="no-show">{translate key=Rename}</span><span class="fa fa-pencil-square-o"></span></a>
                        </div>

                        <div>{translate key="LayoutDescription" args="{$smarty.capture.dayName}, {$smarty.capture.daysVisible}"}</div>

                        <div>{translate key='ScheduleAdministrator'}
                            <span class="propertyValue scheduleAdmin"
                                  data-type="select" data-pk="{$id}" data-value="{$schedule->GetAdminGroupId()}"
                                  data-name="{FormKeys::SCHEDULE_ADMIN_GROUP_ID}">{$GroupLookup[$schedule->GetAdminGroupId()]->Name}</span>
                            {if $AdminGroups|count > 0}
                                <a class="update changeScheduleAdmin" href="#">
                                    <span class="no-show">{translate key='ScheduleAdministrator'}</span>
                                    <span class="fa fa-pencil-square-o"></span
                                </a>
                            {/if}
                        </div>

                        <div>
                            <div class="availabilityPlaceHolder inline-block">
                                {include file="Admin/Schedules/manage_availability.tpl" schedule=$schedule timezone=$Timezone}
                            </div>
                            <a class="update changeAvailability inline-block" href="#">
                                <span class="no-show">Change Availability</span>
                                <span class="fa fa-pencil-square-o"></span>
                            </a>
                        </div>

                        <div class="concurrentContainer">
                            <span class="allowConcurrentYes {if !$schedule->GetAllowConcurrentReservations()}no-show{/if}">{translate key=ConcurrentYes}</span>
                            <span class="allowConcurrentNo {if $schedule->GetAllowConcurrentReservations()}no-show{/if}">{translate key=ConcurrentNo}</span>
                            <a class="update toggleConcurrent" href="#"
                               data-allow="{$schedule->GetAllowConcurrentReservations()|intval}">{translate key=Change}</a>
                        </div>

                        <div>
                            {translate key=DefaultStyle}
                            <span class="propertyValue defaultScheduleStyle inlineUpdate" data-type="select"
                                  data-pk="{$id}"
                                  data-name="{FormKeys::SCHEDULE_DEFAULT_STYLE}"
                                  data-value="{$schedule->GetDefaultStyle()}">{$StyleNames[$schedule->GetDefaultStyle()]}</span>
                        </div>

                        {if $CreditsEnabled}
                            <span>{translate key=PeakTimes}</span>
                            <a class="update changePeakTimes" href="#">
                                <span class="no-show">{translate key=PeakTimes}</span>
                                <span class="fa fa-pencil-square-o"></span>
                            </a>
                            <div class="peakPlaceHolder">
                                {include file="Admin/Schedules/manage_peak_times.tpl" Layout=$Layouts[$id] Months=$Months DayNames=$DayNames}
                            </div>
                        {/if}

                        <div>{translate key=Resources}
                            <span class="propertyValue">
                            {if array_key_exists($id, $Resources)}
                                {foreach from=$Resources[$id] item=r name=resources_loop}
                                    {$r->GetName()|escape}{if !$smarty.foreach.resources_loop.last}, {/if}
                                {/foreach}
                            {else}
                                {translate key=None}
                            {/if}
                            </span>
                        </div>

                        {if $schedule->GetIsCalendarSubscriptionAllowed()}
                        <div>
                            <span>{translate key=PublicId}</span>
                            <span class="propertyValue">{$schedule->GetPublicId()}</span>
                        </div>
                        {/if}

                    </div>

                    <div class="layout col-xs-12 col-sm-6">
                        {function name="display_periods"}
                            {foreach from=$Layouts[$id]->GetSlots($day) item=period name=layouts}
                                {if $period->IsReservable() == $showReservable}
                                    {$period->Start->Format("H:i")} - {$period->End->Format("H:i")}
                                    {if $period->IsLabelled()}
                                        {$period->Label}
                                    {/if}
                                    {if !$smarty.foreach.layouts.last}, {/if}
                                {/if}
                                {foreachelse}
                                {translate key=None}
                            {/foreach}
                        {/function}

                        <div>
                            {translate key=ScheduleLayout args=$schedule->GetTimezone()}
                            <a class="update changeLayoutButton" href="#" title="{translate key=ChangeLayout}">
                                <span class="fa fa-pencil-square-o"
                                        data-layout-type="{$Layouts[$id]->GetType()}"></span>
                                <span class="no-show">{translate key=ChangeLayout}</span>
                            </a>
                        </div>
                        <input type="hidden" class="timezone" value="{$schedule->GetTimezone()}"/>

                        {if $Layouts[$id]->UsesDailyLayouts()}
                            <input type="hidden" class="usesDailyLayouts" value="true"/>
                            {translate key=LayoutVariesByDay} -
                            <a href="#" class="showAllDailyLayouts">{translate key=ShowHide}</a>
                            <div class="allDailyLayouts">
                                {foreach from=DayOfWeek::Days() item=day}
                                    {$DayNames[$day]}
                                    <div class="reservableSlots" id="reservableSlots_{$day}"
                                         ref="reservableEdit_{$day}">
                                        {display_periods showReservable=true day=$day}
                                    </div>
                                    <div class="blockedSlots" id="blockedSlots_{$day}" ref="blockedEdit_{$day}">
                                        {display_periods showReservable=false day=$day}
                                    </div>
                                {/foreach}
                            </div>
                            <div class="margin-top-25"><strong>{translate key=ThisScheduleUsesAStandardLayout}</strong>
                            </div>
                            <div><a href="#" class="update switchLayout"
                                    data-switch-to="{ScheduleLayout::Custom}">{translate key=SwitchToACustomLayout}</a>
                            </div>
                        {elseif $Layouts[$id]->UsesCustomLayout()}
                            <div><strong>{translate key=ThisScheduleUsesACustomLayout}</strong></div>
                            <div><a href="#" class="update switchLayout"
                                    data-switch-to="{ScheduleLayout::Standard}">{translate key=SwitchToAStandardLayout}</a>
                            </div>
                        {else}
                            <input type="hidden" class="usesDailyLayouts" value="false"/>
                            {translate key=ReservableTimeSlots}
                            <div class="reservableSlots" id="reservableSlots" ref="reservableEdit">
                                {display_periods showReservable=true day=null}
                            </div>
                            {translate key=BlockedTimeSlots}
                            <div class="blockedSlots" id="blockedSlots" ref="blockedEdit">
                                {display_periods showReservable=false day=null}
                            </div>
                            <div class="margin-top-25"><strong>{translate key=ThisScheduleUsesAStandardLayout}</strong>
                            </div>
                            <div><a href="#" class="update switchLayout"
                                    data-switch-to="{ScheduleLayout::Custom}">{translate key=SwitchToACustomLayout}</a>
                            </div>
                        {/if}
                    </div>
                    <div class="actions col-xs-12">
                        {if $schedule->GetIsDefault()}
                            <span class="note">{translate key=ThisIsTheDefaultSchedule}</span>
                            |
                            <span class="note">{translate key=DefaultScheduleCannotBeDeleted}</span>
                            |
                        {else}
                            <a class="update makeDefaultButton" href="#">{translate key=MakeDefault}</a>
                            |
                            <a class="update deleteScheduleButton" href="#">{translate key=Delete}</a>
                            |
                        {/if}
                        {if $schedule->GetIsCalendarSubscriptionAllowed()}
                            <a class="update disableSubscription"
                               href="#">{translate key=TurnOffSubscription}</a>
                            |
                        {else}
                            <a class="update enableSubscription" href="#">{translate key=TurnOnSubscription}</a>
                        {/if}
                        {if $schedule->GetIsCalendarSubscriptionAllowed()}
                            {html_image src="feed.png"}
                            <a target="_blank" href="{$schedule->GetSubscriptionUrl()->GetAtomUrl()}">Atom</a>
                            |
                            <a target="_blank" href="{$schedule->GetSubscriptionUrl()->GetWebcalUrl()}">iCalendar</a>
                        {/if}
                        {indicator id="action-indicator"}
                        <div class="clear"></div>
                    </div>
                </div>
            {/foreach}
        </div>
    </div>

    {pagination pageInfo=$PageInfo}

    <div id="addDialog" class="modal fade" tabindex="-1" role="dialog" aria-labelledby="addScheduleDialogLabel"
         aria-hidden="true">
        <form id="addScheduleForm" method="post">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header">
                        <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                        <h4 class="modal-title" id="addScheduleDialogLabel">{translate key=AddSchedule}</h4>
                    </div>
                    <div class="modal-body">
                        <div class="form-group has-feedback">
                            <label for="addName">{translate key=Name}</label>
                            <input type="text" id="addName"
                                   class="form-control required" {formname key=SCHEDULE_NAME} />
                            <i class="glyphicon glyphicon-asterisk form-control-feedback"
                               data-bv-icon-for="addName"></i>
                        </div>
                        <div class="form-group">
                            <label for="addStartsOn">{translate key=StartsOn}</label>
                            <select {formname key=SCHEDULE_WEEKDAY_START} class="form-control" id="addStartsOn">
                                <option value="{Schedule::Today}">{$Today}</option>
                                {foreach from=$DayNames item="dayName" key="dayIndex"}
                                    <option value="{$dayIndex}">{$dayName}</option>
                                {/foreach}
                            </select>
                        </div>
                        <div class="form-group">
                            <label for="addNumDaysVisible">{translate key=NumberOfDaysVisible}</label>
                            <input type="number" min="1" max="100" class="form-control required" id="addNumDaysVisible"
                                   value="7" {formname key=SCHEDULE_DAYS_VISIBLE} />
                        </div>
                        <div class="form-group">
                            <label for="addSameLayoutAs">{translate key=UseSameLayoutAs}</label>
                            <select class="form-control" {formname key=SCHEDULE_ID} id="addSameLayoutAs">
                                {foreach from=$SourceSchedules item=schedule}
                                    <option value="{$schedule->GetId()}">{$schedule->GetName()}</option>
                                {/foreach}
                            </select>
                        </div>
                    </div>
                    <div class="modal-footer">
                        {cancel_button}
                        {add_button submit=true}
                        {indicator}
                    </div>
                </div>
            </div>
        </form>
    </div>

    <input type="hidden" id="activeId" value=""/>

    <div id="deleteDialog" class="modal fade" tabindex="-1" role="dialog" aria-labelledby="deleteScheduleDialogLabel"
         aria-hidden="true">
        <form id="deleteForm" method="post">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header">
                        <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                        <h4 class="modal-title" id="deleteScheduleDialogLabel">{translate key=Delete}</h4>
                    </div>
                    <div class="modal-body">
                        <div class="form-group">
                            <label for="targetScheduleId">{translate key=MoveResourcesAndReservations}</label>
                            <select id="targetScheduleId" {formname key=SCHEDULE_ID} class="form-control required">
                                <option value="">-- {translate key=Schedule} --</option>
                                {foreach from=$Schedules item=schedule}
                                    <option value="{$schedule->GetId()}">{$schedule->GetName()}</option>
                                {/foreach}
                            </select>
                        </div>
                    </div>
                    <div class="modal-footer">
                        {cancel_button}
                        {delete_button}
                        {indicator}
                    </div>
                </div>
            </div>
        </form>
    </div>

    <div id="changeLayoutDialog" class="modal fade" tabindex="-1" role="dialog"
         aria-labelledby="changeLayoutDialogLabel" aria-hidden="true">
        <form id="changeLayoutForm" method="post" role="form" class="form-inline">
            <div class="modal-dialog modal-lg">
                <div class="modal-content">
                    <div class="modal-header">
                        <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                        <h4 class="modal-title" id="changeLayoutDialogLabel">{translate key=ChangeLayout}</h4>
                    </div>
                    <div class="modal-body">
                        <div class="validationSummary alert alert-danger no-show">
                            <ul>{async_validator id="layoutValidator" key="ValidLayoutRequired"}</ul>
                        </div>

                        <div class="col-xs-12">
                            <div class="checkbox">
                                <input type="checkbox" id="usesSingleLayout" {formname key=USING_SINGLE_LAYOUT}>
                                <label for="usesSingleLayout">{translate key=UseSameLayoutForAllDays}</label>
                            </div>
                        </div>

                        {function name=display_slot_inputs}
                            <div id="{$id}" class="col-xs-12">
                                {assign var=suffix value=""}
                                {if $day!=null}
                                    {assign var=suffix value="_$day"}
                                {/if}
                                <div class="col-xs-6">
                                    <label for="reservableEdit{$suffix}">{translate key=ReservableTimeSlots}</label>
                                    <textarea class="reservableEdit form-control" id="reservableEdit{$suffix}"
                                              name="{FormKeys::SLOTS_RESERVABLE}{$suffix}"></textarea>
                                </div>
                                <div class="col-xs-6">
                                    <label for="blockedEdit{$suffix}">{translate key=BlockedTimeSlots}</label> <a
                                            href="#" class="autofillBlocked" title="{translate key=Autofill}"><i
                                                class="fa fa-magic"></i> {translate key=Autofill}</a>
                                    <textarea class="blockedEdit form-control" id="blockedEdit{$suffix}"
                                              name="{FormKeys::SLOTS_BLOCKED}{$suffix}"></textarea>
                                </div>
                            </div>
                        {/function}

                        <div class="col-xs-12" id="dailySlots">
                            <div role="tabpanel" id="tabs">
                                <ul class="nav nav-tabs" role="tablist">
                                    <li role="presentation" class="active"><a href="#tabs-0" aria-controls="tabs-0"
                                                                              role="tab"
                                                                              data-toggle="tab">{$DayNames[0]}</a></li>
                                    <li role="presentation"><a href="#tabs-1" aria-controls="tabs-1" role="tab"
                                                               data-toggle="tab">{$DayNames[1]}</a></li>
                                    <li role="presentation"><a href="#tabs-2" aria-controls="tabs-2" role="tab"
                                                               data-toggle="tab">{$DayNames[2]}</a></li>
                                    <li role="presentation"><a href="#tabs-3" aria-controls="tabs-3" role="tab"
                                                               data-toggle="tab">{$DayNames[3]}</a></li>
                                    <li role="presentation"><a href="#tabs-4" aria-controls="tabs-4" role="tab"
                                                               data-toggle="tab">{$DayNames[4]}</a></li>
                                    <li role="presentation"><a href="#tabs-5" aria-controls="tabs-5" role="tab"
                                                               data-toggle="tab">{$DayNames[5]}</a></li>
                                    <li role="presentation"><a href="#tabs-6" aria-controls="tabs-6" role="tab"
                                                               data-toggle="tab">{$DayNames[6]}</a></li>
                                </ul>
                                <div class="tab-content">
                                    <div role="tabpanel" class="tab-pane active" id="tabs-0">
                                        {display_slot_inputs day='0'}
                                    </div>
                                    <div role="tabpanel" class="tab-pane" id="tabs-1">
                                        {display_slot_inputs day='1'}
                                    </div>
                                    <div role="tabpanel" class="tab-pane" id="tabs-2">
                                        {display_slot_inputs day='2'}
                                    </div>
                                    <div role="tabpanel" class="tab-pane" id="tabs-3">
                                        {display_slot_inputs day='3'}
                                    </div>
                                    <div role="tabpanel" class="tab-pane" id="tabs-4">
                                        {display_slot_inputs day='4'}
                                    </div>
                                    <div role="tabpanel" class="tab-pane" id="tabs-5">
                                        {display_slot_inputs day='5'}
                                    </div>
                                    <div role="tabpanel" class="tab-pane" id="tabs-6">
                                        {display_slot_inputs day='6'}
                                    </div>
                                </div>
                            </div>
                        </div>

                        {display_slot_inputs id="staticSlots" day=null}

                        <div class="slotTimezone col-xs-12">
                            <label for="layoutTimezone">{translate key=Timezone}</label>
                            <select {formname key=TIMEZONE} id="layoutTimezone" class="form-control">
                                {html_options values=$TimezoneValues output=$TimezoneOutput}
                            </select>
                        </div>

                        <div class="slotWizard col-xs-12">
                            <h5>
                                {capture name="layoutConfig" assign="layoutConfig"}
                                    <input type='number' min='0' step='15' value='30' id='quickLayoutConfig' size=5'
                                           title='Minutes' class='form-control'/>
                                {/capture}
                                {capture name="layoutStart" assign="layoutStart"}
                                    <input type='text' value='08:00' id='quickLayoutStart' size='10' title='From time'
                                           class='form-control' maxlength='5'/>
                                {/capture}
                                {capture name="layoutEnd" assign="layoutEnd"}
                                    <input type='text' value='18:00' id='quickLayoutEnd' size='10' title='End time'
                                           class='form-control' maxlength='5'/>
                                {/capture}
                                {translate key=QuickSlotCreation args="$layoutConfig,$layoutStart,$layoutEnd"}
                                <a href="#" id="createQuickLayout">{translate key=Create}</a>
                            </h5>
                        </div>
                        <div class="slotHelpText col-xs-12">
                            <p>{translate key=Format}: <span>HH:MM - HH:MM {translate key=OptionalLabel}</span></p>

                            <p>{translate key=LayoutInstructions}</p>
                        </div>

                        <div class="clearfix"></div>
                    </div>
                    <div class="modal-footer">
                        {cancel_button}
                        {update_button}
                        {indicator}
                    </div>
                </div>
            </div>
        </form>
    </div>

    <div id="peakTimesDialog" class="modal fade" tabindex="-1" role="dialog" aria-labelledby="peakTimesDialogLabel"
         aria-hidden="true">
        <form id="peakTimesForm" method="post">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header">
                        <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                        <h4 class="modal-title" id="peakTimesDialogLabel">{translate key=PeakTimes}</h4>
                    </div>
                    <div class="modal-body">
                        <div class="form-group">
                            <div class="checkbox">
                                <input type="checkbox" id="peakAllDay" {formname key=PEAK_ALL_DAY} />
                                <label for="peakAllDay">{translate key=AllDay}</label>
                            </div>
                            <div id="peakTimes">
                                {translate key=Between}
                                <label for="peakStartTime" class="no-show">Peak Begin Time</label>
                                <label for="peakEndTime" class="no-show">Peak End Time</label>
                                <input type="text" id="peakStartTime"
                                       class="form-control input-sm inline-block timeinput timepicker"
                                       value="{formatdate date=$DefaultDate format='h:i A'}" {formname key=PEAK_BEGIN_TIME}/>
                                -
                                <input type="text" id="peakEndTime"
                                       class="form-control input-sm inline-block timeinput timepicker"
                                       value="{formatdate date=$DefaultDate->AddHours(9) format='h:i A'}" {formname key=PEAK_END_TIME}/>
                            </div>
                        </div>
                        <div class="form-group">
                            <div class="checkbox">
                                <input type="checkbox" id="peakEveryDay"
                                       checked="checked" {formname key=PEAK_EVERY_DAY} />
                                <label for="peakEveryDay">{translate key=Everyday}</label>
                            </div>
                            <div id="peakDayList" class="no-show">
                                <div class="btn-group" data-toggle="buttons">
                                    <label class="btn btn-default btn-sm">
                                        <input type="checkbox" id="peakDay0" {formname key=repeat_sunday} />
                                        {$DayNames[0]}
                                    </label>
                                    <label class="btn btn-default btn-sm">
                                        <input type="checkbox" id="peakDay1" {formname key=repeat_monday} />
                                        {$DayNames[1]}
                                    </label>
                                    <label class="btn btn-default btn-sm">
                                        <input type="checkbox" id="peakDay2" {formname key=repeat_tuesday} />
                                        {$DayNames[2]}
                                    </label>
                                    <label class="btn btn-default btn-sm">
                                        <input type="checkbox" id="peakDay3" {formname key=repeat_wednesday} />
                                        {$DayNames[3]}
                                    </label>
                                    <label class="btn btn-default btn-sm">
                                        <input type="checkbox" id="peakDay4" {formname key=repeat_thursday} />
                                        {$DayNames[4]}
                                    </label>
                                    <label class="btn btn-default btn-sm">
                                        <input type="checkbox" id="peakDay5" {formname key=repeat_friday} />
                                        {$DayNames[5]}
                                    </label>
                                    <label class="btn btn-default btn-sm">
                                        <input type="checkbox" id="peakDay6" {formname key=repeat_saturday} />
                                        {$DayNames[6]}
                                    </label>
                                </div>
                            </div>
                        </div>
                        <div class="form-group">
                            <div class="checkbox">
                                <input type="checkbox" id="peakAllYear"
                                       checked="checked" {formname key=PEAK_ALL_YEAR} />
                                <label for="peakAllYear">{translate key=AllYear}</label>
                            </div>
                            <div id="peakDateRange" class="no-show">
                                <label for="peakBeginMonth" class="col-xs-2">{translate key=BeginDate}</label>
                                <div class="col-xs-5">
                                    <select id="peakBeginMonth"
                                            class="form-control input-sm" {formname key=PEAK_BEGIN_MONTH}>
                                        {foreach from=$Months item=month name=startMonths}
                                            <option value="{$smarty.foreach.startMonths.iteration}">{$month}</option>
                                        {/foreach}
                                    </select>
                                </div>
                                <div class="col-xs-2">
                                    <label for="peakBeginDay" class="no-show">Peak Begin Day</label>
                                    <select id="peakBeginDay"
                                            class="form-control input-sm" {formname key=PEAK_BEGIN_DAY}>
                                        {foreach from=$DayList item=day}
                                            <option value="{$day}">{$day}</option>
                                        {/foreach}
                                    </select>
                                </div>
                                <div class="col-xs-3">&nbsp;</div>
                                <div class="clearfix"></div>
                                <label for="peakEndMonth" class="col-xs-2">{translate key=EndDate}</label>
                                <div class="col-xs-5">
                                    <select id="peakEndMonth"
                                            class="form-control input-sm" {formname key=PEAK_END_MONTH}>
                                        {foreach from=$Months item=month name=endMonths}
                                            <option value="{$smarty.foreach.endMonths.iteration}">{$month}</option>
                                        {/foreach}
                                    </select>
                                </div>
                                <div class="col-xs-2">
                                    <label for="peakEndDay" class="no-show">Peak End Day</label>
                                    <select id="peakEndDay" class="form-control input-sm" {formname key=PEAK_END_DAY}>
                                        {foreach from=$DayList item=day}
                                            <option value="{$day}">{$day}</option>
                                        {/foreach}
                                    </select>
                                </div>
                                <div class="col-xs-3">&nbsp;</div>
                            </div>
                        </div>
                        <div class="clearfix"></div>
                        <input type="hidden" {formname key=PEAK_DELETE} id="deletePeakTimes" value=""/>
                    </div>
                    <div class="modal-footer">
                        {delete_button class='pull-left' id="deletePeakBtn"}
                        {cancel_button}
                        {update_button}
                        {indicator}
                    </div>
                </div>
            </div>
        </form>
    </div>

    <div id="availabilityDialog" class="modal fade" tabindex="-1" role="dialog"
         aria-labelledby="availabilityDialogLabel"
         aria-hidden="true">
        <form id="availabilityForm" method="post">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header">
                        <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                        <h4 class="modal-title" id="availabilityDialogLabel">{translate key=Availability}</h4>
                    </div>
                    <div class="modal-body">
                        <div class="form-group">
                            <div class="checkbox">
                                <input type="checkbox" id="availableAllYear" {formname key=AVAILABLE_ALL_YEAR} />
                                <label for="availableAllYear">{translate key=AvailableAllYear}</label>
                            </div>
                            <div id="availableDates">
                                {translate key=AvailableBetween}
                                <label for="availabilityStartDate" class="no-show">Available Start Date</label>
                                <label for="availabilityEndDate" class="no-show">Available End Date</label>
                                <input type="text" id="availabilityStartDate"
                                       class="form-control input-sm inline-block dateinput"/>
                                <input type="hidden" id="formattedBeginDate" {formname key=AVAILABLE_BEGIN_DATE} />
                                -
                                <input type="text" id="availabilityEndDate"
                                       class="form-control input-sm inline-block dateinput"/>
                                <input type="hidden" id="formattedEndDate" {formname key=AVAILABLE_END_DATE} />
                            </div>
                        </div>
                        <div class="clearfix"></div>
                    </div>
                    <div class="modal-footer">
                        {cancel_button}
                        {update_button}
                        {indicator}
                    </div>
                </div>
            </div>
        </form>
    </div>

    <div id="switchLayoutDialog" class="modal fade" tabindex="-1" role="dialog"
         aria-labelledby="switchLayoutDialogLabel"
         aria-hidden="true">
        <form id="switchLayoutForm" method="post">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header">
                        <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                        <h4 class="modal-title" id="switchLayoutDialogLabel">{translate key=ChangeLayout}</h4>
                    </div>
                    <div class="modal-body">
                        <div class="alert alert-warning">
                            {translate key=SwitchLayoutWarning}
                        </div>
                        <input type="hidden" id="switchLayoutTypeId" {formname key=LAYOUT_TYPE} />
                        <div class="clearfix"></div>
                    </div>
                    <div class="modal-footer">
                        {cancel_button}
                        {update_button submit=true}
                        {indicator}
                    </div>
                </div>
            </div>
        </form>
    </div>

    <div id="customLayoutDialog" class="modal fade" tabindex="-1" role="dialog"
         aria-labelledby="customLayoutDialogLabel"
         aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                    <h4 class="modal-title" id="customLayoutDialogLabel">{translate key=ChangeLayout}</h4>
                </div>
                <div class="modal-body">
                    <div id="calendar"></div>
                </div>
            </div>
        </div>
    </div>

    <form id="concurrentForm" method="post">
    </form>

    <form id="layoutSlotForm" method="post">
        <input type="hidden" id="slotStartDate" {formname key=BEGIN_DATE} />
        <input type="hidden" id="slotEndDate" {formname key=END_DATE} />
        <input type="hidden" id="slotId" {formname key=LAYOUT_PERIOD_ID} />
    </form>

    <div id="deleteCustomLayoutDialog" style="z-index:10000;" class="default-box-shadow">
        <form id="deleteCustomTimeSlotForm" method="post">
            <input type="hidden" id="deleteSlotStartDate" {formname key=BEGIN_DATE} />
            <input type="hidden" id="deleteSlotEndDate" {formname key=END_DATE} />
            <div>{translate key=DeleteThisTimeSlot}</div>
            <div>
                {cancel_button id=cancelDeleteSlot}
                {delete_button id=deleteSlot}
            </div>
        </form>
    </div>

    <div id="confirmCreateSlotDialog" class="default-box-shadow" style="z-index:10000;">
        {cancel_button id="cancelCreateSlot"}
        {add_button id="confirmCreateOK"}
    </div>

    {control type="DatePickerSetupControl" ControlId="availabilityStartDate" AltId="formattedBeginDate" DefaultDate=$StartDate}
    {control type="DatePickerSetupControl" ControlId="availabilityEndDate" AltId="formattedEndDate" DefaultDate=$EndDate}

    {csrf_token}
    {include file="javascript-includes.tpl" InlineEdit=true Fullcalendar=true Timepicker=true}
    {jsfile src="ajax-helpers.js"}
    {jsfile src="admin/schedule.js"}
    {jsfile src="js/jquery.form-3.09.min.js"}

    <script type="text/javascript">

        function setUpEditables() {
            $.fn.editable.defaults.mode = 'popup';
            $.fn.editable.defaults.toggle = 'manual';
            $.fn.editable.defaults.emptyclass = '';
            $.fn.editable.defaults.params = function (params) {
                params.CSRF_TOKEN = $('#csrf_token').val();
                return params;
            };

            var updateUrl = '{$smarty.server.SCRIPT_NAME}?action=';

            $('.scheduleName').editable({
                url: updateUrl + '{ManageSchedules::ActionRename}', validate: function (value) {
                    if ($.trim(value) == '') {
                        return '{translate key=RequiredValue|escape:'javascript'}';
                    }
                }
            });

            $('.daysVisible').editable({
                url: updateUrl + '{ManageSchedules::ActionChangeDaysVisible}'
            });

            $('.dayName').editable({
                url: updateUrl + '{ManageSchedules::ActionChangeStartDay}', source: [{
                    value: '{Schedule::Today}', text: '{$Today|escape:'javascript'}'
                },
                    {foreach from=$DayNames item="dayName" key="dayIndex"}
                    {
                        value:{$dayIndex}, text: '{$dayName|escape:'javascript'}'
                    },
                    {/foreach}
                ]
            });

            $('.defaultScheduleStyle').editable({
                url: updateUrl + '{ManageSchedules::ActionChangeDefaultStyle}',
                source: [
                    {foreach from=$StyleNames item="styleName" key="styleIndex"}
                    {
                        value:'{$styleIndex}', text:'{$styleName|escape:'javascript'}'
                    },
                    {/foreach}
                ]
            });

            $('.scheduleAdmin').editable({
                url: updateUrl + '{ManageSchedules::ChangeAdminGroup}',
                emptytext: '{{translate key=None}|escape:'javascript'}',
                source: [{
                    value: '0', text: '{{translate key=None}|escape:'javascript'}'
                },
                    {foreach from=$AdminGroups item=group}
                    {
                        value:{$group->Id()}, text: '{$group->Name()|escape:'javascript'}'
                    },
                    {/foreach}
                ]
            });
        }

        $(document).ready(function () {
            setUpEditables();

            var opts = {
                submitUrl: '{$smarty.server.SCRIPT_NAME}',
                saveRedirect: '{$smarty.server.SCRIPT_NAME}',
                changeLayoutAction: '{ManageSchedules::ActionChangeLayout}',
                addAction: '{ManageSchedules::ActionAdd}',
                peakTimesAction: '{ManageSchedules::ActionChangePeakTimes}',
                makeDefaultAction: '{ManageSchedules::ActionMakeDefault}',
                deleteAction: '{ManageSchedules::ActionDelete}',
                availabilityAction: '{ManageSchedules::ActionChangeAvailability}',
                enableSubscriptionAction: '{ManageSchedules::ActionEnableSubscription}',
                disableSubscriptionAction: '{ManageSchedules::ActionDisableSubscription}',
                toggleConcurrentReservations: '{ManageSchedules::ActionToggleConcurrentReservations}',
                switchLayout: '{ManageSchedules::ActionSwitchLayoutType}',
                addLayoutSlot: '{ManageSchedules::ActionAddLayoutSlot}',
                updateLayoutSlot: '{ManageSchedules::ActionUpdateLayoutSlot}',
                deleteLayoutSlot: '{ManageSchedules::ActionDeleteLayoutSlot}',
                calendarOptions: {
                    buttonText: {
                        today: '{{translate key=Today}|escape:'javascript'}',
                        month: '{{translate key=Month}|escape:'javascript'}',
                        week: '{{translate key=Week}|escape:'javascript'}',
                        day: '{{translate key=Day}|escape:'javascript'}'
                    },
                    defaultDate: moment('{Date::Now()->ToTimezone({$Timezone})->Format('Y-m-d')}', 'YYYY-MM-DD'),
                    eventsUrl: '{$smarty.server.SCRIPT_NAME}'
                }
            };

            var scheduleManagement = new ScheduleManagement(opts);
            scheduleManagement.init();

            $('.timepicker').timepicker({
                timeFormat: '{$TimeFormat}'
            });


        });

    </script>

</div>
{include file='globalfooter.tpl'}