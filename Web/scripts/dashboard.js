function Dashboard(opts)
{
	var options = opts;
	
	Dashboard.prototype.init = function()
	{
		function setIcon(dash, targetIcon)
		{
			var iconSpan = dash.find('.dashboardHeader>a>span');
			iconSpan.removeClass('glyphicon-chevron-up');
			iconSpan.removeClass('glyphicon-chevron-down');
			iconSpan.addClass(targetIcon);
			console.log(dash);
		}

		$(".dashboard").each(function(i, v) {
			var dash = $(v);
			var id = dash.attr('id');
			var visibility = readCookie(id);
			if (visibility == '0')
			{
				dash.find('.dashboardContents').hide();
				setIcon(dash, 'glyphicon-chevron-down');
			}
			else
			{
				setIcon(dash, 'glyphicon-chevron-up');
			}
			
			dash.find('.dashboardHeader a').click(function(e) {
				e.preventDefault();
				var dashboard = dash.find('.dashboardContents');
				var id = dashboard.parent().attr('id');
				if (dashboard.css('display') == 'none')
				{
					createCookie(id,'1',30);
					dashboard.show();
					setIcon(dash, 'glyphicon-chevron-up');
				}
				else
				{
					createCookie(id,'0',30);
					dashboard.hide();
					setIcon(dash, 'glyphicon-chevron-down');
				}
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