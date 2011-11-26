{include file='globalheader.tpl' cssFiles='scripts/css/colorbox.css,css/admin.css,css/jquery.qtip.css,scripts/css/timePicker.css'}

<h1>{translate key=ManageReservations}</h1>

<div class="admin">
	<div class="title">
		Add Blackout
	</div>
	<div>
		<form id="addBlackoutForm" method="post">
			<ul>
				<li>
					<label for="addStartDate" class="wideLabel">Start</label>
					<input {formname key=BEGIN_DATE} type="text" id="addStartDate" class="textbox" size="10" value="{formatdate date=$AddStartDate}"/>
					<input {formname key=BEGIN_TIME} type="text" id="addStartTime" class="textbox" size="7" value="12:00 AM" />
				</li>
				<li>
					<label for="addEndDate" class="wideLabel">End</label>
					<input {formname key=END_DATE} type="text" id="addEndDate" class="textbox" size="10" value="{formatdate date=$AddEndDate}"/>
					<input {formname key=END_TIME} type="text" id="addEndTime" class="textbox" size="7"  value="12:00 AM" />
				</li>
				<li>
					<label for="addResourceId" class="wideLabel">Resource</label>
					<select {formname key=RESOURCE_ID} class="textbox" id="addResourceId">
						{object_html_options options=$Resources key='GetId' label="GetName" selected=$ResourceId}
					</select>
					or
					<label for="allResources" style="">All Resources On </label> <input {formname key=BLACKOUT_APPLY_TO_SCHEDULE} type="checkbox" id="allResources" />
					<select {formname key=SCHEDULE_ID} id="addScheduleId" class="textbox" disabled="disabled">
						{object_html_options options=$Schedules key='GetId' label="GetName" selected=$ScheduleId}
					</select>
				</li>
				<li>
					<label for="blackoutReason" class="wideLabel">Reason</label>
					<input {formname key=SUMMARY} type="text" id="blackoutReason" class="textbox required" size="100" maxlength="85"/>
				</li>
				<li>
					<input {formname key=CONFLICT_ACTION} type="radio" id="notifyExisting" name="existingReservations" checked="checked" />
					<label for="notifyExisting">Show me conflicting reservations</label>

					<input {formname key=CONFLICT_ACTION} type="radio" id="deleteExisting" name="existingReservations" />
					<label for="deleteExisting">Delete conflicting reservations</label>
				</li>
				<li style="margin-top:15px; padding-top:15px; border-top: solid 1px #ededed;">
					<button type="button" class="button save create">
						{html_image src="tick-circle.png"} {translate key='Create'}
					</button>
					<input type="reset" value="Cancel" class="button" style="border: 0;background: transparent;color: blue;cursor:pointer; font-size: 60%" />
				</li>
			</ul>
		</form>
	</div>
</div>

<fieldset>
	<legend><h3>Filter</h3></legend>
	<table style="display:inline;">
		<tr>
			<td>Between</td>
			<td>{translate key=Schedule}</td>
			<td>{translate key=Resource}</td>
		</tr>
		<tr>
			<td>
				<input id="startDate" type="text" class="textbox" value="{formatdate date=$StartDate}"/>
				and
				<input id="endDate" type="text" class="textbox" value="{formatdate date=$EndDate}"/>
			</td>
			<td>
				<select id="scheduleId" class="textbox">
					<option value="">{translate key=AllSchedules}</option>
					{object_html_options options=$Schedules key='GetId' label="GetName" selected=$ScheduleId}
				</select>
			</td>
			<td>
				<select id="resourceId" class="textbox">
					<option value="">{translate key=AllResources}</option>
					{object_html_options options=$Resources key='GetId' label="GetName" selected=$ResourceId}
				</select>
			</td>
			<td rowspan="2">
				<button id="filter" class="button">{html_image src="search.png"} Filter</button>
			</td>
		</tr>
	</table>
</fieldset>

<div>&nbsp;</div>

<table class="list" id="reservationTable">
	<tr>
		<th class="id">&nbsp;</th>
		<th>{translate key='Resource'}</th>
		<th>{translate key='BeginDate'}</th>
		<th>{translate key='EndDate'}</th>
		<th>Created By</th>
		<th>{translate key='Delete'}</th>
		<th>{translate key='Edit'}</th>
	</tr>
	{foreach from=$blackouts item=blackout}
	{cycle values='row0,row1' assign=rowCss}
	<tr class="{$rowCss} editable">
		<td class="id">{$blackout->InstanceId}</td>
		<td>{$blackout->ResourceName}</td>
		<td>{formatdate date=$blackout->StartDate timezone=$Timezone key=res_popup}</td>
		<td>{formatdate date=$blackout->EndDate timezone=$Timezone key=res_popup}</td>
		<td>{$blackout->FirstName} {$blackout->LastName}</td>
		<td align="center"><a href="#" class="update delete">{html_image src='cross-button.png'}</a></td>
		<td align="center">
			Edit
		</td>
	</tr>
	{/foreach}
