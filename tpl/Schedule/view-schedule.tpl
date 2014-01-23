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
{extends file="Schedule/schedule.tpl"}

{block name="header"}
{include file='globalheader.tpl' cssFiles='css/schedule.css,css/view-schedule.css,css/jquery.qtip.min.css'}
{/block}

{block name="actions"}{/block}

{block name="scripts-common"}
	{jsfile src="js/jquery.qtip.min.js"}
	{jsfile src="schedule.js"}
	{jsfile src="resourcePopup.js"}

<script type="text/javascript">

$(document).ready(function() {
	var scheduleOptions = {
		reservationUrlTemplate: "view-reservation.php?{QueryStringKeys::REFERENCE_NUMBER}=[referenceNumber]",
		summaryPopupUrl: "ajax/respopup.php"
	};
	var schedule = new Schedule(scheduleOptions, {$ResourceGroupsAsJson});
	schedule.initNavigation();
	schedule.initReservations();
	schedule.initResources();
});
</script>

{/block}