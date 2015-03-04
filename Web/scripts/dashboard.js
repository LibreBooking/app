function Dashboard(opts)
{
	var options = opts;
	
	Dashboard.prototype.init = function()
	{
		$(".dashboard").each(function() { 
			var id = $(this).attr('id');
			var visibility = readCookie(id);
			if (visibility == '0')
			{
				$(this).find('.dashboardContents').hide();
			}
			
			$(this).find('.dashboardHeader a').click(function() {
				var dashboard = $(this).parents('.dashboard').find('.dashboardContents');
				var id = dashboard.parent().attr('id');
				if (dashboard.css('display') == 'none')
				{
					createCookie(id,'1',30);
					dashboard.show();
				}
				else
				{
					createCookie(id,'0',30);
					dashboard.hide();
				}
			});
		});

		$('.resourceNameSelector').each(function ()
		{
			$(this).bindResourceDetails($(this).attr('resource-id'));
			$(this).click(function(e){
				e.preventDefault();
			});
		});

		$(".reservation").each(function() {
			var refNum = $(this).attr('id');

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
				         url: options.summaryPopupUrl,
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
			
			$(this).hover(
				 function () {
				    $(this).addClass('hover');
				  }, 
				  function () {
				    $(this).removeClass('hover');
				  }
			);
			
			$(this).mousedown(function() { 
				$(this).addClass('clicked'); 
			});
		    	
		    $(this).mouseup(function() { 
				$(this).removeClass('clicked'); 
			});
		    
		    $(this).click(function() {
		    	window.location = options.reservationUrl + refNum;
		    });
		})
	}
}