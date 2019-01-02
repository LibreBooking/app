{*
Copyright 2017-2019 Nick Korbel

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

<table class="table" id="reservationTable">
	<thead>
		<tr>
			<th>{translate key=User}</th>
			<th>{translate key=Resource}</th>
			<th>{translate key=Title}</th>
			<th>{translate key=Description}</th>
			<th>{translate key=BeginDate}</th>
			<th>{translate key=EndDate}</th>
			<th>{translate key=Duration}</th>
			<th>{translate key=ReferenceNumber}</th>
			<th>{translate key=Created}</th>
			<th>{translate key=LastModified}</th>
		</tr>
	</thead>
	<tbody>
	{foreach from=$Reservations item=reservation}
		{cycle values='row0,row1' assign=rowCss}
		{if $reservation->RequiresApproval}
			{assign var=rowCss value='pending'}
		{/if}
		{assign var=reservationId value=$reservation->ReservationId}
		<tr class="{$rowCss} editable" data-seriesId="{$reservation->SeriesId}" data-refnum="{$reservation->ReferenceNumber}">
			<td class="user">{fullname first=$reservation->FirstName last=$reservation->LastName ignorePrivacy=($reservation->OwnerId==$UserId)}</td>
			<td class="resource">{$reservation->ResourceName}</td>
			<td class="title">{$reservation->Title}</td>
			<td class="description">{$reservation->Description}</td>
			<td class="date">{formatdate date=$reservation->StartDate timezone=$Timezone key=short_reservation_date}</td>
			<td class="date">{formatdate date=$reservation->EndDate timezone=$Timezone key=short_reservation_date}</td>
			<td class="duration">{$reservation->GetDuration()->__toString()}</td>
			<td class="referenceNumber">{$reservation->ReferenceNumber}</td>
			<td class="created">{formatdate date=$reservation->CreatedDate timezone=$Timezone key=short_datetime}</td>
			<td class="created">{formatdate date=$reservation->ModifiedDate timezone=$Timezone key=short_datetime}</td>
		</tr>

		{*<label>{translate key='CheckInTime'}</label> {formatdate date=$reservation->CheckinDate timezone=$Timezone key=short_datetime}*}
		{*</div>*}
		{*<div>*}
		{*<label>{translate key='CheckOutTime'}</label> {formatdate date=$reservation->CheckoutDate timezone=$Timezone key=short_datetime}*}
		{*</div>*}
		{*<div>*}
		{*<label>{translate key='OriginalEndDate'}</label> {formatdate date=$reservation->OriginalEndDate timezone=$Timezone key=short_datetime}*}


	{/foreach}
	</tbody>
</table>