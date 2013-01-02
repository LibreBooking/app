function Profile() {
	var elements = {
		form: $('#frmRegister')
	};

	Profile.prototype.init = function () {

		$("#btnUpdate").click(function (e) {
			e.preventDefault();
			$('#frmRegister').submit();
		});

		elements.form.bind('onValidationFailed', onValidationFailed);

		ConfigureAdminForm(elements.form, defaultSubmitCallback, successHandler, null, {onBeforeSubmit: onBeforeAddSubmit});
	};

	var defaultSubmitCallback = function (form) {
		return form.attr('action') + "?action=" + form.attr('ajaxAction');
	};

	function onValidationFailed(event, data)
	{
		hideModal();
	}

	function successHandler(response)
	{
		hideModal();
		$('#profileUpdatedMessage').show();
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

}