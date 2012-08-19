(function ($) {
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

		var series = null;
		if (chartType == 'totalTime') {
			series = new TotalTimeSeries();
		}
		else if (chartType == 'total') {
			series = new TotalSeries();
		}
		else {
			series = new DateSeries();
		}

		$('#report-results>tbody>tr').not(':first').each(function () {
			series.Add($(this));
		});

		//var jqDiv = $('<div/>');
		$('#chartdiv').empty();//.append(jqDiv);

		var plot = $.jqplot('chartdiv', series.GetData(), {
			axesDefaults:{
				tickRenderer:$.jqplot.CanvasAxisTickRenderer,
				tickOptions:{
					fontSize:'10pt'
				}
			},
			seriesDefaults:{
				renderer:series.GetGraphRenderer(),
				rendererOptions:{ fillToZero:true },
				pointLabels:{show:true}

			},
			series:series.GetLabels(),
			legend:{
//				show: true,
//				placement: 'outsideGrid'
			},
			axes:{
				xaxis:{
					renderer:series.GetXAxisRenderer(),
					tickOptions:{
						angle:-30,
						formatString:series.GetXAxisFormat()
					},
					//tickInterval : '1 hour',
					min:series.GetXAxisMin()
				},
				yaxis:{
					pad:1.05,
					tickOptions:{ formatString:'%d', formatter:series.GetTickFormatter()},
					min:0
				}
			}
		});
		plot.replot({resetAxes:true});
	};

	function Series() {
		this.Add = function (row) {
		};

		this.GetData = function () {
			return [];
		};

		this.GetLabels = function () {
			return [];
		};

		this.GetTickFormatter = function () {
			return $.jqplot.DefaultTickFormatter;
		};

		this.GetGraphRenderer = function () {
			return $.jqplot.BarRenderer;
		};

		this.GetXAxisRenderer = function () {
			return $.jqplot.CategoryAxisRenderer;
		};

		this.GetXAxisFormat = function () {
			return "%d";
		};

		this.GetXAxisMin = function () {
			return '';
		};
	}

	function TotalSeries() {
		this.series = new Array();
		this.labels = new Array();

		this.Add = function (row) {
			var label = row.find('td[chart-column-type="label"]').text();
			var val = parseInt(row.find('td[chart-column-type="total"]').attr("chart-value"));
			this.series.push([label, val]);
		};

		this.GetData = function () {
			return [this.series];
		};

		this.GetLabels = function () {
			return this.labels;
		};
	}

	TotalSeries.prototype = new Series();

	function TotalTimeSeries() {

		this.series = new Array();
		this.labels = new Array();

		this.GetTickFormatter = function () {
			return $.jqplot.TimeTickFormatter;
		};
	}

	TotalTimeSeries.prototype = new TotalSeries();

	function DateSeries() {
		this.labels = new Array();
		this.groups = [];
		this.min = null;
		this.first = true;

		this.Add = function (row) {
			var date = row.find('td[chart-column-type="date"]').attr('chart-value');
			var groupCell = row.find('td[chart-group="r"]');//.attr('chart-value');
			var groupId = groupCell.attr('chart-value');
			var groupName = groupCell.text();

			if (!this.groups[groupId]) {
				this.groups[groupId] = new this.GroupSeries(groupName);
			}
			this.groups[groupId].AddDate(date);

			if (this.first) {
				this.min = date;
				this.first = false;
			}
		};

		this.GetData = function () {
			var data = new Array();
			for (var group in this.groups) {
				data.push(this.groups[group].GetData());
				this.labels.push(this.groups[group].GetLabel())
			}

			return data;
		};

		this.GetLabels = function () {
			if (this.labels.length <= 0) {
				for (var group in this.groups) {
					this.labels.push(this.groups[group].GetLabel())
				}
			}
			return this.labels;
		};

		this.GetGraphRenderer = function () {
			return $.jqplot.LineRenderer;
		};

		this.GetXAxisRenderer = function () {
			return $.jqplot.DateAxisRenderer;
		};

		this.GetXAxisMin = function () {
			var minDate = new Date(this.min);
			minDate.setHours(minDate.getHours() - 1);

			return minDate.toString();
		};

		this.GetXAxisFormat = function () {
			return '%b %#d, %y %#I:%M %p'
		};

		this.GroupSeries = function (label) {
			var groupLabel = label;
			var series = new Array();

			this.AddDate = function (date) {
				if (series[date]) {
					series[date]++;
				}
				else {
					series[date] = 1;
				}
			};

			this.GetLabel = function () {
				return groupLabel;
			};

			this.GetData = function () {
				var foo = new Array();
				for (var date in series) {
					foo.push([date, series[date]])
				}
				return foo;
			}
		}
	}

	DateSeries.prototype = new Series();
}