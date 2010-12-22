$(document).ready(function() {

	$('.reserved').each(function() { 
		var resid = $(this).attr('id').split('|')[0];
		var pattern = 'td[id^=' + resid + '|]';

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
			         url: 'respopup.php',
			         type: 'GET',
			         data: { id: resid },
			         dataType: 'html'
		      	}
			}
		});
		
		$(this).hover(
			function () { $(pattern).addClass('hilite'); }, 
		    function () { $(pattern).removeClass('hilite'); }
		);
		
		$(this).click(function() {
			alert('redirect to resid' + resid);
		});
	});
	
	$('.clickres')
    	.mousedown(
    		function () { $(this).addClass('clicked'); }
    	)
    	.mouseup(
    		function () { $(this).removeClass('clicked'); }
   	);
    
	$('.clickres').hover(
	    function () { $(this).addClass('hilite'); }, 
	    function () { $(this).removeClass('hilite'); }
	);
	
	$("div:not(#schedule_list)").click(function () {
	 	$("#schedule_list").hide();
	 });
  });
 
  function ShowScheduleList()
  {
  	$("#schedule_list").toggle();
  }
  
  function dpDateChanged(dateText, inst)
  {
  	ChangeDate(inst.selectedYear, inst.selectedMonth+1, inst.selectedDay);
  }
  
  function ChangeDate(year, month, day)
  {
  	RedirectToSelf("sd", /sd=\d{4}-\d{1,2}-\d{1,2}/i, "sd=" + year + "-" + month + "-" + day);
  }
  
  function ChangeSchedule(scheduleId)
  {
  	RedirectToSelf("sid", /sid=\d+/i, "sid=" + scheduleId);
  }
  
  function RedirectToSelf(queryStringParam, regexMatch, substitution)
  {
  	var url = window.location.href;
  	var newUrl = window.location.href;
  	
  	if (url.indexOf(queryStringParam + "=") != -1)
  	{
  	 	newUrl = url.replace(regexMatch, substitution);
  	}
  	else if (url.indexOf("?") != -1)
  	{
  		newUrl = url + "&" + substitution;
  	}
  	else
  	{
  		newUrl = url + "?" + substitution;
  	}
  	
  	newUrl = newUrl.replace("#", "");
  	
  	window.location = newUrl;
  }
  
  function CreateReservation($resourceId)
  {
	  window.location = 'reservation.php';
  }