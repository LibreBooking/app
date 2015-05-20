{*
Copyright 2011-2015 Nick Korbel

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
{include file='globalheader.tpl'  InlineEdit=true}

<div id="page-manage-schedules">

	<h1>{translate key=ManageSchedules}</h1>

	<div class="panel panel-default" id="list-quotas-panel">
		<div class="panel-heading">{translate key="AllSchedules"}</div>
		<div class="panel-body no-padding" id="scheduleList">
			{foreach from=$Schedules item=schedule}
				{assign var=id value=$schedule->GetId()}
				{capture name=daysVisible}<span class='daysVisible inlineUpdate' data-type='number' data-pk='{$id}'
												data-name='{FormKeys::SCHEDULE_DAYS_VISIBLE}'  data-min='0'>{$schedule->GetDaysVisible()}</span>{/capture}
				{assign var=dayOfWeek value=$schedule->GetWeekdayStart()}
				{capture name=dayName}<span class='dayName inlineUpdate' data-type='select' data-pk='{$id}' data-name='{FormKeys::SCHEDULE_WEEKDAY_START}'
											data-value='{$dayOfWeek}'>{if $dayOfWeek == Schedule::Today}{$Today}{else}{$DayNames[$dayOfWeek]}{/if}</span>{/capture}
				<div class="scheduleDetails">
					<div class="col-xs-12 col-sm-6">
						<input type="hidden" class="id" value="{$id}"/>
						<input type="hidden" class="daysVisible" value="{$daysVisible}"/>
						<input type="hidden" class="dayOfWeek" value="{$dayOfWeek}"/>

						<div>
					<span class="title scheduleName" data-type="text" data-pk="{$id}"
						  data-name="{FormKeys::SCHEDULE_NAME}">{$schedule->GetName()|escape}</span>
							<a class="update renameButton" href="#">{translate key='Rename'}</a>
						</div>

						<div>{translate key="LayoutDescription" args="{$smarty.capture.dayName}, {$smarty.capture.daysVisible}"}</div>

						<div>{translate key='ScheduleAdministrator'}
							<span class="scheduleAdmin"
								  data-type="select" data-pk="{$id}" data-value="{$schedule->GetAdminGroupId()}"
								  data-name="{FormKeys::SCHEDULE_ADMIN_GROUP_ID}">{$GroupLookup[$schedule->GetAdminGroupId()]->Name}</span>
							{if $AdminGroups|count > 0}
								<a class="update changeScheduleAdmin" href="#"><span class="fa fa-pencil-square-o"></span></a>
							{/if}
						</div>
					</div>

					<div class="layout col-xs-12 col-sm-6">

						{function name="display_periods"}
							{foreach from=$Layouts[$id]->GetSlots($day) item=period name=layouts}
								{if $period->IsReservable() == $showReservable}
									{$period->Start->Format("H:i")} - {$period->End->Format("H:i")}
									{if $period->IsLabelled()}
										{$period->Label}
									{/if},
								{/if}
								{foreachelse}
								{translate key=None}
							{/foreach}
						{/function}

						{translate key=ScheduleLayout args=$schedule->GetTimezone()}:<br/>
						<input type="hidden" class="timezone" value="{$schedule->GetTimezone()}"/>

						{if !$Layouts[$id]->UsesDailyLayouts()}
							<input type="hidden" class="usesDailyLayouts" value="false"/>
							{translate key=ReservableTimeSlots}
							<div class="reservableSlots" id="reservableSlots" ref="reservableEdit">
								{display_periods showReservable=true day=null}
							</div>
							{translate key=BlockedTimeSlots}
							<div class="blockedSlots" id="blockedSlots" ref="blockedEdit">
								{display_periods showReservable=false day=null}
							</div>
						{else}
							<input type="hidden" class="usesDailyLayouts" value="true"/>
							{translate key=LayoutVariesByDay} -
							<a href="#" class="showAllDailyLayouts">{translate key=ShowHide}</a>
							<div class="allDailyLayouts">
								{foreach from=DayOfWeek::Days() item=day}
									{$DayNames[$day]}
									<div class="reservableSlots" id="reservableSlots_{$day}" ref="reservableEdit_{$day}">
										{display_periods showReservable=true day=$day}
									</div>
									<div class="blockedSlots" id="blockedSlots_{$day}" ref="blockedEdit_{$day}">
										{display_periods showReservable=false day=$day}
									</div>
								{/foreach}
							</div>
						{/if}
					</div>
					<div class="actions col-xs-12">
						<div style="float:left;">
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
							<a class="update changeLayoutButton" href="#">{translate key=ChangeLayout}</a> |
							{if $schedule->GetIsCalendarSubscriptionAllowed()}
								<a class="update disableSubscription"
								   href="#">{translate key=TurnOffSubscription}</a>
							{else}
								<a class="update enableSubscription" href="#">{translate key=TurnOnSubscription}</a>
							{/if}
						</div>
						<div style="float:right;text-align:center;">
							{if $schedule->GetIsCalendarSubscriptionAllowed()}
								{html_image src="feed.png"}
								<a target="_blank" href="{$schedule->GetSubscriptionUrl()->GetAtomUrl()}">Atom</a>
								|
								<a target="_blank" href="{$schedule->GetSubscriptionUrl()->GetWebcalUrl()}">iCalendar</a>
							{/if}
						</div>
						<div class="clear"></div>
					</div>
				</div>
			{/foreach}
		</div>
	</div>

	{pagination pageInfo=$PageInfo}

	<div class="admin" style="margin-top:30px">
		<div class="title">
			{translate key=AddSchedule}
		</div>
		<div>
			<div id="addScheduleResults" class="error" style="display:none;"></div>
			<form id="addScheduleForm" method="post">
				<ul>
					<li><label for="addName">{translate key=Name}</label><br/> <input type="text" id="addName" style="width:300px"
																					  class="textbox required" {formname key=SCHEDULE_NAME} /></li>
					<li><label for="addStartsOn">{translate key=StartsOn}</label><br/>
						<select {formname key=SCHEDULE_WEEKDAY_START} class="textbox" id="addStartsOn">
							<option value="{Schedule::Today}">{$Today}</option>
							{foreach from=$DayNames item="dayName" key="dayIndex"}
								<option value="{$dayIndex}">{$dayName}</option>
							{/foreach}
						</select>
					</li>
					<li><label for="addNumDaysVisible">{translate key=NumberOfDaysVisible}</label><br/>
						<input type="text" class="textbox required" maxlength="3" id="addNumDaysVisible"
							   size="3" {formname key=SCHEDULE_DAYS_VISIBLE} />
					</li>
					<li><label for="addSameLayoutAs">{translate key=UseSameLayoutAs}</label><br/>
						<select style="width:300px" class="textbox" {formname key=SCHEDULE_ID} id="addSameLayoutAs">
							{foreach from=$SourceSchedules item=schedule}
								<option value="{$schedule->GetId()}">{$schedule->GetName()}</option>
							{/foreach}
						</select>
					</li>
					<li style="padding-top:5px;">
						<button type="button" class="button save"
								value="submit">{html_image src="plus-button.png"} {translate key=AddSchedule}</button>
					</li>
				</ul>
			</form>
		</div>
	</div>

	<input type="hidden" id="activeId" value=""/>

	<div id="deleteDialog" class="dialog" title="{translate key=Delete}">
		<form id="deleteForm" method="post">
			<div class="error" style="margin-bottom: 25px;">
				<h3>{translate key=DeleteWarning}</h3>
			</div>

			<label for="targetScheduleId">{translate key=MoveResourcesAndReservations}</label>
			<select id="targetScheduleId" {formname key=SCHEDULE_ID} class="required">
				<option value="">-- {translate key=Schedule} --</option>
				{foreach from=$Schedules item=schedule}
					<option value="{$schedule->GetId()}">{$schedule->GetName()}</option>
				{/foreach}
			</select>
			<br/><br/>
			<button type="button" class="button save">{html_image src="cross-button.png"} {translate key=Delete}</button>
			<button type="button" class="button cancel">{html_image src="slash.png"} {translate key=Cancel}</button>
		</form>
	</div>

	<div id="placeholderDialog" style="display:none">
		<form id="placeholderForm" method="post">
		</form>
	</div>

	<div id="changeLayoutDialog" class="modal fade" tabindex="-1" role="dialog" aria-labelledby="changeLayoutDialogLabel" aria-hidden="true">
		<form id="changeLayoutForm" method="post" role="form" class="form-inline">
			<div class="modal-dialog modal-lg">
				<div class="modal-content">
					<div class="modal-header">
						<button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
						<h4 class="modal-title" id="changeLayoutDialogLabel">{translate key=ChangeLayout}</h4>
					</div>
					<div class="modal-body">
						<div class="validationSummary alert alert-danger hidden">
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
               						<textarea class="reservableEdit form-control" id="reservableEdit{$suffix}" name="{FormKeys::SLOTS_RESERVABLE}{$suffix}"></textarea>
								</div>
								<div class="col-xs-6">
									<label for="blockedEdit{$suffix}">{translate key=BlockedTimeSlots}</label>
									<textarea class="blockedEdit form-control" id="blockedEdit{$suffix}" name="{FormKeys::SLOTS_BLOCKED}{$suffix}"></textarea>
								</div>
							</div>
						{/function}

						<div class="col-xs-12" id="dailySlots">
							<div role="tabpanel" id="tabs">
								<ul class="nav nav-tabs" role="tablist">
									<li role="presentation" class="active"><a href="#tabs-0" aria-controls="tabs-0" role="tab" data-toggle="tab">{$DayNames[0]}</a></li>
									<li role="presentation"><a href="#tabs-1" aria-controls="tabs-1" role="tab" data-toggle="tab">{$DayNames[1]}</a></li>
									<li role="presentation"><a href="#tabs-2" aria-controls="tabs-2" role="tab" data-toggle="tab">{$DayNames[2]}</a></li>
									<li role="presentation"><a href="#tabs-3" aria-controls="tabs-3" role="tab" data-toggle="tab">{$DayNames[3]}</a></li>
									<li role="presentation"><a href="#tabs-4" aria-controls="tabs-4" role="tab" data-toggle="tab">{$DayNames[4]}</a></li>
									<li role="presentation"><a href="#tabs-5" aria-controls="tabs-5" role="tab" data-toggle="tab">{$DayNames[5]}</a></li>
									<li role="presentation"><a href="#tabs-6" aria-controls="tabs-6" role="tab" data-toggle="tab">{$DayNames[6]}</a></li>
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
									<input type='number' min='0' step='15' value='30' id='quickLayoutConfig' size=5' title='Minutes' class='form-control'/>
								{/capture}
								{capture name="layoutStart" assign="layoutStart"}
									<input type='text' value='08:00' id='quickLayoutStart' size='10' title='From time' class='form-control'/>
								{/capture}
								{capture name="layoutEnd" assign="layoutEnd"}
									<input type='text' value='18:00' id='quickLayoutEnd' size='10' title='End time' class='form-control'/>
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
						<button type="button" class="btn btn-default cancel" data-dismiss="modal">{translate key='Cancel'}</button>
						<button type="button" class="btn btn-success save"><span class="glyphicon glyphicon-ok-circle"></span>{translate key='Update'}</button>
						{indicator}
					</div>
				</div>
			</div>
		</form>
	</div>

	{html_image src="admin-ajax-indicator.gif" class="indicator" style="display:none;"}
	{jsfile src="admin/edit.js"}
	{jsfile src="admin/schedule.js"}
	{jsfile src="js/jquery.form-3.09.min.js"}

	<script type="text/javascript">

		function setUpEditables() {
			$.fn.editable.defaults.mode = 'popup';
			$.fn.editable.defaults.toggle = 'manual';
			$.fn.editable.defaults.emptyclass = '';

			var updateUrl = '{$smarty.server.SCRIPT_NAME}?action=';

			$('.scheduleName').editable({
				url: updateUrl + '{ManageSchedules::ActionRename}',
				validate: function (value) {
					if ($.trim(value) == '')
					{
						return '{translate key=RequiredValue}';
					}
				}
			});

			$('.daysVisible').editable({
				url: updateUrl + '{ManageSchedules::ActionChangeDaysVisible}'
			});

			$('.dayName').editable({
				url: updateUrl + '{ManageSchedules::ActionChangeStartDay}',
				source: [
					{
						value: '{Schedule::Today}', text: '{$Today}'
					},
					{foreach from=$DayNames item="dayName" key="dayIndex"}
					{
						value:{$dayIndex}, text: '{$dayName}'
					},
					{/foreach}
				]
			});

			$('.scheduleAdmin').editable({
				url: updateUrl + '{ManageSchedules::ChangeAdminGroup}',
				emptytext: '{translate key=None}',
				source: [
					{
						value: '0', text: ''
					},
					{foreach from=$AdminGroups item=group}
					{
						value:{$group->Id()}, text: '{$group->Name()}'
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
				makeDefaultAction: '{ManageSchedules::ActionMakeDefault}',
				deleteAction: '{ManageSchedules::ActionDelete}',
				enableSubscriptionAction: '{ManageSchedules::ActionEnableSubscription}',
				disableSubscriptionAction: '{ManageSchedules::ActionDisableSubscription}'
			};

			var scheduleManagement = new ScheduleManagement(opts);
			scheduleManagement.init();
		});

	</script>

</div>
{include file='globalfooter.tpl'}
