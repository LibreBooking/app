function ScheduleManagement(opts)
{
	var options = opts;

	var elements = {
		activeId:$('#activeId'),

		layoutDialog:$('#changeLayoutDialog'),
		deleteDialog:$('#deleteDialog'),

		changeLayoutForm:$('#changeLayoutForm'),
		placeholderForm:$('#placeholderForm'),
		deleteForm:$('#deleteForm'),

		addForm:$('#addScheduleForm'),

		reservableEdit:$('#reservableEdit'),
		blockedEdit:$('#blockedEdit'),
		layoutTimezone:$('#layoutTimezone'),
		quickLayoutConfig:$('#quickLayoutConfig'),
		quickLayoutStart:$('#quickLayoutStart'),
		quickLayoutEnd:$('#quickLayoutEnd'),
		createQuickLayout:$('#createQuickLayout'),

		daysVisible:$('#daysVisible'),
		dayOfWeek:$('#dayOfWeek'),
		deleteDestinationScheduleId:$('#targetScheduleId'),
		usesSingleLayout:$('#usesSingleLayout')
	};

	ScheduleManagement.prototype.init = function ()
	{
		$('.scheduleDetails').each(function ()
		{
			var details = $(this);
			var id = details.find(':hidden.id').val();
			var reservable = details.find('.reservableSlots');
			var blocked = details.find('.blockedSlots');
			var timezone = details.find('.timezone');
			var daysVisible = details.find('.daysVisible');
			var dayOfWeek = details.find('.dayOfWeek');
			var usesDailyLayouts = details.find('.usesDailyLayouts');

			details.find('a.update').click(function ()
			{
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

			details.find('.changeLayoutButton').click(function (e)
			{
				showChangeLayout(e, reservable, blocked, timezone, (usesDailyLayouts.val() == 'false'));
				return false;
			});

			details.find('.makeDefaultButton').click(function (e)
			{
				PerformAsyncAction($(this), getSubmitCallback(options.makeDefaultAction), $('.indicator'));
			});

			details.find('.enableSubscription').click(function (e)
			{
				PerformAsyncAction($(this), getSubmitCallback(options.enableSubscriptionAction), $('.indicator'));
			});

			details.find('.disableSubscription').click(function (e)
			{
				PerformAsyncAction($(this), getSubmitCallback(options.disableSubscriptionAction), $('.indicator'));
			});

			details.find('.deleteScheduleButton').click(function (e)
			{
				showDeleteDialog(e);
				return false;
			});

			details.find('.showAllDailyLayouts').click(function(e)
			{
				e.preventDefault();
				$(this).next('.allDailyLayouts').toggle();
			});
		});

		$(".save").click(function ()
		{
			$(this).closest('form').submit();
		});

		$(".cancel").click(function ()
		{
			$(this).closest('.dialog').dialog("close");
		});

		elements.quickLayoutConfig.change(function ()
		{
			createQuickLayout();
		});

		elements.quickLayoutStart.change(function ()
		{
			createQuickLayout();
		});

		elements.quickLayoutEnd.change(function ()
		{
			createQuickLayout();
		});

		elements.createQuickLayout.click(function (e)
		{
			e.preventDefault();
			createQuickLayout();
		});

		elements.usesSingleLayout.change(function ()
		{
			toggleLayoutChange($(this).is(':checked'));
		});

		ConfigureAdminForm(elements.changeLayoutForm, getSubmitCallback(options.changeLayoutAction));
		ConfigureAdminForm(elements.addForm, getSubmitCallback(options.addAction), null, handleAddError);
		ConfigureAdminForm(elements.deleteForm, getSubmitCallback(options.deleteAction));
	};

	var getSubmitCallback = function (action)
	{
		return function ()
		{
			return options.submitUrl + "?sid=" + elements.activeId.val() + "&action=" + action;
		};
	};

	var createQuickLayout = function ()
	{
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

	var getFormattedTime = function (date)
	{
		var hour = date.getHours() < 10 ? "0" + date.getHours() : date.getHours();
		var minute = date.getMinutes() < 10 ? "0" + date.getMinutes() : date.getMinutes();
		return hour + ":" + minute;
	};

	var handleAddError = function (responseText)
	{
		$('#addScheduleResults').text(responseText);
		$('#addScheduleResults').show();
	};

	var setActiveScheduleId = function (scheduleId)
	{
		elements.activeId.val(scheduleId);
	};

	var getActiveScheduleId = function ()
	{
		return elements.activeId.val();
	};

	var showChangeLayout = function (e, reservableDiv, blockedDiv, timezone, usesSingleLayout)
	{
		$.each(reservableDiv, function(index, val){
			var slots = reformatTimeSlots($(val));
			$('#' + $(val).attr('ref')).val(slots);
		});

		$.each(blockedDiv, function(index, val){
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

	var toggleLayoutChange = function (useSingleLayout)
	{
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

	var showDeleteDialog = function (e)
	{
		var scheduleId = getActiveScheduleId();
		elements.deleteDestinationScheduleId.children().removeAttr('disabled');
		elements.deleteDestinationScheduleId.children('option[value="' + scheduleId + '"]').attr('disabled', 'disabled');
		elements.deleteDestinationScheduleId.val('');

		elements.deleteDialog.modal('show');
	};

	var reformatTimeSlots = function (div)
	{
		var text = $.trim(div.text());
		text = text.replace(/\s\s+/g, ' ');
		text = text.replace(/\s*,\s*/g, '\n');
		return text;
	};
}