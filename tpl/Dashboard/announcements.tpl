{*
Copyright 2011-2020 Nick Korbel

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
<div class="dashboard" id="announcementsDashboard">
	<div class="dashboardHeader">
		<div class="left">{translate key="Announcements"} <span class="badge">{$Announcements|count}</span></div>
		<div class="right">
			<a href="#" title="{translate key=ShowHide} {translate key="Announcements"}">
                <i class="fas fa-chevron-down"></i>
                <span class="no-show">Expand/Collapse</span>
            </a>
		</div>
		<div class="clearfix"></div>
	</div>
	<div class="dashboardContents">
        {if $Announcements|count == 0}
            <div class="noresults">{translate key="NoAnnouncements"}</div>
        {else}
            <ul>
                {foreach from=$Announcements item=each}
                    <li>{$each->Text()|html_entity_decode|url2link|nl2br}</li>
                {/foreach}
            </ul>
        {/if}
	</div>
</div>
