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
{include file='globalheader.tpl' cssFiles='css/dashboard.css,css/jquery.qtip.min.css'}

<ul id="dashboardList">
{foreach from=$items item=dashboardItem}
    <li>{$dashboardItem->PageLoad()}</li>
{/foreach}
</ul>

<script type="text/javascript" src="scripts/js/jquery.qtip.min.js"></script>
<script type="text/javascript" src="{$Path}scripts/dashboard.js"></script>

<script type="text/javascript">
$(document).ready(function() {

	var dashboardOpts = {
		reservationUrl: "{Pages::RESERVATION}?{QueryStringKeys::REFERENCE_NUMBER}=",
		summaryPopupUrl: "ajax/respopup.php"
	};

	var dashboard = new Dashboard(dashboardOpts);
	dashboard.init();
});
</script>

{include file='globalfooter.tpl'}