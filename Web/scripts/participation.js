function Participation(opts)
{
	var options = opts;

	var elements = {
		invitationAction: $('.participationAction'),
		referenceNumber: $("#referenceNumber"),
		indicator: $('#indicator'),
		jsonResult: $('#jsonResult')
	};

	Participation.prototype.initReservation = function() {
		elements.invitationAction.click(function() {
			elements.indicator.show();
			RespondToInvitation($(this).val(), elements.referenceNumber.val(), $(this));
		});
	};

	Participation.prototype.initParticipation = function() {

		elements.invitationAction.click(function() {
			elements.jsonResult.hide();

			var li = $(this).parents('li');
			li.last('button').append(elements.indicator);
			elements.indicator.show();
			var referenceNumber = li.find('.referenceNumber').val();
			RespondToInvitation($(this).val(), referenceNumber, $(this));
		});
		
		$('.reservation').each(function(){
			var refNum = $(this).attr('referenceNumber');
			$(this).attachReservationPopup(refNum);
		});
	};


	function RespondToInvitation(action, referenceNumber, element) {
		$('#invite-error').remove();
		$.ajax({
			url: 'participation.php',
			dataType: 'json',
			data: {ia: action, rn: referenceNumber, rs: options.responseType},
			success: function(data) {
				if (data && data != null)
				{
					elements.indicator.hide();
					element.hide();
					element.after('<span class="error" id="invite-error">' + data + '</span>');
				}
				else{
					window.location.reload();
				}
			}
		});
	};
}
