{*
Copyright 2011-2012 Nick Korbel

This file is part of phpScheduleIt.

phpScheduleIt is free software: you can redistribute it and/or modify
it under the terms of the GNU General Public License as published by
the Free Software Foundation, either version 3 of the License, or
(at your option) any later version.

phpScheduleIt is distributed in the hope that it will be useful,
but WITHOUT ANY WARRANTY; without even the implied warranty of
MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
GNU General Public License for more details.

You should have received a copy of the GNU General Public License
along with phpScheduleIt.  If not, see <http://www.gnu.org/licenses/>.
*}
{include file='globalheader.tpl' cssFiles='scripts/css/colorbox.css,css/admin.css,css/jquery.qtip.min.css'}

<h1>{translate key=ManageReservations}</h1>

<fieldset>
	<legend><h3>{translate key=Filter}</h3></legend>
	<table style="display:inline;">
		<tr>
			<td>{translate key=Between}</td>
			<td>{translate key=User}</td>
			<td>{translate key=Schedule}</td>
			<td>{translate key=Resource}</td>
			<td>{translate key=Status}</td>
			<td>{translate key=ReferenceNumber}</td>
		</tr>
		<tr>
			<td>
				<input id="startDate" type="text" class="textbox" value="{formatdate date=$StartDate}"/>
				<input id="formattedStartDate" type="hidden" value="{formatdate date=$StartDate key=system}"/>
				-
				<input id="endDate" type="text" class="textbox" value="{formatdate date=$EndDate}"/>
				<input id="formattedEndDate" type="hidden" value="{formatdate date=$EndDate key=system}"/>
			</td>
			<td>
				<input id="userFilter" type="text" class="textbox" value="{$UserName}" />
				<input id="userId" type="hidden" value="{$UserId}" />
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
			<td>
				<select id="statusId" class="textbox">
					<option value="">{translate key=AllReservations}</option>
					<option value="{ReservationStatus::Pending}" {if $ReservationStatusId eq ReservationStatus::Pending}selected="selected"{/if}>{translate key=PendingReservations}</option>
				</select>
			</td>
			<td>
				<input id="referenceNumber" type="text" class="textbox" value="{$ReferenceNumber}" />
			</td>
			<td rowspan="2">
				<button id="filter" class="button">{html_image src="search.png"} {translate key=Filter}</button>
			</td>
		</tr>
	</table>
</fieldset>

<div>&nbsp;</div>

<p>
	<a href="{$CsvExportUrl}">{translate key=ExportToCSV}</a>
</p>
<table class="list" id="reservationTable">
	<tr>
		<th class="id">&nbsp;</th>
		<th>{translate key='User'}</th>
		<th>{translate key='Resource'}</th>
		<th>{translate key='BeginDate'}</th>
		<th>{translate key='EndDate'}</th>
		<th>{translate key='Created'}</th>
		<th>{translate key='LastModified'}</th>
		<th>{translate key='ReferenceNumber'}</th>
		<th>{translate key='Delete'}</th>
		<th>{translate key='Approve'}</th>
	</tr>
	{foreach from=$reservations item=reservation}
	{cycle values='row0,row1' assign=rowCss}
	{if $reservation->RequiresApproval}
		{assign var=rowCss value='pending'}
	{/if}
	<tr class="{$rowCss} editable">
		<td class="id">{$reservation->ReservationId}</td>
		<td>{$reservation->FirstName} {$reservation->LastName}</td>
		<td>{$reservation->ResourceName}</td>
		<td>{formatdate date=$reservation->StartDate timezone=$Timezone key=res_popup}</td>
		<td>{formatdate date=$reservation->EndDate timezone=$Timezone key=res_popup}</td>
		<td>{formatdate date=$reservation->CreatedDate timezone=$Timezone key=general_datetime}</td>
		<td>{formatdate date=$reservation->ModifiedDate timezone=$Timezone key=general_datetime}</td>
		<td class="referenceNumber">{$reservation->ReferenceNumber}</td>
		<td align="center"><a href="#" class="update delete">{html_image src='cross-button.png'}</a></td>
		<td align="center">
			{if $reservation->RequiresApproval}
				<a href="#" class="update approve">{html_image src='tick-button.png'}</a>
			{else}
				-
			{/if}
		</td>
	</tr>
	{/foreach}
</table>

{pagination pageInfo=$PageInfo}

<div id="deleteInstanceDialog" class="dialog" style="display:none;" title="{translate key='Delete'}">
	<form id="deleteInstanceForm" method="post">
		<div class="delResResponse"></div>
		<div class="error" style="margin-bottom: 25px;">
			<h3>{translate key=DeleteWarning}</h3>
		</div>
		<button type="button" class="button save">{html_image src="cross-button.png"} {translate key='Delete'}</button>
		<button type="button" class="button cancel">{html_image src="slash.png"} {translate key='Cancel'}</button>
		<input type="hidden" {formname key=SERIES_UPDATE_SCOPE} value="{SeriesUpdateScope::ThisInstance}" />
		<input type="hidden" class="reservationId" {formname key=RESERVATION_ID} value="" />
	</form>
</div>


<div id="deleteSeriesDialog" class="dialog" style="display:none;" title="{translate key='Delete'}">
	<form id="deleteSeriesForm" method="post">
		<div class="error" style="margin-bottom: 25px;">
			<h3>{translate key=DeleteWarning}</h3>
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

<script type="text/javascript" src="{$Path}scripts/admin/edit.js"></script>
<script type="text/javascript" src="{$Path}scripts/admin/reservations.js"></script>

<script type="text/javascript" src="{$Path}scripts/autocomplete.js"></script>
<script type="text/javascript" src="{$Path}scripts/reservationPopup.js"></script>
<script type="text/javascript" src="{$Path}scripts/approval.js"></script>
<script type="text/javascript">

$(document).ready(function() {

	var updateScope = {};
	updateScope['btnUpdateThisInstance'] = '{SeriesUpdateScope::ThisInstance}';
	updateScope['btnUpdateAllInstances'] = '{SeriesUpdateScope::FullSeries}';
	updateScope['btnUpdateFutureInstances'] = '{SeriesUpdateScope::FutureInstances}';

	var actions = {};
		
	var resOpts = {
		autocompleteUrl: "{$Path}ajax/autocomplete.php?type={AutoCompleteType::User}",
		reservationUrlTemplate: "{$Path}reservation.php?{QueryStringKeys::REFERENCE_NUMBER}=[refnum]",
		popupUrl: "{$Path}ajax/respopup.php",
		updateScope: updateScope,
		actions: actions,
		deleteUrl: '{$Path}ajax/reservation_delete.php?{QueryStringKeys::RESPONSE_TYPE}=json'
	};

	var approvalOpts = {
		url: '{$Path}ajax/reservation_approve.php'
	};
	
	var approval = new Approval(approvalOpts);
		
	var reservationManagement = new ReservationManagement(resOpts, approval);
	reservationManagement.init();

	{foreach from=$reservations item=reservation}

		reservationManagement.addReservation(
			{
				referenceNumber: '{$reservation->ReferenceNumber}',
				isRecurring: '{$reservation->IsRecurring}'
			}
		);
	{/foreach}
});
</script>

{control type="DatePickerSetupControl" ControlId="startDate" AltId="formattedStartDate"}
{control type="DatePickerSetupControl" ControlId="endDate" AltId="formattedEndDate"}

<div id="approveDiv" style="display:none;text-align:center; top:15%;position:relative;">
<h3>{translate key=Approving}...</h3>
{html_image src="reservation_submitting.gif"}
</div>
{include file='globalfooter.tpl'}