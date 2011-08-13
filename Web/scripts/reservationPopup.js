$.fn.attachReservationPopup = function(refNum, detailsUrl)
{
	if (detailsUrl == null)
	{
		detailsUrl = "ajax/respopup.php";
	}
	
	$(this).qtip({
		position:
		{
			  my: 'bottom left',
			  at: 'top left',
			  target: $(this)
		},

		content:
		{
			text: 'Loading...',
			ajax:
			{
				 url: detailsUrl,
				 type: 'GET',
				 data: { id: refNum },
				 dataType: 'html'
			}
		},

		show:
		{
			delay: 700
		}
	});
}