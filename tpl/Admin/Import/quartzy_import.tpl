{*
Copyright 2017-2019 Nick Korbel

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

{include file='globalheader.tpl'}

<div id="page-import-quartzy" class="admin-page">

    <div class="default-box col-xs-12 col-sm-8 col-sm-offset-2">
        <h1>{translate key=ImportQuartzy}</h1>

        <div class="margin-bottom-25">

            <div id="importErrors" class="error hidden"></div>
            <div id="importResult" class="hidden">
                <span>{translate key=RowsImported}</span>

                <div id="importCount" class="inline bold"></div>
                <span>{translate key=RowsSkipped}</span>

                <div id="importSkipped" class="inline bold"></div>
                <a href="{$smarty.server.SCRIPT_NAME}">{translate key=Done}</a>
            </div>

            <form id="quartzyImportForm" method="post" enctype="multipart/form-data" ajaxAction="importQuartzy">
                <div class="validationSummary alert alert-danger no-show">
                    <ul>
                        {async_validator id="fileExtensionValidator" key=""}
                        {async_validator id="importQuartzyValidator" key=""}
                    </ul>
                </div>

                <div>
                    <label for="importFile" class="no-show">Import File</label>
                    <input type="file" name="quartzyFile" id="importFile"/>
                </div>

                <div>
                    <label for="includeBookings">Include Bookings</label>
                    <input type="checkbox" id="includeBookings" name="includeBookings"/>
                    <span>(this can take up to 20 minutes)</span>
                </div>

                <div class="admin-update-buttons">
                    <button id="btnUpload" type="button"
                            class="btn btn-success save"><i class="fa fa fa-upload"></i> {translate key=Import}</button>
                    {indicator}
                </div>
                {csrf_token}
            </form>
        </div>
        <div>
            <div class="alert alert-info">
                <div class="note">Export your Quartzy data <a
                            href="https://support.quartzy.com/hc/en-us/articles/214823208"
                            target="_new">following these instructions</a></div>
                <div class="note">Users will imported with the password <strong>p@ssw0rd!</strong></div>
            </div>
            <div class="alert alert-warning">Please do not make any changes to the Quartzy export file. Your data cannot
                be
                imported if this file is altered in any way.
            </div>
        </div>
    </div>
</div>


{include file="javascript-includes.tpl"}
{jsfile src="ajax-helpers.js"}
{jsfile src="js/jquery.form-3.09.min.js"}

<script type="text/javascript">
    $(document).ready(function () {

        var importForm = $('#quartzyImportForm');

        var defaultSubmitCallback = function (form) {
            return function () {
                return '{$smarty.server.SCRIPT_NAME}?action=' + form.attr('ajaxAction');
            };
        };

        var importHandler = function (responseText, form) {
            if (!responseText) {
                return;
            }

            $('#importCount').text(responseText.importCount);
            $('#importSkipped').text(responseText.skippedRows.length > 0 ? responseText.skippedRows.join(',') : '-');
            $('#importResult').show();

            var errors = $('#importErrors');
            errors.empty();
            if (responseText.messages && responseText.messages.length > 0) {
                var messages = responseText.messages.join('</li><li>');
                errors.html('<div>' + messages + '</div>').show();
            }
        };

        $('#btnUpload').click(function (e) {
            e.preventDefault();
            importForm.submit();
        });

        ConfigureAsyncForm(importForm, defaultSubmitCallback(importForm), importHandler);
    });
</script>

{include file='globalfooter.tpl'}