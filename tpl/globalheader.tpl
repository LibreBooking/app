{*
Copyright 2011-2013 Nick Korbel

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
		xmlns="http://www.w3.org/1999/xhtml" lang="{$HtmlLang}" xml:lang="{$HtmlLang}" dir="{$HtmlTextDirection}">
<head>
	<title>{if $TitleKey neq ''}{translate key=$TitleKey args=$TitleArgs}{else}{$Title}{/if}</title>
	<meta http-equiv="Content-Type" content="text/html; charset={$Charset}"/>
	<meta name="robots" content="noindex" />
{if $ShouldLogout}
	<meta http-equiv="REFRESH" content="{$SessionTimeoutSeconds};URL={$Path}logout.php?{QueryStringKeys::REDIRECT}={$smarty.server.REQUEST_URI|urlencode}">
{/if}
	<link rel="shortcut icon" href="{$Path}favicon.ico"/>
	<link rel="icon" href="{$Path}favicon.ico"/>
	{if $UseLocalJquery}
		<script type="text/javascript" src="{$Path}scripts/js/jquery-1.8.2.min.js"></script>
		<script type="text/javascript" src="{$Path}scripts/js/jquery-ui-1.9.0.custom.min.js"></script>
	{else}
		<script type="text/javascript" src="//ajax.googleapis.com/ajax/libs/jquery/1.8.2/jquery.min.js"></script>
		<script type="text/javascript" src="//ajax.googleapis.com/ajax/libs/jqueryui/1.9.0/jquery-ui.min.js"></script>
	{/if}
	<script type="text/javascript" src="{$Path}scripts/phpscheduleit.js"></script>
	<script type="text/javascript" src="{$Path}scripts/menubar.js"></script>
	<style type="text/css">
		@import url({$Path}css/nav.css);
		@import url({$Path}css/style.css);
		{if $UseLocalJquery}
			@import url({$Path}scripts/css/smoothness/jquery-ui-1.9.0.custom.min.css);
		{else}
			@import url(//ajax.googleapis.com/ajax/libs/jqueryui/1.9.0/themes/smoothness/jquery-ui.css);
		{/if}
		{if $cssFiles neq ''}
			{assign var='CssFileList' value=','|explode:$cssFiles}
			{foreach from=$CssFileList item=cssFile}
			@import url({$Path}{$cssFile});
			{/foreach}
		{/if}
		@import url('{$Path}css/{$CssUrl}');
		{if $CssExtensionFile neq ''}
			@import url('{$CssExtensionFile}');
		{/if}
	</style>

	{if $printCssFiles neq ''}
		{assign var='PrintCssFileList' value=','|explode:$printCssFiles}
		{foreach from=$PrintCssFileList item=cssFile}
		<link rel='stylesheet' type='text/css' href='{$Path}{$cssFile}' media='print' />
		{/foreach}
	{/if}

	<script type="text/javascript">
		$(document).ready(function () {
		initMenu();
		});
	</script>
</head>
<body>
<div id="wrapper">
	<div id="doc">
		<div id="logo"><a href="{$HomeUrl}">{html_image src="$LogoUrl"}</a></div>
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
			{if $LoggedIn}
				<li class="menubaritem first"><a href="{$Path}{Pages::DASHBOARD}">{translate key="Dashboard"}</a></li>
				<li class="menubaritem"><a href="{$Path}{Pages::PROFILE}">{translate key="MyAccount"}</a>
					<ul>
						<li class="menuitem"><a href="{$Path}{Pages::PROFILE}">{translate key="Profile"}</a></li>
						<li class="menuitem"><a href="{$Path}{Pages::PASSWORD}">{translate key="ChangePassword"}</a></li>
						<li class="menuitem"><a href="{$Path}{Pages::NOTIFICATION_PREFERENCES}">{translate key="NotificationPreferences"}</a></li>
						<li class="menuitem"><a href="{$Path}{Pages::PARTICIPATION}">{translate key="OpenInvitations"}</a></li>
					</ul>
				</li>
				<li class="menubaritem"><a href="{$Path}{Pages::SCHEDULE}">{translate key="Schedule"}</a>
					<ul>
						<li class="menuitem"><a href="{$Path}{Pages::SCHEDULE}">{translate key="Bookings"}</a></li>
						<li class="menuitem"><a href="{$Path}{Pages::MY_CALENDAR}">{translate key="MyCalendar"}</a></li>
						<li class="menuitem"><a href="{$Path}{Pages::CALENDAR}">{translate key="ResourceCalendar"}</a></li>
						<!--<li class="menuitem"><a href="#">{translate key="Current Status"}</a></li>-->
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
										href="{$Path}admin/manage_blackouts.php">{translate key="ManageBlackouts"}</a></li>
							</ul>
						</li>
						<li class="menuitem"><a
								href="{$Path}admin/manage_schedules.php">{translate key="ManageSchedules"}</a></li>
						<li class="menuitem"><a
								href="{$Path}admin/manage_resources.php">{translate key="ManageResources"}</a>
							<ul>
								<li class="menuitem"><a
										href="{$Path}admin/manage_accessories.php">{translate key="ManageAccessories"}</a></li>
							</ul>
						</li>
						<li class="menuitem"><a href="{$Path}admin/manage_users.php">{translate key="ManageUsers"}</a></li>
						<li class="menuitem"><a href="{$Path}admin/manage_groups.php">{translate key="ManageGroups"}</a></li>
						<li class="menuitem"><a href="{$Path}admin/manage_quotas.php">{translate key="ManageQuotas"}</a></li>
						<li class="menuitem"><a href="{$Path}admin/manage_announcements.php">{translate key="ManageAnnouncements"}</a></li>
						<li class="menuitem"><a href="#">{translate key="Customization"}</a>
								<ul>
									<li class="menuitem"><a
											href="{$Path}admin/manage_attributes.php">{translate key="Attributes"}</a></li>
									{if $EnableConfigurationPage}<li class="menuitem"><a
											href="{$Path}admin/manage_configuration.php">{translate key="ManageConfiguration"}</a></li>
									{/if}
									<li class="menuitem"><a href="{$Path}admin/manage_theme.php">{translate key="LookAndFeel"}</a></li>
								</ul>
							</li>
						<li class="menuitem"><a href="{$Path}admin/server_settings.php">{translate key="ServerSettings"}</a></li>
					</ul>
				</li>
			{/if}
			{if $CanViewResponsibilities}
				<li class="menubaritem"><a href="#">{translate key=Responsibilities}</a>
					<ul>
						{if $CanViewGroupAdmin}
							<li class="menuitem"><a
									href="{$Path}admin/manage_group_users.php">{translate key="ManageUsers"}</a></li>
							<li class="menuitem"><a href="{$Path}admin/manage_group_reservations.php">{translate key=GroupReservations}</a>
							</li>
							<li class="menuitem"><a href="{$Path}admin/manage_admin_groups.php">{translate key="ManageGroups"}</a>

						{/if}
						{if $CanViewResourceAdmin || $CanViewScheduleAdmin}
							<li class="menuitem"><a href="{$Path}admin/manage_admin_resources.php">{translate key="ManageResources"}</a></li>
							<li class="menuitem"><a href="{$Path}admin/manage_blackouts.php">{translate key="ManageBlackouts"}</a></li>
						{/if}
						{if $CanViewResourceAdmin}
							<li class="menuitem"><a href="{$Path}admin/manage_resource_reservations.php">{translate key=ResourceReservations}</a></li>
						{/if}
						{if $CanViewScheduleAdmin}
							<li class="menuitem"><a href="{$Path}admin/manage_admin_schedules.php">{translate key="ManageSchedules"}</a></li>
							<li class="menuitem"><a href="{$Path}admin/manage_schedule_reservations.php">{translate key=ScheduleReservations}</a></li>
						{/if}
					</ul>
				</li>
			{/if}
			{if $CanViewReports}
			<li class="menubaritem"><a href="{$Path}reports/{Pages::REPORTS_GENERATE}">{translate key=Reports}</a>
				<ul>
					<li><a href="{$Path}reports/{Pages::REPORTS_GENERATE}">{translate key=GenerateReport}</a></li>
					<li><a href="{$Path}reports/{Pages::REPORTS_SAVED}">{translate key=MySavedReports}</a></li>
					<li><a href="{$Path}reports/{Pages::REPORTS_COMMON}">{translate key=CommonReports}</a></li>
				</ul>
			</li>
			{/if}
			{/if}
				<li class="menubaritem"><a href="{$Path}help.php">{translate key=Help}</a><ul>
					<li><a href="{$Path}help.php?ht=admin">{translate key=Administration}</a></li>
					<li><a href="{$Path}help.php?ht=about">{translate key=About}</a></li>
				</ul></li>
			</ul>
			<!-- end #nav -->
		</div>
		<!-- end #header -->
		<div id="content">