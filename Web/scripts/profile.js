function Profile() {
	var elements = {
		form: $('#form-profile')
	};

	Profile.prototype.init = function () {

		$("#btnUpdate").click(function (e) {
			e.preventDefault();
			elements.form.submit();
		});

		elements.form.bind('onValidationFailed', onValidationFailed);

		ConfigureAsyncForm(elements.form, defaultSubmitCallback, successHandler, null, {onBeforeSubmit: onBeforeSubmit});
	};

	var defaultSubmitCallback = function (form) {
		return form.attr('action') + "?action=" + form.attr('ajaxAction');
	};

	function onValidationFailed(event, data)
	{
		elements.form.find('button').removeAttr('disabled');
		hideModal();
		$('#validationErrors').removeClass('hidden');
	}

	function successHandler(response)
	{
		hideModal();
		$('#profileUpdatedMessage').removeClass('hidden');
	}

	function onBeforeSubmit(formData, jqForm, opts)
	{
		var bv = jqForm.data('bootstrapValidator');

		if (!bv.isValid() && bv.$invalidFields.length > 0)
		{
			return false;
		}

		$('#profileUpdatedMessage').addClass('hidden');

		$.blockUI({ message: $('#wait-box') });

		return true;
	}

	function hideModal()
	{
		$.unblockUI();

		var top = $("#profile-box").scrollTop();
		$('html, body').animate({scrollTop:top}, 'slow');
	}

}