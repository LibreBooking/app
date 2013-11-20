function BlackoutManagement(opts)
{
	var options = opts;

	var elements = {
		startDate: $("#formattedStartDate"),
		endDate: $("#formattedEndDate"),
		scheduleId: $("#scheduleId"),
		resourceId: $("#resourceId"),
        blackoutTable: $("#blackoutTable"),
        reservationTable: $("#reservationTable"),

		allResources: $('#allResources'),
		addResourceId: $('#addResourceId'),
		addScheduleId: $('#addScheduleId'),

		deleteDialog: $('#deleteDialog'),
		deleteRecurringDialog: $('#deleteRecurringDialog'),

        deleteForm: $('#deleteForm'),
		deleteRecurringForm: $('#deleteRecurringForm'),
		addBlackoutForm: $('#addBlackoutForm'),

		referenceNumberList: $(':hidden.reservationId')
	};

	var blackouts = new Object();
    var blackoutId;

	BlackoutManagement.prototype.init = function()
	{
        ConfigureAdminDialog(elements.deleteDialog, 'auto', 'auto');
        ConfigureAdminDialog(elements.deleteRecurringDialog, 'auto', 'auto');

		wireUpUpdateButtons();

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

		elements.blackoutTable.find('.editable td:not(.update)').click(function (e)
		{
			var tr = $(this).parents('tr');
			var id = tr.find('.id').text();

			$.colorbox(
					{   inline: false,
						href: opts.editUrl + id,
						transition: "none",
						width: "75%",
						height: "75%",
						overlayClose: false,
						onComplete: function ()
						{
							ConfigureAdminForm($('#editBlackoutForm'), getUpdateUrl, onAddSuccess, null, {onBeforeSubmit: onBeforeAddSubmit, target: '#result'});

							wireUpUpdateButtons();

							$(".save").click(function() {
								$(this).closest('form').submit();
							});

							$('#cancelUpdate').click(function (e)
							{
								$.colorbox.close();
							});

							$('.blackoutResources').click(function (e)
							{
								if ($(".blackoutResources input:checked").length == 0)
								{
									e.preventDefault();
								}
							});

							$('#updateStartTime').timepicker({
								show24Hours: false
							});

							$('#updateEndTime').timepicker({
								show24Hours: false
							});

						}});
		});

		handleBlackoutApplicabilityChange();
		wireUpTimePickers();

		elements.blackoutTable.delegate('.update', 'click', function(e) {
            e.preventDefault();

            var tr = $(this).parents('tr');
            var id = tr.find('.id').text();
            setActiveBlackoutId(id);
		});

        elements.blackoutTable.delegate('.delete', 'click', function() {
            showDeleteBlackout();
		});

		elements.blackoutTable.delegate('.delete-recurring', 'click', function() {
            showDeleteRecurringBlackout();
		});

		$('#showAll').click(function(e)
		{
			e.preventDefault();
			elements.startDate.val('');
			elements.endDate.val('');
			elements.scheduleId.val('');
			elements.resourceId.val('');

			filterReservations();
		});
		$('#filter').click(filterReservations);

		ConfigureAdminForm(elements.addBlackoutForm, getAddUrl, onAddSuccess, null, {onBeforeSubmit: onBeforeAddSubmit, target: '#result'});
		ConfigureAdminForm(elements.deleteForm, getDeleteUrl, onDeleteSuccess, null, {onBeforeSubmit: onBeforeDeleteSubmit, target: '#result'});
		ConfigureAdminForm(elements.deleteRecurringForm, getDeleteUrl, onDeleteSuccess, null, {onBeforeSubmit: onBeforeDeleteSubmit, target: '#result'});
	};

    function showDeleteBlackout() {
        elements.deleteDialog.dialog('open');
    }

	function showDeleteRecurringBlackout() {
        elements.deleteRecurringDialog.dialog('open');
    }

    function setActiveBlackoutId(id) {
        blackoutId = id;
    }

    function getActiveBlackoutId() {
       return blackoutId;
    }

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

    function onBeforeDeleteSubmit()
    {
        $.colorbox({inline:true, href:"#createDiv", transition:"none", width:"75%", height:"75%", overlayClose: false});
        $('#result').hide();
        $('#creating, #createDiv').show();
    }

	function onAddSuccess()
	{
		$('#creating').hide();
		$('#result').show();

        $("#reservationTable").find('.editable').each(function() {
           var refNum = $(this).find('.referenceNumber').text();
           $(this).attachReservationPopup(refNum, options.popupUrl);
       });

        $("#reservationTable").delegate('.editable', 'click', function() {
            $(this).addClass('clicked');
            var td = $(this).find('.referenceNumber');
            viewReservation(td.text());
        });
	}

    function onDeleteSuccess()
    {
        location.reload();
    }
	
	function getDeleteUrl()
	{
		return opts.deleteUrl + getActiveBlackoutId();
	}

	function getAddUrl()
	{
		return opts.addUrl;
	}

	function getUpdateUrl()
	{
		return opts.updateUrl;
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
		$('#addStartTime').timepicker({
			show24Hours: false
		});
		$('#addEndTime').timepicker({
			show24Hours: false
		});
	}

	function ChangeUpdateScope(updateScopeValue)
	{
		$('.hdnSeriesUpdateScope').val(updateScopeValue);
	}

	function wireUpUpdateButtons()
	{
		$('.btnUpdateThisInstance').click(function ()
		{
			ChangeUpdateScope(options.scopeOpts.instance);
		});

		$('.btnUpdateAllInstances').click(function ()
		{
			ChangeUpdateScope(options.scopeOpts.full);
		});
	}
}