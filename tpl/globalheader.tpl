<!DOCTYPE html>
<html lang="{$HtmlLang}" dir="{$HtmlTextDirection}">
<head>
    <title>{if isset($TitleKey) && $TitleKey neq ''}{translate key=$TitleKey args=$TitleArgs}{else}{$Title}{/if}</title>
    <meta http-equiv="Content-Type" content="text/html; charset={$Charset}"/>
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="robots" content="noindex"/>
    {if isset($ShouldLogout) && $ShouldLogout}
        <meta http-equiv="REFRESH"
			  content="{$SessionTimeoutSeconds};URL={$Path}logout.php?{QueryStringKeys::REDIRECT}={$smarty.server.REQUEST_URI|urlencode}" />
    {/if}
    <link rel="shortcut icon" href="{$Path}{$FaviconUrl}"/>
    <link rel="icon" href="{$Path}{$FaviconUrl}"/>
    <!-- JavaScript -->
    {if isset($UseLocalJquery) && $UseLocalJquery}
        {jsfile src="js/jquery-3.3.1.min.js"}
        {jsfile src="js/jquery-migrate-3.0.1.min.js"}
        {jsfile src="js/jquery-ui.1.12.1.custom.min.js"}
        {jsfile src="bootstrap/js/bootstrap.min.js"}
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
        <script type="text/javascript"
                src="https://netdna.bootstrapcdn.com/bootstrap/3.3.4/js/bootstrap.min.js"></script>
    {/if}

    <!-- End JavaScript -->

    <!-- CSS -->
    {if isset($UseLocalJquery) && $UseLocalJquery}
        {cssfile src="scripts/css/smoothness/jquery-ui.1.12.1.custom.min.css"}
        {cssfile src="css/font-awesome-4.7.0/css/font-awesome.min.css" rel="stylesheet"}
        {cssfile src="scripts/bootstrap/css/bootstrap.css" rel="stylesheet"}
        {if isset($Qtip) && $Qtip}
            {cssfile src="css/jquery.qtip.min.css" rel="stylesheet"}
        {/if}
        {if isset($Validator) && $Validator}
            {cssfile src="css/bootstrapValidator.min.css" rel="stylesheet"}
        {/if}
        {if isset($InlineEdit) && $InlineEdit}
            {cssfile src="scripts/js/x-editable/css/bootstrap-editable.css" rel="stylesheet"}
            {cssfile src="scripts/js/wysihtml5/bootstrap3-wysihtml5.min.css" rel="stylesheet"}
        {/if}

    {else}
        <link rel="stylesheet"
              href="https://code.jquery.com/ui/1.12.1/themes/smoothness/jquery-ui.css"
              type="text/css"/>
        <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css"
              type="text/css"/>
        <link rel="stylesheet" href="https://netdna.bootstrapcdn.com/bootstrap/3.3.4/css/bootstrap.min.css"
              type="text/css"/>
        <link rel="stylesheet" href="https://cdn.jsdelivr.net/qtip2/3.0.3/jquery.qtip.min.css"
              type="text/css"/>
        {if isset($Validator) && $Validator}
            <link rel="stylesheet"
                  href="https://cdnjs.cloudflare.com/ajax/libs/jquery.bootstrapvalidator/0.5.3/css/bootstrapValidator.min.css"
                  type="text/css"/>
        {/if}
        {if isset($InlineEdit) && $InlineEdit}
            <link rel="stylesheet"
                  href="https://cdnjs.cloudflare.com/ajax/libs/x-editable/1.5.1/bootstrap3-editable/css/bootstrap-editable.css"
                  type="text/css"/>
            {cssfile src="scripts/js/wysihtml5/bootstrap3-wysihtml5.min.css" rel="stylesheet"}
        {/if}
    {/if}
    {if isset($Select2) && $Select2}
        {cssfile src="scripts/css/select2/select2-4.0.5.min.css"}
        {*{cssfile src="scripts/css/select2/select2-bootstrap.min.css"}*}
    {/if}
    {if isset($Timepicker) && $Timepicker}
        {cssfile src="scripts/css/timePicker.css" rel="stylesheet"}
    {/if}
    {if isset($Fullcalendar) && $Fullcalendar}
        {cssfile src="scripts/css/fullcalendar.min.css"}
        <link rel='stylesheet' type='text/css' href='{$Path}scripts/css/fullcalendar.print.css' media='print'/>
    {/if}
    {if isset($Owl) && $Owl}
        {cssfile src="scripts/js/owl-2.2.1/assets/owl.carousel.min.css"}
        {cssfile src="scripts/js/owl-2.2.1/assets/owl.theme.default.css"}
    {/if}

    {jsfile src="js/jquery-ui-timepicker-addon.js"}
    {cssfile src="scripts/css/jquery-ui-timepicker-addon.css"}
    {cssfile src="booked.css"}
    {if isset($cssFiles) && $cssFiles neq ''}
        {assign var='CssFileList' value=','|explode:$cssFiles}
        {foreach from=$CssFileList item=cssFile}
            {cssfile src=$cssFile}
        {/foreach}
    {/if}
    {if isset($CssUrl) && $CssUrl neq ''}
        {cssfile src=$CssUrl}
    {/if}
    {if isset($CssExtensionFile) && $CssExtensionFile neq ''}
        {cssfile src=$CssExtensionFile}
    {/if}

    {if isset($printCssFiles) && $printCssFiles neq ''}
        {assign var='PrintCssFileList' value=','|explode:$printCssFiles}
        {foreach from=$PrintCssFileList item=cssFile}
            <link rel='stylesheet' type='text/css' href='{$Path}{$cssFile}' media='print'/>
        {/foreach}
    {/if}
    <!-- End CSS -->
