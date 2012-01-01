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
{translate key='User'},{translate key='Resource'},{translate key='BeginDate'},{translate key='EndDate'},{translate key='Created'},{translate key='LastModified'},{translate key='ReferenceNumber'}
{foreach from=$reservations item=reservation}
{$reservation->FirstName} {$reservation->LastName},{$reservation->ResourceName},{formatdate date=$reservation->StartDate timezone=$Timezone key=res_popup},{formatdate date=$reservation->EndDate timezone=$Timezone key=res_popup},{formatdate date=$reservation->CreatedDate timezone=$Timezone key=general_datetime},{formatdate date=$reservation->ModifiedDate timezone=$Timezone key=general_datetime},{$reservation->ReferenceNumber}
{/foreach}