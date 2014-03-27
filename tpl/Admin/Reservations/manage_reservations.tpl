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

<div class="filterTable horizontal-list label-top main-div-shadow" id="filterTable">
	<form id="filterForm">
		<div class="main-div-header">{translate key=Filter}</div>
		<ul>
			<li class="filter-dates">
				<label for="startDate">{translate key=Between}</label>
				<input id="startDate" type="text" class="textbox" value="{formatdate date=$StartDate}" size="10"
					   style="width:65px;"/>
				<input id="formattedStartDate" type="hidden" value="{formatdate date=$StartDate key=system}"/>
				-
				<input id="endDate" type="text" class="textbox" value="{formatdate date=$EndDate}" size="10"
					   style="width:65px;"/>
				<input id="formattedEndDate" type="hidden" value="{formatdate date=$EndDate key=system}"/>
			</li>
			<li class="filter-user">
				<label for="userFilter">{translate key=User}</label>
				<input id="userFilter" type="text" class="textbox" value="{$UserNameFilter}"/>
				<input id="userId" type="hidden" value="{$UserIdFilter}"/>
			</li>
			<li class="filter-schedule">
				<label for="scheduleId">{translate key=Schedule}</label>
				<select id="scheduleId" class="textbox">
					<option value="">{translate key=AllSchedules}</option>
					{object_html_options options=$Schedules key='GetId' label="GetName" selected=$ScheduleId}
				</select>
			</li>
			<li class="filter-resource">
				<label for="resourceId">{translate key=Resource}</label>
				<select id="resourceId" class="textbox">
					<option value="">{translate key=AllResources}</option>
					{object_html_options options=$Resources key='GetId' label="GetName" selected=$ResourceId}
				</select>
			</li>
			<li class="filter-status">
				<label for="statusId">{translate key=Status}</label>
				<select id="statusId" class="textbox">
					<option value="">{translate key=AllReservations}</option>
					<option value="{ReservationStatus::Pending}"
							{if $ReservationStatusId eq ReservationStatus::Pending}selected="selected"{/if}>{translate key=PendingReservations}</option>
				</select>
			</li>
			<li class="filter-referenceNumber">
				<label for="referenceNumber">{translate key=ReferenceNumber}</label>
				<input id="referenceNumber" type="text" class="textbox" value="{$ReferenceNumber}"/>
			</li>
			<li class="filter-resourceStatus">
				<label for="resourceStatusIdFilter">{translate key=ResourceStatus}</label>
				<select id="resourceStatusIdFilter" class="textbox">
					<option value="">{translate key=All}</option>
					<option value="{ResourceStatus::AVAILABLE}">{translate key=Available}</option>
					<option value="{ResourceStatus::UNAVAILABLE}">{translate key=Unavailable}</option>
					<option value="{ResourceStatus::HIDDEN}">{translate key=Hidden}</option>
				</select>
			</li>
			<li class="filter-resourceStatusReason">
				<label for="resourceReasonIdFilter">{translate key=Reason}</label>
				<select id="resourceReasonIdFilter" class="textbox"></select>
			</li>
			{foreach from=$AttributeFilters item=attribute}
				<li class="customAttribute filter-customAttribute{$attribute->Id()}">
					{control type="AttributeControl" attribute=$attribute searchmode=true}
				</li>
			{/foreach}
		</ul>
	</form>
	<div class="clear">&nbsp;</div>
	<div id="adminFilterButtons">
		<button id="filter" class="button">{html_image src="search.png"} {translate key=Filter}</button>
		<a href="#" id="clearFilter">{translate key=Reset}</a>
	</div>
