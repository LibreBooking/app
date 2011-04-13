	
	function ConfigureAdminForm(formElement, urlCallback, successHandler, responseHandler)
	{
		formElement.submit(function() { 
			
			var submitOptions = { 
				url: urlCallback(),
		        beforeSubmit: BeforeFormSubmit,
		        success: function(responseText, statusText, xhr, form)  { 
					if (responseText.trim() != '' && responseHandler) 
					{
						$(form).find('.indicator').hide();
						responseHandler(responseText);
					}
					else
					{
						if (successHandler)
						{
							successHandler();
						}
						else
						{
							window.location = window.location;
						}
					}
		        }
			};
			
	        $(this).ajaxSubmit(submitOptions); 
	 		return false; 
	    });
	};
	
	function BeforeFormSubmit(formData, jqForm, opts)
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
	
	function ConfigureAdminDialog(dialogElement, dialogTitle, dialogWidth, dialogHeight)
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