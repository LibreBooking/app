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

{include file='globalheader.tpl'}

<div id="page-manage-reservations">
<h1>{translate key=ManageReservations}</h1>

<div class="panel panel-default filterTable">
	<div class="panel-heading"><span class="glyphicon glyphicon-filter"></span> {translate key="Filter"}</div>
	<div class="panel-body">
		<form id="filterForm" class="horizontal-list form-inline" role="form">
			<ul>
				<li class="filter-dates">
					<div class="form-group">
						<label for="startDate">{translate key=Between}</label>
						<input id="startDate" type="text" class="form-control" value="{formatdate date=$StartDate}" size="10"/>
						<input id="formattedStartDate" type="hidden" value="{formatdate date=$StartDate key=system}"/>
						-
						<input id="endDate" type="text" class="form-control" value="{formatdate date=$EndDate}" size="10" title="End date"/>
						<input id="formattedEndDate" type="hidden" value="{formatdate date=$EndDate key=system}"/>
					</div>
				</li>
				<li class="filter-user">
					<div class="form-group">
						<label for="userFilter">{translate key=User}</label>
						<input id="userFilter" type="text" class="form-control" value="{$UserNameFilter}"/>
						<input id="userId" type="hidden" value="{$UserIdFilter}"/>
					</div>
				</li>
				<li class="filter-schedule">
					<div class="form-group">
						<label for="scheduleId">{translate key=Schedule}</label>
						<select id="scheduleId" class="form-control">
							<option value="">{translate key=AllSchedules}</option>
							{object_html_options options=$Schedules key='GetId' label="GetName" selected=$ScheduleId}
						</select>
					</div>
				</li>
				<li class="filter-resource">
					<div class="form-group">
						<label for="resourceId">{translate key=Resource}</label>
						<select id="resourceId" class="form-control">
							<option value="">{translate key=AllResources}</option>
							{object_html_options options=$Resources key='GetId' label="GetName" selected=$ResourceId}
						</select>
				</li>
				<li class="filter-status">
					<div class="form-group">
						<label for="statusId">{translate key=Status}</label>
						<select id="statusId" class="form-control">
							<option value="">{translate key=AllReservations}</option>
							<option value="{ReservationStatus::Pending}"
									{if $ReservationStatusId eq ReservationStatus::Pending}selected="selected"{/if}>{translate key=PendingReservations}</option>
						</select>
					</div>
				</li>
				<li class="filter-referenceNumber">
					<div class="form-group">
						<label for="referenceNumber">{translate key=ReferenceNumber}</label>
						<input id="referenceNumber" type="text" class="form-control" value="{$ReferenceNumber}"/>
					</div>
				</li>
				<li class="filter-resourceStatus">
					<div class="form-group">
						<label for="resourceStatusIdFilter">{translate key=ResourceStatus}</label>
						<select id="resourceStatusIdFilter" class="form-control">
							<option value="">{translate key=All}</option>
							<option value="{ResourceStatus::AVAILABLE}">{translate key=Available}</option>
							<option value="{ResourceStatus::UNAVAILABLE}">{translate key=Unavailable}</option>
							<option value="{ResourceStatus::HIDDEN}">{translate key=Hidden}</option>
						</select>
					</div>
				</li>
				<li class="filter-resourceStatusReason">
					<div class="form-group">
						<label for="resourceReasonIdFilter">{translate key=Reason}</label>
						<select id="resourceReasonIdFilter" class="form-control"></select>
					</div>
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
			<button id="filter" class="btn btn-success btn-sm"><span class="glyphicon glyphicon-search"></span> {translate key=Filter}</button>
			<button id="clearFilter" class="btn btn-default btn-sm">{translate key=Reset}</button>
		</div>
	</div>
</div>

<div>
	<a href="{$CsvExportUrl}" class="btn btn-default btn-sm">{translate key=ExportToCSV} <span class="glyphicon glyphicon-export"></span></a>
