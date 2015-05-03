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
{include file='globalheader.tpl'}
<form>
<ul>
	<li>For resource: <select id="resourceId" class="textbox"><option>Resource 1</option></select></li>
	<li class=""><select class="textbox"><option>Specific Date</option><option>Date Range</option></select></li>
	<li><input type="text" id="reservationDate" class="textbox" /></li>
	<li><input type="text" id="startDate" class="textbox"/> and <input type="text" id="endDate" class="textbox" /></li>
	<li><select class="textbox"><option>Length</option><option>Period</option></select></li>
	<li><input type="text" value="0" /> hours <input type="text" value="0" /> minutes</li>
	<li>Start: <select id="beginPeriod"></select> End: <select id="endPeriod"></select></li>
</ul>
</form>
{include file='globalfooter.tpl'}