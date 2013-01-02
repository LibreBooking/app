function Configuration() {
	var elements = {
		form: $('form')
	};

	Configuration.prototype.init = function () {

		$(".save").click(function (e) {
			e.preventDefault();
			elements.form.submit();
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
		$('#updatedMessage').show().delay('3000').fadeOut('slow');
	}

	function onBeforeAddSubmit(formData, jqForm, opts)
	{
		$('#updatedMessage').hide();

		$.colorbox({inline:true, href:"#modalDiv", transition:"none", width:"75%", height:"75%", overlayClose: false});
		$('#modalDiv').show();

		return true;
	}

	function hideModal()
	{
		$('#modalDiv').hide();
		$.colorbox.close();

		var top = $("#updatedMessage").scrollTop();
		$('html, body').animate({scrollTop:top}, 'slow');
	}

}