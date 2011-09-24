{include file='globalheader.tpl' cssFiles='css/admin.css,css/jquery.qtip.css'}

<h1>{translate key=ManageReservations}</h1>

<fieldset>
	<legend><h3>Filter</h3></legend>
	<table style="display:inline;">
		<tr>
			<td>Between</td>
			<td>{translate key=User}</td>
			<td>{translate key=Schedule}</td>
			<td>{translate key=Resource}</td>
			<td>{translate key=ReferenceNumber}</td>
		</tr>
		<tr>
			<td>
				<input id="startDate" type="textbox" class="datepicker textbox" value="{formatdate date=$StartDate}"/>
				and
				<input id="endDate" type="textbox" class="datepicker textbox" value="{formatdate date=$EndDate}"/>
			</td>
			<td>
				<input id="userFilter" type="textbox" class="textbox" value="{$UserName}" />
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
				<input id="referenceNumber" type="textbox" class="textbox" value="{$ReferenceNumber}" />
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
		<th>{translate key='User'}</th>
		<th>{translate key='Resource'}</th>
		<th>{translate key='Start'}</th>
		<th>{translate key='End'}</th>
		<th>{translate key='Created'}</th>
		<th>{translate key='LastModified'}</th>
		<th>{translate key='ReferenceNumber'}</th>
		<th>{translate key='Delete'}</th>
	</tr>
	{foreach from=$reservations item=reservation}
	{cycle values='row0,row1' assign=rowCss}
	<tr class="{$rowCss} editable">
		<td class="id">{$reservation->ReservationId}</td>
		<td>{$reservation->FirstName} {$reservation->LastName}</td>
		<td>{$reservation->ResourceName}</td>
		<td>{formatdate date=$reservation->StartDate timezone=$Timezone key=res_popup}</td>
		<td>{formatdate date=$reservation->EndDate timezone=$Timezone key=res_popup}</td>
		<td>{formatdate date=$reservation->CreatedDate timezone=$Timezone key=general_datetime}</td>
		<td>{formatdate date=$reservation->ModifiedDate timezone=$Timezone key=general_datetime}</td>
		<td class="referenceNumber">{$reservation->ReferenceNumber}</td>
		<td>{html_image src='cross-button.png'}</td>
	</tr>
	{/foreach}
</table>

{pagination pageInfo=$PageInfo}


<script type="text/javascript" src="{$Path}scripts/autocomplete.js"></script>
<script type="text/javascript" src="{$Path}scripts/reservationPopup.js"></script>
<script type="text/javascript" src="{$Path}scripts/js/jquery.qtip.min.js"></script>
<script type="text/javascript" src="{$Path}scripts/admin/reservations.js"></script>
<script type="text/javascript">

$(document).ready(function() {

	var resOpts = {
		autocompleteUrl: "{$Path}ajax/autocomplete.php?type={AutoCompleteType::User}",
		reservationUrlTemplate: "{$Path}reservation.php?rn=[refnum]",
		popupUrl: "{$Path}ajax/respopup.php"
	};
		
	var reservationManagement = new ReservationManagement(resOpts);
	reservationManagement.init();
});
</script>

{include file='globalfooter.tpl'}