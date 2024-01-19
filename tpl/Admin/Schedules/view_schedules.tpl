{include file='globalheader.tpl' InlineEdit=true Fullcalendar=true Timepicker=true}

<div id="page-manage-schedules" class="admin-page">

	<h1>{translate key=ManageSchedules}</h1>

	<div class="panel panel-default admin-panel" id="list-schedules-panel">
		<div class="panel-body no-padding" id="scheduleList">
            {foreach from=$Schedules item=schedule}
                {assign var=id value=$schedule->GetId()}
                {*$schedule|@var_dump*}
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
								  data-name="{FormKeys::SCHEDULE_ADMIN_GROUP_ID}">{($GroupLookup[$schedule->GetAdminGroupId()]) ? $GroupLookup[$schedule->GetAdminGroupId()]->Name : 'None'}</span>
                            {if $AdminGroups|default:array()|count > 0}
								<a class="update changeScheduleAdmin" href="#">
									<span class="no-show">{translate key='ScheduleAdministrator'}</span>
									<span class="fa fa-pencil-square-o"></span>
								</a>
                            {/if}
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

                        {*--------------------------ERRADO--------------------------*}
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
                        {*----------------------------------------------------------*}

                        {*--------------------------ERRADO--------------------------*}
						{* <div>{translate key=Resources}
							<span class="propertyValue">
                            {if array_key_exists($id, $Resources)}
                                {foreach from=$Resources[$id] item=r name=resources_loop}
                                    {$r->GetName()|escape}{if !$smarty.foreach.resources_loop.last}, {/if}
                                {/foreach}
                            {else}
                                {translate key=None}
                            {/if}
                            </span>
						</div> *}

                        {* {if $schedule->GetIsCalendarSubscriptionAllowed()}
							<div>
								<span>{translate key=PublicId}</span>
								<span class="propertyValue">{$schedule->GetPublicId()}</span>
							</div>
                        {/if} *}
                        {*----------------------------------------------------------*}

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

						{* <div>
                            {translate key=ScheduleLayout args=$schedule->GetTimezone()}
							<a class="update changeLayoutButton" href="#" title="{translate key=ChangeLayout}">
                                <span class="fa fa-pencil-square-o"
									  data-layout-type="{$Layouts[$id]->GetType()}"></span>
								<span class="no-show">{translate key=ChangeLayout}</span>
							</a>
						</div>
						<input type="hidden" class="timezone" value="{$schedule->GetTimezone()}"/> *}

                        {* {if $Layouts[$id]->UsesDailyLayouts()}
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
                        {/if} *}
					</div>
					<div class="actions col-xs-12">
                        {if $schedule->GetIsDefault()}
							<span class="note">{translate key=ThisIsTheDefaultSchedule}</span>
                        {else}
                            <span class="note">--</span>
                        {/if}
                        {indicator id="action-indicator"}
						<div class="clear"></div>
					</div>
				</div>
            {/foreach}
		</div>
	</div>

    {pagination pageInfo=$PageInfo}


	{* <div id="peakTimesDialog" class="modal fade" tabindex="-1" role="dialog" aria-labelledby="peakTimesDialogLabel"
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
	</div> *}

	{* <div id="availabilityDialog" class="modal fade" tabindex="-1" role="dialog"
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
	</div> *}

	{* <div id="customLayoutDialog" class="modal fade" tabindex="-1" role="dialog"
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
	</div> *}

	{* <form id="layoutSlotForm" method="post">
		<input type="hidden" id="slotStartDate" {formname key=BEGIN_DATE} />
		<input type="hidden" id="slotEndDate" {formname key=END_DATE} />
		<input type="hidden" id="slotId" {formname key=LAYOUT_PERIOD_ID} />
	</form> *}

	{* <div id="deleteCustomLayoutDialog" style="z-index:10000;" class="default-box-shadow">
		<form id="deleteCustomTimeSlotForm" method="post">
			<input type="hidden" id="deleteSlotStartDate" {formname key=BEGIN_DATE} />
			<input type="hidden" id="deleteSlotEndDate" {formname key=END_DATE} />
			<div>{translate key=DeleteThisTimeSlot}</div>
			<div>
                {cancel_button id=cancelDeleteSlot}
                {delete_button id=deleteSlot}
			</div>
		</form>
	</div> *}

	{* <div id="confirmCreateSlotDialog" class="default-box-shadow" style="z-index:10000;">
        {cancel_button id="cancelCreateSlot"}
        {add_button id="confirmCreateOK"}
	</div> *}

	{* <div id="concurrentMaximumDialog" class="modal fade" tabindex="-1" role="dialog"
		 aria-labelledby="concurrentMaximumDialogLabel"
		 aria-hidden="true">
		<form id="concurrentMaximumForm" method="post">
			<div class="modal-dialog">
				<div class="modal-content">
					<div class="modal-header">
						<button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
						<h4 class="modal-title" id="concurrentMaximumDialogLabel">{translate key=ScheduleMaximumConcurrent}</h4>
					</div>
					<div class="modal-body">
						<div class="alert alert-info">
							{translate key=ScheduleMaximumConcurrentNote}
						</div>
						<div class="checkbox">
							<input type="checkbox" id="maximumConcurrentUnlimited" {formname key=MAXIMUM_CONCURRENT_UNLIMITED}/>
							<label for="maximumConcurrentUnlimited">{translate key=Unlimited}</label>
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
				</div>
			</div>
		</form>
	</div> *}

	{* <div id="resourcesPerReservationDialog" class="modal fade" tabindex="-1" role="dialog"
		 aria-labelledby="resourcesPerReservationDialogLabel"
		 aria-hidden="true">
		<form id="resourcesPerReservationForm" method="post">
			<div class="modal-dialog">
				<div class="modal-content">
					<div class="modal-header">
						<button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
						<h4 class="modal-title" id="resourcesPerReservationDialogLabel">{translate key=ScheduleResourcesPerReservation}</h4>
					</div>
					<div class="modal-body">
						<div class="checkbox">
							<input type="checkbox" id="resourcesPerReservationUnlimited" {formname key=MAXIMUM_RESOURCES_PER_RESERVATION_UNLIMITED}/>
							<label for="resourcesPerReservationUnlimited">{translate key=Unlimited}</label>
						</div>
						<div class="form-group">
							<label for="resourcesPerReservationResources">{translate key=Resources}</label>
							<input type="number" class="form-control required" min="0" id="resourcesPerReservationResources" {formname key=MAXIMUM_RESOURCES_PER_RESERVATION}/>
						</div>
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
	</div> *}

    {* {control type="DatePickerSetupControl" ControlId="availabilityStartDate" AltId="formattedBeginDate" DefaultDate=$StartDate}
    {control type="DatePickerSetupControl" ControlId="availabilityEndDate" AltId="formattedEndDate" DefaultDate=$EndDate}

    {csrf_token}
    {include file="javascript-includes.tpl" InlineEdit=true Fullcalendar=true Timepicker=true}
    {jsfile src="ajax-helpers.js"}
    {jsfile src="admin/schedule.js"}
    {jsfile src="js/jquery.form-3.09.min.js"} *}

	{* <script type="text/javascript">

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
					if ($.trim(value) == '')
					{
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
				url: updateUrl + '{ManageSchedules::ActionChangeDefaultStyle}', source: [
                    {foreach from=$StyleNames item="styleName" key="styleIndex"}
					{
						value: '{$styleIndex}', text: '{$styleName|escape:'javascript'}'
					},
                    {/foreach}
				]
			});

			$('.scheduleAdmin').editable({
				url: updateUrl + '{ManageSchedules::ChangeAdminGroup}', emptytext: '{{translate key=None}|escape:'javascript'}', source: [{
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

			$('.timepicker').timepicker({
				timeFormat: '{$TimeFormat}'
			});


		});

	</script> *}

</div>

{include file='globalfooter.tpl'}