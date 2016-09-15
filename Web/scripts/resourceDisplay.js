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
		$.each(resources, function (i, resource) {
			elements.resourceList.append('<option value="' + resource.id + '">' + resource.name + '</option>');
		});

		elements.resourceListBox.removeClass('no-show');
	}

	function activateResourceDisplay(resourceId) {
		$.blockUI({message: $('#wait-box')});
		ajaxPost(elements.activateResourceDisplayForm, null, null, function (data) {
			if (data.location)
			{
				window.location = data.location;
			}
			else
			{
				$.unblockUI();
			}
		});
	}

	ResourceDisplay.prototype.init = function () {
		elements.loginForm.submit(function (e) {
			e.preventDefault();
			ajaxPost(elements.loginForm, null, null, function (data) {
				if (data.error == true)
				{
					elements.loginError.removeClass('no-show');
				}
				else
				{
					elements.loginBox.addClass('no-show');
					populateResourceList(data.resources);
				}

				hideWait();
			});
		});
	};

	ResourceDisplay.prototype.initDisplay = function (opts) {

        var url = opts.url;
        var checkinUrl = opts.checkinUrl;

		refreshResource();

		setInterval(refreshResource, 60000);

		$('#placeholder').on('click', '.reservePrompt', function (e) {
			var emailAddress = $('#emailAddress');
			if (_.isEmpty(emailAddress.val()))
			{
				emailAddress.closest('.input-group').addClass('has-error');
				return;
			}

			$('#formReserve').submit();
		});

		var beginIndex = 0;

		function refreshResource() {
			ajaxGet(url, null, function (data) {
				$('#placeholder').html(data);
				var formReserve = $('#formReserve');
				formReserve.unbind('submit');
				formReserve.unbind('onValidationFailed');
				formReserve.bind('onValidationFailed', function () {
					hideWait();
					$('.reserveResults').addClass('no-show');
				});

				ConfigureAsyncForm(formReserve, function () {
					return formReserve.attr('action');
				}, afterReserve, null, {onBeforeSubmit: showWait});


                var formCheckin = $('#formCheckin');
                formCheckin.unbind('submit');

                ConfigureAsyncForm(formCheckin, null, afterCheckin, null, {onBeforeSubmit: showWait, onBeforeSerialize: beforeCheckin});

                var begin = $('#beginPeriod');
				var end = $('#endPeriod');
				beginIndex = begin.find('option:selected').index();

				begin.unbind('change');
				begin.on('change', function () {
					var newIndex = begin.find('option:selected').index();
					var currentEnd = end.find('option:selected').index();
					var newSelectedEnd = newIndex - beginIndex + currentEnd;
					var totalNumberOfEnds = end.find('option').length-1;
					if (newSelectedEnd < 0)
					{
						newSelectedEnd = 0;
					}
					if (newSelectedEnd > totalNumberOfEnds)
					{
						newSelectedEnd = totalNumberOfEnds;
					}
					end.prop('selectedIndex', newSelectedEnd);
					beginIndex = newIndex;
				})
			});

			function afterReserve(data) {
				var validationErrors = $('#validationErrors');
				if (data.success)
				{
					validationErrors.find('ul').empty().addClass('no-show');
					refreshResource();
				}
				else
				{
					validationErrors.find('ul').empty().html($.map(data.errors, function (item) {
						return "<li>" + item + "</li>";
					}));
					validationErrors.removeClass('no-show');
				}
				hideWait();
			}

			function beforeCheckin() {
                $('#referenceNumber').val($('td[data-checkin="1"]').attr('data-refnum'));
            }

			function afterCheckin(data) {
			    refreshResource();
                hideWait();
            }
		}
	};

	function showWait() {
		$('#waitIndicator').removeClass('no-show');
		$.blockUI({message: $('#wait-box')});
	}

	function hideWait() {
		$.unblockUI();
	}

	elements.loginButton.click(function (e) {
		e.preventDefault();
		showWait();

		elements.loginForm.submit();
	});

	elements.resourceList.on('change', function () {
		var resourceId = $(this).val()

		if (resourceId != '')
		{
			activateResourceDisplay(resourceId);
		}
	});
}