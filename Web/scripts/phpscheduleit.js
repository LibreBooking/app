// Cookie functions from http://www.quirksmode.org/js/cookies.html //
function createCookie(name, value, days) 
{
	if (days) 
	{
		var date = new Date();
		date.setTime(date.getTime()+(days*24*60*60*1000));
		var expires = "; expires="+date.toGMTString();
	}
	else 
	{
		var expires = "";
	}
	document.cookie = name+"="+value+expires+"; path=/";
}

function readCookie(name) 
{
	var nameEQ = name + "=";
	var ca = document.cookie.split(';');
	for (var i=0;i < ca.length;i++) 
	{
		var c = ca[i];
		while (c.charAt(0)==' ') 
		{
			c = c.substring(1,c.length);
		}
		if (c.indexOf(nameEQ) == 0) 
		{
			return c.substring(nameEQ.length,c.length);
		}
	}
	return null;
}

function eraseCookie(name) 
{
	createCookie(name,"",-1);
}

function initMenu()
{
	$("#nav ul").css({display: "none"}); // Opera Fix
	$("#nav li").hover(
			function(){
				$(this).find('ul:first').css({visibility: "visible",display: "none"}).show(10);
			},
			function(){
				$(this).find('ul:first').css({visibility: "hidden"}).hide();
			});
}