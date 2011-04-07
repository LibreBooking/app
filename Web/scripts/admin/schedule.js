function ScheduleManagement(opts)
{
	var options = opts;
	
	var elements = {
		activeId: $('#activeId'),
			
		renameDialog: $('#renameDialog'),
		layoutDialog: $('#changeLayoutDialog'),
		changeSettingsDialog: $('#changeSettingsDialog'),
		
		renameForm: $('#renameForm'),
		settingsForm: $('#settingsForm'),
		changeLayoutForm: $('#changeLayoutForm'),
		makeDefaultForm: $('#makeDefaultForm'),
		
		addForm: $('#addScheduleForm'),
		
		reservableEdit: $('#reservableEdit'),
		blockedEdit: $('#blockedEdit'),
		layoutTimezone: $('#layoutTimezone'),
		
		daysVisible: $('#daysVisible'),
		dayOfWeek: $('#dayOfWeek')
	};
	
	ScheduleManagement.prototype.init = function()
	{
		ConfigureDialog(elements.renameDialog, 'Rename Schedule', 300, 125);
		ConfigureDialog(elements.changeSettingsDialog, 'Change Schedule Settings', 300, 140);
		ConfigureDialog(elements.layoutDialog, 'Change Layout', 700, 510);
		    
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
				elements.makeDefaultForm.submit();
				$(this).after($('.indicator'));
			});
		});

		$(".save").click(function() {
			$(this).closest('form').submit();
		});
		
		$(".cancel").click(function() {
			$(this).closest('.dialog').dialog("close");
		});
		

		ConfigureForm(elements.renameForm, options.renameAction);
		ConfigureForm(elements.settingsForm, options.changeSettingsAction);
		ConfigureForm(elements.changeLayoutForm, options.changeLayoutAction, showLayoutResults);
		ConfigureForm(elements.addForm, options.addAction, handleAddError);
		ConfigureForm(elements.makeDefaultForm, options.makeDefaultAction, function(text){alert(text);});
	};

	var showLayoutResults = function(responseText)
	{
		$('#layoutResults').text(responseText);
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
	
	var reformatTimeSlots = function(div) {
		var text = div.text().trim();
		text = text.replace(/\s\s+/g, ' ');
		text = text.replace(/\s*,\s*/g, '\n');
		return text;
	};
	
	var ConfigureForm = function(formElement, updateAction, responseHandler)
	{
		formElement.submit(function() { 
			
			var submitOptions = { 
				url: options.submitUrl + "?sid=" + elements.activeId.val() + "&action=" + updateAction,
		        //target: '#result',
		        beforeSubmit: CheckRequiredFields,
		        success: function(responseText, statusText, xhr, form)  { 
					if (responseText.trim() != '' && responseHandler) 
					{
						$(form).find('.indicator').hide();
						responseHandler(responseText);
					}
					else
					{
						window.location = options.saveRedirect;
					}
		        }
			};
			
	        $(this).ajaxSubmit(submitOptions); 
	 		return false; 
	    });
	};
	
	var ConfigureDialog = function(dialogElement, dialogTitle, dialogWidth, dialogHeight)
	{
		var dialogOpts = {
				title: dialogTitle,
		        modal: true,
		        autoOpen: false,
		        height: dialogHeight,
		        width: dialogWidth
		    };
		        
		dialogElement.dialog(dialogOpts);
	};
	
	function CheckRequiredFields(formData, jqForm, options)
	{
		var isValid = true;
		$(jqForm).find('.required').each(function(){
			if ($(this).val() == '')
			{
				isValid = false;
				$(this).after('<span class="error">*</span>');
			}
		});
		
		if (isValid)
		{
			$(jqForm).find('button').hide();
			$(jqForm).append($('.indicator'));
			$(jqForm).find('.indicator').show();
		}
		
		return isValid;
	}
}