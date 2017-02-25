{*
Copyright 2011-2017 Nick Korbel

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
"{translate key='Name'}","{translate key='Username'}","{translate key='Email'}","{translate key='Phone'}","{translate key='Organization'}","{translate key='Position'}","{translate key='Created'}","{translate key='LastLogin'}","{translate key='Status'}","{translate key='Credits'}","{translate key='Color'}",{foreach from=$AttributeList item=attr}"{$attr->Label()}",{/foreach}

{foreach from=$users item=user}
"{fullname first=$user->First last=$user->Last ignorePrivacy="true"}","{$user->Username}","{$user->Email}","{$user->Phone}",{$user->Organization},"{$user->Position}","{format_date date=$user->DateCreated key=short_datetime}","{format_date date=$user->LastLogin key=short_datetime}","{$statusDescriptions[$user->StatusId]}","{$user->CurrentCreditCount}","{$user->ReservationColor}",{foreach from=$AttributeList item=attribute}"{$user->GetAttributeValue($attribute->Id())}",{/foreach}

{/foreach}