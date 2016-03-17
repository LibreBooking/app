$.fn.attachReservationPopup = function (refNum, detailsUrl) {
	var me = $(this);
	if (detailsUrl == null)
	{
		detailsUrl = "ajax/respopup.php";
	}

	me.qtip({
		position: {
			my: 'bottom left', at: 'top left', effect: false, viewport: $(window), adjust: {
				mouse: 'flip'
			}
		},

		content: {
			text: function (event, api) {
				$.ajax({url: detailsUrl, data: {id: refNum}})
						.done(function (html) {
							api.set('content.text', html)
						})
						.fail(function (xhr, status, error) {
							api.set('content.text', status + ': ' + error)
						});

				return 'Loading...';
			}
		},

		show: {
			delay: 700, effect: false
		},

		hide: {
			fixed: true, delay: 500
		},

		style: {
			classes: 'qtip-light qtip-bootstrap'
		}
	});
};