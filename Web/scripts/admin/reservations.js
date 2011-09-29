function ReservationManagement(opts)
{
	var options = opts;

	var elements = {
		userFilter: $("#userFilter"),
		startDate: $("#startDate"),
		endDate: $("#endDate"),
		userId: $("#userId"),
		scheduleId: $("#scheduleId"),
		resourceId: $("#resourceId"),
		referenceNumber: $("#referenceNumber"),
		reservationTable: $("#reservationTable"),
		updateScope: $('#hdnSeriesUpdateScope'),

		deleteInstanceDialog: $('#deleteInstanceDialog'),
		deleteSeriesDialog: $('#deleteSeriesDialog'),

		deleteInstanceForm: $('#deleteInstanceForm'),
		deleteSeriesForm: $('#deleteSeriesForm')
	};

	var reservations = new Object();

	ReservationManagement.prototype.init = function()
	{
		ConfigureAdminDialog(elements.deleteInstanceDialog, 425, 200);
		ConfigureAdminDialog(elements.deleteSeriesDialog, 650, 200);
		
		$('.datepicker').datepicker();

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
			var td = $(this).parents('tr').find('.referenceNumber');
			var referenceNumber = td.text();
			setActiveId(referenceNumber);
			showDeleteReservation(referenceNumber);
		});

		$(".saveSeries").click(function() {
			var updateScope = opts.updateScope[$(this).attr('id')];
			elements.updateScope.val(updateScope);
			elements.deleteSeriesForm.submit();
		});
		
		$('#filter').click(filterReservations);

		ConfigureAdminForm(elements.deleteInstanceForm, getSubmitCallback(options.actions.deleteReservation));
		ConfigureAdminForm(elements.deleteSeriesForm, getSubmitCallback(options.actions.deleteReservation));
	};

	ReservationManagement.prototype.addReservation = function(reservation)
	{
		reservations[reservation.referenceNumber] = reservation;
	};

	function getSubmitCallback(action)
	{
		return function() { return opts.actionUrl + "?rn=" + getActiveId() + "&action=" + action; };
	}

	function setActiveId(referenceNumber)
	{
		this.referenceNumber = referenceNumber;
	}

	function getActiveId()
	{
		return this.referenceNumber;
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
				'&rn=' + elements.referenceNumber.val();

		window.location = document.location.pathname + '?' + encodeURI(filterQuery);
	}

	function viewReservation(referenceNumber)
	{
		window.location = options.reservationUrlTemplate.replace('[refnum]', referenceNumber);
	}
}