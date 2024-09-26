<div class="clear"></div>
<div class="modal" id="approveDiv" tabindex="-1" role="dialog" aria-labelledby="approveDivLabel"
	data-bs-backdrop="static" aria-hidden="true">
	{include file="wait-box.tpl" translateKey='Working'}
</div>

<div id="chartdiv" class="card shadow w-100 my-2" style="display:none;height:400px"></div>

<!--[if lt IE 9]>{jsfile src="js/jqplot/excanvas.js"}<![endif]-->
{jsfile src="js/jqplot/jquery.jqplot.min.js"}
{jsfile src="js/jqplot/plugins/jqplot.barRenderer.min.js"}
{jsfile src="js/jqplot/plugins/jqplot.categoryAxisRenderer.min.js"}
{jsfile src="js/jqplot/plugins/jqplot.canvasAxisTickRenderer.min.js"}
{jsfile src="js/jqplot/plugins/jqplot.canvasTextRenderer.min.js"}
{jsfile src="js/jqplot/plugins/jqplot.pointLabels.min.js"}
{jsfile src="js/jqplot/plugins/jqplot.dateAxisRenderer.min.js"}