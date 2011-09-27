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
		reservationTable: $("#reservationTable")
	};

	var reservations = new Object();

	ReservationManagement.prototype.init = function()
	{
		$('.datepicker').datepicker();

		elements.userFilter.userAutoComplete(options.autocompleteUrl, selectUser);

		elements.userFilter.change(function(){
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

		elements.reservationTable.delegate('.delete', 'click', function(e) {
			var td = $(this).find('.referenceNumber');
			var referenceNumber = td.text();
			alert(reservations[referenceNumber].isRecurring);
		});
		
		$('#filter').click(filterReservations);
	};

	ReservationManagement.prototype.addReservation = function(reservation)
	{
		reservations[reservation.referenceNumber] = reservation;
	};

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