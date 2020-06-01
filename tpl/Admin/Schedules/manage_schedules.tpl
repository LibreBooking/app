{*
Copyright 2011-2020 Nick Korbel

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
{include file='globalheader.tpl' InlineEdit=true Fullcalendar=true Qtip=true Select2=true}

<div id="page-manage-schedules" class="admin-page row">

	<div>
		<div class="right">
			<button class="add-schedule-prompt btn admin-action-button waves-effect waves-light" id="add-schedule-prompt">
                {translate key="AddSchedule"}
				<span class="fas fa-plus-circle icon"></span>
			</button>
		</div>
		<h1 class="page-title underline">{translate key=ManageSchedules}</h1>
	</div>

	<div class="card admin-panel" id="list-schedules-panel">
		<div class="card-content">
			<div class="panel-body" id="scheduleList">
                {foreach from=$Schedules item=schedule}
                    {assign var=id value=$schedule->GetId()}
                    {capture name=daysVisible}
						<div class='inline-edit-container inline-edit-days-visible'>
							<span class='propertyValue daysVisible inlineUpdate inline-edit-display inline-edit-activator'
								  data-type='select'
								  data-pk='{$id}'
								  data-value='{$schedule->GetDaysVisible()}'
								  title='{translate key=Edit}'>{$schedule->GetDaysVisible()}</span>
							<div class='input-field no-show inline-edit-editable'>
								<label for='days-visible-select-{$id}' class='active'>{translate key=days}</label>
								<select id='days-visible-select-{$id}' {formname key=SCHEDULE_DAYS_VISIBLE}>
                                    {foreach from=$NumberOfDaysVisible item=n}
										<option value='{$n}'>{$n}</option>
                                    {/foreach}
								</select>
							</div>
						</div>
                    {/capture}
                    {assign var=dayOfWeek value=$schedule->GetWeekdayStart()}
                    {capture name=dayName}
						<div class='inline-edit-container inline-edit-start-day'>
							<span class='propertyValue dayName inlineUpdate inline-edit-display inline-edit-activator'
								  data-type='select'
								  data-pk='{$id}'
								  data-value='{$dayOfWeek}'
								  title='{translate key=Edit}'>{if $dayOfWeek == Schedule::Today}{$Today}{else}{$DayNames[$dayOfWeek]}{/if}</span>
							<div class='input-field no-show inline-edit-editable'>
								<label for='start-day-select-{$id}' class='active'>{translate key=day}</label>
								<select id='start-day-select-{$id}' {formname key=SCHEDULE_WEEKDAY_START}>
									<option value='{Schedule::Today}'>{$Today}</option>
                                    {foreach from=$DayNames item='dayName' key='dayIndex'}
										<option value='{$dayIndex}'>{$dayName|escape}</option>
                                    {/foreach}
								</select>
							</div>
						</div>
                    {/capture}
					<div class="scheduleDetails" data-schedule-id="{$id}">
						<div class="col s12 m6">
							<input type="hidden" class="id" value="{$id}"/>
							<input type="hidden" class="daysVisible" value="{$daysVisible}"/>
							<input type="hidden" class="dayOfWeek" value="{$dayOfWeek}"/>
							<div class='inline-edit-container inline-edit-schedule-name'>
								<span class="title scheduleName inline-edit-display"
									  data-type="text"
									  data-pk="{$id}"
									  data-value="{$schedule->GetName()}">{$schedule->GetName()}
								</span>
								<button class="btn btn-flat btn-link inline-edit-activator" title="{translate key=Rename}">
									<span class="far fa-edit"></span>
								</button>

								<div class='input-field no-show inline-edit-editable'>
									<label for='schedule-name-edit-input-{$id}' class='active'>{translate key=Name}</label>
									<input type="text" required="required" id="schedule-name-edit-input-{$id}" {formname key=SCHEDULE_NAME}/>
								</div>
							</div>

							<div>{translate key="LayoutDescription" args="{$smarty.capture.dayName}, {$smarty.capture.daysVisible}"}</div>

							<div>{translate key='ScheduleAdministrator'}
								<div class='inline-edit-container inline-edit-schedule-admin'>
									<span class="propertyValue scheduleAdmin inlineUpdate inline-edit-display inline-edit-activator"
										  data-type="select"
										  data-pk="{$id}"
										  data-value="{$schedule->GetAdminGroupId()}"
										  title="{translate key=Edit}">{$GroupLookup[$schedule->GetAdminGroupId()]->Name|default:{translate key=None}}</span>

									<div class='input-field no-show inline-edit-editable'>
										<label for='schedule-admin-select-{$id}' class='active'>{translate key=ScheduleAdministrator}</label>
										<select id='schedule-admin-select-{$id}' {formname key=SCHEDULE_ADMIN_GROUP_ID}>
											<option value="">{translate key=None}</option>
                                            {foreach from=$AdminGroups item=group}
												<option value="{$group->Id()}">{$group->Name()|escape}</option>
                                            {/foreach}
										</select>
									</div>
								</div>
							</div>

							<div>
								<div class="availabilityPlaceHolder inline-block">
                                    {include file="Admin/Schedules/manage_availability.tpl" schedule=$schedule timezone=$Timezone}
								</div>
								<button class="update changeAvailability btn btn-flat btn-link inline-edit-activator" title="{translate key=ChangeAvailability}">
									<span class="far fa-edit"></span>
								</button>
							</div>

							<div class="concurrentContainer">
								<span class="allowConcurrentYes {if !$schedule->GetAllowConcurrentReservations()}no-show{/if}">{translate key=ConcurrentYes}</span>
								<span class="allowConcurrentNo {if $schedule->GetAllowConcurrentReservations()}no-show{/if}">{translate key=ConcurrentNo}</span>
								<a class="update toggleConcurrent" href="#"
								   data-allow="{$schedule->GetAllowConcurrentReservations()|intval}">{translate key=Change}</a>
							</div>

							<div class="maximumConcurrentContainer" data-concurrent="{$schedule->GetTotalConcurrentReservations()}">
                                {if $schedule->EnforceConcurrentReservationMaximum()}
                                    {translate key=ScheduleConcurrentMaximum args=$schedule->GetTotalConcurrentReservations()}
                                {else}
                                    {translate key=ScheduleConcurrentMaximumNone}
                                {/if}

								<button class="update changeScheduleConcurrentMaximum btn btn-flat btn-link inline-edit-activator"
										title="{translate key=ChangeMaximumConcurrent}">
									<span class="far fa-edit"></span>
								</button>
							</div>

							<div class="resourcesPerReservationContainer" data-maximum="{$schedule->GetMaxResourcesPerReservation()}">
                                {if $schedule->EnforceMaxResourcesPerReservation()}
                                    {translate key=ScheduleResourcesPerReservationMaximum args=$schedule->GetMaxResourcesPerReservation()}
                                {else}
                                    {translate key=ScheduleResourcesPerReservationNone}
                                {/if}

								<button class="update changeResourcesPerReservation btn btn-flat btn-link inline-edit-activator"
										title="{translate key=ChangeScheduleResourcesPerReservation}">
									<span class="far fa-edit"></span>
								</button>
							</div>

							<div>
								<div class='inline-edit-container inline-edit-style'>
                                    {translate key=DefaultStyle}
									<span class="propertyValue defaultScheduleStyle inlineUpdate inline-edit-display inline-edit-activator"
										  data-type="select"
										  data-pk="{$id}"
										  data-value="{$schedule->GetDefaultStyle()}">{$StyleNames[$schedule->GetDefaultStyle()]}</span>

									<div class='input-field no-show inline-edit-editable'>
										<label for='style-select-{$id}' class='active'>{translate key=DefaultStyle}</label>
										<select id='style-select-{$id}' {formname key=SCHEDULE_DEFAULT_STYLE}>
                                            {foreach from=$StyleNames item="styleName" key="styleIndex"}
												<option value="{$styleIndex}">{$styleName}</option>
                                            {/foreach}
										</select>
									</div>
								</div>
							</div>

                            {if $CreditsEnabled}
								<span>{translate key=PeakTimes}</span>
								<button class="update changePeakTimes btn btn-flat btn-link" title="Change Peak Times">
									<span class="far fa-edit"></span>
								</button>
								<div class="peakPlaceHolder">
                                    {include file="Admin/Schedules/manage_peak_times.tpl" Layout=$Layouts[$id] Months=$Months DayNames=$DayNames}
								</div>
                            {/if}

							<div>{translate key=Resources}
                                {if array_key_exists($id, $Resources)}
									<a href="manage_resources.php?scheduleId={$id}" title="{translate key=View}"><span class="fas fa-search"></span></a>
                                {/if}
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

						<div class="layout col s12 m6">
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
								<button class="update changeLayoutButton btn btn-flat btn-link" title="{translate key=ChangeLayout}">
									<span class="far fa-edit" data-layout-type="{$Layouts[$id]->GetType()}"></span>
								</button>
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
								<div class="margin-top-25">
									<strong>{translate key=ThisScheduleUsesAStandardLayout}</strong>
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
								<div class="margin-top-25">
									<strong>{translate key=ThisScheduleUsesAStandardLayout}</strong>
								</div>
								<div><a href="#" class="update switchLayout"
										data-switch-to="{ScheduleLayout::Custom}">{translate key=SwitchToACustomLayout}</a>
								</div>
                            {/if}
						</div>

						<div class="actions col s12">
                            {if $schedule->GetIsDefault()}
								<span class="note">{translate key=ThisIsTheDefaultSchedule}</span>
								|
								<span class="note">{translate key=DefaultScheduleCannotBeDeleted}</span>
								|
                            {else}
								<button class="btn btn-flat btn-link update makeDefaultButton"><span class="fas fa-star"></span> {translate key=MakeDefault}
								</button>
								|
								<button class="btn btn-flat btn-link update deleteScheduleButton"><span class="fas fa-trash"></span> {translate key=Delete}
								</button>
								|
                            {/if}
                            {if $schedule->GetIsCalendarSubscriptionAllowed()}
								<button class="btn btn-flat btn-link update disableSubscription"><span
											class="fas fa-eye-slash"></span> {translate key=TurnOffSubscription}</button>
								|
                            {else}
								<button class="btn btn-flat btn-link update enableSubscription"><span
											class="fas fa-eye"></span> {translate key=TurnOnSubscription}</button>
                            {/if}
                            {if $schedule->GetIsCalendarSubscriptionAllowed()}
								<a target="_blank" href="{$schedule->GetSubscriptionUrl()->GetAtomUrl()}" class="show-qtip-next"><span
											class="fas fa-rss"></span> Atom</a>
								<div class="atom-help-help-div hidden">
									<div>{translate key=AtomHelp} <a href="https://www.bookedscheduler.com/help/usage/#Subscribing_to_Calendars" target="_blank"
																	 title="{translate key=Help}"><span class="fas fa-info-circle"></span></a></div>
									<div><a target="_blank"
											href="{$schedule->GetSubscriptionUrl()->GetAtomUrl()}">{$schedule->GetSubscriptionUrl()->GetAtomUrl()}</a></div>
								</div>
								<a target="_blank" href="{$schedule->GetSubscriptionUrl()->GetWebcalUrl()}" class="show-qtip-next"><span
											class="far fa-calendar-alt"></span> iCalendar</a>
								<div class="ical-help-help-div hidden">
									<div>{translate key=ICalendarHelp} <a href="https://www.bookedscheduler.com/help/usage/#Subscribing_to_Calendars"
																		  target="_blank" title="{translate key=Help}"><span class="fas fa-info-circle"></span></a>
									</div>
									<div><a target="_blank"
											href="{$schedule->GetSubscriptionUrl()->GetWebcalUrl()}">{$schedule->GetSubscriptionUrl()->GetWebcalUrl()}</a></div>
								</div>
								<button class="btn btn-flat btn-link show-qtip-next"><span class="fas fa-code"></span> {translate key=Embed}</button>
								<div class="embed-help-div hidden">
									<div>{translate key=EmbedHelp} <a href="https://www.bookedscheduler.com/help/usage/#Embedding_a_Calendar_Externally"
																	  target="_blank" title="{translate key=Help}"><span class="fas fa-info-circle"></span></a>
									</div>
									<div><code>&lt;script async src=&quot;{$ScriptUrl}/scripts/embed-calendar.js?sid={$schedule->GetPublicId()}&quot;
											crossorigin=&quot;anonymous&quot;&gt;&lt;/script&gt;</code></div>
								</div>
                            {/if}
                            {indicator id="action-indicator"}
							<div class="clearfix"></div>
						</div>
					</div>
                {/foreach}
			</div>
			<div class="clearfix"></div>
		</div>
	</div>

    {pagination pageInfo=$PageInfo}

	<input type="hidden" id="activeId" value=""/>

	<div id="addDialog" class="modal modal-large modal-fixed-header modal-fixed-footer" tabindex="-1" role="dialog" aria-labelledby="addScheduleDialogLabel"
		 aria-hidden="true">
		<form id="addScheduleForm" method="post">
			<div class="modal-header">
				<h4 class="modal-title left" id="addScheduleDialogLabel">{translate key=AddSchedule}</h4>
                {close_modal}
			</div>
			<div class="modal-content">
				<div class="input-field">
					<label for="addName" class="active">{translate key=Name} *</label>
					<input type="text" id="addName"
						   class="required" autofocus="autofocus" {formname key=SCHEDULE_NAME} />
				</div>
				<div class="input-field">
					<label for="addStartsOn" class="active">{translate key=StartsOn}</label>
					<select {formname key=SCHEDULE_WEEKDAY_START} id="addStartsOn">
						<option value="{Schedule::Today}">{$Today}</option>
                        {foreach from=$DayNames item="dayName" key="dayIndex"}
							<option value="{$dayIndex}">{$dayName}</option>
                        {/foreach}
					</select>
				</div>
				<div class="input-field">
					<label for="addNumDaysVisible" class="active">{translate key=NumberOfDaysVisible}</label>
					<select id="addNumDaysVisible" {formname key=SCHEDULE_DAYS_VISIBLE}>
                        {foreach from=$NumberOfDaysVisible item=n}
							<option value="{$n}" {if $n===7}selected="selected"{/if}>{$n}</option>
                        {/foreach}
					</select>
				</div>
				<div class="input-field">
					<label for="addSameLayoutAs" class="active">{translate key=UseSameLayoutAs}</label>
					<select {formname key=SCHEDULE_ID} id="addSameLayoutAs">
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
		</form>
	</div>

	<div id="deleteDialog" class="modal modal-fixed-header modal-fixed-footer" tabindex="-1" role="dialog" aria-labelledby="deleteScheduleDialogLabel"
		 aria-hidden="true">
		<form id="deleteForm" method="post">
			<div class="modal-header">
				<h4 class="modal-title left" id="deleteScheduleDialogLabel">{translate key=Delete}</h4>
                {close_modal}
			</div>
			<div class="modal-content">
				<div class="input-field">
					<label for="targetScheduleId"
						   class="active">{translate key=MoveResourcesAndReservations}</label>
					<select id="targetScheduleId" {formname key=SCHEDULE_ID} class="required">
                        {foreach from=$SourceSchedules item=schedule}
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
		</form>
	</div>

	<div id="changeLayoutDialog" class="modal modal-large modal-fixed-header modal-fixed-footer" tabindex="-1" role="dialog"
		 aria-labelledby="changeLayoutDialogLabel" aria-hidden="true">
		<form id="changeLayoutForm" method="post" role="form" class="form-inline">
			<div class="modal-header">
				<h4 class="modal-title left" id="changeLayoutDialogLabel">{translate key=ChangeLayout}</h4>
                {close_modal}
			</div>
			<div class="modal-content">

				<div class="validationSummary card error no-show">
					<div class="card-content">
						<ul>{async_validator id="layoutValidator" key="ValidLayoutRequired"}</ul>
					</div>
				</div>

				<div class="col s12 m6 layoutCheckboxDiv">
					<label for="usesSingleLayout">
						<input type="checkbox" id="usesSingleLayout" {formname key=USING_SINGLE_LAYOUT}>
						<span>{translate key=UseSameLayoutForAllDays}</span>
					</label>
				</div>

				<div class="slotWizard col s12 m6">
                    {capture name="layoutConfig" assign="layoutConfig"}
						<div class='input-field inline'>
							<label for='quickLayoutConfig'></label>
							<input type='number' min='0' step='15' value='30' id='quickLayoutConfig'
								   class='input-sm' aria-label='Minutes'/>
						</div>
                    {/capture}
                    {capture name="layoutStart" assign="layoutStart"}
						<div class='input-field inline'>
							<label for='quickLayoutStart'></label>
							<input type='text' value='08:00' id='quickLayoutStart' aria-label='From time'
								   class='input-sm timepicker' maxlength='5'/>
						</div>
                    {/capture}
                    {capture name="layoutEnd" assign="layoutEnd"}
						<div class='input-field inline'>
							<label for='quickLayoutEnd'></label>
							<input type='text' value='18:00' id='quickLayoutEnd' aria-label='End time'
								   class='input-sm timepicker' maxlength='5'/>
						</div>
                    {/capture}
                    {translate key=QuickSlotCreation args="$layoutConfig,$layoutStart,$layoutEnd"}
					<button class="btn btn-flat btn-link" id="createQuickLayout">{translate key=Create}</button>
				</div>

                {function name=display_slot_inputs}
					<div id="{$id}" class="col s12">
                        {assign var=suffix value=""}
                        {if $day!=null}
                            {assign var=suffix value="_$day"}
                        {/if}

						<div class="col s6">
							<div><span class="slot-heading">{translate key=ReservableTimeSlots}</span></div>
							<div class="input-field">
								<label for="reservableEdit{$suffix}" class="no-show">{translate key=ReservableTimeSlots}</label>
								<textarea class="reservableEdit form-control" id="reservableEdit{$suffix}"
										  name="{FormKeys::SLOTS_RESERVABLE}{$suffix}"></textarea>
							</div>
						</div>
						<div class="col s6">
							<div><span class="slot-heading">{translate key=BlockedTimeSlots}</span>
								<button class="btn btn-flat btn-link autofillBlocked" title="{translate key=Autofill}">
									<span class="fa fa-magic"></span> {translate key=Autofill}</button>
							</div>
							<div class="input-field">
								<label for="blockedEdit{$suffix}" class="no-show">{translate key=BlockedTimeSlots}</label>
								<textarea class="blockedEdit form-control" id="blockedEdit{$suffix}"
										  name="{FormKeys::SLOTS_BLOCKED}{$suffix}"></textarea>
							</div>
						</div>
					</div>
                {/function}

				<div class="col s12" id="dailySlots">
					<ul class="tabs" id="slotsTabs">
						<li class="tab active">
							<a href="#tabs-0" class="active" aria-controls="tabs-0">{$DayNames[0]}</a>
						</li>
						<li class="tab">
							<a href="#tabs-1" aria-controls="tabs-1">{$DayNames[1]}</a>
						</li>
						<li class="tab">
							<a href="#tabs-2" aria-controls="tabs-2">{$DayNames[2]}</a>
						</li>
						<li class="tab">
							<a href="#tabs-3" aria-controls="tabs-3">{$DayNames[3]}</a>
						</li>
						<li class="tab">
							<a href="#tabs-4" aria-controls="tabs-4">{$DayNames[4]}</a>
						</li>
						<li class="tab">
							<a href="#tabs-5" aria-controls="tabs-5">{$DayNames[5]}</a>
						</li>
						<li class="tab">
							<a href="#tabs-6" aria-controls="tabs-6">{$DayNames[6]}</a>
						</li>
					</ul>
					<div class="tab-content">
						<div id="tabs-0" class="active">
                            {display_slot_inputs day='0'}
						</div>
						<div id="tabs-1">
                            {display_slot_inputs day='1'}
						</div>
						<div id="tabs-2">
                            {display_slot_inputs day='2'}
						</div>
						<div id="tabs-3">
                            {display_slot_inputs day='3'}
						</div>
						<div id="tabs-4">
                            {display_slot_inputs day='4'}
						</div>
						<div id="tabs-5">
                            {display_slot_inputs day='5'}
						</div>
						<div id="tabs-6">
                            {display_slot_inputs day='6'}
						</div>
					</div>
				</div>

                {display_slot_inputs id="staticSlots" day=null}

				<div class="slotTimezone col s12">
					<label for="layoutTimezone">{translate key=Timezone}</label>
					<select {formname key=TIMEZONE} class="browser-default" id="layoutTimezone">
                        {html_options values=$TimezoneValues output=$TimezoneOutput}
					</select>
				</div>

				<div class="clearfix"></div>
			</div>
			<div class="modal-footer">
				<div class="slotHelpText left">
					<p>{translate key=Format}: <span>HH:MM - HH:MM {translate key=OptionalLabel}</span></p>

					<p>{translate key=LayoutInstructions}</p>
				</div>
				<div class="right">
                    {cancel_button}
                    {update_button}
                    {indicator}
				</div>
				<div class="clearfix"></div>
			</div>
		</form>
	</div>

	<div id="peakTimesDialog" class="modal modal-fixed-header modal-fixed-footer" tabindex="-1" role="dialog" aria-labelledby="peakTimesDialogLabel"
		 aria-hidden="true">
		<form id="peakTimesForm" method="post">
			<div class="modal-header">
				<h4 class="modal-title left" id="peakTimesDialogLabel">{translate key=PeakTimes}</h4>
                {close_modal}
			</div>
			<div class="modal-content">
				<label for="peakAllDay">
					<input type="checkbox" id="peakAllDay" {formname key=PEAK_ALL_DAY} />
					<span>{translate key=AllDay}</span>
				</label>
				<div id="peakTimes">
                    {translate key=Between}
					<div class="input-field inline">
						<label for="peakStartTime" class="no-show">Peak Begin Time</label>

						<input type="text" id="peakStartTime"
							   class="input-sm timeinput timepicker"
							   value="{formatdate date=$DefaultDate format='h:i A'}" {formname key=PEAK_BEGIN_TIME}/>
					</div>
					-
					<div class="input-field inline">
						<label for="peakEndTime" class="no-show">Peak End Time</label>
						<input type="text" id="peakEndTime"
							   class="input-sm timeinput timepicker"
							   value="{formatdate date=$DefaultDate->AddHours(9) format='h:i A'}" {formname key=PEAK_END_TIME}/>
					</div>
				</div>
				<label for="peakEveryDay">
					<input type="checkbox" id="peakEveryDay"
						   checked="checked" {formname key=PEAK_EVERY_DAY} />
					<span>{translate key=Everyday}</span>
				</label>
				<div id="peakDayList" class="no-show">
					<div>
						<label>
							<input type="checkbox" id="peakDay0" {formname key=repeat_sunday} />
							<span>{$DayNames[0]}</span>
						</label>
						<label>
							<input type="checkbox" id="peakDay1" {formname key=repeat_monday} />
							<span>{$DayNames[1]}</span>
						</label>
						<label>
							<input type="checkbox" id="peakDay2" {formname key=repeat_tuesday} />
							<span>{$DayNames[2]}</span>
						</label>
						<label>
							<input type="checkbox" id="peakDay3" {formname key=repeat_wednesday} />
							<span>{$DayNames[3]}</span>
						</label>
						<label>
							<input type="checkbox" id="peakDay4" {formname key=repeat_thursday} />
							<span>{$DayNames[4]}</span>
						</label>
						<label>
							<input type="checkbox" id="peakDay5" {formname key=repeat_friday} />
							<span>{$DayNames[5]}</span>
						</label>
						<label>
							<input type="checkbox" id="peakDay6" {formname key=repeat_saturday} />
							<span>{$DayNames[6]}</span>
						</label>
					</div>
				</div>
				<label for="peakAllYear">
					<input type="checkbox" id="peakAllYear"
						   checked="checked" {formname key=PEAK_ALL_YEAR} />
					<span>{translate key=AllYear}</span>
				</label>
				<div id="peakDateRange" class="no-show">
					<label for="peakBeginMonth" class="col s2">{translate key=BeginDate}</label>
					<div class="col s5">
						<select id="peakBeginMonth"
								class="input-sm" {formname key=PEAK_BEGIN_MONTH}>
                            {foreach from=$Months item=month name=startMonths}
								<option value="{$smarty.foreach.startMonths.iteration}">{$month}</option>
                            {/foreach}
						</select>
					</div>
					<div class="col s2">
						<label for="peakBeginDay" class="no-show">Peak Begin Day</label>
						<select id="peakBeginDay"
								class="input-sm" {formname key=PEAK_BEGIN_DAY}>
                            {foreach from=$DayList item=day}
								<option value="{$day}">{$day}</option>
                            {/foreach}
						</select>
					</div>
					<div class="col s3">&nbsp;</div>
					<div class="clearfix"></div>
					<label for="peakEndMonth" class="col s2">{translate key=EndDate}</label>
					<div class="col s5">
						<select id="peakEndMonth"
								class="input-sm" {formname key=PEAK_END_MONTH}>
                            {foreach from=$Months item=month name=endMonths}
								<option value="{$smarty.foreach.endMonths.iteration}">{$month}</option>
                            {/foreach}
						</select>
					</div>
					<div class="col s2">
						<label for="peakEndDay" class="no-show">Peak End Day</label>
						<select id="peakEndDay" class="input-sm" {formname key=PEAK_END_DAY}>
                            {foreach from=$DayList item=day}
								<option value="{$day}">{$day}</option>
                            {/foreach}
						</select>
					</div>
					<div class="col s3">&nbsp;</div>
				</div>
				<div class="clearfix"></div>
				<input type="hidden" {formname key=PEAK_DELETE} id="deletePeakTimes" value=""/>
				<div class="note"><a href="https://www.bookedscheduler.com/help/administration/#Credits" target="_blank" title="{translate key=Help}"><span
								class="fas fa-info-circle"></span></a> {translate key=PeakTimesHelp}</div>
			</div>
			<div class="modal-footer">
                {delete_button class='left' id="deletePeakBtn"}
                {cancel_button}
                {update_button}
                {indicator}
			</div>
		</form>
	</div>

	<div id="availabilityDialog" class="modal modal-fixed-header modal-fixed-footer" tabindex="-1" role="dialog"
		 aria-labelledby="availabilityDialogLabel"
		 aria-hidden="true">
		<form id="availabilityForm" method="post">
			<div class="modal-header">
				<h4 class="modal-title left" id="availabilityDialogLabel">{translate key=Availability}</h4>
                {close_modal}
			</div>
			<div class="modal-content">

				<label for="availableAllYear">
					<input type="checkbox" id="availableAllYear" {formname key=AVAILABLE_ALL_YEAR} />
					<span>{translate key=AvailableAllYear}</span></label>
				<div id="availableDates">
                    {translate key=AvailableBetween}
					<div class="input-field inline">
						<label for="availabilityStartDate" class="no-show">Available Start Date</label>
						<input type="text" id="availabilityStartDate"
							   class="input-sm dateinput"/>
						<input type="hidden" id="formattedBeginDate" {formname key=AVAILABLE_BEGIN_DATE} />
					</div>
					-
					<div class="input-field inline">
						<label for="availabilityEndDate" class="no-show">Available End Date</label>
						<input type="text" id="availabilityEndDate"
							   class="input-sm dateinput"/>
						<input type="hidden" id="formattedEndDate" {formname key=AVAILABLE_END_DATE} />
					</div>
					<div class="clearfix"></div>
					<div class="note"><a href="https://www.bookedscheduler.com/help/administration/#Schedule_Availability" target="_blank"
										 title="{translate key=Help}"><span class="fas fa-info-circle"></span></a> {translate key=AvailabilityHelp}</div>
				</div>
			</div>
			<div class="modal-footer">
                {cancel_button}
                {update_button}
                {indicator}
			</div>
		</form>
	</div>

	<div id="switchLayoutDialog" class="modal modal-fixed-header modal-fixed-footer" tabindex="-1" role="dialog"
		 aria-labelledby="switchLayoutDialogLabel"
		 aria-hidden="true">
		<form id="switchLayoutForm" method="post">
			<div class="modal-header">
				<h4 class="modal-title left" id="switchLayoutDialogLabel">{translate key=ChangeLayout}</h4>
                {close_modal}
			</div>
			<div class="modal-content">
				<div class="card warning">
					<div class="card-content">
                        {translate key=SwitchLayoutWarning}
					</div>
				</div>
				<input type="hidden" id="switchLayoutTypeId" {formname key=LAYOUT_TYPE} />
				<div class="note"><a href="https://www.bookedscheduler.com/help/administration/#Schedules" target="_blank"
									 title="{translate key=Help}"><span
								class="fas fa-info-circle"></span></a> {translate key=StandardLayoutHelp}</div>
				<div class="note">{translate key=StandardLayoutHelp}</div>
			</div>
			<div class="modal-footer">
                {cancel_button}
                {update_button submit=true}
                {indicator}
			</div>
		</form>
	</div>

	<div id="customLayoutDialog" class="modal modal-large modal-fixed-header modal-fixed-footer" tabindex="-1" role="dialog"
		 aria-labelledby="customLayoutDialogLabel"
		 aria-hidden="true">
		<div class="modal-header">
			<h4 class="modal-title left" id="customLayoutDialogLabel">{translate key=ChangeLayout}</h4>
            {close_modal}
		</div>
		<div class="modal-content">
			<div id="calendar"></div>
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

	<div id="concurrentMaximumDialog" class="modal modal-fixed-header modal-fixed-footer" tabindex="-1" role="dialog"
		 aria-labelledby="concurrentMaximumDialogLabel"
		 aria-hidden="true">
		<form id="concurrentMaximumForm" method="post">
			<div class="modal-header">
				<h4 class="modal-title left" id="concurrentMaximumDialogLabel">{translate key=ScheduleMaximumConcurrent}</h4>
                {close_modal}
			</div>
			<div class="modal-content">
				<div class="card info">
					<div class="card-content">
                        {translate key=ScheduleMaximumConcurrentNote}
					</div>
				</div>
				<div>
					<label for="maximumConcurrentUnlimited">
						<input type="checkbox" id="maximumConcurrentUnlimited" {formname key=MAXIMUM_CONCURRENT_UNLIMITED}/>
						<span>{translate key=Unlimited}</span>
					</label>
				</div>
				<div class="form-group">
					<label for="maximumConcurrent">{translate key=Resources}</label>
					<input type="number" class="form-control required" min="0" id="maximumConcurrent" {formname key=MAXIMUM_CONCURRENT_RESERVATIONS}/>
				</div>
				<div class="clearfix"></div>
			</div>
			<div class="modal-footer">
                {cancel_button}
                {update_button submit=true}
                {indicator}
			</div>
		</form>
	</div>

	<div id="resourcesPerReservationDialog" class="modal modal-fixed-header modal-fixed-footer" tabindex="-1" role="dialog"
		 aria-labelledby="resourcesPerReservationDialogLabel"
		 aria-hidden="true">
		<form id="resourcesPerReservationForm" method="post">
			<div class="modal-header">
				<h4 class="modal-title left" id="resourcesPerReservationDialogLabel">{translate key=ScheduleResourcesPerReservation}</h4>
                {close_modal}
			</div>

			<div class="modal-content">
				<div class="checkbox">
					<label for="resourcesPerReservationUnlimited">
						<input type="checkbox" id="resourcesPerReservationUnlimited" {formname key=MAXIMUM_RESOURCES_PER_RESERVATION_UNLIMITED}/>
						<span>{translate key=Unlimited}</span>
					</label>
				</div>
				<div class="form-group">
					<label for="resourcesPerReservationResources">{translate key=Resources}</label>
					<input type="number" class="form-control required" min="0"
						   id="resourcesPerReservationResources" {formname key=MAXIMUM_RESOURCES_PER_RESERVATION}/>
				</div>
				<div class="clearfix"></div>
			</div>
			<div class="modal-footer">
                {cancel_button}
                {update_button submit=true}
                {indicator}
			</div>
		</form>
	</div>

    {control type="DatePickerSetupControl" ControlId="availabilityStartDate" AltId="formattedBeginDate" DefaultDate=$StartDate}
    {control type="DatePickerSetupControl" ControlId="availabilityEndDate" AltId="formattedEndDate" DefaultDate=$EndDate}

    {csrf_token}
    {include file="javascript-includes.tpl" InlineEdit=true Fullcalendar=true Qtip=true Select2=true}
    {jsfile src="ajax-helpers.js"}
    {jsfile src="admin/schedule.js"}
    {jsfile src="js/jquery.form-3.09.min.js"}

	<script type="text/javascript">

		function setUpEditables() {
			var updateUrl = '{$smarty.server.SCRIPT_NAME}?action=';

			$('.inline-edit-schedule-name').inlineEdit({
				url: updateUrl + '{ManageSchedules::ActionRename}'
			});

			$(".inline-edit-days-visible").inlineEdit({
				url: updateUrl + '{ManageSchedules::ActionChangeDaysVisible}',
			});

			$('.inline-edit-start-day').inlineEdit({
				url: updateUrl + '{ManageSchedules::ActionChangeStartDay}'
			});

			$('.inline-edit-style').inlineEdit({
				url: updateUrl + '{ManageSchedules::ActionChangeDefaultStyle}'
			});

			$('.inline-edit-schedule-admin').inlineEdit({
				url: updateUrl + '{ManageSchedules::ChangeAdminGroup}'
			});
		}

		$(document).ready(function () {
			setUpEditables();

			$("#changeLayoutDialog").find('.timepicker').timepicker({
				twelveHour: false, container: "body"
			});

			$('#layoutTimezone').select2({
				dropdownAutoWidth: false, width: "90%", dropdownParent: $('#changeLayoutDialog'),
			});

			$('div.modal').modal();
			$('#changeLayoutDialog').modal({
				dismissible: false
			});

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
				maximumConcurrentAction: '{ManageSchedules::ActionChangeMaximumConcurrent}',
				maximumResourcesAction: '{ManageSchedules::ActionChangeResourcesPerReservation}',
				calendarOptions: {
					buttonText: {
						today: '{{translate key=Today}|escape:'javascript'}',
						month: '{{translate key=Month}|escape:'javascript'}',
						week: '{{translate key=Week}|escape:'javascript'}',
						day: '{{translate key=Day}|escape:'javascript'}'
					}, defaultDate: moment('{Date::Now()->ToTimezone({$Timezone})->Format('Y-m-d')}', 'YYYY-MM-DD'), eventsUrl: '{$smarty.server.SCRIPT_NAME}'
				}
			};

			var scheduleManagement = new ScheduleManagement(opts);
			scheduleManagement.init();
		});

	</script>
</div>
{include file='globalfooter.tpl'}