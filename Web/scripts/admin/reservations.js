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
		referenceNumber: $("#referenceNumber")
	};

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

		$('#filter').click(filterReservations);
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
}
