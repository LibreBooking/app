<!DOCTYPE html>
{*
Copyright 2011-2019 Nick Korbel

This file is part of Booked Scheduler.

Booked Scheduler is free software: you can redistribute it and/or modify
it under the terms of the GNU General Public License as published by
the Free Software Foundation, either version 3 of the License, or
(at your option) any later version.

Booked Scheduler is distributed in the hope that it will be useful,
but WITHOUT ANY WARRANTY; without even the implied warranty of
MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
GNU General Public License for more details.

You should have received a copy of the GNU General Public License
along with Booked Scheduler.  If not, see <http://www.gnu.org/licenses/>.
*}
<html lang="{$HtmlLang}" dir="{$HtmlTextDirection}">
<head>
    <title>{if $TitleKey neq ''}{translate key=$TitleKey args=$TitleArgs}{else}{$Title}{/if}</title>
    <meta http-equiv="Content-Type" content="text/html; charset={$Charset}"/>
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta name="robots" content="noindex"/>
    {if $ShouldLogout}
        <!--meta http-equiv="REFRESH"
			  content="{$SessionTimeoutSeconds};URL={$Path}logout.php?{QueryStringKeys::REDIRECT}={$smarty.server.REQUEST_URI|urlencode}"-->
    {/if}
    <link rel="shortcut icon" href="{$Path}{$FaviconUrl}"/>
    <link rel="icon" href="{$Path}{$FaviconUrl}"/>
    <!-- JavaScript -->
    {if $UseLocalJquery}
        {jsfile src="js/jquery-3.3.1.min.js"}
        {jsfile src="js/jquery-migrate-3.0.1.min.js"}
        {jsfile src="js/jquery-ui.1.12.1.custom.min.js"}
        {jsfile src="js/popper-1.14.7.min.js"}
        {jsfile src="js/bootstrap-4.3.1.min.js"}
    {else}
        <script
                src="https://code.jquery.com/jquery-3.3.1.min.js"
                integrity="sha256-FgpCb/KJQlLNfOu91ta32o/NMZxltwRo8QtmkMRdAu8="
                crossorigin="anonymous"></script>
        <script src="https://code.jquery.com/jquery-migrate-3.0.1.min.js"></script>
        <script
                src="https://code.jquery.com/ui/1.12.1/jquery-ui.min.js"
                integrity="sha256-VazP97ZCwtekAsvgPBSUwPFKdrwD3unUfSGVYrahUqU="
                crossorigin="anonymous"></script>
        <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.12.9/umd/popper.min.js"
                integrity="sha384-ApNbgh9B+Y1QKtv3Rn7W3mgPxhU9K/ScQsAP7hUibX39j7fakFPskvXusvfa0b4Q"
                crossorigin="anonymous"></script>
        <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/js/bootstrap.min.js"
                integrity="sha384-JjSmVgyd0p3pXB1rRibZUAYoIIy6OrQ6VrjIEaFf/nJGzIxFDsf4x0xIM+B07jRM"
                crossorigin="anonymous"></script>
    {/if}

    <!-- End JavaScript -->

    <!-- CSS -->
    {if $UseLocalJquery}
        {cssfile src="scripts/css/smoothness/jquery-ui.1.12.1.custom.min.css"}
        {cssfile src="css/font-awesome-4.7.0/css/font-awesome.min.css" rel="stylesheet"}
        {cssfile src="css/bootstrap-4.3.1.min.css" rel="stylesheet"}
        {if $Qtip}
            {cssfile src="css/jquery.qtip.min.css" rel="stylesheet"}
        {/if}
        {if $Validator}
            {cssfile src="css/bootstrapValidator.min.css" rel="stylesheet"}
        {/if}
        {if $InlineEdit}
            {cssfile src="scripts/js/x-editable/css/bootstrap-editable.css" rel="stylesheet"}
            {cssfile src="scripts/js/wysihtml5/bootstrap3-wysihtml5.min.css" rel="stylesheet"}
        {/if}

    {else}
        <link rel="stylesheet"
              href="https://code.jquery.com/ui/1.12.1/themes/smoothness/jquery-ui.css"
              type="text/css"/>
        <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css"
              type="text/css"/>
        <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css"
              integrity="sha384-ggOyR0iXCbMQv3Xipma34MD+dH/1fQ784/j6cY/iJTQUOhcWr7x9JvoRxT2MZw1T"
              crossorigin="anonymous">
        <link rel="stylesheet" href="https://cdn.jsdelivr.net/qtip2/3.0.3/jquery.qtip.min.css"
              type="text/css"/>
        {if $Validator}
            <link rel="stylesheet"
                  href="https://cdnjs.cloudflare.com/ajax/libs/jquery.bootstrapvalidator/0.5.3/css/bootstrapValidator.min.css"
                  type="text/css"/>
        {/if}
        {if $InlineEdit}
            <link rel="stylesheet"
                  href="https://cdnjs.cloudflare.com/ajax/libs/x-editable/1.5.1/bootstrap3-editable/css/bootstrap-editable.css"
                  type="text/css"/>
            {cssfile src="scripts/js/wysihtml5/bootstrap3-wysihtml5.min.css" rel="stylesheet"}
        {/if}
    {/if}
    {if $Select2}
        {cssfile src="scripts/css/select2/select2-4.0.5.min.css"}
        {*{cssfile src="scripts/css/select2/select2-bootstrap.min.css"}*}
    {/if}
    {if $Timepicker}
        {cssfile src="scripts/css/timePicker.css" rel="stylesheet"}
    {/if}
    {if $Fullcalendar}
        {cssfile src="scripts/css/fullcalendar.min.css"}
        <link rel='stylesheet' type='text/css' href='{$Path}scripts/css/fullcalendar.print.css' media='print'/>
    {/if}
    {if $Owl}
        {cssfile src="scripts/js/owl-2.2.1/assets/owl.carousel.min.css"}
        {cssfile src="scripts/js/owl-2.2.1/assets/owl.theme.default.css"}
    {/if}

    {jsfile src="js/jquery-ui-timepicker-addon.js"}
    {cssfile src="scripts/css/jquery-ui-timepicker-addon.css"}
    {cssfile src="booked.css"}
    {if $cssFiles neq ''}
        {assign var='CssFileList' value=','|explode:$cssFiles}
        {foreach from=$CssFileList item=cssFile}
            {cssfile src=$cssFile}
        {/foreach}
    {/if}
    {if $CssUrl neq ''}
        {cssfile src=$CssUrl}
    {/if}
    {if $CssExtensionFile neq ''}
        {cssfile src=$CssExtensionFile}
    {/if}

    {if $printCssFiles neq ''}
        {assign var='PrintCssFileList' value=','|explode:$printCssFiles}
        {foreach from=$PrintCssFileList item=cssFile}
            <link rel='stylesheet' type='text/css' href='{$Path}{$cssFile}' media='print'/>
        {/foreach}
    {/if}
    <!-- End CSS -->
