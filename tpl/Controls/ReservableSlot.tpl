{*
Copyright  Nick Korbel

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
<td colspan="{$Slot->PeriodSpan()}" class="reservable clickres slot">
&nbsp;
<input type="hidden" class="href" value="{$Href}" />
<input type="hidden" class="start" value="{$Slot->BeginDate()->Format('Y-m-d H:i:s')|escape:url}" />
<input type="hidden" class="end" value="{$Slot->EndDate()->Format('Y-m-d H:i:s')|escape:url}" />
</td>