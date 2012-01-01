{*
Copyright 2011-2012 Nick Korbel

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
<h2 style="text-align: center;">{translate key=ReservationFailed}</h2>

<div class="error">
	<ul>
	{foreach from=$Errors item=each}
		<li>{$each|nl2br}</li>
	{/foreach}
	</ul>
</div>

<div style="margin: auto;text-align: center;">
	<button id="btnSaveFailed" class="button">{html_image src="arrow_large_left.png"} {translate key='ReservationErrors'}</button>
</div>