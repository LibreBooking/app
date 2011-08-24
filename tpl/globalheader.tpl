<?xml version="1.0" encoding="{$Charset}"?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN"
        "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">
<html
	xmlns="http://www.w3.org/1999/xhtml" lang="{$HtmlLang}" xml:lang="{$HtmlLang}">
<head>
<title>{if $TitleKey neq ''}{translate key=$TitleKey args=$TitleArgs}{else}{$Title}{/if}</title>
<meta http-equiv="Content-Type" content="text/html; charset={$Charset}" />
<link rel="shortcut icon" href="{$Path}favicon.ico" />
<link rel="icon" href="{$Path}favicon.ico" />
<script type="text/javascript" src="{$Path}scripts/js/jquery-1.4.4.min.js"></script>
<script type="text/javascript" src="{$Path}scripts/js/jquery-ui-1.8.7.custom.min.js"></script>
<script type="text/javascript" src="{$Path}scripts/js/jquery.watermark.min.js"></script>
<script type="text/javascript" src="{$Path}scripts/phpscheduleit.js"></script>
<script type="text/javascript" src="{$Path}scripts/menubar.js"></script>
<style type="text/css">
	@import url({$Path}css/nav.css);
	@import url({$Path}css/style.css);
	@import url({$Path}scripts/css/smoothness/jquery-ui-1.8.7.custom.css);
	{assign var='CssFileList' value=','|explode:$cssFiles}
	{foreach from=$CssFileList item=cssFile}
		@import url({$Path}{$cssFile});
	{/foreach}
</style>

<script type="text/javascript">	
	 $(document).ready(function() {
		 initMenu();
	});
</script>
</head>
<body>
<div id="wrapper">
	<div id="doc">
		<div id="header">
		<div id="logo">phpScheduleIt</div>
		<ul id="nav" class="menubar">
		    <li class="menubaritem first"><a href="{$Path}{Pages::DASHBOARD}">{translate key="Dashboard"}</a></li>
		    <li class="menubaritem"><a href="{$Path}{Pages::PROFILE}">{translate key="Account"}</a>
		    	<ul>
		    		<li class="menuitem"><a href="{$Path}{Pages::PROFILE}">{translate key="Profile"}</a></li>
		    		<li class="menuitem"><a href="#">{translate key="Email Preferences"}</a></li>
		    	</ul>
		    </li>
		    <li class="menubaritem"><a href="{$Path}{Pages::SCHEDULE}">{translate key="Schedule"}</a>
		        <ul>
		            <li class="menuitem"><a href="{$Path}{Pages::SCHEDULE}">{translate key="Bookings"}</a></li>
					<li class="menuitem"><a href="{$Path}{Pages::MY_CALENDAR}">{translate key="MyCalendar"}</a></li>
					<li class="menuitem"><a href="{$Path}{Pages::CALENDAR}">{translate key="ResourceCalendar"}</a></li>
					<li class="menuitem"><a href="#">{translate key="Current Status"}</a></li>
					<li class="menuitem"><a href="{$Path}{Pages::PARTICIPATION}">{translate key="OpenInvitations"}</a></li>
					<li class="menuitem"><a href="{$Path}{Pages::OPENINGS}">{translate key="FindAnOpening"}</a></li>
		        </ul>
		    </li>
			<!--
		    <li class="menubaritem"><a href="#">{translate key=Reservations}</a>
		        <ul>
		            <li class="menuitem"><a href="#">{translate key="My Upcoming Reservations"}</a></li>
			    <li class="menuitem"><a href="#">{translate key="Reservation Search"}</a></li>
			</ul>
		    </li>
		    -->
		    {if $CanViewAdmin}
		    <li class="menubaritem"><a href="#">{translate key=Admin}</a>
		        <ul>
		            <li class="menuitem"><a href="{$Path}admin/manage_schedules.php">{translate key="ManageSchedules"}</a></li>
					<li class="menuitem"><a href="{$Path}admin/manage_resources.php">{translate key="ManageResources"}</a></li>
					<li class="menuitem"><a href="{$Path}admin/manage_users.php">{translate key="ManageUsers"}</a>
						<ul>
							<li><a href="#">{translate key="Awaiting Activation"}</a></li>
						</ul>
					</li>
					<li class="menuitem"><a href="{$Path}admin/manage_groups.php">{translate key="ManageGroups"}</a>
					<li class="menuitem"><a href="{$Path}admin/manage_quotas.php">{translate key="ManageQuotas"}</a>
					<li class="menuitem"><a href="{$Path}admin/server_settings.php">{translate key="ServerSettings"}</a>
				</ul>
		    </li>
		    {/if}
		    <li class="menubaritem"><a href="#">{translate key="Help"}</a></li>
		    <li class="menubaritem"><a href="{$Path}logout.php">{translate key="SignOut"}</a></li>
		</ul>
		<!-- end #nav -->
		</div>
		<!-- end #header -->
		<div id="content">