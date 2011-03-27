function ScheduleManagement(opts)
{
	var options = opts;
	
	var elements = {
		renameButton: $('.renameButton'),
		renameDialog: $('#renameDialog'),
		renameForm: $('#renameForm'),
		activeId: $('#activeId'),
		addForm: $('#addScheduleForm')
	};
	
	ScheduleManagement.prototype.init = function()
	{
		ConfigureRenameDialog();
		    
		elements.renameButton.click(function(e) {
			elements.renameDialog.dialog("option", "position", [e.pageX, e.pageY]);
			elements.renameDialog.dialog("open");
			return false;
		});

		$(".save").click(function() {
			$(this).closest('form').submit();
		});
		
		$(".cancel").click(function() {
			$(this).closest('.dialog').dialog("close");
		});
		
		$("a.update").click(function() {
			elements.activeId.val($(this).siblings(':hidden.id').val());
		});
		
		ConfigureForm(elements.renameForm,  options.renameAction);
		ConfigureForm(elements.addForm, options.renameAction);
	}

	
	var ConfigureForm = function(formElement, updateAction)
	{
		formElement.submit(function() { 
			
			var submitOptions = { 
				url: options.submitUrl + "?sid=" + elements.activeId.val() + "&action=" + updateAction,
		        //target: '#result',
		        beforeSubmit: CheckRequiredFields,
		        success: function(responseText, statusText, xhr, $form)  { 
		        	window.location = options.saveRedirect;
		        }
			};
			
	        $(this).ajaxSubmit(submitOptions); 
	 		return false; 
	    });
	}
	
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
	}
	
	
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