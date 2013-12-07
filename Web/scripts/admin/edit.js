function HasResponseText(responseText)
{
	return (
			(responseText.trim != undefined && responseText.trim() != '') || (responseText.constructor == Object && responseText.ErrorIds != undefined)
			);
}
function ConfigureAdminForm(formElement, urlCallback, successHandler, responseHandler, options)
{
	var opts = $.extend(
			{
				dataType: null,
				onBeforeSubmit: BeforeFormSubmit,
				onBeforeSerialize: null,
				target: null,
				validationSummary:$('.validationSummary')
			}, options);

	formElement.submit(function ()
	{
		var submitOptions = {
			url: urlCallback(formElement),
			beforeSubmit: opts.onBeforeSubmit,
			beforeSerialize: opts.onBeforeSerialize,
			dataType: opts.dataType,
			target: opts.target,
			success: function (responseText, statusText, xhr, form)
			{
				formElement.find('.indicator').hide();
				formElement.find('button').show();

				var validationSummary = opts.validationSummary;
				var hasValidationSummary = validationSummary && validationSummary.length > 0;
				var hasResponseText = HasResponseText(responseText);

				if (hasValidationSummary)
				{
					validationSummary.hide();
				}
				if (responseHandler && hasResponseText)
				{
					responseHandler(responseText, form);
				}
				else if (hasValidationSummary && hasResponseText)
				{
					$('.asyncValidation').hide();
					$.each(responseText.ErrorIds, function (index, errorId)
					{
						var errorElement = $('#' + errorId);
						if (responseText.Messages[errorId].length > 0)
						{
							errorElement.text("" + responseText.Messages[errorId].join(' '));
						}
						errorElement.show();
					});

					if (responseText.ErrorIds.length > 0)
					{
						validationSummary.show();
						formElement.trigger('onValidationFailed', responseText);
					}
				}
				else
				{
					if (successHandler)
					{
						successHandler(responseText);
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
	buttonElement.click(function ()
	{

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
	$(jqForm).find('.required').each(function ()
	{
		if ($(this).is(':visible') && $(this).val() == '')
		{
			isValid = false;
			if ($(this).next('span.error').length == 0)
			{
				$(this).after('<span class="error">*</span>');
			}
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
	if (!dialogWidth)
	{
		dialogWidth = 'auto';
	}

	if (!dialogHeight)
	{
		dialogHeight = 'auto';
	}

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
	if (indicator)
	{
		element.after(indicator);
		indicator.show();
	}
	$.post(
			urlCallback(),
			function (data)
			{
				if (data && (data.trim() != ""))
				{
					alert(data);
				}
				window.location.reload();
			}
	);
}

function PerformAsyncPost(url, options)
{
	var opts = $.extend({
		done: function (data)
		{
			window.location.reload();
		},
		fail: function (data)
		{

		},
		always: function (data)
		{

		},
		data: {}
	}, options);
	if (opts.indicator)
	{
		opts.element.after(opts.indicator);
		opts.indicator.show();
	}
	$.post(url, opts.data)
			.done(
			function (data)
			{
				opts.done(data);
			})
			.fail(function (data)
			{
				opts.fail(data);
			})
			.always(function (data)
			{
				opts.always(data);
			});
}

function ClearAsyncErrors(element)
{
	element.find('.asyncValidation').hide();
}

function HtmlDecode(encoded)
{
	return $('<textarea/>').html(encoded).val();
}