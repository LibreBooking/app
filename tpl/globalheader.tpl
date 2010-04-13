<?xml version="1.0" encoding="{$Charset}"?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN"
        "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" lang="en" xml:lang="en">
<!--<html xmlns="http:/www.w3.org/1999/xhtml" xml:lang="{$CurrentLanguage}" lang="{$CurrentLanguage}">-->
	<head>
		<title>{$Title}</title>
		<meta http-equiv="Content-Type" content="text/html; charset={$Charset}" />
		{if $AllowRss && $LoggedIn}
			<link rel="alternate" type="application/rss+xml" title="phpScheduleIt" href="{$ScriptUrl}/rss.php?id={$UserId}" />
		{/if}
		<link rel="shortcut icon" href="favicon.ico"/>
		<link rel="icon" href="favicon.ico"/>
		<script type="text/javascript" src="{$Path}scripts/js/jquery-1.4.2.min.js"></script> 
		<script type="text/javascript" src="{$Path}scripts/js/jquery-ui-1.8rc3.custom.min.js"></script> 
		<script type="text/javascript" src="{$Path}scripts/phpscheduleit.js"></script> 
		<script type="text/javascript" src="{$Path}scripts/menubar.js"></script>
		<!-- FullCalendar content begins-->
		<link rel='stylesheet' type='text/css' href='{$Path}scripts/fullcalendar/fullcalendar.css' />
		<script type='text/javascript' src='{$Path}scripts/fullcalendar/jquery.js'></script>
		<script type='text/javascript' src='{$Path}scripts/fullcalendar/fullcalendar.js'></script>
		{literal}<script type='text/javascript'>

			$(document).ready(function() {

				var date = new Date();
				var d = date.getDate();
				var m = date.getMonth();
				var y = date.getFullYear();

				$('#calendar').fullCalendar({
					theme: true,
					axisFormat: 'H:mm', //24 hour clock in day view
					allDaySlot: false, //All day slot not visible
					firstDay: 1, //Week starts with Monday
					timeFormat: 
					{
					    // for agendaWeek and agendaDay
					    agenda: 'H:mm{ - H:mm}', // 15:30 - 16:30

					    // for all other views
					    '': 'H(:mm)'            // 5:30
					},
					header: {
						left: 'prev,next today',
						center: 'title',
						right: 'month,agendaWeek,agendaDay'
					},
					editable: true,
					events: [
						{
							title: 'All Day Event',
							start: new Date(y, m, d, 0,0),
							end: new Date(y, m, d, 24,0),
							allDay: false
						},
						{
							title: 'Long Event',
							start: new Date(y, m, d-5),
							end: new Date(y, m, d-2)
						},
						{
							id: 999,
							title: 'Repeating Event',
							start: new Date(y, m, d-3, 16, 0),
							end: new Date(y, m, d-3, 17, 0),
							allDay: false
						},
						{
							id: 999,
							title: 'Repeating Event',
							start: new Date(y, m, d+4, 16, 0),
							end: new Date(y, m, d+4, 17, 0),
							allDay: false
						},
						{
							title: 'Meeting',
							start: new Date(y, m, d, 10, 30),
							end: new Date(y, m, d, 12, 30),
							allDay: false
						},
						{
							title: 'Lunch',
							start: new Date(y, m, d, 12, 0),
							end: new Date(y, m, d, 14, 0),
							allDay: false
						},
						{
							title: 'Birthday Party',
							start: new Date(y, m, d+1, 19, 0),
							end: new Date(y, m, d+1, 22, 30),
							allDay: false
						},
						{
							title: 'Click for Google',
							start: new Date(y, m, 28),
							end: new Date(y, m, 29),
							url: 'http://google.com/'
						}
					]
				});
			});

		</script>{/literal}
		<!-- FullCalendar content ends-->
		<style type="text/css">
			@import url({$Path}css/style.css);
			@import url({$Path}scripts/css/smoothness/jquery-ui-1.8rc3.custom.css);
		</style>
	</head>
	<body>
		<div id="wrapper">
		<div id="doc">
		<div id="header">
		<!-- start #nav-main -->
		<div id="nav-main" class="menubar menubarnav">
		  <div class="bd">
		    <ul class="first">
				<li class="menubaritem" onmouseover="mopen('submenu1')" onmouseout="mclosetimer()"><a href="/dashboard.php">Dashboard</a>
			     	<!--<div class="menu" id="submenu1" onmouseover="mcancelclosetimer()">
			         	<ul>
							<li class="menuitem"><a href="/a/">Subitem A</a></li>
						</ul>
			      	</div>-->
				</li>
				<li class="menubaritem" onmouseover="mopen('submenu2')" onmouseout="mclosetimer()"><a href="/user-admin.php">Users</a>
			     	<div class="menu" id="submenu2" onmouseover="mcancelclosetimer()">
			          		<ul>
								<li class="menuitem"><a href="/reg-mini.php">Add new user</a></li>
								<li class="menuitem"><a href="/user.php">View user list</a></li>
								<li class="menuitem"><a href="/user.php">Edit user details</a></li>
								<li class="menuitem"><a href="/user.php">Delete users</a></li>
							</ul>
			      	</div>
				</li>
				<li class="menubaritem" onmouseover="mopen('submenu3')" onmouseout="mclosetimer()"><a href="/resource.php">Resources</a>
			     	<div class="menu" id="submenu3" onmouseover="mcancelclosetimer()">
			          	<ul>
							<li class="menuitem"><a href="/resource.php">Add new resourse</a></li>
							<li class="menuitem"><a href="/resource.php">View resource list</a></li>
							<li class="menuitem"><a href="/resource.php">Edit resource details</a></li>
							<li class="menuitem"><a href="/resource.php">Delete resources</a></li>
						</ul>
			      	</div>
				</li>
				<li class="menubaritem" onmouseover="mopen('submenu4')" onmouseout="mclosetimer()"><a href="/reservation.php">Reservations</a>
			      	<div class="menu" id="submenu4" onmouseover="mcancelclosetimer()">
			          		<ul>
								<li class="menuitem"><a href="/reservation.php?rid=1">Create new reservation</a></li>
								<li class="menuitem"><a href="/reservation.php?rid=1">Edit my reservations</a></li>
								<li class="menuitem"><a href="/reservation.php?rid=1">Edit group reservations</a></li>
								<li class="menuitem"><a href="/reservation.php?rid=1">Delete reservations</a></li>
							</ul>
			      	</div>
			  	</li>
				<li class="menubaritem" onmouseover="mopen('submenu5')" onmouseout="mclosetimer()"><a href="/calendar.php">Calendar</a>
			      	<div class="menu" id="submenu5" onmouseover="mcancelclosetimer()">
			          		<ul>
								<li class="menuitem"><a href="/calendar.php">Resource 1</a></li>
								<li class="menuitem"><a href="/calendar.php">Resource 2</a></li>
								<li class="menuitem"><a href="/calendar.php">Resource 3</a></li>
								<li class="menuitem"><a href="/calendar.php">Resource 4</a></li>
								<li class="menuitem"><a href="/calendar.php">Resource 5</a></li>
								<li class="menuitem"><a href="/calendar.php">All resources</a></li>
							</ul>
			      	</div>
			  	</li>
				<li class="menubaritem" onmouseover="mopen('submenu6')" onmouseout="mclosetimer()"><a href="/resource.php">Reports</a>
			     	<div class="menu" id="submenu6" onmouseover="mcancelclosetimer()">
			          	<ul>
							<li class="menuitem"><a href="/reports.php">Create new report</a></li>
							<li class="menuitem"><a href="/reports.php">View report history</a></li>
						</ul>
			      	</div>
				</li>
				<li class="menubaritem" onmouseover="mopen('submenu7')" onmouseout="mclosetimer()"><a href="/settings.php">Settings</a>
			      	<div class="menu" id="submenu7" onmouseover="mcancelclosetimer()">
			          		<ul>
								<li class="menuitem"><a href="/user-settings.php">Edit my settings</a></li>
								<li class="menuitem"><a href="/user-admin.php">Edit user settings</a></li>
								<li class="menuitem"><a href="/resource-admin.php">Edit resource settings</a></li>
								<li class="menuitem"><a href="/schedule-admin.php">Edit scheduling settings</a></li>
								<li class="menuitem"><a href="/reg-admin.php">Edit registration settings</a></li>
							</ul>
			      	</div>
			    </li>
			</ul>
		   </div>
		  </div><!-- end #nav-main -->
		 </div><!-- end #header -->
	<div id="content">