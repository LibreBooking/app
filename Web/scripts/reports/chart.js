(function($) {
    $.jqplot.TimeTickFormatter = function (format, val) {
		var numdays = Math.floor(val / 86400);
		var numhours = Math.floor((val % 86400) / 3600);
		var numminutes = Math.floor(((val % 86400) % 3600) / 60);

		$hoursAndMinutes = numhours + "h " + numminutes + "m ";

		if (numdays > 0) {
			return numdays + "d " + $hoursAndMinutes;
		}
		return $hoursAndMinutes;

    };
})(jQuery);

function Chart() {
	this.generate = function () {

		var resultsDiv = $('#report-results');
		var chartType = resultsDiv.attr('chart-type');
		var series = new Array();
		var seriesLabels = new Array();

		$('#report-results>tbody>tr').not(':first').each(function () {
			var label = $(this).find('td[chart-type="label"]').text();
			var val = parseInt($(this).find('td[chart-type="total"]').attr("chart-value"));
			series.push([label, val]);
		});

		var tickFormatter = $.jqplot.DefaultTickFormatter;
		if (chartType == 'totalTime')
		{
			tickFormatter = $.jqplot.TimeTickFormatter;
		}

		var plot1 = $.jqplot('chartdiv', [series], {
			axesDefaults:{
				tickRenderer: $.jqplot.CanvasAxisTickRenderer ,
				tickOptions:{
					fontSize:'10pt'
				}
			},
			seriesDefaults:{
				renderer:$.jqplot.BarRenderer,
				rendererOptions:{ fillToZero:true },
				pointLabels:{show:true}

			},
			series: seriesLabels,
			legend:{
//				show: true,
//				placement: 'outsideGrid'
			},
			axes:{
				xaxis:{
					renderer:$.jqplot.CategoryAxisRenderer,
					tickOptions:{
						angle:-30
					}
				},
				yaxis:{
					pad:1.05,
					tickOptions: { formatString:'%d', formatter: tickFormatter},
					min:0
				}
			}
		});

		plot1.redraw();
	}
}