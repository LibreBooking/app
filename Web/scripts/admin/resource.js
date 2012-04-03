function ResourceManagement(opts)
{
	var options = opts;
	
	var elements = {
		activeId: $('#activeId'),
			
		renameDialog: $('#renameDialog'),
		imageDialog: $('#imageDialog'),
		scheduleDialog: $('#scheduleDialog'),
		locationDialog: $('#locationDialog'),
		descriptionDialog: $('#descriptionDialog'),
		notesDialog: $('#notesDialog'),
		deleteDialog: $('#deleteDialog'),
		configurationDialog: $('#configurationDialog'),
		groupAdminDialog: $('#groupAdminDialog'),
		
		renameForm: $('#renameForm'),
		imageForm: $('#imageForm'),
		scheduleForm: $('#scheduleForm'),
		locationForm: $('#locationForm'),
		descriptionForm: $('#descriptionForm'),
		notesForm: $('#notesForm'),
		deleteForm: $('#deleteForm'),
		configurationForm: $('#configurationForm'),
		groupAdminForm: $('#groupAdminForm'),

		addForm: $('#addResourceForm')
	};
	
	var resources = new Object();
	
	ResourceManagement.prototype.init = function()
	{
		$(".days").watermark('days');
		$(".hours").watermark('hrs');
		$(".minutes").watermark('mins');

		ConfigureAdminDialog(elements.renameDialog, 300, 135);
		ConfigureAdminDialog(elements.imageDialog, 500, 150);
		ConfigureAdminDialog(elements.scheduleDialog, 300, 125);
		ConfigureAdminDialog(elements.locationDialog, 300, 170);
		ConfigureAdminDialog(elements.descriptionDialog, 500, 270);
		ConfigureAdminDialog(elements.notesDialog, 500, 270);
		ConfigureAdminDialog(elements.deleteDialog, 500, 300);
		ConfigureAdminDialog(elements.configurationDialog, 500, 500);
		ConfigureAdminDialog(elements.groupAdminDialog, 300, 125);

		$('.resourceDetails').each(function() {
			var id = $(this).find(':hidden.id').val();
			var indicator = $('.indicator');
			
			$(this).find('a.update').click(function() {
				setActiveResourceId(id);				
			});
			
			$(this).find('.imageButton').click(function(e) {
				showChangeImage(e);
				return false;
			});
			
			$(this).find('.removeImageButton').click(function(e) {
				PerformAsyncAction($(this), getSubmitCallback(options.actions.removeImage), indicator);
				return false;
			});
			
			$(this).find('.takeOfflineButton').click(function(e) {
				PerformAsyncAction($(this), getSubmitCallback(options.actions.takeOffline), indicator);
				return false;
			});
			
			$(this).find('.bringOnlineButton').click(function(e) {
				PerformAsyncAction($(this), getSubmitCallback(options.actions.bringOnline), indicator);
				return false;
			});

            $(this).find('.enableSubscription').click(function(e) {
                PerformAsyncAction($(this), getSubmitCallback(options.actions.enableSubscription), indicator);
                return false;
            });

            $(this).find('.disableSubscription').click(function(e) {
                PerformAsyncAction($(this), getSubmitCallback(options.actions.disableSubscription), indicator);
                return false;
            });
			
			$(this).find('.renameButton').click(function(e) {
				showRename(e);
				return false;
			});
			
			$(this).find('.changeScheduleButton').click(function(e) {
				showScheduleMove(e);
				return false;
			});
			
			$(this).find('.changeLocationButton').click(function(e) {
				showChangeLocation(e);
				return false;
			});
			
			$(this).find('.descriptionButton').click(function(e) {
				showChangeDescription(e);
				return false;
			});
			
			$(this).find('.notesButton').click(function(e) {
				showChangeNotes(e);
				return false;
			});

			$(this).find('.adminButton').click(function(e) {
				showResourceAdmin(e);
				return false;
			});
			
			$(this).find('.deleteButton').click(function(e) {
				showDeletePrompt(e);
				return false;
			});
			
			$(this).find('.changeConfigurationButton').click(function(e) {
				showConfigurationPrompt(e);
				return false;
			});
		});

		$(".save").click(function() {
			$(this).closest('form').submit();
		});
		
		$(".cancel").click(function() {
			$(this).closest('.dialog').dialog("close");
		});

		var imageSaveErrorHandler = function(result) { alert(result); };
		var imageSavePreSubmit = function() { showIndicator(elements.imageForm); return true; };
		var combineIntervals = function(form, options)
		{
			$('.interval', form).each(function() {
				var id = $(this).attr('id');
				var d = $('#' + id + 'Days').val();
				var h = $('#' + id + 'Hours').val();
				var m = $('#' + id + 'Minutes').val();
				$(this).val(d + 'd' + h + 'h' + m + 'm');
			});
		};
		
		var errorHandler = function(result) { $("#globalError").html(result).show(); };
		ConfigureUploadForm(elements.imageForm.find('.uploadImage'), getSubmitCallback(options.actions.changeImage), imageSavePreSubmit, null, imageSaveErrorHandler);
		ConfigureAdminForm(elements.renameForm, getSubmitCallback(options.actions.rename), null, errorHandler);
		ConfigureAdminForm(elements.scheduleForm, getSubmitCallback(options.actions.changeSchedule));
		ConfigureAdminForm(elements.locationForm, getSubmitCallback(options.actions.changeLocation));
		ConfigureAdminForm(elements.descriptionForm, getSubmitCallback(options.actions.changeDescription));
		ConfigureAdminForm(elements.notesForm, getSubmitCallback(options.actions.changeNotes));
		ConfigureAdminForm(elements.addForm, getSubmitCallback(options.actions.add), null, handleAddError);
		ConfigureAdminForm(elements.deleteForm, getSubmitCallback(options.actions.deleteResource));
		ConfigureAdminForm(elements.configurationForm, getSubmitCallback(options.actions.changeConfiguration), null, errorHandler, {onBeforeSerialize: combineIntervals});
		ConfigureAdminForm(elements.groupAdminForm, getSubmitCallback(options.actions.changeAdmin));

	};

	ResourceManagement.prototype.add = function(resource)
	{
		resources[resource.id] = resource;
	};
	
	var getSubmitCallback = function(action)
	{
		return function() {
			return options.submitUrl + "?rid=" + getActiveResourceId() + "&action=" + action;
		};
	};
	
	var setActiveResourceId = function(scheduleId)
	{
		elements.activeId.val(scheduleId);
	};
	
	var getActiveResourceId = function()
	{
		return elements.activeId.val();
	};
	
	var getActiveResource = function() 
	{
		return resources[getActiveResourceId()];
	};
	
	var showChangeImage = function(e)
	{
		elements.imageDialog.dialog("open");
	};
	
	var showRename = function(e)
	{
		$('#editName').val(getActiveResource().name);
		elements.renameDialog.dialog("open");
	};
	
	var showScheduleMove = function(e)
	{
		$('#editSchedule').val(getActiveResource().scheduleId);
		elements.scheduleDialog.dialog("open");
	};
	
	var showChangeLocation = function(e)
	{
		$('#editLocation').val(getActiveResource().location);
		$('#editContact').val(getActiveResource().contact);
		elements.locationDialog.dialog("open");
	};
	
	var showChangeDescription = function(e)
	{
		$('#editDescription').val(HtmlDecode(getActiveResource().description));
		elements.descriptionDialog.dialog("open");
	};
	
	var showChangeNotes = function(e)
	{
		$('#editNotes').val(HtmlDecode(getActiveResource().notes));
		elements.notesDialog.dialog("open");
	};

	var showResourceAdmin = function(e)
	{
		$('#adminGroupId').val(getActiveResource().adminGroupId);
		elements.groupAdminDialog.dialog("open");
	};

	var showDeletePrompt = function(e)
	{
		elements.deleteDialog.dialog("open");
	};
	
	var showConfigurationPrompt = function(e)
	{
		elements.configurationDialog.find(':checkbox').change(function () {
			var id = $(this).attr('id');
			var span = elements.configurationDialog.find('.' + id);
			
			if ($(this).is(":checked"))
			{
				span.find(":text").val('');
				span.hide();
			}
			else
			{
				span.show();
			}
		});
		
		var resource = getActiveResource();

		setDaysHoursMinutes('#minDuration', resource.minLength, $('#noMinimumDuration'));
		setDaysHoursMinutes('#maxDuration', resource.maxLength, $('#noMaximumDuration'));
		setDaysHoursMinutes('#startNotice', resource.startNotice, $('#noStartNotice'));
		setDaysHoursMinutes('#endNotice', resource.endNotice, $('#noEndNotice'));
		showHideConfiguration(resource.maxParticipants, $('#maxCapactiy'), $('#unlimitedCapactiy'));
		
		$('#allowMultiday').val(resource.allowMultiday);
		$('#requiresApproval').val(resource.requiresApproval);
		$('#autoAssign').val(resource.autoAssign);
		
		elements.configurationDialog.dialog("open");
	};

	function setDaysHoursMinutes(elementPrefix, interval, attributeCheckbox)
	{
		$(elementPrefix + 'Days').val(interval.days);
		$(elementPrefix + 'Hours').val(interval.hours);
		$(elementPrefix + 'Minutes').val(interval.minutes);
		showHideConfiguration(interval.value, $(elementPrefix), attributeCheckbox);
	}

	function showHideConfiguration(attributeValue, attributeDisplayElement, attributeCheckbox)
	{
		attributeDisplayElement.val(attributeValue);
		var id = attributeCheckbox.attr('id');
		var span = elements.configurationDialog.find('.' + id);
		
		if (attributeValue == '' || attributeValue == undefined)
		{
			attributeCheckbox.attr('checked', true);
			span.hide();
		}
		else
		{
			attributeCheckbox.attr('checked', false);
			span.show();
		}
	}
	
	var showIndicator = function(formElement)
	{
		formElement.find('button').hide();
		formElement.append($('.indicator'));
		formElement.find('.indicator').show();
	};
	
	var handleAddError = function(result)
	{
		$('#addResourceResults').text(result).show();
	};
}