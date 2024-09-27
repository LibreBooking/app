{if isset($UseLocalJquery) && $UseLocalJquery}
    {*{jsfile src="js/jquery-2.1.1.min.js"}*}
    {*{jsfile src="js/jquery-ui-1.10.4.custom.min.js"}*}
    {*{jsfile src="bootstrap/js/bootstrap.min.js"}*}
    {jsfile src="js/lodash.4.6.13.min.js"}
    {jsfile src="js/moment.min.js"}
    {jsfile src="js/jquery.form-3.09.min.js"}
    {*{jsfile src="js/jquery.blockUI-2.66.0.min.js"}*}
    {if isset($Qtip) && $Qtip}
        {jsfile src="js/jquery.qtip.min.js"}
    {/if}
    {if isset($Validator) && $Validator}
        {jsfile src="js/bootstrapvalidator/bootstrapValidator.min.js"}
    {/if}
{else}
    {*<script type="text/javascript"*}
    {*src="https://ajax.googleapis.com/ajax/libs/jquery/2.1.1/jquery.min.js"></script>*}
    {*<script type="text/javascript"*}
    {*src="https://ajax.googleapis.com/ajax/libs/jqueryui/1.10.4/jquery-ui.min.js"></script>*}
    {*<script type="text/javascript"*}
    {*src="https://netdna.bootstrapcdn.com/bootstrap/3.3.4/js/bootstrap.min.js"></script>*}
    <script type="text/javascript" src="https://cdn.jsdelivr.net/lodash/4.16.3/lodash.min.js"></script>
    <script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/moment.js/2.13.0/moment.min.js"></script>
    <script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/jquery.form/3.50/jquery.form.min.js">
    </script>
    {*<script type="text/javascript"
        src="https://cdnjs.cloudflare.com/ajax/libs/jquery.blockUI/2.66.0-2013.10.09/jquery.blockUI.min.js"></script>*}
    {if isset($Qtip) && $Qtip}
        <script type="text/javascript" src="https://cdn.jsdelivr.net/qtip2/3.0.3/jquery.qtip.min.js"></script>
    {/if}
    {if isset($Validator) && $Validator}
        <script type="text/javascript"
            src="https://cdnjs.cloudflare.com/ajax/libs/jquery.bootstrapvalidator/0.5.3/js/bootstrapValidator.min.js"></script>
    {/if}
{/if}
{if isset($InlineEdit) && $InlineEdit}
    {*The version of X-editable that supports Bootstrap 5 does not have a CDN link*}
    {*<script type="text/javascript"
            src="https://cdnjs.cloudflare.com/ajax/libs/x-editable/1.5.1/bootstrap3-editable/js/bootstrap-editable.min.js">
        </script>*}
    {jsfile src="js/x-editable/js/bootstrap-editable.js"}
    <script type="text/javascript"
        src="https://cdnjs.cloudflare.com/ajax/libs/x-editable/1.5.1/inputs-ext/wysihtml5/wysihtml5.js"></script>
    {jsfile src="js/wysihtml5/bootstrap3-wysihtml5.all.min.js"}
{/if}
{if isset($Select2) && $Select2}
    <script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>
    {*jsfile src="js/select2-4.0.5.min.js"*}
{/if}
{if isset($Timepicker) && $Timepicker}
    {jsfile src="js/jquery.timePicker.min.js"}
    {jsfile src="js/jquery-ui-timepicker-addon.js"}
{/if}
{*if isset($FloatThead) && $FloatThead}
    {jsfile src="js/jquery.floatThead.min.js"}
{/if*}
{if isset($Fullcalendar) && $Fullcalendar}
    {jsfile src="js/fullcalendar.js"}
    {if $HtmlLang != 'en'}
        {jsfile src="js/fullcalendarLang/$HtmlLang.js"}
    {/if}
{/if}
{*if isset($Owl) && $Owl}
    {jsfile src="js/owl-2.2.1/owl.carousel.min.js"}
{/if*}
{*if isset($Clear) && $Clear}
    {jsfile src="search-clear.js"}
{/if*}
{if isset($DataTable) && $DataTable}
    <script src="https://cdn.datatables.net/1.13.7/js/jquery.dataTables.js"></script>
    <script src="https://cdn.datatables.net/responsive/2.5.0/js/dataTables.responsive.min.js"></script>
    <script src="https://cdn.datatables.net/1.13.7/js/dataTables.bootstrap5.min.js"></script>
    <script src="https://cdn.datatables.net/buttons/2.4.2/js/dataTables.buttons.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jszip/3.10.1/jszip.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.1.53/pdfmake.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.1.53/vfs_fonts.js"></script>
    <script src="https://cdn.datatables.net/buttons/2.4.2/js/buttons.print.min.js"></script>
    <script src="https://cdn.datatables.net/buttons/2.4.2/js/buttons.bootstrap5.min.js"></script>
    <script src="https://cdn.datatables.net/buttons/2.4.2/js/buttons.html5.min.js"></script>
    <script src="https://cdn.datatables.net/buttons/2.4.2/js/buttons.colVis.min.js"></script>
{/if}
{jsfile src="phpscheduleit.js"}