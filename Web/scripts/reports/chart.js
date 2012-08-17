function Chart() {
	this.generate = function () {

		var resultsDiv = $('#report-results');
		var totalCol = resultsDiv.find("th:contains('Total')");

		var labelColumnIndex = 1;
		var totalColumnIndex = totalCol.parent("tr").children().index(totalCol) + 1;

		var series = new Array();
		$('#report-results>tbody>tr').not(':first').each(function () {

			var label = $(this).find('>td:nth-child(' + labelColumnIndex + ')').text();
			var val = parseInt($(this).find('>td:nth-child(' + totalColumnIndex + ')').text());
			series.push([label, val]);
		});

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
			series:[
//				{ label:'Resources'}
			],
			legend:{
//				show: true,
//				placement: 'outsideGrid'
			},
			axes:{
				xaxis:{
					renderer:$.jqplot.CategoryAxisRenderer,
					tickOptions:{
						//angle:-30
					}
				},
				yaxis:{
					pad:1.05,
					//tickOptions: { formatString: '%d'}
					min:0
				}
			}
		});

		plot1.redraw();
	}
}