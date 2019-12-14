{include file='globalheader.tpl'}

<div id="page-manage-email-templates" class="admin-page row">

    <h1 class="page-title">{translate key=ManageEmailTemplates}</h1>

    <div class="input-field col s6 m4">
        <select id="templateOpts" title="{translate key=EmailTemplate}" class="form-control">
            <option value="">--- {translate key=SelectEmailTemplate} ---</option>
            {foreach from=$Templates item=template}
                <option value="{$template->FileName()}">{$template->Name()}</option>
            {/foreach}
        </select>

    </div>

    <div class="input-field col s6 m4">
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
                <div class="input-field">
                    <textarea id="templateContents" {formname key=EMAIL_CONTENTS} title="{translate key=EmailTemplate}"
                              class="materialize-textarea textarea-highlight"></textarea>
                </div>

                <div class="input-field">
                    {indicator}
                    {update_button submit=true}
                    <input id="reloadEmailContents" type="button" class="btn btn-flat"
                           value="{translate key=ReloadOriginalContents}"/>
                </div>

                <input type="hidden" id="templatePath" {formname key=EMAIL_TEMPLATE_NAME} />
                {csrf_token}
            </form>
        </div>

        <div id="updateSuccess" class="card success" style="display:none;">
            <div class="card-content">
                <span class="fa fa-check-circle"></span> {translate key=UpdateEmailTemplateSuccess}
            </div>
        </div>

        <div id="updateFailed" class="card warning" style="display:none;">
            <div class="card-content">
                <span class="fa fa-warning"></span> {translate key=UpdateEmailTemplateFailed}
            </div>
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

{include file='globalfooter.tpl'}