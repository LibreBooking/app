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

		$.colorbox({inline:true, href:"#" + modalDiv.attr('id'), transition:"none", width:"75%", height:"75%", overlayClose:false});
		modalDiv.show();

		return true;
	}

	function hideModal()
	{
		modalDiv.hide();
		$.colorbox.close();

		var top = self.scrollTop();
		$('html, body').animate({scrollTop:top}, 'slow');
	}

	self.bind('onValidationFailed', onValidationFailed);
	ConfigureAdminForm(self, defaultSubmitCallback, successHandler, null, {onBeforeSubmit:onBeforeAddSubmit});
};