function Calendar(opts)
{
	Calendar.prototype.init = function()
	{
		$('.fc-widget-content').hover(
			function() {
				$(this).addClass('hover');
			},
				
			function() {
				$(this).removeClass('hover');
			}
		);

		$('.day, .today').click(function() {
			window.location = $(this).attr('url');
		});

		$('.week').click(function() {
			window.location = $(this).attr('url');
		});

		$(".reservation").each(function() {
			var refNum = $(this).attr('refNum');
			$(this).attachReservationPopup(refNum);
		});
	};

	Calendar.prototype.dayClick = function(date)
	{
		var month =  date.getMonth()+1;
		window.location = 'my-calendar.php?&ct=day&y=' + date.getFullYear() + '&m=' + month + '&d=' + date.getDate();
	}

}