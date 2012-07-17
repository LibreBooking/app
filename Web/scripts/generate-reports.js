function GenerateReports(reportOptions) {
	var opts = reportOptions;

	var elements = {
		indicator:$('#indicator'),
		customReportForm:$('#customReportInput'),
		saveDialog:$('#saveDialog'),
		saveReportForm:$('#saveReportForm'),
		resultsDiv:$('#resultsDiv')
	};

	GenerateReports.prototype.init = function () {
		$('#selectDiv input').click(function () {
			$('div.select-toggle').hide();

			if ($(this).attr('id') == 'results_list') {
				$('#listOfDiv').show();
			}
			else {
				$('#aggregateDiv').show();
			}
		});

		$("#user_filter").userAutoComplete(opts.userAutocompleteUrl, function (ui) {
			$('#user_id').val(ui.item.value);
		});

		$("#group_filter").userAutoComplete(opts.groupAutocompleteUrl);

		$('.dateinput').click(function () {
			$('#range_within').attr('checked', 'checked');
		});

		$('#btnCustomReport').click(function (e) {
			e.preventDefault();

			var before = function () {
				elements.indicator.show().insertBefore(elements.resultsDiv);
				elements.resultsDiv.html('');
			};

			var after = function (data) {
				elements.indicator.hide();
				elements.resultsDiv.html(data)
			};

			ajaxPost(elements.customReportForm, opts.customReportUrl, before, after);
		});

		$('#showHideCustom').click(function (e) {
			e.preventDefault();
			$('#customReportInput-container').toggle();
		});

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

		$('.dialog .cancel').click(function (e) {
			$(this).closest('.dialog').dialog("close");
		});

		$('#btnSaveReport').click(function (e) {
			var before = function () {};

			var after = function (data) {
				elements.saveDialog.dialog('close');
				$('#saveMessage').show().delay(3000).fadeOut(1000);
			};

			ajaxPost($('#customReportInput, #saveReportForm'), opts.saveUrl, before, after);
		});
	};



}