function ReservationManagement(opts, approval) {
	var options = opts;

	var elements = {
		userFilter: $("#userFilter"),
		startDate: $("#formattedStartDate"),
		endDate: $("#formattedEndDate"),
		userId: $("#userId"),
		scheduleId: $("#scheduleId"),
		resourceId: $("#resourceId"),
		statusId: $('#statusId'),
		referenceNumber: $("#referenceNumber"),
		reservationTable: $("#reservationTable"),
		updateScope: $('#hdnSeriesUpdateScope'),
		resourceStatusIdFilter: $('#resourceStatusIdFilter'),
		resourceReasonIdFilter: $('#resourceReasonIdFilter'),

		deleteInstanceDialog: $('#deleteInstanceDialog'),
		deleteSeriesDialog: $('#deleteSeriesDialog'),

		deleteInstanceForm: $('#deleteInstanceForm'),
		deleteSeriesForm: $('#deleteSeriesForm'),

		statusForm: $('#statusForm'),
		statusDialog: $('#statusDialog'),
		statusReasons: $('#resourceReasonId'),
		statusOptions: $('#resourceStatusId'),
		statusResourceId: $('#statusResourceId'),
		statusReferenceNumber: $('#statusUpdateReferenceNumber'),

		filterButton: $('#filter'),
		clearFilterButton: $('#clearFilter'),
		filterTable: $('#filter-reservations-panel'),

		attributeUpdateForm: $('#attributeUpdateForm'),

		referenceNumberList: $(':hidden.referenceNumber'),
		inlineUpdateErrors: $('#inlineUpdateErrors'),
		inlineUpdateErrorDialog: $('#inlineUpdateErrorDialog')
	};

	var reservations = {};
	var reasons = {};

	ReservationManagement.prototype.init = function () {

		elements.reservationTable.delegate('.changeAttribute', 'click', function (e) {
			e.stopPropagation();
			$(e.target).closest('.updateCustomAttribute').find('.inlineAttribute').editable('toggle');
		});

		$(".save").click(function () {
			$(this).closest('form').submit();
		});

		elements.userFilter.userAutoComplete(options.autocompleteUrl, selectUser);

		elements.userFilter.change(function () {
			if ($(this).val() == '')
			{
				elements.userId.val('');
			}
		});

		function setCurrentReservationInformation(td) {
			var tr = td.parents('tr');
			var referenceNumber = tr.attr('data-refnum');
			var reservationId = tr.find('.id').text();
			setActiveReferenceNumber(referenceNumber);
			setActiveReservationId(reservationId);
			elements.referenceNumberList.val(referenceNumber);
		}

		elements.reservationTable.delegate('a.update', 'click', function (e) {
			e.preventDefault();
			e.stopPropagation();

			var td = $(this);
			if (this.tagName != 'TD')
			{
				td = $(this).closest('td');
			}
			setCurrentReservationInformation(td);
		});

		elements.reservationTable.delegate('tr.editable', 'click', function () {
			$(this).addClass('clicked');
			viewReservation($(this).attr('data-refnum'));
		});

        elements.reservationTable.delegate('.edit', 'click', function(){
            viewReservation($(this).closest('tr').attr('data-refnum'));
        });

		elements.reservationTable.find('tr.editable').each(function () {
			var seriesId = $(this).attr('data-seriesId');
			var refNum = $(this).attr('data-refnum');
			$(this).attachReservationPopup(refNum, options.popupUrl);

			$(this).hover(function (e) {
				$(this).find('td').addClass('highlight');
			}, function (e) {
				$(this).find('td').removeClass('highlight');
			});
		});

		elements.reservationTable.delegate('.delete', 'click', function (e) {
		    e.preventDefault();
            e.stopPropagation();
			showDeleteReservation(getActiveReferenceNumber());
		});

		elements.reservationTable.delegate('.approve', 'click', function (e) {
            e.preventDefault();
            e.stopPropagation();
			approveReservation(getActiveReferenceNumber());
		});

		elements.statusOptions.change(function (e) {
			populateReasonOptions(elements.statusOptions.val(), elements.statusReasons);
		});

		elements.resourceStatusIdFilter.change(function (e) {
			populateReasonOptions(elements.resourceStatusIdFilter.val(), elements.resourceReasonIdFilter);
			if (opts.resourceReasonFilter)
			{
				elements.resourceReasonIdFilter.val(opts.resourceReasonFilter)
			}
		});

		elements.deleteSeriesForm.find('.saveSeries').click(function () {
			var updateScope = opts.updateScope[$(this).attr('id')];
			elements.updateScope.val(updateScope);
			elements.deleteSeriesForm.submit();
		});

		elements.statusDialog.find('.saveAll').click(function () {
			$('#statusUpdateScope').val('all');
			$(this).closest('form').submit();
		});

		elements.filterButton.click(filterReservations);
		elements.clearFilterButton.click(function (e) {
			e.preventDefault();
			elements.filterTable.find('input,select,textarea').val('')

			filterReservations();
		});

		var deleteReservationResponseHandler = function (response, form) {
			form.find('.delResResponse').empty();
			if (!response.deleted)
			{
				form.find('.delResResponse').text(response.errors.join('<br/>'));
			}
			else
			{
				window.location.reload();
			}
		};

		ConfigureAsyncForm(elements.deleteInstanceForm, getDeleteUrl, null, deleteReservationResponseHandler, {dataType: 'json'});
		ConfigureAsyncForm(elements.deleteSeriesForm, getDeleteUrl, null, deleteReservationResponseHandler, {dataType: 'json'});
		ConfigureAsyncForm(elements.statusForm, getUpdateStatusUrl, function () {
			elements.statusDialog.modal('hide');
			// todo inline update
			window.location.reload();
		});
	};

	ReservationManagement.prototype.addReservation = function (reservation) {
		if (!(reservation.referenceNumber in reservations))
		{
			reservation.resources = {};
			reservations[reservation.referenceNumber] = reservation;
		}

		reservations[reservation.referenceNumber].resources[reservation.resourceId] = {
			id: reservation.resourceId,
			statusId: reservation.resourceStatusId,
			descriptionId: reservation.resourceStatusReasonId
		};

	};

	ReservationManagement.prototype.addStatusReason = function (id, statusId, description) {
		if (!(statusId in reasons))
		{
			reasons[statusId] = [];
		}

		reasons[statusId].push({id: id, description: description});
	};

	ReservationManagement.prototype.initializeStatusFilter = function (statusId, reasonId) {
		elements.resourceStatusIdFilter.val(statusId);
		elements.resourceStatusIdFilter.trigger('change');
		elements.resourceReasonIdFilter.val(reasonId);
	};

	var defaultSubmitCallback = function (form) {
		return function () {
			return options.submitUrl + "?action=" + form.attr('ajaxAction') + '&rn=' + getActiveReferenceNumber();
		};
	};

	function getDeleteUrl() {
		return opts.deleteUrl;
	}

	function getUpdateStatusUrl() {
		return opts.resourceStatusUrl.replace('[refnum]', getActiveReferenceNumber());
	}

	function setActiveReferenceNumber(referenceNumber) {
		this.referenceNumber = referenceNumber;
	}

	function getActiveReferenceNumber() {
		return this.referenceNumber;
	}

	function setActiveReservationId(reservationId) {
		this.reservationId = reservationId;
	}

	function showDeleteReservation(referenceNumber) {
		if (reservations[referenceNumber].isRecurring == '1')
		{
			elements.deleteSeriesDialog.modal('show');
		}
		else
		{
			elements.deleteInstanceDialog.modal('show');
		}
	}

	function populateReasonOptions(statusId, reasonsElement) {
		reasonsElement.empty().append($('<option>', {value: '', text: '-'}));

		if (statusId in reasons)
		{
			$.each(reasons[statusId], function (i, v) {
				reasonsElement.append($('<option>', {
					value: v.id,
					text: v.description
				}));
			});
		}
	}

	function selectUser(ui, textbox) {
		elements.userId.val(ui.item.value);
		textbox.val(ui.item.label);
	}

	function filterReservations() {
		var reasonId = '';
		if (elements.resourceReasonIdFilter.val())
		{
			reasonId = elements.resourceReasonIdFilter.val();
		}

		var attributes = elements.filterTable.find('[name^=psiattribute]');
		var attributeString = '';
		$.each(attributes, function (i, attribute) {
			attributeString += '&' + $(attribute).attr('name') + '=' + $(attribute).val();
		});

		var filterQuery =
				'sd=' + elements.startDate.val() +
				'&ed=' + elements.endDate.val() +
				'&sid=' + elements.scheduleId.val() +
				'&rid=' + elements.resourceId.val() +
				'&uid=' + elements.userId.val() +
				'&un=' + elements.userFilter.val() +
				'&rn=' + elements.referenceNumber.val() +
				'&rsid=' + elements.statusId.val() +
				'&rrsid=' + elements.resourceStatusIdFilter.val() +
				'&rrsrid=' + reasonId;

		window.location = document.location.pathname + '?' + encodeURI(filterQuery) + attributeString;
	}

	function viewReservation(referenceNumber) {
		window.location = options.reservationUrlTemplate.replace('[refnum]', referenceNumber);
	}

	function approveReservation(referenceNumber) {
		$.blockUI({ message: $('#approveDiv')});
		approval.Approve(referenceNumber);
	}
}