</div>

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
		{foreach from=$ReservationAttributes item=attr}
			<th>{$attr->Label()}</th>
		{/foreach}
		<th class="action">{translate key='Delete'}</th>
		<th class="action">{translate key='Approve'}</th>
	</tr>
	{foreach from=$reservations item=reservation}
		{cycle values='row0,row1' assign=rowCss}
		{if $reservation->RequiresApproval}
			{assign var=rowCss value='pending'}
		{/if}
		<tr class="{$rowCss} editable" seriesId="{$reservation->SeriesId}">
			<td class="id">{$reservation->ReservationId}</td>
			<td>{fullname first=$reservation->FirstName last=$reservation->LastName ignorePrivacy=true}</td>
			<td>{$reservation->ResourceName}
				<div>{if $reservation->ResourceStatusId == ResourceStatus::AVAILABLE}
						{html_image src="status.png"}
						{*{if $CanUpdateResourceStatus}*}
						{*<a class="changeStatus" href="#"*}
						{*resourceId="{$reservation->ResourceId}">{translate key='Available'}</a>*}
						{*{else}*}
						{translate key='Available'}
						{*{/if}*}
					{elseif $reservation->ResourceStatusId == ResourceStatus::UNAVAILABLE}
						{html_image src="status-away.png"}
						{*{if $CanUpdateResourceStatus}*}
						{*<a class="changeStatus" href="#"*}
						{*resourceId="{$reservation->ResourceId}">{translate key='Unavailable'}</a>*}
						{*{else}*}
						{translate key='Unavailable'}
						{*{/if}*}
					{else}
						{html_image src="status-busy.png"}
						{*{if $CanUpdateResourceStatus}*}
						{*<a class="changeStatus" href="#"*}
						{*resourceId="{$reservation->ResourceId}">{translate key='Hidden'}</a>*}
						{*{else}*}
						{translate key='Hidden'}
						{*{/if}*}
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
			{foreach from=$ReservationAttributes item=attribute}
				<td class="update inlineUpdate updateCustomAttribute" attributeId="{$attribute->Id()}"
					attributeType="{$attribute->Type()}">
					{assign var=attrVal value=$reservation->Attributes->Get($attribute->Id())}
					{if $attribute->Type() == CustomAttributeTypes::CHECKBOX}
						{if $attrVal == 1}
							{translate key=Yes}
						{else}
							{translate key=No}
						{/if}
					{else}
						{$attrVal}
					{/if}
				</td>
			{/foreach}
			<td class="center"><a href="#" class="update delete">{html_image src='cross-button.png'}</a></td>
			<td class="center">
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
		<input type="hidden" {formname key=SERIES_UPDATE_SCOPE} value="{SeriesUpdateScope::ThisInstance}"/>
		<input type="hidden" {formname key=REFERENCE_NUMBER} value="" class="referenceNumber"/>
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
		<input type="hidden" {formname key=REFERENCE_NUMBER} value="" class="referenceNumber"/>
	</form>
</div>

<div id="inlineUpdateErrorDialog" class="dialog" title="{translate key=Error}">
	<div id="inlineUpdateErrors" class="hidden error">&nbsp;</div>
	<div id="reservationAccessError" class="hidden error"/>
</div>
<button type="button" class="button cancel">{translate key='OK'}</button>
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
			<button type="button"
					class="button save">{html_image src="disk-black.png"} {translate key='Update'}</button>
			<button type="button"
					class="button saveAll">{html_image src="disks-black.png"} {translate key='AllReservationResources'}</button>
			<button type="button" class="button cancel">{html_image src="slash.png"} {translate key='Cancel'}</button>
			<input type="hidden" {formname key=RESOURCE_STATUS_UPDATE_SCOPE} id="statusUpdateScope" value=""/>
			<input type="hidden" {formname key=REFERENCE_NUMBER} id="statusUpdateReferenceNumber" value=""/>
			<input type="hidden" {formname key=RESOURCE_ID} id="statusResourceId" value=""/>
		</div>
	</form>
</div>

<div class="hidden">
	{foreach from=$AttributeFilters item=attribute}
		<div class="attributeTemplate" attributeId="{$attribute->Id()}">
			{control type="AttributeControl" attribute=$attribute}
		</div>
	{/foreach}

	<form id="attributeUpdateForm" method="POST" ajaxAction="{ManageReservationsActions::UpdateAttribute}">
		<input type="hidden" id="attributeUpdateReferenceNumber" {formname key=REFERENCE_NUMBER} />
		<input type="hidden" id="attributeUpdateId" {formname key=ATTRIBUTE_ID} />
		<input type="hidden" id="attributeUpdateValue" {formname key=ATTRIBUTE_VALUE} />
	</form>
</div>

<div id="inlineUpdateCancelButtons" class="hidden">
	<div>
		<a href="#" class="confirmCellUpdate">{html_image src="tick-white.png"}</a>
		<a href="#" class="cancelCellUpdate">{html_image src="cross-white.png"}</a>
	</div>
</div>

{html_image src="admin-ajax-indicator.gif" class="indicator" style="display:none;"}

{jsfile src="js/jquery.qtip.min.js"}
{jsfile src="js/jquery.colorbox-min.js"}
{jsfile src="js/jquery.form-3.09.min.js"}

{jsfile src="admin/edit.js"}
{jsfile src="admin/reservations.js"}

{jsfile src="autocomplete.js"}
{jsfile src="reservationPopup.js"}
{jsfile src="approval.js"}

<script type="text/javascript">

	$(document).ready(function ()
	{

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
			resourceStatusUrl: '{$smarty.server.SCRIPT_NAME}?{QueryStringKeys::ACTION}=changeStatus',
			submitUrl: '{$smarty.server.SCRIPT_NAME}'
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

		reservationManagement.initializeStatusFilter('{$ResourceStatusFilterId}', '{$ResourceStatusReasonFilterId}');
	});
</script>

{control type="DatePickerSetupControl" ControlId="startDate" AltId="formattedStartDate"}
{control type="DatePickerSetupControl" ControlId="endDate" AltId="formattedEndDate"}

<div id="approveDiv" style="display:none;text-align:center; top:15%;position:relative;">
	<h3>{translate key=Approving}...</h3>
	{html_image src="reservation_submitting.gif"}
</div>
{include file='globalfooter.tpl'}