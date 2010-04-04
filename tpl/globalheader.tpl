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
			     	<div class="menu" id="submenu1" onmouseover="mcancelclosetimer()">
			         	<ul>
							<li class="menuitem"><a href="/a/">Sub A</a></li>
							<li class="menuitem"><a href="/b/">Sub B</a></li>
							<li class="menuitem"><a href="/c/">Sub C</a></li>
						</ul>
			      	</div>
				</li>
				<li id="resources" class="menubaritem" onmouseover="mopen('submenu2')" onmouseout="mclosetimer()"><a href="/resource.php">Resources</a>
			     	<div class="menu" id="submenu2" onmouseover="mcancelclosetimer()">
			          	<ul>
							<li class="menuitem"><a href="/a/">Add new resourse</a></li>
							<li class="menuitem"><a href="/b/">Edit resource details</a></li>
							<li class="menuitem"><a href="/c/">Edit resource quotas</a></li>
							<li class="menuitem"><a href="/d/">Edit resource constraints</a></li>
						</ul>
			      	</div>
				</li>
				<li id="users" class="menubaritem" onmouseover="mopen('submenu3')" onmouseout="mclosetimer()"><a href="/user-admin.php">Users</a>
			     	<div class="menu" id="submenu3" onmouseover="mcancelclosetimer()">
			          		<ul>
								<li class="menuitem"><a href="/a/">Add new user</a></li>
								<li class="menuitem"><a href="/b/">Edit user details</a></li>
								<li class="menuitem"><a href="/c/">Delete user</a></li>
							</ul>
			      	</div>
				</li>
				<li id="reservations" class="menubaritem" onmouseover="mopen('submenu4')" onmouseout="mclosetimer()"><a href="/reservation.php">Reservations</a>
			      	<div class="menu" id="submenu4" onmouseover="mcancelclosetimer()">
			          		<ul>
								<li class="menuitem"><a href="/a/">Create new reservation</a></li>
								<li class="menuitem"><a href="/b/">Edit reservations</a></li>
								<li class="menuitem"><a href="/b/">Delete reservations</a></li>
							</ul>
			      	</div>
			  	</li>
				<li id="calendar" class="menubaritem" onmouseover="mopen('submenu5')" onmouseout="mclosetimer()"><a href="/calendar.php">Calendar</a>
			      	<div class="menu" id="submenu5" onmouseover="mcancelclosetimer()">
			          		<ul>
								<li id="submenu_5a" class="menuitem"><a href="/a/">View calendar</a></li>
								<li id="submenu_5b" class="menuitem"><a href="/b/">Sub B</a></li>
								<li id="submenu_5c" class="menuitem"><a href="/c/">Sub C</a></li>
								<li id="submenu_5d" class="menuitem"><a href="/d/">Sub D</a></li>
								<li id="submenu_5e" class="menuitem"><a href="/e/">Sub E</a></li>
								<li id="submenu_5f" class="menuitem"><a href="/f/">Sub F</a></li>
							</ul>
			      	</div>
			  	</li>
				<li id="settings" class="menubaritem" onmouseover="mopen('submenu6')" onmouseout="mclosetimer()"><a href="/settings.php">My Settings</a>
			      	<div class="menu" id="submenu6" onmouseover="mcancelclosetimer()">
			          		<ul>
								<li id="submenu_6a" class="menuitem"><a href="/a/">View my settings</a></li>
								<li id="submenu_6b" class="menuitem"><a href="/b/">Edit my settings</a></li>
							</ul>
			      	</div>
			    </li>
			</ul>
		   </div>
		  </div><!-- end #nav-main -->
		 </div><!-- end #header -->
	<div id="content">