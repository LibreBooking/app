function ReservationManagement(opts, approval)
{
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

		deleteInstanceDialog: $('#deleteInstanceDialog'),
		deleteSeriesDialog: $('#deleteSeriesDialog'),

		deleteInstanceForm: $('#deleteInstanceForm'),
		deleteSeriesForm: $('#deleteSeriesForm'),

		reservationIdList: $(':hidden.reservationId')
	};

	var reservations = new Object();

	ReservationManagement.prototype.init = function()
	{
		ConfigureAdminDialog(elements.deleteInstanceDialog, 425, 200);
		ConfigureAdminDialog(elements.deleteSeriesDialog, 650, 200);

		$(".save").click(function() {
			$(this).closest('form').submit();
		});

		$(".cancel").click(function() {
			$(this).closest('.dialog').dialog("close");
		});
		
		elements.userFilter.userAutoComplete(options.autocompleteUrl, selectUser);

		elements.userFilter.change(function() {
			if ($(this).val() == '')
			{
				elements.userId.val('');
			}
		});

		elements.reservationTable.delegate('a.update', 'click', function(e) {
			e.preventDefault();
			e.stopPropagation();

			var tr = $(this).parents('tr');
			var referenceNumber = tr.find('.referenceNumber').text();
			var reservationId = tr.find('.id').text();
			setActiveReferenceNumber(referenceNumber);
			setActiveReservationId(reservationId);
			elements.reservationIdList.val(reservationId);
		});
		
		elements.reservationTable.delegate('.editable', 'click', function() {
			$(this).addClass('clicked');
			var td = $(this).find('.referenceNumber');
			viewReservation(td.text());
		});

		elements.reservationTable.find('.editable').each(function() {
			var refNum = $(this).find('.referenceNumber').text();
			$(this).attachReservationPopup(refNum, options.popupUrl);
		});

		elements.reservationTable.delegate('.delete', 'click', function() {
			showDeleteReservation(getActiveReferenceNumber());
		});

		elements.reservationTable.delegate('.approve', 'click', function() {
			approveReservation(getActiveReferenceNumber());
		});

		elements.deleteSeriesForm.find('.saveSeries').click(function() {
			var updateScope = opts.updateScope[$(this).attr('id')];
			elements.updateScope.val(updateScope);
			elements.deleteSeriesForm.submit();
		});
		
		$('#filter').click(filterReservations);

		var deleteReservationResponseHander = function(response, form)
		{
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

		ConfigureAdminForm(elements.deleteInstanceForm, getDeleteUrl, null, deleteReservationResponseHander, {dataType: 'json'});
		ConfigureAdminForm(elements.deleteSeriesForm, getDeleteUrl, null, deleteReservationResponseHander, {dataType: 'json'});
	};

	ReservationManagement.prototype.addReservation = function(reservation)
	{
		reservations[reservation.referenceNumber] = reservation;
	};

	function getDeleteUrl()
	{
		return opts.deleteUrl;
	}

	function setActiveReferenceNumber(referenceNumber)
	{
		this.referenceNumber = referenceNumber;
	}

	function getActiveReferenceNumber()
	{
		return this.referenceNumber;
	}

	function setActiveReservationId(reservationId)
	{
		this.reservationId = reservationId;
	}

	function getActiveReservationId()
	{
		return this.reservationId;
	}
	
	function showDeleteReservation(referenceNumber)
	{
		if (reservations[referenceNumber].isRecurring == '1')
		{
			elements.deleteSeriesDialog.dialog('open');
		}
		else
		{
			elements.deleteInstanceDialog.dialog('open');
		}
	}
	
	function selectUser(ui, textbox){
		elements.userId.val(ui.item.value);
		textbox.val(ui.item.label);
	}

	function filterReservations()
	{
		var filterQuery =
				'sd=' + elements.startDate.val() +
				'&ed=' + elements.endDate.val() +
				'&sid=' + elements.scheduleId.val() +
				'&rid=' + elements.resourceId.val() +
				'&uid=' + elements.userId.val() +
				'&un=' + elements.userFilter.val() +
				'&rn=' + elements.referenceNumber.val() +
				'&rsid=' + elements.statusId.val();

		window.location = document.location.pathname + '?' + encodeURI(filterQuery);
	}

	function viewReservation(referenceNumber)
	{
		window.location = options.reservationUrlTemplate.replace('[refnum]', referenceNumber);
	}

	function approveReservation(referenceNumber)
	{
		$.colorbox({inline:true, href:"#approveDiv", transition:"none", width:"75%", height:"75%", overlayClose: false});
		$('#approveDiv').show();
		approval.Approve(referenceNumber);
	}
}