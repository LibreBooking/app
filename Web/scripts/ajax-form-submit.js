jQuery.fn.bindAjaxSubmit = function (updateButton, successElement, modalDiv)
{
	var self = this;
	updateButton.click(function (e)
	{
		e.preventDefault();
		self.submit();
	});

	var defaultSubmitCallback = function (form)
	{
		return form.attr('action') + "?action=" + form.attr('ajaxAction');
	};

	function onValidationFailed(event, data)
	{
		hideModal();
	}

	function successHandler(response)
	{
		hideModal();
		successElement.show().delay(5000).fadeOut();
	}

	function onBeforeAddSubmit(formData, jqForm, opts)
	{
		successElement.hide();

		$.blockUI({ message: $('#' +  modalDiv.attr('id'))});
		modalDiv.show();

		return true;
	}

	function hideModal()
	{
		modalDiv.hide();
		$.unblockUI();

		var top = self.scrollTop();
		$('html, body').animate({scrollTop:top}, 'slow');
	}

	self.bind('onValidationFailed', onValidationFailed);
	ConfigureAsyncForm(self, defaultSubmitCallback, successHandler, null, {onBeforeSubmit:onBeforeAddSubmit});
};