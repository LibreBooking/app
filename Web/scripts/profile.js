function Profile() {
	var elements = {
		editForm: $('#frmRegister')
	};

	Profile.prototype.init = function () {

		$("#btnUpdate").click(function (e) {
			e.preventDefault();
			$('#frmRegister').submit();
		});

		$('#frmRegister').bind('onAfterSuccess', hideModal);

		ConfigureAdminForm(elements.editForm, defaultSubmitCallback, onUpdateSuccess, null, {onBeforeSubmit: onBeforeAddSubmit});
	};

	var defaultSubmitCallback = function (form) {
		return form.attr('action') + "?action=" + form.attr('ajaxAction');
	};

	function onUpdateSuccess()
	{
		hideModal();
		$('#profileUpdatedMessage').show();
	}

	function onBeforeAddSubmit(formData, jqForm, opts)
	{
		$('#profileUpdatedMessage').hide();

		$.colorbox({inline:true, href:"#createDiv", transition:"none", width:"75%", height:"75%", overlayClose: false});
		$('#creating, #createDiv').show();

		return true;
	}

	function hideModal()
	{
		$('#creating, #createDiv').hide();
		$.colorbox.close();

		var top = $("#registrationbox").scrollTop();
		$('html, body').animate({scrollTop:top}, 'slow');
	}

}