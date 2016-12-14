function Approval(opts)
{
	var options = opts;

	var elements = {
		approveButton: $('#btnApprove'),
		referenceNumber: $("#referenceNumber")
	};

	function initReservation()
	{
		elements.approveButton.click(function ()
		{
			$('<span class="fa fa-spinner fa-spin fa-2x"/>').insertAfter(elements.approveButton);
			elements.approveButton.hide();
			approve(elements.referenceNumber.val());
		});
	}

	function approve(referenceNumber)
	{
		$.ajax({
			url: options.url,
			dataType: 'json',
			data: {rn: referenceNumber, rs: options.responseType},
			success: function (data)
			{
				if (options.returnUrl)
				{
					window.location = options.returnUrl;
				}
				else
				{
					window.location.reload();
				}
			}
		});
	}

	return {
		initReservation: initReservation,
		Approve: approve
	}

}