</head>
<body {if isset($HideNavBar) && $HideNavBar == true}style="padding-top:0;"{/if}>

{if !isset($HideNavBar) || $HideNavBar == false}
    <nav class="navbar navbar-default {if isset($IsDesktop) && $IsDesktop}navbar-fixed-top{else}navbar-static-top adjust-nav-bar-static{/if}"
         role="navigation">
        <div class="container-fluid">
            <div class="navbar-header">
                <button type="button" class="navbar-toggle" data-toggle="collapse" data-target="#booked-navigation">
                    <span class="sr-only">Toggle navigation</span>
                    <span class="icon-bar"></span>
                    <span class="icon-bar"></span>
                    <span class="icon-bar"></span>
                </button>
                <a class="navbar-brand"
                   href="{$HomeUrl}">{html_image src="$LogoUrl?{$Version}" alt="$Title" class="logo"}</a>
            </div>
            <div class="collapse navbar-collapse" id="booked-navigation">
                <ul class="nav navbar-nav">
                    {if isset($LoggedIn) && $LoggedIn}
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
                                {if isset($ShowParticipation) && $ShowParticipation}
                                    <li id="navInvitations">
                                        <a href="{$Path}{Pages::PARTICIPATION}">{translate key="OpenInvitations"}</a>
                                    </li>
                                {/if}
                                {if isset($CreditsEnabled) && $CreditsEnabled}
                                    <li id="navUserCredits">
                                        <a href="{$Path}{Pages::CREDITS}">{translate key="Credits"}</a>
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
                                <li id="navFindATime"><a href="{$Path}{Pages::OPENINGS}">{translate key="FindATime"}</a>
                                </li>
                                <li id="navFindATime"><a
                                            href="{$Path}{Pages::SEARCH_RESERVATIONS}">{translate key="SearchReservations"}</a>
                                </li>
                            </ul>
                        </li>
                        <li class="dropdown" id="navReportsDropdown">
                            <a href="#" class="dropdown-toggle" data-toggle="dropdown">{translate key="Check"}<b
                                        class="caret"></b></a>
                            <ul class="dropdown-menu">
                                <li id="CheckResources">
                                    <a href="{$Path}view_resources.php">{translate key=Resources}</a>
                                </li>
                                <li id="CheckSchedules">
                                    <a href="{$Path}view_schedules.php">{translate key=Schedules}</a>
                                </li>
                            </ul>
                        </li>
                        {if isset($CanViewAdmin) && $CanViewAdmin}
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
                                    {if isset($PaymentsEnabled) && $PaymentsEnabled}
                                        <li id="navManagePayments"><a
                                                    href="{$Path}admin/manage_payments.php">{translate key="ManagePayments"}</a>
                                        </li>
                                    {/if}
                                    {*<li class="dropdown-header">{translate key=Customization}</li>*}
                                    <li id="navManageAttributes"><a
                                                href="{$Path}admin/manage_attributes.php">{translate key="CustomAttributes"}</a>
                                    </li>
                                </ul>
                            </li>
                        {/if}
                        {if isset($CanViewResponsibilities) && $CanViewResponsibilities}
                            <li class="dropdown" id="navResponsibilitiesDropdown">
                                <a href="#" class="dropdown-toggle"
                                   data-toggle="dropdown">{translate key="Responsibilities"} <b
                                            class="caret"></b></a>
                                <ul class="dropdown-menu">
                                    {if isset($CanViewGroupAdmin) && $CanViewGroupAdmin}
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
                                    {if (isset($CanViewResourceAdmin) && $CanViewResourceAdmin) || (isset($CanViewScheduleAdmin) && $CanViewScheduleAdmin)}
                                        <li id="navResponsibilitiesRAResources"><a
                                                    href="{$Path}admin/manage_admin_resources.php">{translate key="ManageResources"}</a>
                                        </li>
                                        <li id="navResponsibilitiesRABlackouts"><a
                                                    href="{$Path}admin/manage_blackouts.php">{translate key="ManageBlackouts"}</a>
                                        </li>
                                    {/if}
                                    {if isset($CanViewResourceAdmin) && $CanViewResourceAdmin}
                                        <li id="navResponsibilitiesRAReservations">
                                            <a href="{$Path}admin/manage_resource_reservations.php">{translate key="ResourceReservations"}</a>
                                        </li>
                                    {/if}
                                    {if isset($CanViewScheduleAdmin) && $CanViewScheduleAdmin}
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
                        {if isset($CanViewReports) && $CanViewReports}
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
                    {if isset($ShowScheduleLink) && $ShowScheduleLink}
                        <li class="dropdown" id="navScheduleDropdown">
                            <a href="#" class="dropdown-toggle" data-toggle="dropdown">{translate key="Schedule"} <b
                                        class="caret"></b></a>
                            <ul class="dropdown-menu">
                                <li id="navViewSchedule"><a href="view-schedule.php">{translate key='ViewSchedule'}</a>
                                </li>
                                <li id="navViewCalendar"><a href="view-calendar.php">{translate key='ViewCalendar'}</a>
                                </li>
                            </ul>
                        </li>
                    {/if}
                    {if isset($CanViewAdmin) && $CanViewAdmin}
                        <li class="dropdown" id="navHelpDropdown">
                            <a href="#" class="dropdown-toggle" data-toggle="dropdown">
                                <span class="no-show">Configuration</span>
                                <span class="fa fa-cog"></span>
                                <b class="caret"></b>
                                {if isset($ShowNewVersion) && $ShowNewVersion}<span class="badge badge-new-version new-version" id="newVersionBadge">{translate key=NewVersion}</span>{/if}
                            </a>
                            <ul class="dropdown-menu">
                                {if isset($EnableConfigurationPage) && $EnableConfigurationPage}
                                    <li id="navManageConfiguration"><a
                                                href="{$Path}admin/manage_configuration.php">{translate key="ManageConfiguration"}</a>
                                    </li>
                                {/if}
                                <li id="navEmailTemplates"><a
                                            href="{$Path}admin/manage_email_templates.php">{translate key="ManageEmailTemplates"}</a>
                                </li>
                                <li id="navLookAndFeel"><a
                                            href="{$Path}admin/manage_theme.php">{translate key="LookAndFeel"}</a>
                                </li>
                                <li id="navImport"><a href="{$Path}admin/import.php">{translate key="Import"}</a>
                                </li>
                                <li id="navServerSettings"><a
                                            href="{$Path}admin/server_settings.php">{translate key="ServerSettings"}</a>
                                </li>
                                <li id="navDataCleanup"><a
                                            href="{$Path}admin/data_cleanup.php">{translate key="DataCleanup"}</a>
                                </li>
                                {if isset($ShowNewVersion) && $ShowNewVersion}
                                    <li class="divider new-version"></li>
                                    <li id="navNewVersion" class="new-version">
                                        <a href="https://github.com/effgarces/BookedScheduler/releases">{translate key=WhatsNew}</a>
                                    </li>
                                {/if}
                            </ul>
                        </li>
                    {/if}
                    <li class="dropdown" id="navHelpDropdown">
                        <a href="#" class="dropdown-toggle" data-toggle="dropdown">{translate key="Help"} <b
                                    class="caret"></b></a>
                        <ul class="dropdown-menu">
                            <li id="navHelp"><a href="https://github.com/effgarces/BookedScheduler/wiki">{translate key=Help}</a></li>
                            {if isset($CanViewAdmin) && $CanViewAdmin}
                                <li id="navHelpAdmin"><a href="https://github.com/effgarces/BookedScheduler/wiki/Administration">{translate key=Administration}</a></li>
                            {/if}
                            <li id="navAbout"><a href="{$Path}help.php?ht=about">{translate key=About}</a></li>
                        </ul>
                    </li>
                    {if isset($LoggedIn) && $LoggedIn}
                        <li id="navSignOut"><a href="{$Path}logout.php">{translate key="SignOut"}</a></li>
                    {else}
                        <li id="navLogIn"><a href="{$Path}index.php">{translate key="LogIn"}</a></li>
                    {/if}
                </ul>
            </div>
        </div>
    </nav>
{/if}

<div id="main" class="container-fluid" {if isset($HideNavBar) && $HideNavBar}style="padding-bottom:0;"{/if}>
