function ScheduleManagement(opts)
{
	var options = opts;
	
	var elements = {
		renameButton: $('.renameButton'),
		renameDialog: $('#renameDialog'),
		renameForm: $('#renameForm'),
		activeId: $('#activeId'),
		addForm: $('#addScheduleForm'),
		reservableEdit: $('#reservableEdit'),
		blockedEdit: $('#blockedEdit'),
		layoutDialog: $('#changeLayoutDialog'),
		changeLayoutForm: $('#changeLayoutForm')
	};
	
	ScheduleManagement.prototype.init = function()
	{
		ConfigureRenameDialog();
		ConfigureLayoutDialog();
		    
		$('.scheduleDetails').each(function() {
			var id = $(this).find(':hidden.id').val();
			var reservable = $(this).find('.reservableSlots');
			var blocked = $(this).find('.blockedSlots');
			
			$(this).find('a.update').click(function() {
				setActiveScheduleId(id);				
			});
			
			$(this).find('.renameButton').click(function(e) {
				showRename(e);
				return false;
			});
			
			$(this).find('.changeLayoutButton').click(function(e) {
				showChangeLayout(e, reservable, blocked);
				return false;
			});
		});

		$(".save").click(function() {
			$(this).closest('form').submit();
		});
		
		$(".cancel").click(function() {
			$(this).closest('.dialog').dialog("close");
		});
		
		ConfigureForm(elements.renameForm,  options.renameAction);
		ConfigureForm(elements.addForm, options.addAction);
		ConfigureForm(elements.changeLayoutForm, options.changeLayoutAction, showLayoutResults);
	};

	var showLayoutResults = function(responseText)
	{
		$('#layoutResults').text(responseText);
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
	
	var showChangeLayout = function(e, reservableDiv, blockedDiv)
	{
		var reservable = reformatTimeSlots(reservableDiv);
		var blocked = reformatTimeSlots(blockedDiv);
		
		elements.reservableEdit.val(reservable);
		elements.blockedEdit.val(blocked);
		
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
	
	var ConfigureRenameDialog = function()
	{
		var renameDialogOpts = {
				title: 'Rename Schedule',
		        modal: true,
		        autoOpen: false,
		        height: 125,
		        width: 300
		    };
		        
		elements.renameDialog.dialog(renameDialogOpts);
	};
	
	var ConfigureLayoutDialog = function()
	{
		var layoutDialogOpts = {
				title: 'Change Layout',
		        modal: true,
		        autoOpen: false,
		        height: 510,
		        width: 700
		    };
		        
		elements.layoutDialog.dialog(layoutDialogOpts);
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