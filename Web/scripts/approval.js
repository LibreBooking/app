function Approval(opts)
{
	var options = opts;

	var elements = {
		approveButton: $('#btnApprove'),
		referenceNumber: $("#referenceNumber"),
		indicator: $('#indicator')
	};

	Approval.prototype.initReservation = function() {
		elements.approveButton.click(function() {
			elements.indicator.insertAfter(elements.approveButton).show();
			elements.approveButton.hide();
            Approval.prototype.Approve(elements.referenceNumber.val());
		});
	};

	Approval.prototype.Approve = function(referenceNumber) {
		$.ajax({
			url: options.url,
			dataType: 'json',
			data: {rn: referenceNumber, rs: options.responseType},
			success: function(data) {
				window.location.reload();
			}
		});
	};
}
