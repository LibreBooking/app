function Registration()
{
	var elements = {
		profileForm: $('#frmRegister')
	};

	Registration.prototype.init = function () {

		$("#btnUpdate").click(function (e) {
			e.preventDefault();
			$('#frmRegister').submit();
		});

		elements.profileForm.bind('onValidationFailed', onValidationFailed);

		ConfigureAdminForm(elements.profileForm, defaultSubmitCallback, successHandler, null, {onBeforeSubmit: onBeforeAddSubmit});
	};

	var defaultSubmitCallback = function (form) {
		return form.attr('action') + "?action=" + form.attr('ajaxAction');
	};

	function onValidationFailed(event, data)
	{
		refreshCaptcha(data);
		hideModal();
	}

	function successHandler(response)
	{
		window.location = response.url;
	}

	function onBeforeAddSubmit(formData, jqForm, opts)
	{
		$('#profileUpdatedMessage').hide();

		$.colorbox({inline:true, href:"#modalDiv", transition:"none", width:"75%", height:"75%", overlayClose: false});
		$('#modalDiv').show();

		return true;
	}

	function hideModal()
	{
		$('#modalDiv').hide();
		$.colorbox.close();

		var top = $("#registrationbox").scrollTop();
		$('html, body').animate({scrollTop:top}, 'slow');
	}

	function refreshCaptcha(response) {
		var src = $('#captchaImg').attr('src') + '?' + Math.random();
		$('#captchaImg').attr('src', src);
		$('#captchaValue').val('');
	}

}