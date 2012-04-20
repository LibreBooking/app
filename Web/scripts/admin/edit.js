	
	function ConfigureAdminForm(formElement, urlCallback, successHandler, responseHandler, options)
	{
		var opts = $.extend(
				{
					dataType: null,
					onBeforeSubmit: BeforeFormSubmit,
					onBeforeSerialize: null,
					target: null
				}, options);

		formElement.submit(function() {
			
			var submitOptions = { 
				url: urlCallback(formElement),
		        beforeSubmit: opts.onBeforeSubmit,
		        beforeSerialize: opts.onBeforeSerialize,
				dataType: opts.dataType,
				target: opts.target,
		        success: function(responseText, statusText, xhr, form)  {

					formElement.find('.indicator').hide();
					formElement.find('button').show();
					
					if (responseHandler && (
							(responseText.trim != undefined && responseText.trim() != '') || (responseText.constructor == Object)
						)
					)
					{
						responseHandler(responseText, form);
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
	}
	
	function ConfigureUploadForm(buttonElement, urlCallback, preSubmitCallback, successHandler, responseHandler)
	{
		buttonElement.click(function() {
			
			if (preSubmitCallback && !preSubmitCallback())
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
	
	function ConfigureAdminDialog(dialogElement, dialogWidth, dialogHeight)
	{
		var dialogOpts = {
		        modal: true,
		        autoOpen: false,
		        height: dialogHeight,
		        width: dialogWidth
		    };
		        
		dialogElement.dialog(dialogOpts);
	}
	
	function PerformAsyncAction(element, urlCallback, indicator)
	{
		if (indicator) {
            element.after(indicator);
			indicator.show();
		}
		$.post(
			urlCallback(), 
			function(data) {
				if (data && (data.trim() != ""))
				{
					alert(data);
				}
				window.location.reload();
			}
		);
	}

	function ClearAsyncErrors(element)
	{
		element.find('.asyncValidation').hide();
	}

	function HtmlDecode(encoded)
	{
		return $('<textarea/>').html(encoded).val();
	}