{*
Copyright 2013-2017 Nick Korbel

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

<div id="page-manage-accessories" class="admin-page">
    <h1>{translate key=LookAndFeel}</h1>

    <div id="successMessage" class="alert alert-success hidden">
        {translate key=ThemeUploadSuccess}
    </div>

    <form id="elementForm" action="{$smarty.server.SCRIPT_NAME}" ajaxAction="update" method="post" enctype="multipart/form-data">
        <div class="validationSummary alert alert-danger no-show" id="validationErrors">
            <ul>
                {async_validator id="logoFileExt"}
                {async_validator id="cssFileExt"}
                {async_validator id="logoFile"}
                {async_validator id="cssFile"}
            </ul>
        </div>

        <div>
            <h4>{translate key="Logo"} (*.png, *.gif, *.jpg - 50px height)</h4>

            <div>
                <a href="{$ScriptUrl}/img/{$LogoUrl}" download="{$ScriptUrl}/img/{$LogoUrl}">{$LogoUrl}</a>
                <a href="#" id="removeLogo">{translate key=Remove}</a>
            </div>
            <input type="file" {formname key=LOGO_FILE} class="pull-left"/>

            <a href="#" class="clearInput inline">{html_image src="cross-button.png"}</a>

        </div>
        <div>
            <div>
                <h4>{translate key="CssFile"} (*.css)</h4>

                <a href="{$ScriptUrl}/css/{$CssUrl}" download="{$ScriptUrl}/css/{$CssUrl}">{$CssUrl}</a>
            </div>
            <input type="file" {formname key=CSS_FILE} class="pull-left"/>
            <a href="#" class="clearInput">{html_image src="cross-button.png"}</a>
        </div>

        <div>
            <div>
                <h4>{translate key="ReservationColors"}</h4>

                <a href="manage_reservation_colors.php">{translate key=Manage}</a>
            </div>
        </div>

        <div class="clearfix"></div>

        <button type="button" class="btn btn-success update margin-top-25" name="{Actions::SAVE}" id="saveButton">
            {translate key='Update'}
        </button>

        {csrf_token}

    </form>


    <div id="wait-box" class="wait-box">
        <h3>{translate key=Working}</h3>
        {html_image src="reservation_submitting.gif"}
    </div>

    {jsfile src="ajax-helpers.js"}
    {jsfile src="js/jquery.form-3.09.min.js"}
    {jsfile src="js/ajaxfileupload.js"}
    {jsfile src="ajax-form-submit.js"}

    <script type="text/javascript">
        $('document').ready(function () {

            $('#elementForm').bindAjaxSubmit($('#saveButton'), $('#successMessage'), $('#wait-box'));
//
//            function successHandler(response)
//            {
//                hideModal();
//                $('#successMessage').show().delay(5000).fadeOut();
//            }
//
//            function hideModal()
//            {
//                $('#wait-box').hide();
//                $.unblockUI();
//            }
//
//            function showModal(formData, jqForm, opts)
//            {
//                $('#successMessage').hide();
//
//                $.blockUI({ message: $('#' +  $('#wait-box').attr('id'))});
//                $('#wait-box').show();
//
//                return true;
//            }
//
//            ConfigureUploadForm($('#saveButton'), function(){
//                return $('#elementForm').attr('action');
//            }, showModal, successHandler, null);

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
        });

    </script>

</div>
{include file='globalfooter.tpl'}