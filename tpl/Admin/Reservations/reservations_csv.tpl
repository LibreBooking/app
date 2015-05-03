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
{translate key='User'},{translate key='Resource'},{translate key='Title'},{translate key='Description'},{translate key='BeginDate'},{translate key='EndDate'},{translate key='Duration'},{translate key='Created'},{translate key='LastModified'},{translate key='ReferenceNumber'},{foreach from=$ReservationAttributes item=attr}{$attr->Label()},{/foreach}

{foreach from=$reservations item=reservation}
"{fullname first=$reservation->FirstName last=$reservation->LastName}","{$reservation->ResourceName}","{$reservation->Title}","{$reservation->Description}",{formatdate date=$reservation->StartDate timezone=$Timezone key=res_popup},{formatdate date=$reservation->EndDate timezone=$Timezone key=res_popup},"{$reservation->GetDuration()->__toString()}",{formatdate date=$reservation->CreatedDate timezone=$Timezone key=general_datetime},{formatdate date=$reservation->ModifiedDate timezone=$Timezone key=general_datetime},{$reservation->ReferenceNumber},{foreach from=$ReservationAttributes item=attribute}{$reservation->Attributes->Get($attribute->Id())},{/foreach}

{/foreach}