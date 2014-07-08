{*
Copyright 2011-2014 Nick Korbel

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
<div class="panel panel-default dashboard" id="announcementsDashboard">
  <div class="panel-heading dashboardHeader">{translate key="Announcements"} <a href="#" title="{translate key=ShowHide} {translate key="Announcements"}"><span class="glyphicon"></span></a></div>
  <div class="panel-body dashboardContents">
	  <ul>
		{foreach from=$Announcements item=each}
			<li>{$each|html_entity_decode|url2link|nl2br}</li>
		{foreachelse}
			<div class="noresults">{translate key="NoAnnouncements"}</div>
		{/foreach}
	</ul>
  </div>
</div>
