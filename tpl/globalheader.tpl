<?xml version="1.0" encoding="{$Charset}"?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN"
        "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">
<html
	xmlns="http://www.w3.org/1999/xhtml" lang="en" xml:lang="en">
<!--<html xmlns="http:/www.w3.org/1999/xhtml" xml:lang="{$CurrentLanguage}" lang="{$CurrentLanguage}">-->
<head>
<title>{if $TitleKey neq ''}{translate key=$TitleKey args=$TitleArgs}{else}{$Title}{/if}</title>
<meta http-equiv="Content-Type" content="text/html; charset={$Charset}" />
{if $AllowRss && $LoggedIn}
<link rel="alternate" type="application/rss+xml" title="phpScheduleIt"
	href="{$ScriptUrl}/rss.php?id={$UserId}" />
{/if}
<link rel="shortcut icon" href="favicon.ico" />
<link rel="icon" href="favicon.ico" />
<script type="text/javascript"
	src="{$Path}scripts/js/jquery-1.4.4.min.js"></script>
<script type="text/javascript"
	src="{$Path}scripts/js/jquery-ui-1.8.7.custom.min.js"></script>
<script type="text/javascript" src="{$Path}scripts/phpscheduleit.js"></script>
<script type="text/javascript" src="{$Path}scripts/menubar.js"></script>
<style type="text/css">
@import url({$Path}css/style.css);

@import url({$Path}scripts/css/smoothness/jquery-ui-1.8.7.custom.css);
</style>
</head>
<body>
<div id="wrapper">
	<div id="doc">
		<div id="header"><!-- start #nav-main -->
			<div id="nav-main" class="menubar menubarnav">
				<div class="bd">
					<ul class="first">
						<li class="menubaritem" onmouseover="mopen('submenu1')" onmouseout="mclosetimer()">
							<a href="dashboard.php">Dashboard</a></li>
						<li class="menubaritem" onmouseover="mopen('submenu2')"
							onmouseout="mclosetimer()"><a href="/user-list.php">Users</a>
						<div class="menu" id="submenu2" onmouseover="mcancelclosetimer()">
						<ul>
							<li class="menuitem"><a href="/reg-mini.php">Add user</a></li>
							<li class="menuitem"><a href="/user.php">Edit user details</a></li>
							<li class="menuitem"><a href="/user.php">Delete users</a></li>
						</ul>
						</div>
						</li>
						<li class="menubaritem" onmouseover="mopen('submenu3')"
							onmouseout="mclosetimer()"><a href="/resource-list.php">Resources</a>
						<div class="menu" id="submenu3" onmouseover="mcancelclosetimer()">
						<ul>
							<li class="menuitem"><a href="/resource.php">Add resource</a></li>
							<li class="menuitem"><a href="/resource.php">Edit resource details</a></li>
							<li class="menuitem"><a href="/resource.php">Delete resources</a></li>
						</ul>
						</div>
						</li>
						<li class="menubaritem" onmouseover="mopen('submenu4')"
							onmouseout="mclosetimer()"><a href="/reservation.php?rid=1">Reservations</a>
						<div class="menu" id="submenu4" onmouseover="mcancelclosetimer()">
						<ul>
							<li class="menuitem"><a href="/reservation.php?rid=1">New reservation</a></li>
							<li class="menuitem"><a href="/reservation.php?rid=1">Edit my
							reservations</a></li>
							<li class="menuitem"><a href="/reservation.php?rid=1">Edit group
							reservations</a></li>
							<li class="menuitem"><a href="/reservation.php?rid=1">Edit all
							reservations</a></li>
							<li class="menuitem"><a href="/reservation.php?rid=1">Delete
							reservations</a></li>
						</ul>
						</div>
						</li>
						<li class="menubaritem" onmouseover="mopen('submenu5')"
							onmouseout="mclosetimer()"><a href="sched.php">Calendar</a>
						<div class="menu" id="submenu5" onmouseover="mcancelclosetimer()">
						<ul>
							<li class="menuitem"><a href="/calendar.php?uid=1">My calendar</a></li>
							<li class="menuitem"><a href="/calendar.php">All resources</a></li>
							<li class="separator">
							<hr />
							</li>
							<li class="menuitem"><a href="/calendar.php?rid=1">Resource 1</a></li>
							<li class="menuitem"><a href="/calendar.php?rid=2">Resource 2</a></li>
							<li class="menuitem"><a href="/calendar.php?rid=3">Resource 3</a></li>
							<li class="menuitem"><a href="/calendar.php?rid=4">Resource 4</a></li>
							<li class="menuitem"><a href="/calendar.php?rid=5">Resource 5</a></li>
						</ul>
						</div>
						</li>
						<li class="menubaritem" onmouseover="mopen('submenu6')"
							onmouseout="mclosetimer()"><a href="/reports.php">Reports</a>
						<div class="menu" id="submenu6" onmouseover="mcancelclosetimer()">
						<ul>
							<li class="menuitem"><a href="/reports.php">New report</a></li>
							<li class="menuitem"><a href="/report-history.php">Report history</a></li>
						</ul>
						</div>
						</li>
						<li class="menubaritem" onmouseover="mopen('submenu7')"
							onmouseout="mclosetimer()"><a href="/settings.php">Settings</a>
						<div class="menu" id="submenu7" onmouseover="mcancelclosetimer()">
						<ul>
							<li class="menuitem"><a href="/user-admin.php">User settings</a></li>
							<li class="menuitem"><a href="/resource-admin.php">Resource settings</a></li>
							<li class="menuitem"><a href="/schedule-admin.php">Scheduling settings</a></li>
							<li class="menuitem"><a href="/reg-admin.php">Registration settings</a></li>
						</ul>
						</div>
						</li>
					</ul>
				</div>
			</div>
			<!-- end #nav-main -->
		</div>
		<!-- end #header -->
		<div id="content">