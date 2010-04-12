<?xml version="1.0" encoding="{$Charset}"?>
<!DOCTYPE html PUBLIC "-/*W3C/*DTD XHTML 1.0 Strict/*EN"
		"http:/*www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">
<html xmlns="http:/*www.w3.org/1999/xhtml" xml:lang="{$CurrentLanguage}" lang="{$CurrentLanguage}">
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
		<div id="nav-main" class="menubar menubarnav" role="navigation">
		  <div class="bd">
		    <ul class="first">
				<li id="dashboard" class="menubaritem" onmouseover="mopen('submenu1')" onmouseout="mclosetimer()"><a id="a1" href="/dashboard.php">Dashboard</a>
			     	<!--><div class="menu" id="submenu1" onmouseover="mcancelclosetimer()">
			         	<ul>
							<li class="menuitem"><a href="/a/">Subitem A</a></li>
						</ul>
			      	</div>-->
				</li>
				<li id="users" class="menubaritem" onmouseover="mopen('submenu2')" onmouseout="mclosetimer()"><a href="/user-admin.php">Users</a>
			     	<div class="menu" id="submenu2" onmouseover="mcancelclosetimer()">
			          		<ul>
								<li class="menuitem"><a href="/reg-mini.php">Add new user</a></li>
								<li class="menuitem"><a href="/user.php">View user list</a></li>
								<li class="menuitem"><a href="/user.php">View/Edit user details</a></li>
								<li class="menuitem"><a href="/user.php">Delete users</a></li>
							</ul>
			      	</div>
				</li>
				<li id="resources" class="menubaritem" onmouseover="mopen('submenu3')" onmouseout="mclosetimer()"><a href="/resource.php">Resources</a>
			     	<div class="menu" id="submenu3" onmouseover="mcancelclosetimer()">
			          	<ul>
							<li class="menuitem"><a href="/resource.php">Add new resourse</a></li>
							<li class="menuitem"><a href="/resource.php">View resource list</a></li>
							<li class="menuitem"><a href="/resource.php">View/Edit resource details</a></li>
							<li class="menuitem"><a href="/resource.php">Delete resources</a></li>
						</ul>
			      	</div>
				</li>
				<li id="reservations" class="menubaritem" onmouseover="mopen('submenu4')" onmouseout="mclosetimer()"><a href="/reservation.php">Reservations</a>
			      	<div class="menu" id="submenu4" onmouseover="mcancelclosetimer()">
			          		<ul>
								<li class="menuitem"><a href="/reservation.php?rid=1">Create new reservation</a></li>
								<li class="menuitem"><a href="/reservation.php?rid=1">View/Edit my reservations</a></li>
								<li class="menuitem"><a href="/reservation.php?rid=1">View/Edit group reservations</a></li>
								<li class="menuitem"><a href="/reservation.php?rid=1">Delete reservations</a></li>
							</ul>
			      	</div>
			  	</li>
				<li id="calendar" class="menubaritem" onmouseover="mopen('submenu5')" onmouseout="mclosetimer()"><a href="/calendar.php">Calendar</a>
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
				<li id="reports" class="menubaritem" onmouseover="mopen('submenu6')" onmouseout="mclosetimer()"><a href="/resource.php">Reports</a>
			     	<div class="menu" id="submenu6" onmouseover="mcancelclosetimer()">
			          	<ul>
							<li class="menuitem"><a href="/reports.php">Create new report</a></li>
							<li class="menuitem"><a href="/reports.php">View report history</a></li>
						</ul>
			      	</div>
				</li>
				<li id="settings" class="menubaritem" onmouseover="mopen('submenu7')" onmouseout="mclosetimer()"><a href="/settings.php">Settings</a>
			      	<div class="menu" id="submenu7" onmouseover="mcancelclosetimer()">
			          		<ul>
								<li class="menuitem"><a href="/user-settings.php">View/Edit my settings</a></li>
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