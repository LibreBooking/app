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
<div class="dashboard" id="announcementsDashboard">
	<div class="dashboardHeader">
		<div class="pull-left">{translate key="Announcements"} <span class="badge">{$Announcements|count}</span></div>
		<div class="pull-right">
			<a href="#" title="{translate key=ShowHide} {translate key="Announcements"}">
				<i class="glyphicon"></i>
                <span class="no-show">Expand/Collapse</span>
            </a>
		</div>
		<div class="clearfix"></div>
	</div>
	<div class="dashboardContents">
		<ul>
			{foreach from=$Announcements item=each}
				<li>{$each->Text()|html_entity_decode|url2link|nl2br}</li>
				{foreachelse}
				<div class="noresults">{translate key="NoAnnouncements"}</div>
			{/foreach}
		</ul>
	</div>
</div>
