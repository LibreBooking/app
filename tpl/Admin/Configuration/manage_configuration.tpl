{include file='globalheader.tpl'}

<div id="page-manage-configuration" class="admin-page">

    <h1 class="border-bottom mb-3">{translate key=ManageConfiguration}</h1>

    {if $ShowScriptUrlWarning}
        <div class="alert alert-danger">
            {translate key=ScriptUrlWarning args="$CurrentScriptUrl,$SuggestedScriptUrl"}
        </div>
    {/if}

    <form id="frmConfigFile" method="GET" action="{$SCRIPT_NAME}" role="form">
        <div class="form-group mb-2">
            <label for="cf" class="fw-bold">{translate key=File}</label>
            <select name="cf" id="cf" class="form-select">
                {foreach from=$ConfigFiles item=file}
                    {assign var=selected value=""}
                    {if $file->Location eq $SelectedFile}{assign var=selected value="selected='selected'"}{/if}
                    <option value="{$file->Location}" {$selected}>{$file->Name}</option>
                {/foreach}
            </select>
        </div>
    </form>

    {function name="list_settings"}
        <div class="row gy-4 mb-3">
            {foreach from=$settings item=setting}
                {assign value='col-sm-6' var=rowCss}
                {assign var="name" value=$setting->Name}
                <div class="{$rowCss}">
                    <div class="form-group">
                        <label for="{$name}" class="fw-bold">{$setting->Key}</label>
                        {if $setting->Key == ConfigKeys::DEFAULT_TIMEZONE}
                            <i class="bi bi-question-circle-fill link-primary" data-bs-toggle="tooltip"
                                title="Look up here http://php.net/manual/en/timezones.php"></i>
                            <select id=" {$name}" name="{$name}" class="form-select">
                                {html_options values=$TimezoneValues output=$TimezoneOutput selected=$setting->Value}
                            </select>
                        {elseif $setting->Key == ConfigKeys::LANGUAGE}
                            <i class="bi bi-question-circle-fill link-primary" data-bs-toggle="tooltip"
                                title="Find your language in the lang directory"></i>
                            <select id="{$name}" name="{$name}" class="form-select">
                                {object_html_options options=$Languages key='GetLanguageCode' label='GetDisplayName' selected=$setting->Value|strtolower}
                            </select>
                        {elseif $setting->Key == ConfigKeys::DEFAULT_HOMEPAGE}
                            <label for="default__homepage" class="visually-hidden">Homepage</label><i
                                class="bi bi-question-circle-fill link-primary" data-bs-toggle="tooltip"
                                title="The default homepage to use when new users register"></i>
                            <select id="default__homepage" name="{$name}" class="form-select">
                                {html_options values=$HomepageValues output=$HomepageOutput selected=$setting->Value|strtolower}
                            </select> <a href="#" id="applyHomepage" class="link-primary">{translate key=ApplyToCurrentUsers}</a>
                        {elseif $setting->Key == ConfigKeys::PLUGIN_AUTHENTICATION}
                            <select id="{$name}" name="{$name}" class="form-select">
                                {html_options values=$AuthenticationPluginValues output=$AuthenticationPluginValues selected=$setting->Value}
                            </select>
                        {elseif $setting->Key == ConfigKeys::PLUGIN_AUTHORIZATION}
                            <select id="{$name}" name="{$name}" class="form-select">
                                {html_options values=$AuthorizationPluginValues output=$AuthorizationPluginValues selected=$setting->Value}
                            </select>
                        {elseif $setting->Key == ConfigKeys::PLUGIN_PERMISSION}
                            <select id="{$name}" name="{$name}" class="form-select">
                                {html_options values=$PermissionPluginValues output=$PermissionPluginValues selected=$setting->Value}
                            </select>
                        {elseif $setting->Key == ConfigKeys::PLUGIN_POSTREGISTRATION}
                            <select id="{$name}" name="{$name}" class="form-select">
                                {html_options values=$PostRegistrationPluginValues output=$PostRegistrationPluginValues selected=$setting->Value}
                            </select>
                        {elseif $setting->Key == ConfigKeys::PLUGIN_PRERESERVATION}
                            <select id="{$name}" name="{$name}" class="form-select">
                                {html_options values=$PreReservationPluginValues output=$PreReservationPluginValues selected=$setting->Value}
                            </select>
                        {elseif $setting->Key == ConfigKeys::PLUGIN_POSTRESERVATION}
                            <select id="{$name}" name="{$name}" class="form-select">
                                {html_options values=$PostReservationPluginValues output=$PostReservationPluginValues selected=$setting->Value}
                            </select>
                        {elseif $setting->Type == ConfigSettingType::String}
                            <input id="{$name}" type="text" size="50" name="{$name}" value="{$setting->Value|escape}"
                                class="form-control" />
                        {else}
                            <div>
                                <div class="form-check form-check-inline">
                                    <input class="form-check-input" id="radio{$name}t" type="radio" value="true" name="{$name}"
                                        {if $setting->Value == 'true'} checked="checked" {/if} />
                                    <label class="form-check-label" for="radio{$name}t">{translate key="True"}</label>
                                </div>
                                <div class="form-check form-check-inline">
                                    <input class="form-check-input" id="radio{$name}f" type="radio" value="false" name="{$name}"
                                        {if $setting->Value == 'false'} checked="checked" {/if} />
                                    <label class="form-check-label" for="radio{$name}f">{translate key="False"}</label>
                                </div>
                            </div>
                        {/if}
                    </div>
                </div>
            {/foreach}
        </div>
    {/function}


    {if !$IsPageEnabled}
        <div class="alert alert-danger">
            {translate key=ConfigurationUiNotEnabled}
        </div>
    {/if}

    {if !$IsConfigFileWritable}
        <div class="alert alert-danger">
            {translate key=ConfigurationFileNotWritable}
        </div>
    {/if}

    {if $IsPageEnabled && $IsConfigFileWritable}
        <div class="card shadow">
            <div class="card-body">
                {assign var=HelpUrl value="https://github.com/LibreBooking/app/wiki/Administration"}
                <h3 class="text-center border-bottom mb-3">{translate key=ConfigurationUpdateHelp args=$HelpUrl}</h3>
                <div id="updatedMessage" class="alert alert-success" style="display:none;">
                    {translate key=ConfigurationUpdated}
                </div>
                <div id="configSettings">
                    <div class="d-grid">
                        <input type="button" value="{translate key=Update}" class='btn btn-primary save' />
                    </div>

                    <form id="frmConfigSettings" method="post" ajaxAction="{ConfigActions::Update}"
                        action="{$smarty.server.SCRIPT_NAME}">
                        <div class="accordion my-3" id="accordionConfig">
                            <div>
                                <div class="accordion-item shadow mb-2">
                                    <h2 class="accordion-header text-capitalize">
                                        <button class="accordion-button text-capitalize" type="button"
                                            data-bs-toggle="collapse"
                                            data-bs-target="#{translate key=GeneralConfigSettings}">
                                            {translate key=GeneralConfigSettings}
                                        </button>
                                    </h2>
                                    <div id="{translate key=GeneralConfigSettings}"
                                        class="accordion-collapse collapse show">
                                        <div class="accordion-body">
                                            <fieldset>
                                                <div class="no-style config-settings">
                                                    {list_settings settings=$Settings}
                                                </div>
                                            </fieldset>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            {foreach from=$SectionSettings key=section item=settings}
                                <div>
                                    <div class="accordion-item shadow mb-2">
                                        <h2 class="accordion-header">
                                            <button class="accordion-button collapsed text-capitalize" type="button"
                                                data-bs-toggle="collapse" data-bs-target="#{$section}">
                                                {$section}
                                            </button>
                                        </h2>
                                        <div id="{$section}" class="accordion-collapse collapse">
                                            <div class="accordion-body">
                                                <fieldset>
                                                    <div class="no-style config-settings">
                                                        {list_settings settings=$settings}
                                                    </div>
                                                </fieldset>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            {/foreach}
                        </div>
                        <input type="hidden" name="setting_names" value="{$SettingNames}" />
                    </form>

                    <div class="d-grid">
                        <input type="button" value="{translate key=Update}" class='btn btn-primary save' />
                    </div>

                </div>

                <form id="updateHomepageForm" method="post" ajaxAction="{ConfigActions::SetHomepage}"
                    action="{$smarty.server.SCRIPT_NAME}">
                    <input type="hidden" name="homepage_id" id="homepage_id" />
                </form>

                {csrf_token}
            </div>
        </div>

        {include file="javascript-includes.tpl"}

        {jsfile src="ajax-helpers.js"}
        {jsfile src="js/jquery.form-3.09.min.js"}
        {jsfile src="admin/configuration.js"}
        <script type="text/javascript">
            $(document).ready(function() {
                var config = new Configuration();
                config.init();
            });
        </script>
        <div id="wait-box" class="wait-box">
            <h3>{translate key=Working}</h3>
            {html_image src="reservation_submitting.gif"}
        </div>
    {/if}
</div>
<script>
    var tooltipTriggerList = [].slice.call(document.querySelectorAll('[data-bs-toggle="tooltip"]'))
    var tooltipList = tooltipTriggerList.map(function(tooltipTriggerEl) {
        return new bootstrap.Tooltip(tooltipTriggerEl)
    })
</script>
{include file='globalfooter.tpl'}