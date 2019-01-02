{*
Copyright 2017-2019 Nick Korbel

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
{if $resource->GetIsCalendarSubscriptionAllowed()}
    <div><a class="update disableSubscription subscriptionButton"
            href="#">{translate key=TurnOffSubscription}</a>
    </div>
    <div>
        {html_image src="feed.png"}
        <a target="_blank" href="{$resource->GetSubscriptionUrl()->GetAtomUrl()}">Atom</a>
        |
        <a target="_blank" href="{$resource->GetSubscriptionUrl()->GetWebcalUrl()}">iCalendar</a>
    </div>
    <div>
        <span>{translate key=PublicId}</span>
        <span class="propertyValue">{$resource->GetPublicId()}</span>
    </div>
{else}
    <div>
        <a class="update enableSubscription subscriptionButton"
           href="#">{translate key=TurnOnSubscription}</a>
    </div>
{/if}