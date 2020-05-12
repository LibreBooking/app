function BlackoutManagement(opts) {
	var options = opts;

	var elements = {
		startDate: $("#formattedStartDate"),
		endDate: $("#formattedEndDate"),
		scheduleId: $("#scheduleId"),
		resourceId: $("#resourceId"),
		blackoutTable: $("#blackoutTable"),

		allResources: $('#allResources'),
		addResourceId: $('#addResourceId'),
		addScheduleId: $('#addScheduleId'),

		deleteDialog: $('#deleteDialog'),
		deleteRecurringDialog: $('#deleteRecurringDialog'),

		deleteForm: $('#deleteForm'),
		deleteRecurringForm: $('#deleteRecurringForm'),
		addBlackoutForm: $('#addBlackoutForm'),

		referenceNumberList: $(':hidden.reservationId'),

		deleteMultiplePrompt: $('#delete-selected'),
		deleteMultipleDialog: $('#deleteMultipleDialog'),
		deleteMultipleForm: $('#deleteMultipleForm'),
		deleteMultipleCheckboxes: $('.delete-multiple'),
		deleteMultipleSelectAll: $('#delete-all'),
		deleteMultipleCount: $('#deleteMultipleCount'),
		deleteMultiplePlaceHolder: $('#deleteMultiplePlaceHolder'),

		addPromptButton: $('#add-blackout-prompt'),
		addDialog: $('#add-blackout-dialog')
	};

	var blackoutId;

	BlackoutManagement.prototype.init = function () {
		wireUpUpdateButtons();

		$(".cancel").click(function () {
			$(this).closest('.modal').modal("close");
		});

		$('#result').delegate('.reload', 'click', function (e) {
			location.reload();
		});

		$('#result').delegate('.unblock', 'click', function (e) {
			$('#result').hide();
			$.unblockUI();
		});

		ConfigureAsyncForm($('#editBlackoutForm'), getUpdateUrl);

		elements.blackoutTable.find('.edit').click(function (e) {
			const id = $(e.currentTarget ).data('blackout-id');
			handleEditClicked(id);
		});

		handleBlackoutApplicabilityChange();
		wireUpTimePickers();

		elements.blackoutTable.delegate('.update', 'click', function (e) {
			e.preventDefault();

			var tr = $(this).parents('tr');
			var id = tr.attr('data-blackout-id');
			setActiveBlackoutId(id);
		});

		elements.blackoutTable.delegate('.delete', 'click', function () {
			showDeleteBlackout();
		});

		elements.blackoutTable.delegate('.delete-recurring', 'click', function () {
			showDeleteRecurringBlackout();
		});

		$('#showAll').click(function (e) {
			e.preventDefault();
			elements.startDate.val('');
			elements.endDate.val('');
			elements.scheduleId.val('');
			elements.resourceId.val('');

			filterReservations();
		});

		$('#filter').click(function (e) {
			e.preventDefault();
			filterReservations();
		});

		elements.deleteMultiplePrompt.click(function (e) {
			e.preventDefault();
			var checked = elements.blackoutTable.find('.delete-multiple:checked');
			elements.deleteMultipleCount.text(checked.length);
			elements.deleteMultiplePlaceHolder.empty();
			elements.deleteMultiplePlaceHolder.append(checked.clone());
			elements.deleteMultipleDialog.modal('open');
		});

		elements.deleteMultipleSelectAll.click(function (e) {
			e.stopPropagation();
			var isChecked = elements.deleteMultipleSelectAll.is(":checked");
			elements.deleteMultipleCheckboxes.prop('checked', isChecked);
			elements.deleteMultiplePrompt.toggleClass('no-show', !isChecked);
		});

		elements.deleteMultipleCheckboxes.click(function (e) {
			e.stopPropagation();
			const thisChecked = $(e.target).is(":checked");
			const blackoutId = $(e.target).attr("value");
			elements.blackoutTable.find('.delete-multiple[value="' + blackoutId + '"]').attr('checked', thisChecked);
			const numberChecked = elements.blackoutTable.find('.delete-multiple:checked').length;
			const allSelected = numberChecked === elements.blackoutTable.find('.delete-multiple').length;
			elements.deleteMultipleSelectAll.prop('checked', allSelected);
			elements.deleteMultiplePrompt.toggleClass('no-show', numberChecked === 0);
		});

		elements.addPromptButton.click(function (e) {
			elements.addBlackoutForm.trigger('reset');
			elements.addDialog.modal('open');
		});

		ConfigureAsyncForm(elements.addBlackoutForm, getAddUrl, onAddSuccess, null, {
			onBeforeSubmit: onBeforeAddSubmit, target: '#result'
		});
		ConfigureAsyncForm(elements.deleteForm, getDeleteUrl, onDeleteSuccess, null, {
			onBeforeSubmit: onBeforeDeleteSubmit, target: '#result'
		});
		ConfigureAsyncForm(elements.deleteRecurringForm, getDeleteUrl, onDeleteSuccess, null, {
			onBeforeSubmit: onBeforeDeleteSubmit, target: '#result'
		});
		ConfigureAsyncForm(elements.deleteMultipleForm);
	};

	function handleEditClicked(id) {
		const spinner = $('#update-spinner');
		spinner.show();

		$('#editBlackoutDialog').modal('open');

		var updateDiv = $('#update-contents');
		updateDiv.empty();
		spinner.removeClass('no-show');

		updateDiv.load(opts.editUrl + id, function () {

			spinner.addClass('no-show');

			M.updateTextFields();

			updateDiv.find('select').each(function (i, select) {
				$(select).formSelect();
			});

			wireUpUpdateButtons();

			$(".save").unbind('click');
			$(".save").click(function () {
				$(this).closest('form').submit();
			});

			$('.blackoutResources').click(function (e) {
				if ($(".blackoutResources input:checked").length == 0)
				{
					e.preventDefault();
				}
			});
			wireUpTimePickers();

			var form = $('#editBlackoutForm');
			form.unbind('submit');
			ConfigureAsyncForm(form, getUpdateUrl, onAddSuccess, null, {
				onBeforeSubmit: onBeforeAddSubmit, target: '#result'
			});
		});
	}

	function showDeleteBlackout() {
		elements.deleteDialog.modal('open');
	}

	function showDeleteRecurringBlackout() {
		elements.deleteRecurringDialog.modal('open');
	}

	function setActiveBlackoutId(id) {
		blackoutId = id;
	}

	function getActiveBlackoutId() {
		return blackoutId;
	}

	function showWaitBox() {
		$.blockUI({message: $('#wait-box')});

		$('#result').hide();
		$('#creatingNotification').show();
	}

	function onBeforeAddSubmit(formData, jqForm, opts) {
		var isValid = BeforeFormSubmit(formData, jqForm, opts);

		if (isValid)
		{
			showWaitBox();
		}
		return isValid;
	}

	function onBeforeDeleteSubmit() {
		$('.modal').modal('close');
		showWaitBox();
	}

	function onAddSuccess() {
		$('.blockUI').css('cursor', 'default');
		$('#creatingNotification').hide();
		$('#result').show();
	}

	function onDeleteSuccess() {
		$('.modal').modal('close');
		location.reload();
	}

	function getDeleteUrl() {
		return opts.deleteUrl + getActiveBlackoutId();
	}

	function getAddUrl() {
		return opts.addUrl;
	}

	function getUpdateUrl() {
		return opts.updateUrl;
	}

	function filterReservations() {
		var filterQuery = 'sd=' + elements.startDate.val() + '&ed=' + elements.endDate.val() + '&sid=' + elements.scheduleId.val() + '&rid=' + elements.resourceId.val();

		window.location = document.location.pathname + '?' + encodeURI(filterQuery);
	}

	function viewReservation(referenceNumber) {
		window.location = options.reservationUrlTemplate.replace('[refnum]', referenceNumber);
	}

	function handleBlackoutApplicabilityChange() {
		elements.allResources.change(function () {
			if ($(this).is(':checked'))
			{
				elements.addResourceId.attr('disabled', 'disabled');
				elements.addScheduleId.removeAttr('disabled');
			}
			else
			{
				elements.addScheduleId.attr('disabled', 'disabled');
				elements.addResourceId.removeAttr('disabled');
			}

			elements.addResourceId.formSelect();
			elements.addScheduleId.formSelect();
		});
	}

	function wireUpTimePickers() {
		$('.timepicker').unbind('timepicker');
		$('.timepicker').timepicker({
			timeFormat: options.timeFormat
		});
	}

	function ChangeUpdateScope(updateScopeValue) {
		$('.hdnSeriesUpdateScope').val(updateScopeValue);
	}

	function wireUpUpdateButtons() {
		$('.btnUpdateThisInstance').unbind('click');
		$('.btnUpdateThisInstance').click(function () {
			ChangeUpdateScope(options.scopeOpts.instance);
		});

		$('.btnUpdateAllInstances').unbind('click');
		$('.btnUpdateAllInstances').click(function () {
			ChangeUpdateScope(options.scopeOpts.full);
		});
	}
}