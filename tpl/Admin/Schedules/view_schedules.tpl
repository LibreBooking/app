{include file='globalheader.tpl' InlineEdit=true Fullcalendar=true Timepicker=true}

<div id="page-manage-schedules" class="admin-page">

	<h1>{translate key=ManageSchedules}</h1>

	{pagination pageInfo=$PageInfo}

	<div class="panel panel-default admin-panel" id="list-schedules-panel">
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
						</div>

						<div>{translate key="LayoutDescription" args="{$smarty.capture.dayName}, {$smarty.capture.daysVisible}"}</div>

						<div>{translate key='ScheduleAdministrator'}
							<span class="propertyValue scheduleAdmin"
								  data-type="select" data-pk="{$id}" data-value="{$schedule->GetAdminGroupId()}"
								  data-name="{FormKeys::SCHEDULE_ADMIN_GROUP_ID}">{($GroupLookup[$schedule->GetAdminGroupId()]) ? $GroupLookup[$schedule->GetAdminGroupId()]->Name : 'None'}
							</span>
						</div>

						<div>
							<div class="availabilityPlaceHolder inline-block">
                                {include file="Admin/Schedules/manage_availability.tpl" schedule=$schedule timezone=$Timezone}
							</div>
						</div>

						<div class="maximumConcurrentContainer" data-concurrent="{$schedule->GetTotalConcurrentReservations()}">
                            {if $schedule->EnforceConcurrentReservationMaximum()}
                                {translate key=ScheduleConcurrentMaximum args=$schedule->GetTotalConcurrentReservations()}
                            {else}
                                {translate key=ScheduleConcurrentMaximumNone}
                            {/if}
						</div>

						<div class="resourcesPerReservationContainer" data-maximum="{$schedule->GetMaxResourcesPerReservation()}">
                            {if $schedule->EnforceMaxResourcesPerReservation()}
                                {translate key=ScheduleResourcesPerReservationMaximum args=$schedule->GetMaxResourcesPerReservation()}
                            {else}
                                {translate key=ScheduleResourcesPerReservationNone}
                            {/if}
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
						</div>
						<input type="hidden" class="timezone" value="{$schedule->GetTimezone()}"/>

                        {if $Layouts[$id]->UsesDailyLayouts()}
							<input type="hidden" class="usesDailyLayouts" value="true"/>
                            {translate key=LayoutVariesByDay} -
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
                        {elseif $Layouts[$id]->UsesCustomLayout()}
							<div><strong>{translate key=ThisScheduleUsesACustomLayout}</strong></div>
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
                        {/if}
					</div>
					<div class="actions col-xs-12">
                        {if $schedule->GetIsDefault()}
							<span class="note">{translate key=ThisIsTheDefaultSchedule}</span>
                        {else}
                            <span class="note">¯\_(ツ)_/¯</span>
                        {/if}
                        {indicator id="action-indicator"}
						<div class="clear"></div>
					</div>
				</div>
            {/foreach}
		</div>
	</div>

    {pagination pageInfo=$PageInfo}

    {csrf_token}
    {include file="javascript-includes.tpl" InlineEdit=true Fullcalendar=true Timepicker=true}
    {jsfile src="ajax-helpers.js"}
    {jsfile src="admin/schedule.js"}
    {jsfile src="js/jquery.form-3.09.min.js"}
</div>

{include file='globalfooter.tpl'}