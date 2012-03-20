function ScheduleManagement(opts)
{
	var options = opts;
	
	var elements = {
		activeId: $('#activeId'),
			
		renameDialog: $('#renameDialog'),
		layoutDialog: $('#changeLayoutDialog'),
		changeSettingsDialog: $('#changeSettingsDialog'),
		deleteDialog: $('#deleteDialog'),

		renameForm: $('#renameForm'),
		settingsForm: $('#settingsForm'),
		changeLayoutForm: $('#changeLayoutForm'),
        placeholderForm: $('#placeholderForm'),
		deleteForm: $('#deleteForm'),

		addForm: $('#addScheduleForm'),
		
		reservableEdit: $('#reservableEdit'),
		blockedEdit: $('#blockedEdit'),
		layoutTimezone: $('#layoutTimezone'),
		quickLayoutConfig: $('#quickLayoutConfig'),
		quickLayoutStart: $('#quickLayoutStart'),
		quickLayoutEnd: $('#quickLayoutEnd'),
		
		daysVisible: $('#daysVisible'),
		dayOfWeek: $('#dayOfWeek'),
		deleteDestinationScheduleId: $('#targetScheduleId')
	};
	
	ScheduleManagement.prototype.init = function()
	{
		ConfigureAdminDialog(elements.renameDialog, 300, 125);
		ConfigureAdminDialog(elements.changeSettingsDialog, 300, 140);
		ConfigureAdminDialog(elements.layoutDialog, 730, 550);
		ConfigureAdminDialog(elements.deleteDialog, 430, 200);

		$('.scheduleDetails').each(function() {
			var id = $(this).find(':hidden.id').val();
			var reservable = $(this).find('.reservableSlots');
			var blocked = $(this).find('.blockedSlots');
			var timezone = $(this).find('.timezone');
			var daysVisible = $(this).find('.daysVisible');
			var dayOfWeek = $(this).find('.dayOfWeek');
			
			$(this).find('a.update').click(function() {
				setActiveScheduleId(id);				
			});
			
			$(this).find('.renameButton').click(function(e) {
				showRename(e);
				return false;
			});
			
			$(this).find('.changeButton').click(function(e) {
				showChangeSettings(e, daysVisible, dayOfWeek);
				return false;
			});
			
			$(this).find('.changeLayoutButton').click(function(e) {
				showChangeLayout(e, reservable, blocked, timezone);
				return false;
			});
			
			$(this).find('.makeDefaultButton').click(function(e) {
                PerformAsyncAction($(this), getSubmitCallback(options.makeDefaultAction), $('.indicator'));
//                elements.placeholderForm.submit();
//				$(this).after($('.indicator'));
			});

            $(this).find('.enableSubscription').click(function(e) {
                PerformAsyncAction($(this), getSubmitCallback(options.enableSubscriptionAction), $('.indicator'));
			});

            $(this).find('.disableSubscription').click(function(e) {
                PerformAsyncAction($(this), getSubmitCallback(options.disableSubscriptionAction), $('.indicator'));
			});

            $(this).find('.deleteScheduleButton').click(function(e) {
                showDeleteDialog(e);
                return false;
            });
		});

		$(".save").click(function() {
			$(this).closest('form').submit();
		});
		
		$(".cancel").click(function() {
			$(this).closest('.dialog').dialog("close");
		});

		elements.quickLayoutConfig.change(function() {
			createQuickLayout();
		});

		elements.quickLayoutStart.change(function() {
			createQuickLayout();
		});

		elements.quickLayoutEnd.change(function() {
			createQuickLayout();
		});

		var handleLayoutUpdate = function(response) {
			$('.asyncValidation').hide();
			$.each(response.ErrorIds, function(index, errorId) {
				$('#' + errorId).show();
			});
		};

		ConfigureAdminForm(elements.renameForm, getSubmitCallback(options.renameAction));
		ConfigureAdminForm(elements.settingsForm, getSubmitCallback(options.changeSettingsAction));
		ConfigureAdminForm(elements.changeLayoutForm, getSubmitCallback(options.changeLayoutAction), null, handleLayoutUpdate);
		ConfigureAdminForm(elements.addForm, getSubmitCallback(options.addAction), null, handleAddError);
		//ConfigureAdminForm(elements.placeholderForm, getSubmitCallback(options.makeDefaultAction));
		ConfigureAdminForm(elements.deleteForm, getSubmitCallback(options.deleteAction));
	};

	var getSubmitCallback = function(action) {
		return function() {
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

			var intervalMilliseconds =  60 * 1000 * intervalMinutes;
			while (currentTime.getTime() < endDateTime.getTime())
			{
				nextTime.setTime(nextTime.getTime() + intervalMilliseconds);

				layout += getFormattedTime(currentTime) + ' - ';
				layout += getFormattedTime(nextTime) + '\n';

				currentTime.setTime(currentTime.getTime() + intervalMilliseconds);
			}
			
			elements.reservableEdit.val(layout);
			elements.blockedEdit.val(blocked);
		}
	};

	var getFormattedTime = function(date)
	{
		var hour = date.getHours() < 10 ? "0" + date.getHours() : date.getHours();
		var minute = date.getMinutes()< 10 ? "0" + date.getMinutes() : date.getMinutes();
		return hour + ":" + minute;
	};

	var handleAddError = function(responseText)
	{
		$('#addScheduleResults').text(responseText);
		$('#addScheduleResults').show();
	};
	
	var setActiveScheduleId = function(scheduleId)
	{
		elements.activeId.val(scheduleId);
	};

    var getActiveScheduleId = function()
    {
        return elements.activeId.val();
    };
	
	var showRename = function(e)
	{
		elements.renameDialog.dialog("option", "position", [e.pageX, e.pageY]);
		elements.renameDialog.dialog("open");
	};
	
	var showChangeSettings = function(e, daysVisible, dayOfWeek)
	{
		elements.daysVisible.val(daysVisible.val());
		elements.dayOfWeek.val(dayOfWeek.val());
		
		elements.changeSettingsDialog.dialog("option", "position", [e.pageX, e.pageY]);
		elements.changeSettingsDialog.dialog("open");
	};
	
	var showChangeLayout = function(e, reservableDiv, blockedDiv, timezone)
	{
		var reservable = reformatTimeSlots(reservableDiv);
		var blocked = reformatTimeSlots(blockedDiv);
		
		elements.reservableEdit.val(reservable);
		elements.blockedEdit.val(blocked);
		elements.layoutTimezone.val(timezone.val());
		
		elements.layoutDialog.dialog("open");
	};

    var showDeleteDialog = function(e)
    {
        var scheduleId = getActiveScheduleId();
		elements.deleteDestinationScheduleId.children().removeAttr('disabled');
		elements.deleteDestinationScheduleId.children('option[value="' + scheduleId + '"]').attr('disabled','disabled');
		elements.deleteDestinationScheduleId.val('');

        elements.deleteDialog.dialog('open');
    };
	
	var reformatTimeSlots = function(div) {
		var text = $.trim(div.text());
		text = text.replace(/\s\s+/g, ' ');
		text = text.replace(/\s*,\s*/g, '\n');
		return text;
	};
}