</head>
<body {if $HideNavBar == true}style="padding-top:0;"{/if}>

{if $HideNavBar == false}
    <nav class="navbar navbar-expand-lg navbar-light bg-light {if $IsDesktop}fixed-top{else}adjust-nav-bar-static sticky-top{/if}"
         role="navigation">
        <a class="navbar-brand"
           href="{$HomeUrl}">{html_image src="$LogoUrl?{$Version}" alt="$Title" class="logo"}</a>
        <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#booked-navigation"
                aria-controls="booked-navigation"
                aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
        </button>
        <div class="collapse navbar-collapse" id="booked-navigation">
            <ul class="navbar-nav">
                {if $LoggedIn}
                    <li id="navDashboard" class="nav-item">
                        <a href="{$Path}{Pages::DASHBOARD}" class="nav-link">{translate key="Dashboard"}</a>
                    </li>
                    <li id="navMyAccountDropdown" class="nav-item dropdown">
                        <a class="nav-link dropdown-toggle" id="myAccountDropdownLink" href="#" class="dropdown-toggle"
                           data-toggle="dropdown"
                           aria-haspopup="true" aria-expanded="false">
                            {translate key="MyAccount"}
                        </a>
                        <div class="dropdown-menu" aria-labelledby="navMyAccountDropdownLink">
                            <a id="navProfile" class="dropdown-item"
                               href="{$Path}{Pages::PROFILE}">{translate key="Profile"}</a>
                            <a id="navPassword" class="dropdown-item"
                               href="{$Path}{Pages::PASSWORD}">{translate key="ChangePassword"}</a>

                            <a id="navNotification" class="dropdown-item"
                               href="{$Path}{Pages::NOTIFICATION_PREFERENCES}">{translate key="NotificationPreferences"}</a>
                            {if $ShowParticipation}
                                <a id="navInvitations" class="dropdown-item"
                                   href="{$Path}{Pages::PARTICIPATION}">{translate key="OpenInvitations"}</a>
                            {/if}
                            {if $CreditsEnabled}
                                <a id="navUserCredits" class="dropdown-item"
                                   href="{$Path}{Pages::CREDITS}">{translate key="Credits"}</a>
                            {/if}
                        </div>
                    </li>
                    <li id="navScheduleDropdown" class="nav-item dropdown">
                        <a class="nav-link dropdown-toggle" id="navScheduleDropdownLink" href="#" data-toggle="dropdown"
                           aria-haspopup="true"
                           aria-expanded="false">
                            {translate key="Schedule"}
                        </a>
                        <div class="dropdown-menu" aria-labelledby="navScheduleDropdownLink">
                            <a id="navBookings" class="dropdown-item" href="{$Path}{Pages::SCHEDULE}">
                                {translate key="Bookings"}
                            </a>
                            <a id="navMyCalendar" class="dropdown-item" href="{$Path}{Pages::MY_CALENDAR}">
                                {translate key="MyCalendar"}
                            </a>
                            <a id="navResourceCalendar" class="dropdown-item" href="{$Path}{Pages::CALENDAR}">
                                {translate key="ResourceCalendar"}
                            </a>
                            <a id="navFindATime" class="dropdown-item" href="{$Path}{Pages::OPENINGS}">
                                {translate key="FindATime"}
                            </a>
                            <a id="navFindATime" class="dropdown-item" href="{$Path}{Pages::SEARCH_RESERVATIONS}">
                                {translate key="SearchReservations"}
                            </a>
                        </div>
                    </li>
                    {if $CanViewAdmin}
                        <li id="navApplicationManagementDropdown" class="nav-item dropdown">
                            <a class="nav-link dropdown-toggle" id="navAppManagementDropdownLink" href="#"
                               class="dropdown-toggle"
                               data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                {translate key="ApplicationManagement"}
                            </a>
                            <div class="dropdown-menu" aria-labelledby="navAppManagementDropdownLink">
                                <a id="navManageReservations" class="dropdown-item"
                                   href="{$Path}admin/manage_reservations.php">
                                    {translate key="ManageReservations"}
                                </a>
                                <a id="navManageBlackouts" class="dropdown-item"
                                   href="{$Path}admin/manage_blackouts.php">
                                    {translate key="ManageBlackouts"}
                                </a>
                                <a id="navManageQuotas" class="dropdown-item" href="{$Path}admin/manage_quotas.php">
                                    {translate key="ManageQuotas"}
                                </a>
                                <div class="dropdown-divider"></div>
                                <a id="navManageSchedules" class="dropdown-item"
                                   href="{$Path}admin/manage_schedules.php">
                                    {translate key="ManageSchedules"}</a>
                                <a id="navManageResources" class="dropdown-item"
                                   href="{$Path}admin/manage_resources.php">
                                    {translate key="ManageResources"}
                                </a>
                                <a id="navManageAccessories" class="dropdown-item"
                                   href="{$Path}admin/manage_accessories.php">
                                    {translate key="ManageAccessories"}
                                </a>
                                <div class="dropdown-divider"></div>
                                <a id="navManageUsers" class="dropdown-item" href="{$Path}admin/manage_users.php">
                                    {translate key="ManageUsers"}
                                </a>
                                <a id="navManageGroups" class="dropdown-item" href="{$Path}admin/manage_groups.php">
                                    {translate key="ManageGroups"}
                                </a>
                                <a id="navManageAnnouncements" class="dropdown-item"
                                   href="{$Path}admin/manage_announcements.php">
                                    {translate key="ManageAnnouncements"}
                                </a>
                                <div class="dropdown-divider"></div>
                                {if $PaymentsEnabled}
                                    <a id="navManagePayments" class="dropdown-item"
                                       href="{$Path}admin/manage_payments.php">
                                        {translate key="ManagePayments"}
                                    </a>
                                {/if}
                                <a id="navManageAttributes" class="dropdown-item"
                                   href="{$Path}admin/manage_attributes.php">
                                    {translate key="CustomAttributes"}
                                </a>
                            </div>
                        </li>
                    {/if}
                    {if $CanViewResponsibilities}
                        <li id="navResponsibilitiesDropdown" class="nav-item dropdown">
                            <a class="nav-link dropdown-toggle" id="navResponsibilitiesDropdownLink" href="#"
                               class="dropdown-toggle"
                               data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                {translate key="Responsibilities"}
                            </a>

                            <div class="dropdown-menu" aria-labelledby="navResponsibilitiesDropdownLink">
                                {if $CanViewGroupAdmin}
                                    <a id="navResponsibilitiesGAUsers" class="dropdown-item"
                                       href="{$Path}admin/manage_group_users.php">
                                        {translate key="ManageUsers"}
                                    </a>
                                    <a id="navResponsibilitiesGAReservations" class="dropdown-item"
                                       href="{$Path}admin/manage_group_reservations.php">
                                        {translate key="GroupReservations"}
                                    </a>
                                    <a id="navResponsibilitiesGAGroups" class="dropdown-item"
                                       href="{$Path}admin/manage_admin_groups.php">
                                        {translate key="ManageGroups"}
                                    </a>
                                {/if}
                                {if $CanViewResourceAdmin || $CanViewScheduleAdmin}
                                    <a id="navResponsibilitiesRAResources" class="dropdown-item"
                                       href="{$Path}admin/manage_admin_resources.php">
                                        {translate key="ManageResources"}
                                    </a>
                                    <a id="navResponsibilitiesRABlackouts" class="dropdown-item"
                                       href="{$Path}admin/manage_blackouts.php">
                                        {translate key="ManageBlackouts"}
                                    </a>
                                {/if}
                                {if $CanViewResourceAdmin}
                                    <a id="navResponsibilitiesRAReservations" class="dropdown-item"
                                       href="{$Path}admin/manage_resource_reservations.php">
                                        {translate key="ResourceReservations"}
                                    </a>
                                {/if}
                                {if $CanViewScheduleAdmin}
                                    <a id="navResponsibilitiesSASchedules" class="dropdown-item"
                                       href="{$Path}admin/manage_admin_schedules.php">
                                        {translate key="ManageSchedules"}
                                    </a>
                                    <a id="navResponsibilitiesSAReservations" class="dropdown-item"
                                       href="{$Path}admin/manage_schedule_reservations.php">
                                        {translate key="ScheduleReservations"}
                                    </a>
                                {/if}
                                <a id="navResponsibilitiesAnnouncements" class="dropdown-item"
                                   href="{$Path}admin/manage_announcements.php">
                                    {translate key="ManageAnnouncements"}
                                </a>
                            </div>
                        </li>
                    {/if}
                    {if $CanViewReports}
                        <li id="navReportsDropdown" class="nav-item dropdown">
                            <a class="nav-link dropdown-toggle" id="navReportsDropdownLink" href="#"
                               class="dropdown-toggle"
                               data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                {translate key="Reports"}
                            </a>
                            <div class="dropdown-menu" aria-labelledby="navReportsDropdownLink">
                                <a id="navGenerateReport" class="dropdown-item"
                                   href="{$Path}reports/{Pages::REPORTS_GENERATE}">
                                    {translate key=GenerateReport}
                                </a>
                                <a id="navSavedReports" class="dropdown-item"
                                   href="{$Path}reports/{Pages::REPORTS_SAVED}">
                                    {translate key=MySavedReports}
                                </a>
                                <a id="navCommonReports" class="dropdown-item"
                                   href="{$Path}reports/{Pages::REPORTS_COMMON}">
                                    {translate key=CommonReports}
                                </a>
                            </div>
                        </li>
                    {/if}
                {/if}
            </ul>
            <ul class="navbar-nav text-right">
                {if $ShowScheduleLink}
                    <li id="navScheduleDropdown" class="nav-item dropdown">
                        <a class="nav-link dropdown-toggle" id="navRightScheduleDropdownLink" href="#"
                           class="dropdown-toggle" data-toggle="dropdown"
                           aria-haspopup="true" aria-expanded="false">
                            {translate key="Schedule"}
                        </a>
                        <div class="dropdown-menu" aria-labelledby="myRightScheduleDropdownLink">
                            <a id="navViewSchedule" class="dropdown-item" href="view-schedule.php">
                                {translate key='ViewSchedule'}
                            </a>
                            <a id="navViewCalendar" class="dropdown-item" href="view-calendar.php">
                                {translate key='ViewCalendar'}
                            </a>
                        </div>
                    </li>
                {/if}
                {if $CanViewAdmin}
                    <li id="navAdminDropdown" class="nav-item dropdown">
                        <a class="nav-link dropdown-toggle" id="navAdminDropdownLink" href="#" class="dropdown-toggle"
                           data-toggle="dropdown"
                           aria-haspopup="true" aria-expanded="false">
                            <span class="no-show">Configuration</span>
                            <span class="fa fa-cog"></span>
                            {if $ShowNewVersion}<span class="badge badge-new-version new-version"
                                                      id="newVersionBadge">{translate key=NewVersion}</span>{/if}
                        </a>
                        <div class="dropdown-menu" aria-labelledby="navAdminDropdownLink">
                            {if $EnableConfigurationPage}
                                <a id="navManageConfiguration" class="dropdown-item"
                                   href="{$Path}admin/manage_configuration.php">
                                    {translate key="ManageConfiguration"}
                                </a>
                            {/if}
                            <a id="navEmailTemplates" class="dropdown-item"
                               href="{$Path}admin/manage_email_templates.php">
                                {translate key="ManageEmailTemplates"}
                            </a>
                            <a id="navLookAndFeel" class="dropdown-item" href="{$Path}admin/manage_theme.php">
                                {translate key="LookAndFeel"}
                            </a>
                            <a id="navImport" class="dropdown-item" href="{$Path}admin/import.php">
                                {translate key="Import"}
                            </a>
                            <a id="navServerSettings" class="dropdown-item" href="{$Path}admin/server_settings.php">
                                {translate key="ServerSettings"}
                            </a>
                            <a id="navDataCleanup" class="dropdown-item" href="{$Path}admin/data_cleanup.php">
                                {translate key="DataCleanup"}
                            </a>
                            {if $ShowNewVersion}
                                <div class="dropdown-divider"></div>
                                <a id="navNewVersion" class="dropdown-item"
                                   href="https://www.bookedscheduler.com/whatsnew">
                                    {translate key=WhatsNew}
                                </a>
                            {/if}
                        </div>
                    </li>
                {/if}
                <li id="navHelpDropdown" class="nav-item dropdown">
                    <a class="nav-link dropdown-toggle" id="navHelpDropdownLink" href="#" class="dropdown-toggle"
                       data-toggle="dropdown"
                       aria-haspopup="true" aria-expanded="false">
                        {translate key="Help"}
                    </a>
                    <div class="dropdown-menu" aria-labelledby="navHelpDropdownLink">
                        <a id="navHelp" class="dropdown-item" href="{$Path}help.php">
                            {translate key=Help}
                        </a>
                        {if $CanViewAdmin}
                            <a id="navHelpAdmin" class="dropdown-item" href="{$Path}help.php?ht=admin">
                                {translate key=Administration}
                            </a>
                        {/if}
                        <a id="navAbout" class="dropdown-item" href="{$Path}help.php?ht=about">
                            {translate key=About}
                        </a>
                    </div>
                </li>
                {if $LoggedIn}
                    <li id="navSignOut" class="nav-item">
                        <a class="nav-link" href="{$Path}logout.php">
                            {translate key="SignOut"}
                        </a>
                    </li>
                {else}
                    <li id="navLogIn" class="nav-item">
                        <a class="nav-link" href="{$Path}index.php">
                            {translate key="LogIn"}
                        </a>
                    </li>
                {/if}
            </ul>
        </div>
    </nav>
{/if}

<div id="main" class="container-fluid">