</div>

<table class="table" id="reservationTable">
	<thead>
	<tr>
		<th class="id hidden">&nbsp;</th>
		<th>{translate key='User'}</th>
		<th>{translate key='Resource'}</th>
		<th>{translate key='Title'}</th>
		<th>{translate key='Description'}</th>
		<th>{translate key='BeginDate'}</th>
		<th>{translate key='EndDate'}</th>
		<th>{translate key='Duration'}</th>
		<th>{translate key='Created'}</th>
		<th>{translate key='LastModified'}</th>
		<th>{translate key='ReferenceNumber'}</th>
		<th class="action">{translate key='Delete'}</th>
		<th class="action">{translate key='Approve'}</th>
	</tr>
	</thead>
	<tbody>
	{foreach from=$reservations item=reservation}
		{cycle values='row0,row1' assign=rowCss}
		{if $reservation->RequiresApproval}
			{assign var=rowCss value='pending'}
		{/if}
		<tr class="{$rowCss} editable" data-seriesId="{$reservation->SeriesId}" data-refnum="{$reservation->ReferenceNumber}">
			<td class="id hidden">{$reservation->ReservationId}</td>
			<td class="user">{fullname first=$reservation->FirstName last=$reservation->LastName ignorePrivacy=true}</td>
			<td class="resource">{$reservation->ResourceName}
				<div>{if $reservation->ResourceStatusId == ResourceStatus::AVAILABLE}
						{html_image src="status.png"}
						{translate key='Available'}
					{elseif $reservation->ResourceStatusId == ResourceStatus::UNAVAILABLE}
						{html_image src="status-away.png"}
						{translate key='Unavailable'}
					{else}
						{html_image src="status-busy.png"}
						{translate key='Hidden'}
					{/if}
					{if array_key_exists($reservation->ResourceStatusReasonId,$StatusReasons)}
						<span class="reservationResourceStatusReason">{$StatusReasons[$reservation->ResourceStatusReasonId]->Description()}</span>
					{/if}
				</div>
			</td>
			<td class="title">{$reservation->Title}</td>
			<td class="description">{$reservation->Description}</td>
			<td class="date">{formatdate date=$reservation->StartDate timezone=$Timezone key=short_reservation_date}</td>
			<td class="date">{formatdate date=$reservation->EndDate timezone=$Timezone key=short_reservation_date}</td>
			<td class="duration">{$reservation->GetDuration()->__toString()}</td>
			<td class="date">{formatdate date=$reservation->CreatedDate timezone=$Timezone key=short_datetime}</td>
			<td class="date">{formatdate date=$reservation->ModifiedDate timezone=$Timezone key=short_datetime}</td>
			<td class="referenceNumber">{$reservation->ReferenceNumber}</td>
			<td class="action"><a href="#" class="update delete">{html_image src='cross-button.png'}</a></td>
			<td class="action">
				{if $reservation->RequiresApproval}
					<a href="#" class="update approve">{html_image src='tick-button.png'}</a>
				{else}
					-
				{/if}
			</td>
		</tr>
		{if $ReservationAttributes|count > 0}
			<tr class="{$rowCss} customAttributeUpdate" data-seriesId="{$reservation->SeriesId}" data-refnum="{$reservation->ReferenceNumber}">
				<td colspan="13" class="horizontal-list">
					<ul>
						{foreach from=$ReservationAttributes item=attribute}
							<li class="update inlineUpdate updateCustomAttribute" attributeId="{$attribute->Id()}" attributeType="{$attribute->Type()}">
								<span class="glyphicon glyphicon-pencil"></span> <label>{$attribute->Label()}:</label>
								<span class="attributeValue">
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
								</span>
							</li>
						{/foreach}
					</ul>
				</td>
			</tr>
		{/if}
	{/foreach}
	</tbody>
</table>

{pagination pageInfo=$PageInfo}

