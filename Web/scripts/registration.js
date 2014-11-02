function Registration()
{
	var elements = {
		form:$('#frmRegister')
	};

	Registration.prototype.init = function ()
	{

		$("#btnUpdate").click(function (e)
		{
			e.preventDefault();
			$('#frmRegister').submit();
		});

		elements.form.bind('onValidationFailed', onValidationFailed);

		ConfigureAdminForm(elements.form, defaultSubmitCallback, successHandler, null, {onBeforeSubmit:onBeforeAddSubmit});
	};

	var defaultSubmitCallback = function (form)
	{
		return form.attr('action') + "?action=" + form.attr('ajaxAction');
	};

	function onValidationFailed(event, data)
	{
		refreshCaptcha();
		hideModal();
	}

	function successHandler(response)
	{
		if (response && response.url)
		{
			window.location = response.url;
		}
		else
		{
			onValidationFailed();
			$('#registrationError').show();
		}
	}

	function onBeforeAddSubmit(formData, jqForm, opts)
	{
		$('#profileUpdatedMessage').hide();
		$('#registrationError').hide();

		$.blockUI({ message: $('#modalDiv') });

		return true;
	}

	function hideModal()
	{
		$.unblockUI();

		var top = $("#registrationbox").scrollTop();
		$('html, body').animate({scrollTop:top}, 'slow');
	}

	function refreshCaptcha()
	{
		var captchaImg = $('#captchaImg');
		if (captchaImg.length > 0)
		{
			var src = captchaImg.attr('src') + '?' + Math.random();
			captchaImg.attr('src', src);
			$('#captchaValue').val('');
		}
		else if(typeof Recaptcha != "undefined")
		{
			Recaptcha.reload();
		}
	}
}