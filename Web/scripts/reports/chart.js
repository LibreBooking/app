var TimeTickFormatter = function (format, val) {
    var numdays = Math.floor(val / 86400);
    var numhours = Math.floor((val % 86400) / 3600);
    var numminutes = Math.floor(((val % 86400) % 3600) / 60);

    var hoursAndMinutes = numhours + "h " + numminutes + "m ";

    if (numdays > 0) {
        return numdays + "d " + hoursAndMinutes;
    }
    return hoursAndMinutes;
};

function BookedChart(options) {
    var chartDiv = $('#chartdiv');
    var chartCanvas = $('#chart-canvas');
    var chartIndicator = $('#chart-indicator');

    this.clear = function () {
        chartDiv.hide();
    };

    this.generate = function () {
        var resultsDiv = $('#report-results');
        chartDiv.show();
        chartIndicator.show();

        var chartType = resultsDiv.attr('chart-type');
        var series = null;
        // if (chartType == 'totalTime') {
        //     series = new TotalTimeSeries();
        // } else
            if (chartType == 'totalTime' || chartType == 'total') {
            series = new TotalSeries();
        } else {
            series = new DateSeries(options);
        }
        $('#report-results>tbody>tr').each(function () {
            series.Add($(this));
        });

        var data = {
            type: 'line',
                labels: series.GetXLabels(),
                datasets: series.GetData()
        };
        var chart = Chart.Line(chartCanvas,{
            data:data,
            options: {
                scales: {
                    xAxes: [
                        series.GetXAxis()
                    ],
                    yAxes: [{
                        min: 0
                    }]
                }
            }
        });

        chartIndicator.hide();
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

        this.GetXLabels = function() {
            return [];
        };

        this.GetXAxis = function() {
            return {};
        };
    }

    function TotalSeries() {
        this.series = [];
        this.labels = [];

        this.Add = function (row) {
            var itemLabel = row.find('td[chart-column-type="label"]').text();
            var val = parseInt(row.find('td[chart-column-type="total"]').attr("chart-value"));
            this.labels.push(itemLabel);
            this.series.push(val);
        };

        this.GetData = function () {
            return this.series;
        };

        this.GetXLabels = function () {
            return this.labels;
        };
    }

    TotalSeries.prototype = new Series();

    function TotalTimeSeries() {
        this.series = [];
        this.labels = [];
    }

    TotalTimeSeries.prototype = new TotalSeries();

    function DateSeries(options) {
        this.labels = [];
        this.groups = [];
        this.min = null;
        this.first = true;
        this.dates = [];

        this.Add = function (row) {
            var date = moment(row.find('td[chart-column-type="date"]').attr('chart-value'));
            var groupCell = row.find('td[chart-group="r"],td[chart-group="a"]');
            var groupId = groupCell.attr('chart-value');
            var groupName = groupCell.text();
            var totalValue = row.find('td[chart-column-type="total"]').attr('chart-value');
            var total = _.isEmpty(totalValue) ? 1: parseInt(totalValue);

            if (!this.groups[groupId]) {
                this.groups[groupId] = new this.GroupSeries(groupName, groupId);
            }
            this.groups[groupId].AddDate(date, total);

            if (this.first) {
                this.min = date;
                this.first = false;
            }

            this.dates.push(date.format("YYYY-MM-DD"));
        };

        this.dataLoaded = false;
        this.GetData = function () {
            var data = [];
            if (!this.dataLoaded) {
                for (var group in this.groups) {
                    data.push({
                        label: this.groups[group].GetLabel(),
                        data: this.groups[group].GetData()
                    });

                    this.labels.push({label: this.groups[group].GetLabel()});
                }
                this.dataLoaded = true;
            }

            return data;
        };

        this.GetLabels = function () {
            if (this.labels.length <= 0) {
                for (var group in this.groups) {
                    this.labels.push({label: this.groups[group].GetLabel()});
                }
            }

            return this.labels;
        };

        this.GetLegendOptions = function () {
            return {
                show: true,
                placement: 'outsideGrid',
                fontSize: '10pt'
            };
        };

        this.GroupSeries = function (label, groupId) {
            var groupLabel = label;
            var series = [];
            var id = groupId;

            this.AddDate = function (date, count) {
                if (count === '' || count === undefined) {
                    count = 0;
                }
                if (series[date]) {
                    series[date] += count;
                } else {
                    series[date] = count;
                }
            };

            this.GetLabel = function () {
                return groupLabel;
            };

            this.GetData = function () {
                var data = [];
                for (var date in series) {
                    // data.push([date, series[date]]);
                    // data.push({t: date, y:series[date]});
                    data.push(series[date]);
                }
                return data;
            };

            this.GetId = function () {
                return id;
            };
        };

        this.GetXLabels = function() {
            return this.dates;
        };

        this.GetXAxis = function() {
            return {
                type: 'time',
                time: {
                    parser: "YYYY-MM-DD",
                    unit: 'day'
                }
            };
        };
    }

    DateSeries.prototype = new Series();
}