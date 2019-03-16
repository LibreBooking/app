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
    <meta name="viewport" content="width=device-width, initial-scale=1">
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
        {jsfile src="js/materialize-1.0.0.min.js"}
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
        <script src="https://cdnjs.cloudflare.com/ajax/libs/materialize/1.0.0/js/materialize.min.js"></script>
    {/if}

    <!-- End JavaScript -->

    <!-- CSS -->
    {if $UseLocalJquery}
        {cssfile src="css/fonts/roboto.css" }
        {cssfile src="scripts/css/smoothness/jquery-ui.1.12.1.custom.min.css"}
        {cssfile src="css/font-awesome-4.7.0/css/font-awesome.min.css"}
        {cssfile src="css/materialize-1.0.0.min.css"}
        {cssfile src="css/materialize/material-icons.css"}

        {if $Qtip}
            {cssfile src="css/jquery.qtip.min.css"}
        {/if}
        {if $Validator}
            {cssfile src="css/bootstrapValidator.min.css"}
        {/if}
        {if $InlineEdit}
            {cssfile src="scripts/js/x-editable/css/bootstrap-editable.css"}
            {cssfile src="scripts/js/wysihtml5/bootstrap3-wysihtml5.min.css"}
        {/if}

    {else}
        <link href="https://fonts.googleapis.com/css?family=Roboto" rel="stylesheet">
        <link rel="stylesheet"
              href="https://code.jquery.com/ui/1.12.1/themes/smoothness/jquery-ui.css"
              type="text/css"/>
        <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css"
              type="text/css"/>
        <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/materialize/1.0.0/css/materialize.min.css">
        <link href="https://fonts.googleapis.com/icon?family=Material+Icons" rel="stylesheet">
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

    {include file="Navbar/navbar-dropdowns.tpl" LoggedIn=$LoggedIn}
    {include file="Navbar/navbar-dropdowns.tpl" suffix="mobile" LoggedIn=$LoggedIn}

    <nav id="desktop-navigation" class="nav-content navbar-fixed-top" role="navigation">
        <div class="nav-wrapper">
            <a href="{$HomeUrl}" class="brand-logo">
                {html_image src="$LogoUrl?{$Version}" alt="$Title" class="logo"}
            </a>
            <a href="#" data-target="mobile-navigation" class="sidenav-trigger">
                <i class="material-icons">menu</i>
            </a>
            <ul class="hide-on-med-and-down">
                {include file="Navbar/navbar.tpl" LoggedIn=$LoggedIn}
                {if $LoggedIn}
                    <li id="navSignOut" class="right">
                        <a href="{$Path}logout.php">{translate key="SignOut"}</a>
                    </li>
                {else}
                    <li id="navLogIn" class="right">
                        <a href="{$Path}index.php">{translate key="LogIn"}</a>
                    </li>
                {/if}

                <li id="navHelpDropdown" class="right">
                    <a class="dropdown-trigger" href="#!" data-target="view-help-nav">
                        {translate key="Help"}<i class="material-icons right">arrow_drop_down</i>
                    </a>
                </li>

                {if $CanViewAdmin}
                    <li id="navHelpDropdown" class="right">
                        <a class="dropdown-trigger" href="#!" data-target="view-settings-nav">
                            <i class="material-icons {if $ShowNewVersion}new-version{/if}" id="newVersionBadge">settings</i>
                        </a>
                    </li>
                {/if}
                {if $ShowScheduleLink}
                    <li id="navScheduleDropdown" class="right">
                        <a class="dropdown-trigger" href="#!" data-target="view-schedule-nav">
                            {translate key="Schedule"}<i class="material-icons right">arrow_drop_down</i>
                        </a>
                    </li>
                {/if}
            </ul>
        </div>
    </nav>

    <ul class="sidenav" id="mobile-navigation">
        {include file="Navbar/navbar.tpl" suffix="mobile" LoggedIn=$LoggedIn}

        {if $ShowScheduleLink}
            <li id="navScheduleDropdown">
                <a class="dropdown-trigger" href="#!" data-target="view-schedule-navmobile">
                    {translate key="Schedule"}<i class="material-icons right">arrow_drop_down</i>
                </a>
            </li>
        {/if}

        {if $CanViewAdmin}
            <li id="navHelpDropdownmobile">
                <a class="dropdown-trigger" href="#!" data-target="view-settings-navmobile">
                    <i class="material-icons {if $ShowNewVersion}new-version{/if}" id="newVersionBadge">settings</i>
                </a>
            </li>
        {/if}

        <li id="navHelpDropdownmobile">
            <a class="dropdown-trigger" href="#!" data-target="view-help-navmobile">
                {translate key="Help"}<i class="material-icons right">arrow_drop_down</i>
            </a>
        </li>

        {if $LoggedIn}
            <li id="navSignOutmobile">
                <a href="{$Path}logout.php">{translate key="SignOut"}</a>
            </li>
        {else}
            <li id="navLogInmobile">
                <a href="{$Path}index.php">{translate key="LogIn"}</a>
            </li>
        {/if}
    </ul>
{/if}

<div id="main" class="container">
