function ScheduleManagement(opts) {
	var options = opts;

	var elements = {
		activeId: $('#activeId'),

		layoutDialog: $('#changeLayoutDialog'),
		deleteDialog: $('#deleteDialog'),
		addDialog: $('#addDialog'),

		changeLayoutForm: $('#changeLayoutForm'),
		placeholderForm: $('#placeholderForm'),
		deleteForm: $('#deleteForm'),

		addForm: $('#addScheduleForm'),
        addName: $('#addName'),

		reservableEdit: $('#reservableEdit'),
		blockedEdit: $('#blockedEdit'),
		layoutTimezone: $('#layoutTimezone'),
		quickLayoutConfig: $('#quickLayoutConfig'),
		quickLayoutStart: $('#quickLayoutStart'),
		quickLayoutEnd: $('#quickLayoutEnd'),
		createQuickLayout: $('#createQuickLayout'),

		daysVisible: $('#daysVisible'),
		dayOfWeek: $('#dayOfWeek'),
		deleteDestinationScheduleId: $('#targetScheduleId'),
		usesSingleLayout: $('#usesSingleLayout'),

		addScheduleButton: $('#add-schedule'),

		peakTimesDialog: $('#peakTimesDialog'),
		peakTimesForm: $('#peakTimesForm'),
		peakEveryDay: $('#peakEveryDay'),
		peakDayList: $('#peakDayList'),
		peakAllYear: $('#peakAllYear'),
		peakDateRange: $('#peakDateRange'),
		peakAllDay: $('#peakAllDay'),
		peakTimes: $('#peakTimes'),
		deletePeakTimesButton: $('#deletePeakBtn'),
		deletePeakTimes: $('#deletePeakTimes')
	};

	ScheduleManagement.prototype.init = function () {
		$('.scheduleDetails').each(function () {
			var details = $(this);
			var id = details.find(':hidden.id').val();
			var reservable = details.find('.reservableSlots');
			var blocked = details.find('.blockedSlots');
			var timezone = details.find('.timezone');
			var daysVisible = details.find('.daysVisible');
			var dayOfWeek = details.find('.dayOfWeek');
			var usesDailyLayouts = details.find('.usesDailyLayouts');

			details.find('a.update').click(function () {
				setActiveScheduleId(id);
			});

			details.find('.renameButton').click(function (e) {
				e.stopPropagation();
				details.find('.scheduleName').editable('toggle');
			});

			details.find('.dayName').click(function (e) {
				e.stopPropagation();
				$(this).editable('toggle');
			});

			details.find('.daysVisible').click(function (e) {
				e.stopPropagation();
				$(this).editable('toggle');
			});

			details.find('.changeScheduleAdmin').click(function (e) {
				e.stopPropagation();
				details.find('.scheduleAdmin').editable('toggle');
			});

			details.find('.changeLayoutButton').click(function (e) {
				showChangeLayout(e, reservable, blocked, timezone, (usesDailyLayouts.val() == 'false'));
				return false;
			});

			details.find('.makeDefaultButton').click(function (e) {
				PerformAsyncAction($(this), getSubmitCallback(options.makeDefaultAction), $('#action-indicator'));
			});

			details.find('.enableSubscription').click(function (e) {
				PerformAsyncAction($(this), getSubmitCallback(options.enableSubscriptionAction), $('#action-indicator'));
			});

			details.find('.disableSubscription').click(function (e) {
				PerformAsyncAction($(this), getSubmitCallback(options.disableSubscriptionAction), $('#action-indicator'));
			});

			details.find('.deleteScheduleButton').click(function (e) {
				showDeleteDialog(e);
				return false;
			});

			details.find('.showAllDailyLayouts').click(function (e) {
				e.preventDefault();
				$(this).next('.allDailyLayouts').toggle();
			});

			details.find('.changePeakTimes').click(function (e) {
				e.preventDefault();
				showPeakTimesDialog(getActiveScheduleId());
			});
		});

		elements.deletePeakTimesButton.click(function(e) {
			e.preventDefault();
			elements.deletePeakTimes.val('1');
		});

		$(".save").click(function (e) {
			e.preventDefault();
			e.stopPropagation();
			$(this).closest('form').submit();
		});

		$(".cancel").click(function () {
			$(this).closest('.dialog').dialog("close");
		});

		elements.quickLayoutConfig.change(function () {
			createQuickLayout();
		});

		elements.quickLayoutStart.change(function () {
			createQuickLayout();
		});

		elements.quickLayoutEnd.change(function () {
			createQuickLayout();
		});

		elements.createQuickLayout.click(function (e) {
			e.preventDefault();
			createQuickLayout();
		});

		elements.usesSingleLayout.change(function () {
			toggleLayoutChange($(this).is(':checked'));
		});

		elements.addScheduleButton.click(function (e) {
			e.preventDefault();
			elements.addDialog.modal('show');
		});

        elements.addDialog.on('shown.bs.modal', function () {
            elements.addName.focus();
        });

        $('.autofillBlocked').click(function(e){
			e.preventDefault();
			autoFillBlocked();
		});

		wireUpPeakTimeToggles();

		ConfigureAsyncForm(elements.changeLayoutForm, getSubmitCallback(options.changeLayoutAction));
		ConfigureAsyncForm(elements.addForm, getSubmitCallback(options.addAction), null, handleAddError);
		ConfigureAsyncForm(elements.deleteForm, getSubmitCallback(options.deleteAction));
		ConfigureAsyncForm(elements.peakTimesForm, getSubmitCallback(options.peakTimesAction), refreshPeakTimes);
	};

	var getSubmitCallback = function (action) {
		return function () {
			return options.submitUrl + "?sid=" + elements.activeId.val() + "&action=" + action;
		};
	};

	var createQuickLayout = function () {
		var intervalMinutes = elements.quickLayoutConfig.val();
		var startTime = elements.quickLayoutStart.val();
		var endTime = elements.quickLayoutEnd.val();

		if (intervalMinutes != '' && startTime != '' && endTime != '')
		{
			var layout = '';
			var blocked = '';

			if (startTime != '00:00')
			{
				blocked += '00:00 - ' + startTime + "\n";
			}

			if (endTime != '00:00')
			{
				blocked += endTime + ' - 00:00';
			}

			var startTimes = startTime.split(":");
			var endTimes = endTime.split(":");

			var currentTime = new Date();
			currentTime.setHours(startTimes[0]);
			currentTime.setMinutes(startTimes[1]);

			var endDateTime = new Date();
			endDateTime.setHours(endTimes[0]);
			endDateTime.setMinutes(endTimes[1]);

			var nextTime = new Date(currentTime);

			var intervalMilliseconds = 60 * 1000 * intervalMinutes;
			while (currentTime.getTime() < endDateTime.getTime())
			{
				nextTime.setTime(nextTime.getTime() + intervalMilliseconds);

				layout += getFormattedTime(currentTime) + ' - ';
				layout += getFormattedTime(nextTime) + '\n';

				currentTime.setTime(currentTime.getTime() + intervalMilliseconds);
			}

			$('.reservableEdit:visible', elements.layoutDialog).val(layout);
			$('.blockedEdit:visible', elements.layoutDialog).val(blocked);
		}
	};

	var getFormattedTime = function (date) {
		var hour = date.getHours() < 10 ? "0" + date.getHours() : date.getHours();
		var minute = date.getMinutes() < 10 ? "0" + date.getMinutes() : date.getMinutes();
		return hour + ":" + minute;
	};

	var autoFillBlocked = function() {

		function splitAndTrim(line) {
			return _.map(_.split(line, '-'), _.trim);
		}

		var blocked = '';

		var reservableText = _.trim($('.reservableEdit:visible', elements.layoutDialog).val());
		var reservable = _.split(reservableText, "\n");
		if (reservable.length === 0)
		{
			$('.blockedEdit:visible', elements.layoutDialog).val("00:00 - 00:00");
			return;
		}

		var startIndex = 0;
		if (!_.startsWith(reservable[0], '00:00') && !_.startsWith(reservable[0], '0:00'))
		{
			blocked += "00:00 - " + splitAndTrim(reservable)[0] + "\n";
			startIndex = 1;
		}

		for (var i = startIndex; i < reservable.length; i++) {
			var firstIteration = i === 0;
			var lastIteration = i+1 === reservable.length;

			if (_.isEmpty(_.trim(reservable[i])))
			{
				continue;
			}

			var current = splitAndTrim(reservable[i]);
			var previous = null;
			if (!firstIteration)
			{
				previous = splitAndTrim(reservable[i - 1]);
			}

			if (!firstIteration && !lastIteration && current[0] != previous[1])
			{
				blocked += previous[1] + " - " + current[0] + "\n";
			}

			if (lastIteration && current[1] != '00:00')
			{
				blocked += current[1] + ' - 00:00' + "\n";
			}
		}

		$('.blockedEdit:visible', elements.layoutDialog).val(blocked);
	};

	var handleAddError = function (responseText) {
		$('#addScheduleResults').text(responseText);
		$('#addScheduleResults').show();
	};

	var setActiveScheduleId = function (scheduleId) {
		elements.activeId.val(scheduleId);
	};

	var getActiveScheduleId = function () {
		return elements.activeId.val();
	};

	var showChangeLayout = function (e, reservableDiv, blockedDiv, timezone, usesSingleLayout) {
		elements.changeLayoutForm.find('.validationSummary ').addClass('no-show');
	    $.each(reservableDiv, function (index, val) {
			var slots = reformatTimeSlots($(val));
			$('#' + $(val).attr('ref')).val(slots);
		});

		$.each(blockedDiv, function (index, val) {
			var slots = reformatTimeSlots($(val));
			$('#' + $(val).attr('ref')).val(slots);
		});

		elements.layoutTimezone.val(timezone.val());
		elements.usesSingleLayout.prop('checked', false);

		if (usesSingleLayout)
		{
			elements.usesSingleLayout.prop('checked', true);
		}
		elements.usesSingleLayout.trigger('change');

		elements.layoutDialog.modal("show");
	};

	var toggleLayoutChange = function (useSingleLayout) {
		if (useSingleLayout)
		{
			$('#dailySlots').hide();
			$('#staticSlots').show();
		}
		else
		{
			$('#staticSlots').hide();
			$('#dailySlots').show();
		}
	};

	var showDeleteDialog = function (e) {
		var scheduleId = getActiveScheduleId();
		elements.deleteDestinationScheduleId.children().removeAttr('disabled');
		elements.deleteDestinationScheduleId.children('option[value="' + scheduleId + '"]').attr('disabled', 'disabled');
		elements.deleteDestinationScheduleId.val('');

		elements.deleteDialog.modal('show');
	};

	var reformatTimeSlots = function (div) {
		var text = $.trim(div.text());
		text = text.replace(/\s\s+/g, ' ');
		text = text.replace(/\s*,\s*/g, '\n');
		return text;
	};

	var showPeakTimesDialog = function (scheduleId) {
		var peakPlaceHolder = $('[data-schedule-id=' + scheduleId + ']').find('.peakPlaceHolder');

		var times = peakPlaceHolder.find('.peakTimes');
		var days = peakPlaceHolder.find('.peakDays');
		var months = peakPlaceHolder.find('.peakMonths');

		if (times.length > 0)
		{
			var allDay = times.data('all-day');
			var startTime = times.data('start-time');
			var endTime = times.data('end-time');

			var everyday = days.data('everyday');
			var days = days.data('weekdays').split(",");

			var allYear = months.data('all-year');
			var beginMonth = months.data('begin-month');
			var beginDay = months.data('begin-day');
			var endMonth = months.data('end-month');
			var endDay = months.data('end-day');

			if (allDay == 1)
			{
				elements.peakAllDay.prop('checked', true);
			}
			else
			{
				elements.peakAllDay.prop('checked', false);
				$('#peakStartTime').val(startTime);
				$('#peakEndTime').val(endTime);
			}

			elements.peakEveryDay.attr('checked', everyday == 1);

			_.each($('#peakDayList').find(':checked'), function (e) {
				$(e).closest('label').button('toggle');
			});

			_.each(days, function (day) {
				$('#peakDay' + day).closest('label').button('toggle');
			});

			if (allYear == 1)
			{
				elements.peakAllYear.prop('checked', true);
			}
			else
			{
				elements.peakAllYear.prop('checked', false);
				$('#peakBeginMonth').val(beginMonth);
				$('#peakBeginDay').val(beginDay);
				$('#peakEndMonth').val(endMonth);
				$('#peakEndDay').val(endDay);
			}

			peakOnAllDayChanged();
			peakOnEveryDayChanged();
			peakOnAllYearChanged();
		}

		elements.deletePeakTimes.val('');
		elements.peakTimesDialog.modal('show');
	};

	var peakOnEveryDayChanged = function () {
		if ((elements.peakEveryDay).is(':checked'))
		{
			elements.peakDayList.addClass('no-show');
		}
		else
		{
			elements.peakDayList.removeClass('no-show');
		}
	};

	var peakOnAllYearChanged = function () {
		if ((elements.peakAllYear).is(':checked'))
		{
			elements.peakDateRange.addClass('no-show');
		}
		else
		{
			elements.peakDateRange.removeClass('no-show');
		}
	};

	var peakOnAllDayChanged = function () {
		if ((elements.peakAllDay).is(':checked'))
		{
			elements.peakTimes.addClass('no-show');
		}
		else
		{
			elements.peakTimes.removeClass('no-show');
		}
	};

	var refreshPeakTimes = function (resultHtml) {
		$('[data-schedule-id=' + getActiveScheduleId() + ']').find('.peakPlaceHolder').html(resultHtml);
		elements.peakTimesDialog.modal('hide');
	};

	var wireUpPeakTimeToggles = function () {
		elements.peakEveryDay.on('click', function (e) {
			peakOnEveryDayChanged();
		});

		elements.peakAllYear.on('click', function (e) {
			peakOnAllYearChanged();
		});

		elements.peakAllDay.on('click', function (e) {
			peakOnAllDayChanged();
		});
	};
}