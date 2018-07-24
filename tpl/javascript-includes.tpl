
{if $UseLocalJquery}
    {*{jsfile src="js/jquery-2.1.1.min.js"}*}
    {*{jsfile src="js/jquery-ui-1.10.4.custom.min.js"}*}
    {*{jsfile src="bootstrap/js/bootstrap.min.js"}*}
    {jsfile src="js/lodash.4.6.13.min.js"}
    {jsfile src="js/moment.min.js"}
    {jsfile src="js/jquery.form-3.09.min.js"}
    {jsfile src="js/jquery.blockUI-2.66.0.min.js"}
    {if $Qtip}
        {jsfile src="js/jquery.qtip.min.js"}
    {/if}
    {if $Validator}
        {jsfile src="js/bootstrapvalidator/bootstrapValidator.min.js"}
    {/if}
    {if $InlineEdit}
        {jsfile src="js/x-editable/js/bootstrap-editable.min.js"}
        {jsfile src="js/x-editable/wysihtml5/wysihtml5.js"}
        {jsfile src="js/wysihtml5/bootstrap3-wysihtml5.all.min.js"}
    {/if}
{else}
    {*<script type="text/javascript"*}
            {*src="https://ajax.googleapis.com/ajax/libs/jquery/2.1.1/jquery.min.js"></script>*}
    {*<script type="text/javascript"*}
            {*src="https://ajax.googleapis.com/ajax/libs/jqueryui/1.10.4/jquery-ui.min.js"></script>*}
    {*<script type="text/javascript"*}
            {*src="https://netdna.bootstrapcdn.com/bootstrap/3.3.4/js/bootstrap.min.js"></script>*}
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
    {if $Validator}
        <script type="text/javascript"
                src="https://cdnjs.cloudflare.com/ajax/libs/jquery.bootstrapvalidator/0.5.3/js/bootstrapValidator.min.js"></script>
    {/if}

    {if $InlineEdit}
        <script type="text/javascript"
                src="https://cdnjs.cloudflare.com/ajax/libs/x-editable/1.5.1/bootstrap3-editable/js/bootstrap-editable.min.js"></script>
        <script type="text/javascript"
                src="https://cdnjs.cloudflare.com/ajax/libs/x-editable/1.5.1/inputs-ext/wysihtml5/wysihtml5.js"></script>
        {jsfile src="js/wysihtml5/bootstrap3-wysihtml5.all.min.js"}
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
{jsfile src="phpscheduleit.js"}