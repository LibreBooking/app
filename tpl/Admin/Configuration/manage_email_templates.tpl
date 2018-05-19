{include file='globalheader.tpl'}

<div id="page-manage-email-templates" class="admin-page">

    <div class="default-box col-xs-12 col-sm-8 col-sm-offset-2">
        <h1>{translate key=ManageEmailTemplates}</h1>

        <div class="form-group col-sm-8 col-xs-6">
            <select id="templateOpts" title="{translate key=EmailTemplate}" class="form-control">
                <option value="">--- {translate key=SelectEmailTemplate} ---</option>
                {foreach from=$Templates item=template}
                    <option value="{$template->FileName()}">{$template->Name()}</option>
                {/foreach}
            </select>

        </div>

        <div class="form-group col-sm-4 col-xs-6">
            <select id="languageOpts" title="{translate key=Language}" class="form-control">
                {foreach from=$Languages item=language}
                    <option value="{$language->LanguageCode}"
                            {if $Language==$language->LanguageCode}selected="selected"{/if}>{$language->DisplayName}</option>
                {/foreach}
            </select>
        </div>

        <div id="editEmailSection" class="no-show">
            <div>
                <form role="form" id="updateEmailForm" ajaxAction="{EmailTemplatesActions::Update}" method="post">
                    <div class="form-group col-xs-12">
                    <textarea id="templateContents" {formname key=EMAIL_CONTENTS} title="{translate key=EmailTemplate}"
                              class="form-control" rows="20" style="width:100%"></textarea>
                    </div>

                    <div class="form-group col-xs-12">
                        {indicator}
                        {update_button submit=true}
                        <input id="reloadEmailContents" type="button" class="btn btn-default"
                               value="{translate key=ReloadOriginalContents}"/>
                    </div>

                    <input type="hidden" id="templatePath" {formname key=EMAIL_TEMPLATE_NAME} />
                    {csrf_token}
                </form>
            </div>

            <div id="updateSuccess" class="alert alert-success col-xs-12" style="display:none;">
                <span class="glyphicon glyphicon-ok-sign"></span> {translate key=UpdateEmailTemplateSuccess}
            </div>

            <div id="updateFailed" class="alert alert-warning col-xs-12" style="display:none;">
                <span class="glyphicon glyphicon-alert"></span> {translate key=UpdateEmailTemplateFailed}
            </div>
        </div>

        {include file="javascript-includes.tpl"}

        {jsfile src="ajax-helpers.js"}
        {jsfile src="admin/email-templates.js"}
        <script type="text/javascript">

            $(document).ready(function () {
                var opts = {
                    scriptUrl: '{$smarty.server.SCRIPT_NAME}'
                };
                var emails = new EmailTemplateManagement(opts);
                emails.init();
            });

        </script>
        <div id="wait-box" class="wait-box">
            <h3>{translate key=Working}</h3>
            {html_image src="reservation_submitting.gif"}
        </div>
    </div>
</div>

{include file='globalfooter.tpl'}