<div class="modal fade" id="deleteInstanceDialog" tabindex="-1" role="dialog" aria-labelledby="deleteInstanceDialogLabel" aria-hidden="true">
	<div class="modal-dialog">
		<form id="deleteInstanceForm" method="post">
			<div class="modal-content">
				<div class="modal-header">
					<button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
					<h4 class="modal-title" id="deleteInstanceDialogLabel">{translate key=Delete}</h4>
				</div>
				<div class="modal-body">
					<div class="delResResponse"></div>
					<div class="error">
						<h3>{translate key=DeleteWarning}</h3>
					</div>

					<input type="hidden" {formname key=SERIES_UPDATE_SCOPE} value="{SeriesUpdateScope::ThisInstance}"/>
					<input type="hidden" {formname key=REFERENCE_NUMBER} value="" class="referenceNumber"/>
				</div>
				<div class="modal-footer">
					<button type="button" class="btn btn-default cancel" data-dismiss="modal">{translate key='Cancel'}</button>
					<button type="button" class="btn btn-danger save">{translate key='Delete'}</button>
				</div>
			</div>
		</form>
	</div>
</div>

<div class="modal fade" id="deleteSeriesDialog" tabindex="-1" role="dialog" aria-labelledby="deleteSeriesDialogLabel" aria-hidden="true">
	<div class="modal-dialog">
		<form id="deleteSeriesForm" method="post">
			<div class="modal-content">
				<div class="modal-header">
					<button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
					<h4 class="modal-title" id="deleteSeriesDialogLabel">{translate key=Delete}</h4>
				</div>
				<div class="modal-body">
					<div class="error">
						<h3>{translate key=DeleteWarning}</h3>
					</div>
					<input type="hidden" id="hdnSeriesUpdateScope" {formname key=SERIES_UPDATE_SCOPE} />
					<input type="hidden" {formname key=REFERENCE_NUMBER} value="" class="referenceNumber"/>
				</div>
				<div class="modal-footer">
					<button type="button" class="btn btn-default cancel" data-dismiss="modal">{translate key='Cancel'}</button>

					<button type="button" class="btn btn-danger saveSeries btnUpdateThisInstance">
						{translate key='ThisInstance'}
					</button>
					<button type="button" class="btn btn-danger saveSeries btnUpdateAllInstances">
						{translate key='AllInstances'}
					</button>
					<button type="button" class="btn btn-danger saveSeries btnUpdateFutureInstances">
						{translate key='FutureInstances'}
					</button>
				</div>
			</div>
		</form>
	</div>
</div>

<div id="inlineUpdateErrorDialog" class="dialog" title="{translate key=Error}">
	<div id="inlineUpdateErrors" class="hidden error">&nbsp;</div>
	<div id="reservationAccessError" class="hidden error"></div>
	<button type="button" class="button cancel">{translate key='OK'}</button>
</div>

<div class="hidden">
	{foreach from=$AttributeFilters item=attribute}
		<div class="attributeTemplate" attributeId="{$attribute->Id()}">
			{control type="AttributeControl" attribute=$attribute}
			<div class="inlineUpdateCancelButtons">
				<div>
					<a href="#" class="confirmCellUpdate">{html_image src="tick-white.png"}</a>
					<a href="#" class="cancelCellUpdate">{html_image src="cross-white.png"}</a>
				</div>
			</div>
		</div>

	{/foreach}

	<form id="attributeUpdateForm" method="POST" ajaxAction="{ManageReservationsActions::UpdateAttribute}">
		<input type="hidden" id="attributeUpdateReferenceNumber" {formname key=REFERENCE_NUMBER} />
		<input type="hidden" id="attributeUpdateId" {formname key=ATTRIBUTE_ID} />
		<input type="hidden" id="attributeUpdateValue" {formname key=ATTRIBUTE_VALUE} />
	</form>
</div>

{html_image src="admin-ajax-indicator.gif" class="indicator" style="display:none;"}

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

</div>
{include file='globalfooter.tpl'}
