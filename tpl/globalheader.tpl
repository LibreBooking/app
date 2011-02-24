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
@import url({$Path}css/nav.css);
@import url({$Path}css/style.css);

@import url({$Path}scripts/css/smoothness/jquery-ui-1.8.7.custom.css);
</style>

{literal}
<script type="text/javascript">
	function mainmenu(){
		$("#nav ul").css({display: "none"}); // Opera Fix
		$("#nav li").hover(
				function(){
					$(this).find('ul:first').css({visibility: "visible",display: "none"}).show(10);
				},
				function(){
					$(this).find('ul:first').css({visibility: "hidden"}).hide();
				});
	}
	
	 $(document).ready(function(){
		mainmenu();
	});
</script>
{/literal}
</head>
<body>
<div id="wrapper">
	<div id="doc">
		<div id="header">
		<div id="logo">phpScheduleIt</div>
		<ul id="nav" class="menubar">
		    <li class="menubaritem first"><a href="dashboard.php">Dashboard</a></li>
		    <li class="menubaritem"><a href="#">Users</a>
		    	<ul>
		    		<li class="menuitem"><a href="/reg-mini.php">Add user</a></li>
		    		<li class="menuitem"><a href="/user.php">Edit user details</a></li>
					<li class="menuitem"><a href="/user.php">Delete users</a></li>
		    	</ul>
		    </li>
		    <li class="menubaritem"><a href="schedule.php">Schedule</a>
		        <ul>
		            <li class="menuitem"><a href="/resource.php">Schedule 1</a></li>
					<li class="menuitem"><a href="/resource.php">Edit resource details</a></li>
					<li class="menuitem"><a href="/resource.php">Delete resources</a></li>
		        </ul>
		    </li>
		    <li class="menubaritem"><a href="#">Reservations</a>
		        <ul>
		            <li class="menuitem"><a href="/reservation.php?rid=1">New reservation</a></li>
					<li class="menuitem"><a href="/reservation.php?rid=1">Edit my reservations</a></li>
					<li class="menuitem"><a href="/reservation.php?rid=1">Edit group reservations</a></li>
					<li class="menuitem"><a href="/reservation.php?rid=1">Edit all reservations</a></li>
					<li class="menuitem"><a href="/reservation.php?rid=1">Delete reservations</a></li>
		        </ul>
		    </li>
		    <li class="menubaritem"><a href="#">Help</a></li>
		</ul>
		<!-- end #nav -->
		</div>
		<!-- end #header -->
		<div id="content">