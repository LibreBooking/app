<?xml version="1.0" encoding="{$Charset}"?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN"
		"http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="{$CurrentLanguage}" lang="{$CurrentLanguage}">
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
				<li id="dashboard" class="menubaritem"><a href="/dashboard.php">Dashboard</a>
			     	<div class="menu">
			       		<div class="bd">
			         		<ul>
								<li id="submenu_a" class="menuitem"><a href="/a/">Sub A</a></li>
								<li id="submenu_b" class="menuitem"><a href="/b/">Sub B</a></li>
								<li id="submenu_c" class="menuitem"><a href="/c/">Sub C</a></li>
							</ul>
			        	</div>
			      	</div>
				</li>
				<li id="resources" class="menubaritem"><a href="/resource.php">Resources</a>
			     	<div class="menu">
			        	<div class="bd">
			          		<ul>
								<li id="submenu_a" class="menuitem"><a href="/a/">Sub A</a></li>
								<li id="submenu_b" class="menuitem"><a href="/b/">Sub B</a></li>
								<li id="submenu_c" class="menuitem"><a href="/c/">Sub C</a></li>
							</ul>
			        	</div>
			      	</div>
				</li>
				<li id="users" class="menubaritem"><a href="/user-admin.php">Users</a>
			     	<div class="menu">
			        	<div class="bd">
			          		<ul>
								<li id="submenu_a" class="menuitem"><a href="/a/">Sub A</a></li>
								<li id="submenu_b" class="menuitem"><a href="/b/">Sub B</a></li>
								<li id="submenu_c" class="menuitem"><a href="/c/">Sub C</a></li>
							</ul>
			        	</div>
			      	</div>
				</li>
				<li id="reservations" class="menubaritem"><a href="/reservation.php">Reservations</a>
			      	<div class="menu">
			        	<div class="bd">
			          		<ul>
								<li id="submenu_a" class="menuitem"><a href="/a/">Sub A</a></li>
								<li id="submenu_b" class="menuitem"><a href="/b/">Sub B</a></li>
								<li id="submenu_c" class="menuitem"><a href="/c/">Sub C</a></li>
							</ul>
			        	</div>
			      	</div>
			  	</li>
				<li id="calendar" class="menubaritem"><a href="/calendar.php">Calendar</a>
			      	<div class="menu">
			        	<div class="bd">
			          		<ul>
								<li id="submenu_a" class="menuitem"><a href="/a/">Sub A</a></li>
								<li id="submenu_b" class="menuitem"><a href="/b/">Sub B</a></li>
								<li id="submenu_c" class="menuitem"><a href="/c/">Sub C</a></li>
								<li id="submenu_d" class="menuitem"><a href="/d/">Sub D</a></li>
								<li id="submenu_e" class="menuitem"><a href="/e/">Sub E</a></li>
								<li id="submenu_f" class="menuitem"><a href="/f/">Sub F</a></li>
							</ul>
			        	</div>
			      	</div>
			  	</li>
				<li id="settings" class="menubaritem"><a href="/settings.php">My Settings</a>
			      	<div class="menu">
			        	<div class="bd">
			          		<ul>
								<li id="submenu_a" class="menuitem"><a href="/a/">Sub A</a></li>
								<li id="submenu_b" class="menuitem"><a href="/b/">Sub B</a></li>
								<li id="submenu_c" class="menuitem"><a href="/c/">Sub C</a></li>
								<li id="submenu_d" class="menuitem"><a href="/d/">Sub D</a></li>
							</ul>
			        	</div>
			      	</div>
			    </li>
			</ul>
		   </div>
		  </div><!-- end #nav-main -->
		 </div><!-- end #header -->
	<div id="content">