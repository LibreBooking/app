<!DOCTYPE html>
{*
Copyright 2011-2017 Nick Korbel

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
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="robots" content="noindex"/>
    {if $ShouldLogout}
        <!--meta http-equiv="REFRESH"
			  content="{$SessionTimeoutSeconds};URL={$Path}logout.php?{QueryStringKeys::REDIRECT}={$smarty.server.REQUEST_URI|urlencode}"-->
    {/if}
    <link rel="shortcut icon" href="{$Path}favicon.ico"/>
    <link rel="icon" href="{$Path}favicon.ico"/>
    <!-- JavaScript -->
    {if $UseLocalJquery}
        {jsfile src="js/jquery-2.1.1.min.js"}
        {jsfile src="js/jquery-ui-1.10.4.custom.min.js"}
        {jsfile src="bootstrap/js/bootstrap.min.js"}
        {*{jsfile src="js/lodash.4.6.13.min.js"}*}
        {*{jsfile src="js/moment.min.js"}*}
        {*{jsfile src="js/jquery.form-3.09.min.js"}*}
        {*{jsfile src="js/jquery.blockUI-2.66.0.min.js"}*}
        {*{if $Qtip}*}
            {*{jsfile src="js/jquery.qtip.min.js"}*}
        {*{/if}*}
        {*{if $Validator}*}
            {*{jsfile src="js/bootstrapvalidator/bootstrapValidator.min.js"}*}
        {*{/if}*}
        {*{if $InlineEdit}*}
            {*{jsfile src="js/x-editable/js/bootstrap-editable.min.js"}*}
            {*{jsfile src="js/x-editable/wysihtml5/wysihtml5.js"}*}
            {*{jsfile src="js/wysihtml5/bootstrap3-wysihtml5.all.min.js"}*}
        {*{/if}*}
    {else}
        <script type="text/javascript"
                src="https://ajax.googleapis.com/ajax/libs/jquery/2.1.1/jquery.min.js"></script>
        <script type="text/javascript"
                src="https://ajax.googleapis.com/ajax/libs/jqueryui/1.10.4/jquery-ui.min.js"></script>
        <script type="text/javascript"
                src="https://netdna.bootstrapcdn.com/bootstrap/3.3.4/js/bootstrap.min.js"></script>
        {*<script type="text/javascript"*}
                {*src="https://cdn.jsdelivr.net/lodash/4.16.3/lodash.min.js"></script>*}
        {*<script type="text/javascript"*}
                {*src="https://cdnjs.cloudflare.com/ajax/libs/moment.js/2.13.0/moment.min.js"></script>*}
        {*<script type="text/javascript"*}
                {*src="https://cdnjs.cloudflare.com/ajax/libs/jquery.form/3.50/jquery.form.min.js"></script>*}
        {*<script type="text/javascript"*}
                {*src="https://cdnjs.cloudflare.com/ajax/libs/jquery.blockUI/2.66.0-2013.10.09/jquery.blockUI.min.js"></script>*}
        {*{if $Qtip}*}
            {*<script type="text/javascript"*}
                    {*src="https://cdn.jsdelivr.net/qtip2/3.0.3/jquery.qtip.min.js"></script>*}
        {*{/if}*}
        {*{if $Validator}*}
            {*<script type="text/javascript"*}
                    {*src="https://cdnjs.cloudflare.com/ajax/libs/jquery.bootstrapvalidator/0.5.3/js/bootstrapValidator.min.js"></script>*}
        {*{/if}*}

        {*{if $InlineEdit}*}
            {*<script type="text/javascript"*}
                    {*src="https://cdnjs.cloudflare.com/ajax/libs/x-editable/1.5.1/bootstrap3-editable/js/bootstrap-editable.min.js"></script>*}
            {*<script type="text/javascript"*}
                    {*src="https://cdnjs.cloudflare.com/ajax/libs/x-editable/1.5.1/inputs-ext/wysihtml5/wysihtml5.js"></script>*}
            {*{jsfile src="js/wysihtml5/bootstrap3-wysihtml5.all.min.js"}*}
        {*{/if}*}
    {/if}

    <!-- End JavaScript -->

    <!-- CSS -->
    {if $UseLocalJquery}
        {cssfile src="scripts/css/smoothness/jquery-ui-1.10.4.custom.min.css"}
        {cssfile src="css/font-awesome-4.7.0/css/font-awesome.min.css" rel="stylesheet"}
        {cssfile src="scripts/bootstrap/css/bootstrap.css" rel="stylesheet"}
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
              href="https://ajax.googleapis.com/ajax/libs/jqueryui/1.9.0/themes/smoothness/jquery-ui.css"
              type="text/css"/>
        <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css"
              type="text/css"/>
        <link rel="stylesheet" href="https://netdna.bootstrapcdn.com/bootstrap/3.3.4/css/bootstrap.min.css"
              type="text/css"/>
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
        {cssfile src="scripts/css/select2/select2.min.css"}
        {cssfile src="scripts/css/select2/select2-bootstrap.min.css"}
    {/if}
    {if $Timepicker}
        {cssfile src="scripts/css/timePicker.css" rel="stylesheet"}
    {/if}
    {if $Fullcalendar}
        {cssfile src="scripts/css/fullcalendar.min.css"}
        <link rel='stylesheet' type='text/css' href='scripts/css/fullcalendar.print.css' media='print'/>
        {*{jsfile src="js/fullcalendar.js"}*}
        {*{jsfile src="js/fullcalendarLang/$HtmlLang.js"}*}
    {/if}
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
<body>

{if $HideNavBar == false}
    <nav class="navbar navbar-default {if $IsDesktop}navbar-fixed-top{else}navbar-static-top adjust-nav-bar-static{/if}"
         role="navigation">
        <div class="container-fluid">
            <div class="navbar-header">
                <button type="button" class="navbar-toggle" data-toggle="collapse" data-target="#booked-navigation">
                    <span class="sr-only">Toggle navigation</span>
                    <span class="icon-bar"></span>
                    <span class="icon-bar"></span>
                    <span class="icon-bar"></span>
                </button>
                <a class="navbar-brand" href="{$HomeUrl}">{html_image src="$LogoUrl?{$Version}" alt="$Title" class="logo"}</a>
            </div>
            <div class="collapse navbar-collapse" id="booked-navigation">
                <ul class="nav navbar-nav">
                    {if $LoggedIn}
                        <li id="navDashboard"><a href="{$Path}{Pages::DASHBOARD}">{translate key="Dashboard"}</a></li>
                        <li class="dropdown" id="navMyAccountDropdown">
                            <a href="#" class="dropdown-toggle" data-toggle="dropdown">{translate key="MyAccount"} <b
                                        class="caret"></b></a>
                            <ul class="dropdown-menu">
                                <li id="navProfile"><a href="{$Path}{Pages::PROFILE}">{translate key="Profile"}</a></li>
                                <li id="navPassword"><a
                                            href="{$Path}{Pages::PASSWORD}">{translate key="ChangePassword"}</a></li>
                                <li id="navNotification">
                                    <a href="{$Path}{Pages::NOTIFICATION_PREFERENCES}">{translate key="NotificationPreferences"}</a>
                                </li>
                                {if $ShowParticipation && $AllowParticipation}
                                    <li id="navInvitations"><a
                                                href="{$Path}{Pages::PARTICIPATION}">{translate key="OpenInvitations"}</a>
                                    </li>
                                {/if}
                            </ul>
                        </li>
                        <li class="dropdown" id="navScheduleDropdown">
                            <a href="#" class="dropdown-toggle" data-toggle="dropdown">{translate key="Schedule"} <b
                                        class="caret"></b></a>
                            <ul class="dropdown-menu">
                                <li id="navBookings"><a href="{$Path}{Pages::SCHEDULE}">{translate key="Bookings"}</a>
                                </li>
                                <li id="navMyCalendar"><a
                                            href="{$Path}{Pages::MY_CALENDAR}">{translate key="MyCalendar"}</a></li>
                                <li id="navResourceCalendar"><a
                                            href="{$Path}{Pages::CALENDAR}">{translate key="ResourceCalendar"}</a></li>
                                <!--<li class="menuitem"><a href="#">{translate key="Current Status"}</a></li>-->
                                <li id="navFindATime"><a href="{$Path}{Pages::OPENINGS}">{translate key="FindATime"}</a></li>
                                <li id="navFindATime"><a href="{$Path}{Pages::SEARCH_RESERVATIONS}">{translate key="SearchReservations"}</a></li>
                            </ul>
                        </li>
                        {if $CanViewAdmin}
                            <li class="dropdown" id="navApplicationManagementDropdown">
                                <a href="#" class="dropdown-toggle"
                                   data-toggle="dropdown">{translate key="ApplicationManagement"}
                                    <b class="caret"></b></a>
                                <ul class="dropdown-menu">
                                    <li id="navManageReservations"><a
                                                href="{$Path}admin/manage_reservations.php">{translate key="ManageReservations"}</a>
                                    </li>
                                    <li id="navManageBlackouts"><a
                                                href="{$Path}admin/manage_blackouts.php">{translate key="ManageBlackouts"}</a>
                                    </li>
                                    <li id="navManageQuotas"><a
                                                href="{$Path}admin/manage_quotas.php">{translate key="ManageQuotas"}</a>
                                    </li>
                                    <li class="divider"></li>
                                    <li id="navManageSchedules"><a
                                                href="{$Path}admin/manage_schedules.php">{translate key="ManageSchedules"}</a>
                                    <li id="navManageResources"><a
                                                href="{$Path}admin/manage_resources.php">{translate key="ManageResources"}</a>
                                    </li>
                                    <li id="navManageAccessories"><a
                                                href="{$Path}admin/manage_accessories.php">{translate key="ManageAccessories"}</a>
                                    </li>

                                    <li class="divider"></li>
                                    <li id="navManageUsers"><a
                                                href="{$Path}admin/manage_users.php">{translate key="ManageUsers"}</a>
                                    </li>
                                    <li id="navManageGroups"><a
                                                href="{$Path}admin/manage_groups.php">{translate key="ManageGroups"}</a>
                                    </li>

                                    <li id="navManageAnnouncements"><a
                                                href="{$Path}admin/manage_announcements.php">{translate key="ManageAnnouncements"}</a>
                                    </li>
                                    <li class="divider"></li>
                                    {*<li class="dropdown-header">{translate key=Customization}</li>*}
                                    <li id="navManageAttributes"><a
                                                href="{$Path}admin/manage_attributes.php">{translate key="CustomAttributes"}</a>
                                    </li>
                                    {if $EnableConfigurationPage}
                                        <li id="navManageConfiguration"><a
                                                    href="{$Path}admin/manage_configuration.php">{translate key="ManageConfiguration"}</a>
                                        </li>
                                    {/if}
                                    <li id="navLookAndFeel"><a
                                                href="{$Path}admin/manage_theme.php">{translate key="LookAndFeel"}</a>
                                    </li>
                                    <li id="navImport"><a href="{$Path}admin/import.php">{translate key="Import"}</a>
                                    </li>
                                    <li id="navServerSettings"><a
                                                href="{$Path}admin/server_settings.php">{translate key="ServerSettings"}</a>
                                    </li>
                                </ul>
                            </li>
                        {/if}
                        {if $CanViewResponsibilities}
                            <li class="dropdown" id="navResponsibilitiesDropdown">
                                <a href="#" class="dropdown-toggle"
                                   data-toggle="dropdown">{translate key="Responsibilities"} <b
                                            class="caret"></b></a>
                                <ul class="dropdown-menu">
                                    {if $CanViewGroupAdmin}
                                        <li id="navResponsibilitiesGAUsers"><a
                                                    href="{$Path}admin/manage_group_users.php">{translate key="ManageUsers"}</a>
                                        </li>
                                        <li id="navResponsibilitiesGAReservations"><a
                                                    href="{$Path}admin/manage_group_reservations.php">{translate key="GroupReservations"}</a>
                                        </li>
                                        <li id="navResponsibilitiesGAGroups"><a
                                                    href="{$Path}admin/manage_admin_groups.php">{translate key="ManageGroups"}</a>
                                        </li>
                                    {/if}
                                    {if $CanViewResourceAdmin || $CanViewScheduleAdmin}
                                        <li id="navResponsibilitiesRAResources"><a
                                                    href="{$Path}admin/manage_admin_resources.php">{translate key="ManageResources"}</a>
                                        </li>
                                        <li id="navResponsibilitiesRABlackouts"><a
                                                    href="{$Path}admin/manage_blackouts.php">{translate key="ManageBlackouts"}</a>
                                        </li>
                                    {/if}
                                    {if $CanViewResourceAdmin}
                                        <li id="navResponsibilitiesRAReservations">
                                            <a href="{$Path}admin/manage_resource_reservations.php">{translate key="ResourceReservations"}</a>
                                        </li>
                                    {/if}
                                    {if $CanViewScheduleAdmin}
                                        <li id="navResponsibilitiesSASchedules">
                                            <a href="{$Path}admin/manage_admin_schedules.php">{translate key="ManageSchedules"}</a>
                                        </li>
                                        <li id="navResponsibilitiesSAReservations">
                                            <a href="{$Path}admin/manage_schedule_reservations.php">{translate key="ScheduleReservations"}</a>
                                        </li>
                                    {/if}
                                    <li id="navResponsibilitiesAnnouncements">
                                        <a href="{$Path}admin/manage_announcements.php">{translate key="ManageAnnouncements"}</a>
                                    </li>
                                </ul>
                            </li>
                        {/if}
                        {if $CanViewReports}
                            <li class="dropdown" id="navReportsDropdown">
                                <a href="#" class="dropdown-toggle" data-toggle="dropdown">{translate key="Reports"} <b
                                            class="caret"></b></a>
                                <ul class="dropdown-menu">
                                    <li id="navGenerateReport">
                                        <a href="{$Path}reports/{Pages::REPORTS_GENERATE}">{translate key=GenerateReport}</a>
                                    </li>
                                    <li id="navSavedReports">
                                        <a href="{$Path}reports/{Pages::REPORTS_SAVED}">{translate key=MySavedReports}</a>
                                    </li>
                                    <li id="navCommonReports">
                                        <a href="{$Path}reports/{Pages::REPORTS_COMMON}">{translate key=CommonReports}</a>
                                    </li>
                                </ul>
                            </li>
                        {/if}
                    {/if}

                </ul>
                <ul class="nav navbar-nav navbar-right">
                    {if $ShowScheduleLink}
                        <li class="dropdown" id="navScheduleDropdown">
                            <a href="#" class="dropdown-toggle" data-toggle="dropdown">{translate key="Schedule"} <b
                                        class="caret"></b></a>
                            <ul class="dropdown-menu">
                                <li id="navViewSchedule"><a href="view-schedule.php">{translate key='ViewSchedule'}</a></li>
                            </ul>
                        </li>
                    {/if}
                    <li class="dropdown" id="navHelpDropdown">
                        <a href="#" class="dropdown-toggle" data-toggle="dropdown">{translate key="Help"} <b
                                    class="caret"></b></a>
                        <ul class="dropdown-menu">
                            <li id="navHelp"><a href="{$Path}help.php">{translate key=Help}</a></li>
                            {if $CanViewAdmin}
                                <li id="navHelpAdmin"><a href="{$Path}help.php?ht=admin">{translate key=Administration}</a></li>{/if}
                            <li id="navAbout"><a href="{$Path}help.php?ht=about">{translate key=About}</a></li>
                        </ul>
                    </li>
                    {if $LoggedIn}
                        <li id="navSignOut"><a href="{$Path}logout.php">{translate key="SignOut"}</a></li>
                    {else}
                        <li id="navLogIn"><a href="{$Path}index.php">{translate key="LogIn"}</a></li>
                    {/if}
                </ul>
            </div>
        </div>
    </nav>
{/if}

<div id="main" class="container-fluid">
