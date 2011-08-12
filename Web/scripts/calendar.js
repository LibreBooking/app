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
			alert($(this).attr('day'));
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
			alert($(this).attr('week'));
		});
	}
}