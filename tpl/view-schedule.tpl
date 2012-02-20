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
{extends file="schedule.tpl"}

{block name="header"}
{include file='globalheader.tpl' cssFiles='css/schedule.css,css/view-schedule.css'}
{/block}

{block name="scripts"}
<script type="text/javascript" src="scripts/js/jquery.qtip.min.js"></script>
<script type="text/javascript" src="scripts/schedule.js"></script>

<script type="text/javascript">

$(document).ready(function() {
	var scheduleOptions = {
		reservationUrlTemplate: "view-reservation.php?{QueryStringKeys::REFERENCE_NUMBER}=[referenceNumber]",
		summaryPopupUrl: "ajax/respopup.php"
	}
	var schedule = new Schedule(scheduleOptions);
	schedule.initNavigation();
	schedule.initReservations();
});
</script>

{/block}