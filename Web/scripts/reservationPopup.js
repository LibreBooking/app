$.fn.attachReservationPopup = function (refNum, detailsUrl)
{
	var me = $(this);
	if (detailsUrl == null)
	{
		detailsUrl = "ajax/respopup.php";
	}

	me.qtip({
		position:{
			my:'bottom left',
			at:'top left',
			target:false,
			viewport: $(window),
			effect:false
		},

		content:{
			text:'Loading...',
			ajax:{
				url:detailsUrl,
				type:'GET',
				data:{ id:refNum },
				dataType:'html'
			}
		},

		show:{
			delay:700,
			effect:false
		}
	});
}