function Participation(opts)
{
	var options = opts;

	var elements = {
		invitationAction: $('.participationAction'),
		referenceNumber: $("#referenceNumber"),
		indicator: $('#indicator')
	};

	Participation.prototype.initReservation = function() {
		elements.invitationAction.click(function() {
			elements.indicator.show();
			RespondToInvitation($(this).val(), elements.referenceNumber.val());
		});
	};

	Participation.prototype.initParticipation = function() {

		elements.invitationAction.click(function() {
			var li = $(this).parents('li');
			li.last('button').append('<img src="img/admin-ajax-indicator.gif" />')
			var referenceNumber = li.find('.referenceNumber').val();
			RespondToInvitation($(this).val(), referenceNumber);
		});
		
		$('.reservation').each(function(){
			var refNum = $(this).attr('referenceNumber');
			$(this).attachReservationPopup(refNum);
		});
	};


	function RespondToInvitation(action, referenceNumber) {
		$.ajax({
			url: 'participation.php',
			dataType: 'json',
			data: {ia: action, rn: referenceNumber, rs: options.responseType},
			success: function(data) {
				window.location.reload();
			}
		});
	};
}
