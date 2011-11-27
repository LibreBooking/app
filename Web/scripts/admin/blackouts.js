function BlackoutManagement(opts)
{
	var options = opts;

	var elements = {
		startDate: $("#startDate"),
		endDate: $("#endDate"),
		scheduleId: $("#scheduleId"),
		resourceId: $("#resourceId"),
		reservationTable: $("#reservationTable"),
		updateScope: $('#hdnSeriesUpdateScope'),

		allResources: $('#allResources'),
		addResourceId: $('#addResourceId'),
		addScheduleId: $('#addScheduleId'),

		deleteInstanceDialog: $('#deleteInstanceDialog'),
		deleteSeriesDialog: $('#deleteSeriesDialog'),

		deleteInstanceForm: $('#deleteInstanceForm'),
		deleteSeriesForm: $('#deleteSeriesForm'),
		addBlackoutForm: $('#addBlackoutForm'),

		reservationIdList: $(':hidden.reservationId')
	};

	var blackouts = new Object();

	BlackoutManagement.prototype.init = function()
	{
		$(".save").click(function() {
			$(this).closest('form').submit();
		});

		$(".cancel").click(function() {
			$(this).closest('.dialog').dialog("close");
		});

		$('#createDiv').delegate('.reload', 'click', function(e) {
			location.reload();
		});

		$('#createDiv').delegate('.close', 'click', function(e) {
			$('#createDiv').hide();
			$.colorbox.close();
		});
		
		handleBlackoutApplicabilityChange();
		wireUpTimePickers();
		
//		elements.reservationTable.delegate('a.update', 'click', function(e) {
//			e.preventDefault();
//			e.stopPropagation();
//
//			var tr = $(this).parents('tr');
//			var referenceNumber = tr.find('.referenceNumber').text();
//			var reservationId = tr.find('.id').text();
//			setActiveReferenceNumber(referenceNumber);
//			setActiveReservationId(reservationId);
//			elements.reservationIdList.val(reservationId);
//		});
//
//		elements.reservationTable.delegate('.editable', 'click', function() {
//			$(this).addClass('clicked');
//			var td = $(this).find('.referenceNumber');
//			viewReservation(td.text());
//		});
//
//		elements.reservationTable.find('.editable').each(function() {
//			var refNum = $(this).find('.referenceNumber').text();
//			$(this).attachReservationPopup(refNum, options.popupUrl);
//		});
//
//		elements.reservationTable.delegate('.delete', 'click', function() {
//			showDeleteReservation(getActiveReferenceNumber());
//		});
//
//		elements.deleteSeriesForm.find('.saveSeries').click(function() {
//			var updateScope = opts.updateScope[$(this).attr('id')];
//			elements.updateScope.val(updateScope);
//			elements.deleteSeriesForm.submit();
//		});
		
		$('#filter').click(filterReservations);


		ConfigureAdminForm(elements.addBlackoutForm, getAddUrl, onAddSuccess, null, {onBeforeSubmit: onBeforeAddSubmit, target: '#result'});
		//ConfigureAdminForm(elements.deleteSeriesForm, getDeleteUrl);
	};

	function onBeforeAddSubmit(formData, jqForm, opts)
	{
		var isValid = BeforeFormSubmit(formData, jqForm, opts);

		if (isValid)
		{
			$.colorbox({inline:true, href:"#createDiv", transition:"none", width:"75%", height:"75%", overlayClose: false});
			$('#result').hide();
			$('#creating, #createDiv').show();
		}
		return isValid;
	}

	function onAddSuccess()
	{
		$('#creating').hide();
		$('#result').show();
	}
	
	function getDeleteUrl()
	{
		return opts.deleteUrl;
	}

	function getAddUrl()
	{
		return opts.addUrl;
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
	
	function filterReservations()
	{
		var filterQuery =
				'sd=' + elements.startDate.val() +
				'&ed=' + elements.endDate.val() +
				'&sid=' + elements.scheduleId.val() +
				'&rid=' + elements.resourceId.val();

		window.location = document.location.pathname + '?' + encodeURI(filterQuery);
	}

	function viewReservation(referenceNumber)
	{
		window.location = options.reservationUrlTemplate.replace('[refnum]', referenceNumber);
	}

	function handleBlackoutApplicabilityChange()
	{
		elements.allResources.change(function(){
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
		});
	}

	function wireUpTimePickers()
	{
		$('#addStartTime').timePicker({
			show24Hours: false
		});
		$('#addEndTime').timePicker({
			show24Hours: false
		});
	}
}