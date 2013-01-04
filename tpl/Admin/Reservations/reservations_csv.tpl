{*
Copyright 2011-2013 Nick Korbel

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
{translate key='User'},{translate key='Resource'},{translate key='Title'},{translate key='Description'},{translate key='BeginDate'},{translate key='EndDate'},{translate key='Duration'},{translate key='Created'},{translate key='LastModified'},{translate key='ReferenceNumber'}{foreach from=$AttributeList->GetLabels() item=label},{$label}{/foreach}

{foreach from=$reservations item=reservation}
"{fullname first=$reservation->FirstName last=$reservation->LastName}","{$reservation->ResourceName}","{$reservation->Title}","{$reservation->Description}",{formatdate date=$reservation->StartDate timezone=$Timezone key=res_popup},{formatdate date=$reservation->EndDate timezone=$Timezone key=res_popup},"{$reservation->GetDuration()->__toString()}",{formatdate date=$reservation->CreatedDate timezone=$Timezone key=general_datetime},{formatdate date=$reservation->ModifiedDate timezone=$Timezone key=general_datetime},{$reservation->ReferenceNumber}{foreach from=$AttributeList->GetValues($reservation->SeriesId) item=value},"{$value}"{/foreach}

{/foreach}