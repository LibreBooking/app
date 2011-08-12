function Calendar(opts)
{
	Calendar.prototype.init = function()
	{
		$('.day, .today').hover(
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

		$('.week').hover(
			function() {
				$(this).addClass('hover');
				$(this).siblings('.day, .today').addClass('hover');
			},

			function() {
				$(this).removeClass('hover');
				$(this).siblings('.day, .today').removeClass('hover');
			}
		);

		$('.week').click(function() {
			window.location = $(this).attr('url');
		});
	}
}