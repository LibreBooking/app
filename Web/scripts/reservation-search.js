function ReservationSearch(options) {
	var elements = {
		searchForm: $('#searchForm'),
		reservationResults: $('#reservation-results'),
		resources: $('#resources'),
		schedules: $('#schedules'),
		userFilter: $('#userFilter'),
		userId: $('#userId'), // today: $('#today'),
		// tomorrow: $('#tomorrow'),
		// thisweek: $('#thisweek'),
		daterange: $('input[name="AVAILABILITY_RANGE"]'),
		beginDate: $('#beginDate'),
		endDate: $('#endDate')
	};

	var init = function () {
		ConfigureAsyncForm(elements.searchForm, function () {
			elements.reservationResults.empty();
		}, showSearchResults);

		elements.userFilter.userAutoComplete(options.autocompleteUrl, selectUser);

		elements.userFilter.change(function () {
			if ($(this).val() == '')
			{
				elements.userId.val('');
			}
		});

		elements.daterange.change(function (e) {
			if ($(e.target).val() == 'daterange')
			{
				elements.beginDate.removeAttr('disabled');
				elements.endDate.removeAttr('disabled');
			}
			else
			{
				elements.beginDate.val('').attr('disabled', 'disabled');
				elements.endDate.val('').attr('disabled', 'disabled');
			}
		});

		$('input[name="AVAILABILITY_RANGE"]').change(function (e) {
			if ($(e.target).val() == 'daterange')
			{
				elements.beginDate.removeAttr('disabled');
				elements.endDate.removeAttr('disabled');
			}
			else
			{
				elements.beginDate.val('').attr('disabled', 'disabled');
				elements.endDate.val('').attr('disabled', 'disabled');
			}
		});
	};

	function selectUser(ui, textbox) {
		elements.userId.val(ui.item.value);
		textbox.val(ui.item.label);
	}

	var showSearchResults = function (data) {
		elements.reservationResults.empty().html(data);

		elements.reservationResults.find('tr.editable').each(function () {
			var seriesId = $(this).attr('data-seriesId');
			var refNum = $(this).attr('data-refnum');
			$(this).attachReservationPopup(refNum, options.popupUrl);

			$(this).hover(function (e) {
				$(this).find('td').addClass('highlight');
			}, function (e) {
				$(this).find('td').removeClass('highlight');
			});
		});
	};

	elements.reservationResults.delegate('tr.editable', 'click', function () {
		viewReservation($(this).attr('data-refnum'));
	});


	function viewReservation(referenceNumber) {
		window.location = options.reservationUrlTemplate.replace('[refnum]', referenceNumber);
	}

	return {init: init};
}