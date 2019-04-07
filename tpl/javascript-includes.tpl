
{if $UseLocalJquery}
    {jsfile src="js/lodash.4.6.13.min.js"}
    {jsfile src="js/moment.min.js"}
    {jsfile src="js/jquery.form-3.09.min.js"}
    {jsfile src="js/jquery.blockUI-2.66.0.min.js"}
    {if $Qtip}
        {jsfile src="js/jquery.qtip.min.js"}
    {/if}
    {if $InlineEdit}
        {jsfile src="js/x-editable/js/jqueryui-editable.js"}
        {*{jsfile src="js/x-editable/wysihtml5/wysihtml5.js"}*}
        {*{jsfile src="js/x-editable/wysihtml5/bootstrap-wysihtml5-0.0.2/bootstrap-wysihtml5-0.0.2.min.js"}*}
        {*{jsfile src="js/x-editable/wysihtml5/bootstrap-wysihtml5-0.0.2/wysihtml5-0.3.0.min.js"}*}
    {/if}
{else}
    <script type="text/javascript"
            src="https://cdn.jsdelivr.net/lodash/4.16.3/lodash.min.js"></script>
    <script type="text/javascript"
            src="https://cdnjs.cloudflare.com/ajax/libs/moment.js/2.13.0/moment.min.js"></script>
    <script type="text/javascript"
            src="https://cdnjs.cloudflare.com/ajax/libs/jquery.form/3.50/jquery.form.min.js"></script>
    <script type="text/javascript"
            src="https://cdnjs.cloudflare.com/ajax/libs/jquery.blockUI/2.66.0-2013.10.09/jquery.blockUI.min.js"></script>
    {if $Qtip}
        <script type="text/javascript"
                src="https://cdn.jsdelivr.net/qtip2/3.0.3/jquery.qtip.min.js"></script>
    {/if}

    {if $InlineEdit}
        <script src="https://cdnjs.cloudflare.com/ajax/libs/x-editable/1.5.0/jqueryui-editable/js/jqueryui-editable.min.js"></script>
        {*{jsfile src="js/x-editable/wysihtml5/wysihtml5.js"}*}
        {*{jsfile src="js/x-editable/wysihtml5/bootstrap-wysihtml5-0.0.2/bootstrap-wysihtml5-0.0.2.min.js"}*}
        {*{jsfile src="js/x-editable/wysihtml5/bootstrap-wysihtml5-0.0.2/wysihtml5-0.3.0.min.js"}*}
    {/if}
{/if}
{if $Select2}
    {jsfile src="js/select2-4.0.5.min.js"}
{/if}
{if $Timepicker}
    {jsfile src="js/jquery.timePicker.min.js"}
    {jsfile src="js/jquery-ui-timepicker-addon.js"}
{/if}
{if $FloatThead}
    {jsfile src="js/jquery.floatThead.min.js"}
{/if}
{if $Fullcalendar}
    {jsfile src="js/fullcalendar.js"}
    {if $HtmlLang != 'en'}
    {jsfile src="js/fullcalendarLang/$HtmlLang.js"}
    {/if}
{/if}
{if $Owl}
    {jsfile src="js/owl-2.2.1/owl.carousel.min.js"}
{/if}
{if $Clear}
    {jsfile src="search-clear.js"}
{/if}
{if $Validator}
    {jsfile src="js/jquery-validation-1.19.0/jquery.validate.min.js"}
{/if}
{jsfile src="phpscheduleit.js"}