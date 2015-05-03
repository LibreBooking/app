{*
Copyright 2012-2015 Nick Korbel

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
<div class="clear"></div>
<div id="chart-indicator" style="display:none; text-align: center;">
	<h3>{translate key=Working}</h3>
{html_image src="admin-ajax-indicator.gif"}
</div>

<div id="chartdiv" style="margin:auto;height:400px;width:80%"></div>

<!--[if lt IE 9]>{jsfile src="js/jqplot/excanvas.min.js"}<![endif]-->
{jsfile src="js/jqplot/jquery.jqplot.min.js"}
{jsfile src="js/jqplot/plugins/jqplot.barRenderer.min.js"}
{jsfile src="js/jqplot/plugins/jqplot.categoryAxisRenderer.min.js"}
{jsfile src="js/jqplot/plugins/jqplot.canvasAxisTickRenderer.min.js"}
{jsfile src="js/jqplot/plugins/jqplot.canvasTextRenderer.min.js"}
{jsfile src="js/jqplot/plugins/jqplot.pointLabels.min.js"}
{jsfile src="js/jqplot/plugins/jqplot.dateAxisRenderer.min.js"}

<script type="text/javascript">
	$(document).ready(function () {
		$(document).on('loaded', '#report-no-data, #report-results', function () {
			var chart = new Chart();
			chart.clear();
		});
	});
</script>