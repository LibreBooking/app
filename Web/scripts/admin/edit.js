	
	function ConfigureAdminForm(formElement, urlCallback, successHandler, responseHandler)
	{
		formElement.submit(function() { 
			
			var submitOptions = { 
				url: urlCallback(),
		        beforeSubmit: BeforeFormSubmit,
		        success: function(responseText, statusText, xhr, form)  {

					formElement.find('.indicator').hide();
					formElement.find('button').show();
					
					if (responseText.trim() != '' && responseHandler) 
					{
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
							window.location.reload();
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
						form.find('.indicator').hide();
						form.find('button').show();

						if (responseText.trim() != '' && responseHandler)
						{
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
								window.location.reload();
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
	
	function PerformAsyncAction(element, urlCallback, indicator)
	{
		if (indicator) {
			indicator.show();
		}
		$.post(
			urlCallback(), 
			function(data) {
				if (data.trim() != "")
				{
					alert(data);
				}
				window.location.reload();
			}
		);
	};