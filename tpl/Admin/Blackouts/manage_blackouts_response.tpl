{*
Copyright 2011-2019 Nick Korbel

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
<div>
	{if $Successful}
		<h2>{translate key=$SuccessKey}</h2>
		<button class="reload btn btn-primary">{translate key="OK"}</button>
	{else}
		<h2>{translate key=$FailKey}</h2>
		<button class="unblock btn btn-primary">{translate key="OK"}</button>
	{/if}

	{if !empty($Message)}
		<h5>{$Message}</h5>
	{/if}

	{if !empty($Blackouts)}
		<h5>{translate key=BlackoutConflicts}</h5>
		{foreach from=$Blackouts item=blackout}
			{format_date date=$blackout->StartDate timezone=$Timezone}
		{/foreach}
	{/if}

	{if !empty($Reservations)}
		<h5>{translate key=ReservationConflicts}</h5>
		<table class="table" id="reservationTable" style="margin-left: auto; margin-right: auto;">
			<thead>
			<tr data-reservation-id="{$reservation->ReservationId}">
				<th>{translate key='User'}</th>
				<th>{translate key='Resource'}</th>
				<th>{translate key='BeginDate'}</th>
				<th>{translate key='EndDate'}</th>
				<th>{translate key='ReferenceNumber'}</th>
			</tr>
			</thead>
			<tbody>
			{foreach from=$Reservations item=reservation}
				{cycle values='row0,row1' assign=rowCss}
				<tr class="{$rowCss} editable">
					<td>{$reservation->FirstName} {$reservation->LastName}</td>
					<td>{$reservation->ResourceName}</td>
					<td>{formatdate date=$reservation->StartDate timezone=$Timezone key=res_popup}</td>
					<td>{formatdate date=$reservation->EndDate timezone=$Timezone key=res_popup}</td>
					<td class="referenceNumber">{$reservation->ReferenceNumber}</td>
				</tr>
			{/foreach}
			</tbody>
		</table>
	{/if}
</div>