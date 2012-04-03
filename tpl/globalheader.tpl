{*
Copyright 2011-2012 Nick Korbel

This file is part of phpScheduleIt.

phpScheduleIt is free software: you can redistribute it and/or modify
it under the terms of the GNU General Public License as published by
the Free Software Foundation, either version 3 of the License, or
(at your option) any later version.

phpScheduleIt is distributed in the hope that it will be useful,
but WITHOUT ANY WARRANTY; without even the implied warranty of
MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
GNU General Public License for more details.

You should have received a copy of the GNU General Public License
along with phpScheduleIt.  If not, see <http://www.gnu.org/licenses/>.
*}
<?xml version="1.0" encoding="{$Charset}"?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN"
		"http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">
<html
		xmlns="http://www.w3.org/1999/xhtml" lang="{$HtmlLang}" xml:lang="{$HtmlLang}">
<head>
	<title>{if $TitleKey neq ''}{translate key=$TitleKey args=$TitleArgs}{else}{$Title}{/if}</title>
	<meta http-equiv="Content-Type" content="text/html; charset={$Charset}"/>
{if $ShouldLogout}
	<meta http-equiv="REFRESH"
		  content="{$SessionTimeoutSeconds};URL={$Path}logout.php?{QueryStringKeys::REDIRECT}={$smarty.server.REQUEST_URI|urlencode}">
{/if}
	<link rel="shortcut icon" href="{$Path}favicon.ico"/>
	<link rel="icon" href="{$Path}favicon.ico"/>
	<script type="text/javascript" src="{$Path}scripts/js/jquery-1.7.1.min.js"></script>
	<script type="text/javascript" src="{$Path}scripts/js/jquery-ui-1.8.17.custom.min.js"></script>
	<script type="text/javascript" src="{$Path}scripts/js/jquery.watermark.min.js"></script>
	<script type="text/javascript" src="{$Path}scripts/phpscheduleit.js"></script>
	<script type="text/javascript" src="{$Path}scripts/menubar.js"></script>
	<style type="text/css">
		@import url({$Path}css/nav.css);
		@import url({$Path}css/style.css);
		@import url({$Path}scripts/css/smoothness/jquery-ui-1.8.17.custom.css);
		{if $cssFiles neq ''}
			{assign var='CssFileList' value=','|explode:$cssFiles}
			{foreach from=$CssFileList item=cssFile}
			@import url({$Path}{$cssFile});
			{/foreach}
		{/if}
		{if $CssExtensionFile neq ''}
			@import url('{$CssExtensionFile}');
		{/if}
	</style>

	<script type="text/javascript">
		$(document).ready(function () {
		initMenu();
		});
	</script>
</head>
<body>
<div id="wrapper">
	<div id="doc">
		<div id="logo">{html_image src="logo4.1.png"}</div>
		<div id="header">
			<div id="header-top">
				<div id="signout">
				{if $LoggedIn}
					{translate key="SignedInAs"} {$UserName}<br/><a
						href="{$Path}logout.php">{translate key="SignOut"}</a>
					{else}
					{translate key="NotSignedIn"}<br/>
					<a href="{$Path}index.php">{translate key="LogIn"}</a>
				{/if}
				</div>
			</div>
			<ul id="nav" class="menubar">
				<li class="menubaritem first"><a href="{$Path}{Pages::DASHBOARD}">{translate key="Dashboard"}</a></li>
				<li class="menubaritem"><a href="{$Path}{Pages::PROFILE}">{translate key="MyAccount"}</a>
					<ul>
						<li class="menuitem"><a href="{$Path}{Pages::PROFILE}">{translate key="Profile"}</a></li>
						<li class="menuitem"><a href="{$Path}{Pages::PASSWORD}">{translate key="ChangePassword"}</a>
						<li class="menuitem"><a href="{$Path}{Pages::NOTIFICATION_PREFERENCES}">{translate key="NotificationPreferences"}</a></li>

					</ul>
				</li>
				<li class="menubaritem"><a href="{$Path}{Pages::SCHEDULE}">{translate key="Schedule"}</a>
					<ul>
						<li class="menuitem"><a href="{$Path}{Pages::SCHEDULE}">{translate key="Bookings"}</a></li>
						<li class="menuitem"><a href="{$Path}{Pages::MY_CALENDAR}">{translate key="MyCalendar"}</a></li>
						<li class="menuitem"><a href="{$Path}{Pages::CALENDAR}">{translate key="ResourceCalendar"}</a>
						</li>
						<!--<li class="menuitem"><a href="#">{translate key="Current Status"}</a></li>-->
						<li class="menuitem"><a
								href="{$Path}{Pages::PARTICIPATION}">{translate key="OpenInvitations"}</a></li>
						<!--<li class="menuitem"><a href="{$Path}{Pages::OPENINGS}">{translate key="FindAnOpening"}</a></li>-->
					</ul>
				</li>
			{if $CanViewAdmin}
				<li class="menubaritem"><a href="#">{translate key=ApplicationManagement}</a>
					<ul>
						<li class="menuitem"><a
								href="{$Path}admin/manage_reservations.php">{translate key="ManageReservations"}</a>
							<ul>
								<li class="menuitem"><a
										href="{$Path}admin/manage_blackouts.php">{translate key="ManageBlackouts"}</a>
							</ul>
						</li>
						<li class="menuitem"><a
								href="{$Path}admin/manage_schedules.php">{translate key="ManageSchedules"}</a></li>
						<li class="menuitem"><a
								href="{$Path}admin/manage_resources.php">{translate key="ManageResources"}</a>
							<ul>
								<li class="menuitem"><a
										href="{$Path}admin/manage_accessories.php">{translate key="ManageAccessories"}</a>
							</ul>
						</li>
						<li class="menuitem"><a href="{$Path}admin/manage_users.php">{translate key="ManageUsers"}</a>
						</li>
						<li class="menuitem"><a href="{$Path}admin/manage_groups.php">{translate key="ManageGroups"}</a>
						<li class="menuitem"><a href="{$Path}admin/manage_quotas.php">{translate key="ManageQuotas"}</a>
						<li class="menuitem"><a
								href="{$Path}admin/manage_announcements.php">{translate key="ManageAnnouncements"}</a>
						<li class="menuitem"><a
								href="{$Path}admin/server_settings.php">{translate key="ServerSettings"}</a>
					</ul>
				</li>
			{/if}
			{if $CanViewResponsibilities}
				<li class="menubaritem"><a href="#">Responsibilities</a>
					<ul>
						{if $CanViewGroupAdmin}

							<li class="menuitem"><a
									href="{$Path}admin/manage_group_users.php">{translate key="ManageUsers"}</a></li>
							<li class="menuitem"><a href="{$Path}admin/manage_group_reservations.php">Group Reservations</a>
							</li>

						{/if}
						{if $CanViewResourceAdmin}
							<li class="menuitem"><a
									href="{$Path}admin/manage_admin_resources.php">{translate key="ManageResources"}</a></li>
							<li class="menuitem"><a href="{$Path}admin/manage_resource_reservations.php">Resource
								Reservations</a>
							</li>

						{/if}
					</ul>
				</li>
			{/if}
				<li class="menubaritem"><a href="{$Path}help.php">{translate key="Help"}</a></li>
			</ul>
			<!-- end #nav -->
		</div>
		<!-- end #header -->
		<div id="content">