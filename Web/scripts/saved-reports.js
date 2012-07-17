function SavedReports(reportOptions) {
	var opts = reportOptions;

	var elements = {
		indicator:$('#indicator'),
		resultsDiv:$('#resultsDiv')
	};

	var reportId = 0;
	this.init = function () {

		wireUpReportLinks();

		$('#btnPrint').live('click', function (e) {
			e.preventDefault();

			var url = opts.printUrl + elements.customReportForm.serialize();
			window.open(url);
		});

		$('#btnCsv').live('click', function (e) {
			e.preventDefault();

			var url = opts.csvUrl + elements.customReportForm.serialize();
			window.open(url);
		});

		$('#btnSaveReportPrompt').live('click', function (e) {
			e.preventDefault();

			elements.saveDialog.find(':text').val('');
			elements.saveDialog.dialog({modal:true});
		});
	};

	var wireUpReportLinks = function () {
		$('#report-list a.report').click(function (e) {
			e.preventDefault();
			reportId = $(this).parent().attr('reportId');
		});

		$('.runNow').click(function (e) {
			e.preventDefault();

			var before = function () {
				elements.indicator.show().insertBefore(elements.resultsDiv);
				elements.resultsDiv.html('');
			};

			var after = function (data) {
				elements.indicator.hide();
				elements.resultsDiv.html(data)
			};

			ajaxGet(opts.generateUrl, before, after);
		});
	};

	var ajaxGet = function (url, onBefore, onAfter) {
		$.ajax({
			type:'GET',
			url:url + reportId,
			cache:false,
			beforeSend:function () {
				onBefore();
			}
		}).done(function (data) {
					onAfter(data);
				});
	};

}

