function SavedReports(reportOptions) {
	var opts = reportOptions;

	var elements = {
		indicator:$('#indicator'),
		resultsDiv:$('#resultsDiv'),
		emailForm:$('#emailForm'),
		sendEmailButton:$('#btnSendEmail'),
		emailIndicator:$('#sendEmailIndicator')
	};

	var reportId = 0;

	this.init = function () {

		wireUpReportLinks();

		$('#btnPrint').live('click', function (e) {
			e.preventDefault();

			var url = opts.printUrl + reportId;
			window.open(url);
		});

		$('#btnCsv').live('click', function (e) {
			e.preventDefault();

			var url = opts.csvUrl + reportId;
			window.open(url);
		});

		$('.cancel').click(function (e) {
			e.preventDefault();
			$(this).closest('.dialog').dialog('close');
		});

		elements.sendEmailButton.click(function (e) {
			e.preventDefault();
			var before = function () {
				elements.sendEmailButton.hide();
				elements.emailIndicator.show()
			};
			var after = function (data) {
				$('#emailSent').show().delay(3000).fadeOut(1000);
				elements.emailIndicator.hide();
				elements.sendEmailButton.show();
				$('#emailDiv').dialog('close');
			};

			ajaxPost(elements.emailForm, opts.emailUrl + reportId, before, after);
		});
	};

	var wireUpReportLinks = function () {
		$('#report-list a.report').click(function (e) {
			e.preventDefault();
			reportId = $(this).parent().attr('reportId');
		});

		$('.runNow').click(function (e) {
			var before = function () {
				elements.indicator.show().insertBefore(elements.resultsDiv);
				elements.resultsDiv.html('');
			};

			var after = function (data) {
				elements.indicator.hide();
				elements.resultsDiv.html(data)
			};

			ajaxGet(opts.generateUrl + reportId, before, after);
		});

		$('.emailNow').click(function (e) {
			$('#emailDiv').dialog({modal:true});
		});


	};


	/**

	 // TODO: NK 2012-07-17 scheduled reports on hold for now
	 function InitializeRepeatElements() {
	 elements.repeatOptions.change(function () {
	 ChangeRepeatOptions();
	 });
	 }

	 function InitializeRepeatOptions() {
	 if (options.repeatType) {
	 elements.repeatOptions.val(options.repeatType);
	 $('#repeat_every').val(options.repeatInterval);
	 for (var i = 0; i < options.repeatWeekdays.length; i++) {
	 var id = "#repeatDay" + options.repeatWeekdays[i];
	 $(id).attr('checked', true);
	 }

	 $("#repeatOnMonthlyDiv :radio[value='" + options.repeatMonthlyType + "']").attr('checked', true);

	 ChangeRepeatOptions();
	 }
	 }

	 function ChangeRepeatOptions() {
	 var repeatDropDown = elements.repeatOptions;
	 if (repeatDropDown.val() != 'none') {
	 $('#repeatUntilDiv').show();
	 }
	 else {
	 $('div[id!=repeatOptions]', elements.repeatDiv).hide();
	 }

	 if (repeatDropDown.val() == 'daily') {
	 $('.weeks', elements.repeatDiv).hide();
	 $('.months', elements.repeatDiv).hide();
	 $('.years', elements.repeatDiv).hide();

	 $('.days', elements.repeatDiv).show();
	 }

	 if (repeatDropDown.val() == 'weekly') {
	 $('.days', elements.repeatDiv).hide();
	 $('.months', elements.repeatDiv).hide();
	 $('.years', elements.repeatDiv).hide();

	 $('.weeks', elements.repeatDiv).show();
	 }

	 if (repeatDropDown.val() == 'monthly') {
	 $('.days', elements.repeatDiv).hide();
	 $('.weeks', elements.repeatDiv).hide();
	 $('.years', elements.repeatDiv).hide();

	 $('.months', elements.repeatDiv).show();
	 }

	 if (repeatDropDown.val() == 'yearly') {
	 $('.days', elements.repeatDiv).hide();
	 $('.weeks', elements.repeatDiv).hide();
	 $('.months', elements.repeatDiv).hide();

	 $('.years', elements.repeatDiv).show();
	 }
	 }

	 */
}

