{*
Copyright 2011-2014 Nick Korbel

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
{include file='globalheader.tpl' cssFiles='scripts/css/colorbox.css,css/admin.css,css/jquery.qtip.min.css'}

<h1>{translate key=ManageReservations}</h1>

<fieldset>
	<legend style="font-weight:bold;font-size:12pt;">{translate key=Filter}</legend>
	<table id="filterTable">
		<tr>
			<td>{translate key=Between}</td>
			<td>{translate key=User}</td>
			<td>{translate key=Schedule}</td>
			<td>{translate key=Resource}</td>
			<td>{translate key=Status}</td>
			<td>{translate key=ReferenceNumber}</td>
			<td>{translate key=ResourceStatus}</td>
			<td>{translate key=Reason}</td>
		</tr>
		<tr>
			<td>
				<input id="startDate" type="text" class="textbox" value="{formatdate date=$StartDate}" size="10"/>
				<input id="formattedStartDate" type="hidden" value="{formatdate date=$StartDate key=system}"/>
				-
				<input id="endDate" type="text" class="textbox" value="{formatdate date=$EndDate}" size="10"/>
				<input id="formattedEndDate" type="hidden" value="{formatdate date=$EndDate key=system}"/>
			</td>
			<td>
				<input id="userFilter" type="text" class="textbox" value="{$UserNameFilter}" size="30" />
				<input id="userId" type="hidden" value="{$UserIdFilter}" />
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
			<td>
				<select id="resourceStatusIdFilter" class="textbox">
					<option value="">{translate key=All}</option>
					<option value="{ResourceStatus::AVAILABLE}">{translate key=Available}</option>
					<option value="{ResourceStatus::UNAVAILABLE}">{translate key=Unavailable}</option>
					<option value="{ResourceStatus::HIDDEN}">{translate key=Hidden}</option>
				</select>
			</td>
			<td>
				<select id="resourceReasonIdFilter" class="textbox">
				</select>
			</td>
		</tr>
	</table>
	<div id="reservationFilterButtons">
		<button id="filter" class="button">{html_image src="search.png"} {translate key=Filter}</button>
		<a href="#" id="clearFilter">{translate key=Reset}</a>
	</div>
</fieldset>

<div>&nbsp;</div>

<p>
	<a href="{$CsvExportUrl}">{translate key=ExportToCSV}</a>
</p>
<table class="list" id="reservationTable">
	<tr>
		<th class="id">&nbsp;</th>
		<th style="max-width: 120px;">{translate key='User'}</th>
		<th style="max-width: 120px;">{translate key='Resource'}</th>
		<th style="max-width: 120px;">{translate key='Title'}</th>
		<th style="max-width: 120px;">{translate key='Description'}</th>
		<th class="date">{translate key='BeginDate'}</th>
		<th class="date">{translate key='EndDate'}</th>
		<th>{translate key='Duration'}</th>
		<th class="date">{translate key='Created'}</th>
		<th class="date">{translate key='LastModified'}</th>
		<th>{translate key='ReferenceNumber'}</th>
		{foreach from=$AttributeList->GetLabels() item=label}
		<th>{$label}</th>
		{/foreach}
		<th class="action">{translate key='Delete'}</th>
		<th class="action">{translate key='Approve'}</th>
	</tr>
	{foreach from=$reservations item=reservation}
	{cycle values='row0,row1' assign=rowCss}
	{if $reservation->RequiresApproval}
		{assign var=rowCss value='pending'}
	{/if}
	<tr class="{$rowCss} editable">
		<td class="id">{$reservation->ReservationId}</td>
		<td>{fullname first=$reservation->FirstName last=$reservation->LastName ignorePrivacy=true}</td>
		<td>{$reservation->ResourceName}
			<div>{if $reservation->ResourceStatusId == ResourceStatus::AVAILABLE}
				{html_image src="status.png"}
				{if $CanUpdateResourceStatus}
					<a class="update changeStatus" href="#" resourceId="{$reservation->ResourceId}">{translate key='Available'}</a>
				{else}
					{translate key='Available'}
				{/if}
			{elseif $reservation->ResourceStatusId == ResourceStatus::UNAVAILABLE}
				{html_image src="status-away.png"}
				{if $CanUpdateResourceStatus}
					<a class="update changeStatus" href="#" resourceId="{$reservation->ResourceId}">{translate key='Unavailable'}</a>
				{else}
					{translate key='Unavailable'}
				{/if}
			{else}
				{html_image src="status-busy.png"}
				{if $CanUpdateResourceStatus}
					<a class="update changeStatus"  href="#" resourceId="{$reservation->ResourceId}">{translate key='Hidden'}</a>
				{else}
					{translate key='Hidden'}
				{/if}
			{/if}
			{if array_key_exists($reservation->ResourceStatusReasonId,$StatusReasons)}
				<span class="reservationResourceStatusReason">{$StatusReasons[$reservation->ResourceStatusReasonId]->Description()}</span>
			{/if}
			</div>
		</td>
		<td>{$reservation->Title}</td>
		<td>{$reservation->Description}</td>
		<td>{formatdate date=$reservation->StartDate timezone=$Timezone key=res_popup}</td>
		<td>{formatdate date=$reservation->EndDate timezone=$Timezone key=res_popup}</td>
		<td>{$reservation->GetDuration()->__toString()}</td>
		<td>{formatdate date=$reservation->CreatedDate timezone=$Timezone key=general_datetime}</td>
		<td>{formatdate date=$reservation->ModifiedDate timezone=$Timezone key=general_datetime}</td>
		<td class="referenceNumber">{$reservation->ReferenceNumber}</td>
		{foreach from=$AttributeList->GetAttributes($reservation->SeriesId) item=attribute}
		<td>{$attribute->Value()}</td>
		{/foreach}
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
		<input type="hidden" {formname key=REFERENCE_NUMBER} value="" class="referenceNumber" />
	</form>
</div>

<div id="deleteSeriesDialog" class="dialog" style="display:none;" title="{translate key='Delete'}">
	<form id="deleteSeriesForm" method="post">
		<div class="error" style="margin-bottom: 25px;">
			<h3>{translate key=DeleteWarning}</h3>
		</div>
		<button type="button" class="button saveSeries btnUpdateThisInstance">
			{html_image src="disk-black.png"}
			{translate key='ThisInstance'}
		</button>
		<button type="button" class="button saveSeries btnUpdateAllInstances">
			{html_image src="disks-black.png"}
			{translate key='AllInstances'}
		</button>
		<button type="button" class="button saveSeries btnUpdateFutureInstances">
			{html_image src="disk-arrow.png"}
			{translate key='FutureInstances'}
		</button>
		<button type="button" class="button cancel">
			{html_image src="slash.png"}
			{translate key='Cancel'}
		</button>
		<input type="hidden" id="hdnSeriesUpdateScope" {formname key=SERIES_UPDATE_SCOPE} />
		<input type="hidden" {formname key=REFERENCE_NUMBER} value="" class="referenceNumber" />
	</form>
</div>

<div id="statusDialog" class="dialog" title="{translate key=CurrentStatus}">
	<form id="statusForm" method="post">
		<div>
			<select id="resourceStatusId" {formname key=RESOURCE_STATUS_ID} class="textbox">
				<option value="{ResourceStatus::AVAILABLE}">{translate key=Available}</option>
				<option value="{ResourceStatus::UNAVAILABLE}">{translate key=Unavailable}</option>
				<option value="{ResourceStatus::HIDDEN}">{translate key=Hidden}</option>
			</select>
		</div>
		<div>
			<label for="resourceReasonId">{translate key=Reason}</label><br/>
			<select id="resourceReasonId" {formname key=RESOURCE_STATUS_REASON_ID} class="textbox">
			</select>
		</div>
		<div class="admin-update-buttons">
			<button type="button" class="button save">{html_image src="disk-black.png"} {translate key='Update'}</button>
			<button type="button" class="button saveAll">{html_image src="disks-black.png"} {translate key='AllReservationResources'}</button>
			<button type="button" class="button cancel">{html_image src="slash.png"} {translate key='Cancel'}</button>
			<input type="hidden" {formname key=RESOURCE_STATUS_UPDATE_SCOPE} id="statusUpdateScope" value="" />
			<input type="hidden" {formname key=REFERENCE_NUMBER} id="statusUpdateReferenceNumber" value="" />
			<input type="hidden" {formname key=RESOURCE_ID} id="statusResourceId" value="" />
		</div>
	</form>
</div>

{html_image src="admin-ajax-indicator.gif" class="indicator" style="display:none;"}

<script type="text/javascript" src="{$Path}scripts/js/jquery.qtip.min.js"></script>
<script type="text/javascript" src="{$Path}scripts/js/jquery.colorbox-min.js"></script>
<script type="text/javascript" src="{$Path}scripts/js/jquery.form-3.09.min.js"></script>

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
		deleteUrl: '{$Path}ajax/reservation_delete.php?{QueryStringKeys::RESPONSE_TYPE}=json',
		resourceStatusUrl: '{$smarty.server.SCRIPT_NAME}?{QueryStringKeys::ACTION}=changeStatus'
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
				id: '{$reservation->ReservationId}',
				referenceNumber: '{$reservation->ReferenceNumber}',
				isRecurring: '{$reservation->IsRecurring}',
				resourceStatusId: '{$reservation->ResourceStatusId}',
				resourceStatusReasonId: '{$reservation->ResourceStatusReasonId}',
				resourceId: '{$reservation->ResourceId}'
			}
		);
	{/foreach}

	{foreach from=$StatusReasons item=reason}
		reservationManagement.addStatusReason('{$reason->Id()}', '{$reason->StatusId()}', '{$reason->Description()|escape:javascript}');
	{/foreach}

	reservationManagement.initializeStatusFilter('{$ResourceStatusFilterId}','{$ResourceStatusReasonFilterId}');
});
</script>

{control type="DatePickerSetupControl" ControlId="startDate" AltId="formattedStartDate"}
{control type="DatePickerSetupControl" ControlId="endDate" AltId="formattedEndDate"}

<div id="approveDiv" style="display:none;text-align:center; top:15%;position:relative;">
<h3>{translate key=Approving}...</h3>
{html_image src="reservation_submitting.gif"}
</div>
{include file='globalfooter.tpl'}