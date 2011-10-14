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
			Approve(elements.referenceNumber.val());
		});
	};

//	Approval.prototype.initParticipation = function() {
//
//		elements.invitationAction.click(function() {
//			var li = $(this).parents('li');
//			li.last('button').append('<img src="img/admin-ajax-indicator.gif" />')
//			var referenceNumber = li.find('.referenceNumber').val();
//			Approve($(this).val(), referenceNumber);
//		});
//
//		$('.reservation').each(function(){
//			var refNum = $(this).attr('referenceNumber');
//			$(this).attachReservationPopup(refNum);
//		});
//	};


	function Approve(referenceNumber) {
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
