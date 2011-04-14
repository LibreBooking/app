	
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
	
	function ConfigureUploadForm(buttonElement, urlCallback, preSubmitCallback, successHandler, responseHandler)
	{
		buttonElement.click(function() {
			
			if (preSubmitCallback && preSubmitCallback() == false)
			{
				return false;
			}
			
			var form = buttonElement.parent('form');
			var uploadElementId = form.find('input:file').attr('id');
						
			$.ajaxFileUpload
			(
				{
					url: urlCallback(), 
					secureuri: false,
					fileElementId: uploadElementId,
					success: function (responseText, status)
					{
						if (responseText.trim() != '' && responseHandler) 
						{
							form.find('.indicator').hide();
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
					},
					error: function (data, status, e)
					{
						alert(e);
					}
				}
			);
			
			return false;
		});
	}
	
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