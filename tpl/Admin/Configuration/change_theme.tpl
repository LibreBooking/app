{*
Copyright 2013-2020 Nick Korbel

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
{include file='globalheader.tpl' }

<div id="page-change-theme" class="admin-page">
    <div class="default-box col-xs-12 col-sm-8 col-sm-offset-2">

        <h1>{translate key=LookAndFeel}</h1>

        <div id="successMessage" class="alert alert-success hidden">
            {translate key=ThemeUploadSuccess}
        </div>

        <form id="elementForm" action="{$smarty.server.SCRIPT_NAME}" ajaxAction="update" method="post"
              enctype="multipart/form-data">
            <div class="validationSummary alert alert-danger no-show" id="validationErrors">
                <ul>
                    {async_validator id="logoFileExt"}
                    {async_validator id="cssFileExt"}
                    {async_validator id="faviconFileExt"}
                    {async_validator id="logoFile"}
                    {async_validator id="cssFile"}
                    {async_validator id="faviconFile"}
                </ul>
            </div>

            <div>
                <h4>{translate key="Logo"} (*.png, *.gif, *.jpg - 50px height)</h4>

                <div>
                    <a href="{$ScriptUrl}/img/{$LogoUrl}" download="{$ScriptUrl}/img/{$LogoUrl}">{$LogoUrl}</a>
                    <a href="#" id="removeLogo">{translate key=Remove}</a>
                </div>
                <label for="logoFile" class="no-show">Logo File</label>
                <input type="file" {formname key=LOGO_FILE} class="pull-left" id="logoFile"/>

                <a href="#" class="clearInput inline"><span class="no-show">{translate key=Delete}</span>{html_image src="cross-button.png"}</a>
            </div>

            <div>
                <h4>Favicon (*.ico, *.png, *.gif, *.jpg - 32px x 32px or 16px x 16px)</h4>

                <div>
                    <a href="{$ScriptUrl}/{$FaviconUrl}" download="{$ScriptUrl}/img/{$FaviconUrl}">{$FaviconUrl}</a>
                    <a href="#" id="removeFavicon">{translate key=Remove}</a>
                </div>
                <label for="faviconFile" class="no-show">Favicon File</label>
                <input type="file" {formname key=FAVICON_FILE} class="pull-left" id="faviconFile"/>

                <a href="#" class="clearInput inline"><span class="no-show">{translate key=Delete}</span>{html_image src="cross-button.png"}</a>
            </div>

            <div>
                <div>
                    <h4>{translate key="CssFile"} (*.css)</h4>

                    <a href="{$ScriptUrl}/css/{$CssUrl}" download="{$ScriptUrl}/css/{$CssUrl}">{$CssUrl}</a>
                </div>
                <label for="cssFile" class="no-show">CSS File</label>
                <input type="file" {formname key=CSS_FILE} class="pull-left" id="cssFile"/>
                <a href="#" class="clearInput"><span class="no-show">{translate key=Delete}</span>{html_image src="cross-button.png"}</a>
            </div>

            <div class="clearfix"></div>

            <button type="button" class="btn btn-success update margin-top-25" name="{Actions::SAVE}" id="saveButton">
                {translate key='Update'}
            </button>

            {csrf_token}

        </form>

    </div>

    <div id="wait-box" class="wait-box">
        <h3>{translate key=Working}</h3>
        {html_image src="reservation_submitting.gif"}
    </div>

    {include file="javascript-includes.tpl"}

    {jsfile src="ajax-helpers.js"}
    {jsfile src="js/jquery.form-3.09.min.js"}
    {jsfile src="js/ajaxfileupload.js"}
    {jsfile src="ajax-form-submit.js"}

    <script type="text/javascript">
        $('document').ready(function () {

            $('#elementForm').bindAjaxSubmit($('#saveButton'), $('#successMessage'), $('#wait-box'));

            $('.clearInput').click(function (e) {
                e.preventDefault();
                $(this).prev('input').val('');
            });

            $('#removeLogo').click(function (e) {
                e.preventDefault();

                PerformAsyncAction($(this), function () {
                    return '{$smarty.server.SCRIPT_NAME}?action=removeLogo';
                });
            });

            $('#removeFavicon').click(function (e) {
                e.preventDefault();

                PerformAsyncAction($(this), function () {
                    return '{$smarty.server.SCRIPT_NAME}?action=removeFavicon';
                });
            });
        });

    </script>

</div>
{include file='globalfooter.tpl'}