</table>

{pagination pageInfo=$PageInfo}

<div id="deleteInstanceDialog" class="dialog" style="display:none;">
	<form id="deleteInstanceForm" method="post">
		<div class="error" style="margin-bottom: 25px;">
			<h3>This action is permanent and irrecoverable!</h3>
		</div>
		<button type="button" class="button save">{html_image src="cross-button.png"} {translate key='Delete'}</button>
		<button type="button" class="button cancel">{html_image src="slash.png"} {translate key='Cancel'}</button>
		<input type="hidden" {formname key=SERIES_UPDATE_SCOPE} value="{SeriesUpdateScope::ThisInstance}" />
		<input type="hidden" class="reservationId" {formname key=RESERVATION_ID} value="" />
	</form>
</div>


<div id="deleteSeriesDialog" class="dialog" style="display:none;">
	<form id="deleteSeriesForm" method="post">
		<div class="error" style="margin-bottom: 25px;">
			<h3>This action is permanent and irrecoverable!</h3>
		</div>
		<button type="button" id="btnUpdateThisInstance" class="button saveSeries">
			{html_image src="disk-black.png"}
			{translate key='ThisInstance'}
		</button>
		<button type="button" id="btnUpdateAllInstances" class="button saveSeries">
			{html_image src="disks-black.png"}
			{translate key='AllInstances'}
		</button>
		<button type="button" id="btnUpdateFutureInstances" class="button saveSeries">
			{html_image src="disk-arrow.png"}
			{translate key='FutureInstances'}
		</button>
		<button type="button" class="button cancel">
			{html_image src="slash.png"}
			{translate key='Cancel'}
		</button>
		<input type="hidden" id="hdnSeriesUpdateScope" {formname key=SERIES_UPDATE_SCOPE} />
		<input type="hidden" class="reservationId" {formname key=RESERVATION_ID} value="" />
	</form>
</div>

{html_image src="admin-ajax-indicator.gif" class="indicator" style="display:none;"}

<script type="text/javascript" src="{$Path}scripts/js/jquery.qtip.min.js"></script>
<script type="text/javascript" src="{$Path}scripts/js/jquery.colorbox-min.js"></script>
<script type="text/javascript" src="{$Path}scripts/js/jquery.form-2.43.js"></script>
<script type="text/javascript" src="{$Path}scripts/js/jquery.timePicker.min.js"></script>

<script type="text/javascript" src="{$Path}scripts/admin/edit.js"></script>
<script type="text/javascript" src="{$Path}scripts/admin/blackouts.js"></script>

<script type="text/javascript">

$(document).ready(function() {

	var updateScope = {};
	updateScope['btnUpdateThisInstance'] = '{SeriesUpdateScope::ThisInstance}';
	updateScope['btnUpdateAllInstances'] = '{SeriesUpdateScope::FullSeries}';
	updateScope['btnUpdateFutureInstances'] = '{SeriesUpdateScope::FutureInstances}';

	var actions = {};
		
	var blackoutOpts = {
		reservationUrlTemplate: "{$Path}reservation.php?{QueryStringKeys::REFERENCE_NUMBER}=[refnum]",
		updateScope: updateScope,
		actions: actions,
		deleteUrl: '{$Path}ajax/reservation_delete.php?{QueryStringKeys::RESPONSE_TYPE}=json',
		addUrl: '{$smarty.server.SCRIPT_NAME}?action={ManageBlackoutsActions::ADD}'
	};

	
	var blackoutManagement = new BlackoutManagement(blackoutOpts);
	blackoutManagement.init();

	
});
</script>

{control type="DatePickerSetupControl" ControlId="startDate"}
{control type="DatePickerSetupControl" ControlId="endDate"}
{control type="DatePickerSetupControl" ControlId="addStartDate"}
{control type="DatePickerSetupControl" ControlId="addEndDate"}

<div id="createDiv" style="display:none;text-align:center; top:15%;position:relative;">
	<div id="creating">
		<h3>Creating...</h3>
		{html_image src="reservation_submitting.gif"}
	</div>
	<div id="result" style="display:none;"></div>
</div>

{include file='globalfooter.tpl'}