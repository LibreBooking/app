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
			
		});
	}
}