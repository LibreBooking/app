function Participation(opts)
{
	var options = opts;

	var elements = {
		invitationAction: $('.participationAction'),
		referenceNumber: $("#referenceNumber"),
		indicator: $('#indicator')
	};

	Participation.prototype.init = function() {
		elements.invitationAction.click(function() {
			elements.indicator.show();

			$.ajax({
				url: 'participation.php',
				dataType: 'json',
				data: {ia: $(this).val(), rn: elements.referenceNumber.val(), rs: options.responseType},
				success: function(data) {
					window.location.reload();
				}
			});
		});
	};
}
