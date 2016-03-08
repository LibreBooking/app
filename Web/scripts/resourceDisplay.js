function ResourceDisplay(opts) {
	var options = opts;

	var elements = {
		loginForm: $('#loginForm'),
		loginButton: $('#loginButton'),
		loginError: $('#loginError'),
		loginBox: $('#login-box'),
		resourceList: $('#resourceList'),
		resourceListBox: $('#resource-list-box'),
		activateResourceDisplayForm: $('#activateResourceDisplayForm')
	};

	function populateResourceList(resources) {
		$.each(resources, function(i, resource){
			elements.resourceList.append('<option value="' + resource.id + '">' + resource.name + '</option>');
		});

		elements.resourceListBox.removeClass('no-show');
	}

	function activateResourceDisplay(resourceId) {
		$.blockUI({message: $('#wait-box')});
		ajaxPost(elements.activateResourceDisplayForm, null, null, function(data) {
			if (data.location)
			{
				window.location = data.location;
			}
			else {
				$.unblockUI();
			}
		});
	}

	ResourceDisplay.prototype.init = function () {
		elements.loginForm.submit(function (e) {
			e.preventDefault();
			ajaxPost(elements.loginForm, null, null, function (data) {
				if (data.error == true) {
					elements.loginError.removeClass('no-show');
				}
				else {
					elements.loginBox.addClass('no-show');
					populateResourceList(data.resources);
				}

				$.unblockUI();
			});
		});

		elements.loginButton.click(function (e) {
			e.preventDefault();
			$('#waitIndicator').removeClass('no-show');
			$.blockUI({message: $('#wait-box')});

			elements.loginForm.submit();
		});

		elements.resourceList.on('change', function(){
			var resourceId = $(this).val()

			if (resourceId != '')
			{
				activateResourceDisplay(resourceId);
			}
		});
	};
}