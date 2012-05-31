function Profile(options) {
	var elements = {
		profileForm: $('#frmRegister')
	};

	var opts = $.extend(
					{
						handleValidationFailed: handleValidationFailed,
						handleUpdateSuccess: handleUpdateSuccess
					}, options);

	Profile.prototype.init = function () {

		$("#btnUpdate").click(function (e) {
			e.preventDefault();
			$('#frmRegister').submit();
		});

		elements.profileForm.bind('onAfterSuccess', onUpdateSuccess);
		elements.profileForm.bind('onValidationFailed', onValidationFailed);

		ConfigureAdminForm(elements.profileForm, defaultSubmitCallback, successHandler, null, {onBeforeSubmit: onBeforeAddSubmit});
	};

	var defaultSubmitCallback = function (form) {
		return form.attr('action') + "?action=" + form.attr('ajaxAction');
	};

	function handleUpdateSuccess(response)
	{
		hideModal();
		$('#profileUpdatedMessage').show();
	}

	function handleValidationFailed(response)
	{
		// hook method
	}

	function onValidationFailed(event)
	{
		opts.handleValidationFailed(event.data)
	}

	function onUpdateSuccess(event)
	{
		opts.handleUpdateSuccess(event.data)
	}

	function onBeforeAddSubmit(formData, jqForm, opts)
	{
		$('#profileUpdatedMessage').hide();

		$.colorbox({inline:true, href:"#modalDiv", transition:"none", width:"75%", height:"75%", overlayClose: false});
		$('#modalDiv').show();

		return true;
	}

	function successHandler()
	{
		// no op
	}

	function hideModal()
	{
		$('#modalDiv').hide();
		$.colorbox.close();

		var top = $("#registrationbox").scrollTop();
		$('html, body').animate({scrollTop:top}, 'slow');
	}

}