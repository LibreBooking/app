function ScheduleManagement(opts)
{
	var options = opts;

	var elements = {
		activeId:$('#activeId'),

		renameDialog:$('#renameDialog'),
		layoutDialog:$('#changeLayoutDialog'),
		changeSettingsDialog:$('#changeSettingsDialog'),
		deleteDialog:$('#deleteDialog'),
		groupAdminDialog:$('#groupAdminDialog'),

		renameForm:$('#renameForm'),
		settingsForm:$('#settingsForm'),
		changeLayoutForm:$('#changeLayoutForm'),
		placeholderForm:$('#placeholderForm'),
		deleteForm:$('#deleteForm'),
		groupAdminForm:$('#groupAdminForm'),

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
		ConfigureAdminDialog(elements.renameDialog, 300, 125);
		ConfigureAdminDialog(elements.changeSettingsDialog, 'auto', 'auto');
		ConfigureAdminDialog(elements.layoutDialog, 725, 'auto');
		ConfigureAdminDialog(elements.deleteDialog, 430, 200);
		ConfigureAdminDialog(elements.groupAdminDialog, 300, 125);

		$('#tabs').tabs();

		$('.scheduleDetails').each(function ()
		{
			var id = $(this).find(':hidden.id').val();
			var reservable = $(this).find('.reservableSlots');
			var blocked = $(this).find('.blockedSlots');
			var timezone = $(this).find('.timezone');
			var daysVisible = $(this).find('.daysVisible');
			var dayOfWeek = $(this).find('.dayOfWeek');
			var usesDailyLayouts = $(this).find('.usesDailyLayouts');

			$(this).find('a.update').click(function ()
			{
				setActiveScheduleId(id);
			});

			$(this).find('.renameButton').click(function (e)
			{
				showRename(e);
				return false;
			});

			$(this).find('.changeButton').click(function (e)
			{
				showChangeSettings(e, daysVisible, dayOfWeek);
				return false;
			});

			$(this).find('.changeLayoutButton').click(function (e)
			{
				showChangeLayout(e, reservable, blocked, timezone, (usesDailyLayouts.val() == 'false'));
				return false;
			});

			$(this).find('.makeDefaultButton').click(function (e)
			{
				PerformAsyncAction($(this), getSubmitCallback(options.makeDefaultAction), $('.indicator'));
			});

			$(this).find('.enableSubscription').click(function (e)
			{
				PerformAsyncAction($(this), getSubmitCallback(options.enableSubscriptionAction), $('.indicator'));
			});

			$(this).find('.disableSubscription').click(function (e)
			{
				PerformAsyncAction($(this), getSubmitCallback(options.disableSubscriptionAction), $('.indicator'));
			});

			$(this).find('.deleteScheduleButton').click(function (e)
			{
				showDeleteDialog(e);
				return false;
			});

			$(this).find('.adminButton').click(function (e)
			{
				showScheduleAdmin(e, $(this).attr('adminId'));
				return false;
			});

			$(this).find('.showAllDailyLayouts').click(function(e)
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

		ConfigureAdminForm(elements.renameForm, getSubmitCallback(options.renameAction));
		ConfigureAdminForm(elements.settingsForm, getSubmitCallback(options.changeSettingsAction));
		ConfigureAdminForm(elements.changeLayoutForm, getSubmitCallback(options.changeLayoutAction));
		ConfigureAdminForm(elements.addForm, getSubmitCallback(options.addAction), null, handleAddError);
		ConfigureAdminForm(elements.deleteForm, getSubmitCallback(options.deleteAction));
		ConfigureAdminForm(elements.groupAdminForm, getSubmitCallback(options.adminAction));
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

	var showRename = function (e)
	{
		elements.renameDialog.dialog("option", "position", [e.pageX, e.pageY]);
		elements.renameDialog.dialog("open");
	};

	var showChangeSettings = function (e, daysVisible, dayOfWeek)
	{
		elements.daysVisible.val(daysVisible.val());
		elements.dayOfWeek.val(dayOfWeek.val());

		elements.changeSettingsDialog.dialog("option", "position", [e.pageX, e.pageY]);
		elements.changeSettingsDialog.dialog("open");
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
		elements.usesSingleLayout.removeAttr('checked');

		if (usesSingleLayout)
		{
			elements.usesSingleLayout.attr('checked', 'checked');
		}
		elements.usesSingleLayout.trigger('change');

		elements.layoutDialog.dialog("open");
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

		elements.deleteDialog.dialog('open');
	};

	var showScheduleAdmin = function (e, adminGroupId)
	{
		$('#adminGroupId').val(adminGroupId);
		elements.groupAdminDialog.dialog("open");
	};

	var reformatTimeSlots = function (div)
	{
		var text = $.trim(div.text());
		text = text.replace(/\s\s+/g, ' ');
		text = text.replace(/\s*,\s*/g, '\n');
		return text;
	};
}