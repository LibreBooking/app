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
<div id="filter">
{translate key="ChangeCalendar"}
<select id="calendarFilter" class="textbox">
{foreach from=$filters->GetFilters() item=filter}
	<option value="{$filter->Id()}" class="schedule" {if $filter->Selected()}selected="selected"{/if}>{$filter->Name()}</option>
	{foreach from=$filter->GetFilters() item=subfilter}
		<option value="{$subfilter->Id()}" class="resource" {if $subfilter->Selected()}selected="selected"{/if}>-- {$subfilter->Name()}</option>
	{/foreach}
{/foreach}

</select>
</div>