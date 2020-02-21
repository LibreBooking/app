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

{include file='globalheader.tpl'}

<div id="page-manage-configuration" class="admin-page">

    <h1>{translate key=ManageConfiguration}</h1>

    {if $ShowScriptUrlWarning}
        <div class="alert alert-danger">
            {translate key=ScriptUrlWarning args="$CurrentScriptUrl,$SuggestedScriptUrl"}
        </div>
    {/if}

    <form id="frmConfigFile" method="GET" action="{$SCRIPT_NAME}" role="form">
        <div class="form-group">
            <label for="cf">{translate key=File}</label>
            <select name="cf" id="cf" class="form-control">
                {foreach from=$ConfigFiles item=file}
                    {assign var=selected value=""}
                    {if $file->Location eq $SelectedFile}{assign var=selected value="selected='selected'"}{/if}
                    <option value="{$file->Location}" {$selected}>{$file->Name}</option>
                {/foreach}
            </select>
        </div>
    </form>

    {function name="list_settings"}
        {foreach from=$settings item=setting}
            {cycle values=',row1' assign=rowCss}
            {assign var="name" value=$setting->Name}
            <div class="{$rowCss}">
                <div class="form-group col-xs-12">
                    <label for="{$name}" class="control-label">{$setting->Key}</label>
                    {if $setting->Key == ConfigKeys::DEFAULT_TIMEZONE}
                        <select id="{$name}" name="{$name}" class="form-control">
                            {html_options values=$TimezoneValues output=$TimezoneOutput selected=$setting->Value}
                        </select>
                    {elseif $setting->Key == ConfigKeys::LANGUAGE}
                        <select id="{$name}" name="{$name}" class="form-control">
                            {object_html_options options=$Languages key='GetLanguageCode' label='GetDisplayName' selected=$setting->Value|strtolower}
                        </select>
                    {elseif $setting->Key == ConfigKeys::DEFAULT_HOMEPAGE}
                        <label for="default__homepage" class="no-show">Homepage</label>
                        <select id="default__homepage" name="{$name}" class="form-control">
                            {html_options values=$HomepageValues output=$HomepageOutput selected=$setting->Value|strtolower}
                        </select> <a href="#" id="applyHomepage">{translate key=ApplyToCurrentUsers}</a>
                    {elseif $setting->Key == ConfigKeys::PLUGIN_AUTHENTICATION}
                        <select id="{$name}" name="{$name}" class="form-control">
                            {html_options values=$AuthenticationPluginValues output=$AuthenticationPluginValues selected=$setting->Value}
                        </select>
                    {elseif $setting->Key == ConfigKeys::PLUGIN_AUTHORIZATION}
                        <select id="{$name}" name="{$name}" class="form-control">
                            {html_options values=$AuthorizationPluginValues output=$AuthorizationPluginValues selected=$setting->Value}
                        </select>
                    {elseif $setting->Key == ConfigKeys::PLUGIN_PERMISSION}
                        <select id="{$name}" name="{$name}" class="form-control">
                            {html_options values=$PermissionPluginValues output=$PermissionPluginValues selected=$setting->Value}
                        </select>
                    {elseif $setting->Key == ConfigKeys::PLUGIN_POSTREGISTRATION}
                        <select id="{$name}" name="{$name}" class="form-control">
                            {html_options values=$PostRegistrationPluginValues output=$PostRegistrationPluginValues selected=$setting->Value}
                        </select>
                    {elseif $setting->Key == ConfigKeys::PLUGIN_PRERESERVATION}
                        <select id="{$name}" name="{$name}" class="form-control">
                            {html_options values=$PreReservationPluginValues output=$PreReservationPluginValues selected=$setting->Value}
                        </select>
                    {elseif $setting->Key == ConfigKeys::PLUGIN_POSTRESERVATION}
                        <select id="{$name}" name="{$name}" class="form-control">
                            {html_options values=$PostReservationPluginValues output=$PostReservationPluginValues selected=$setting->Value}
                        </select>
                    {elseif $setting->Type == ConfigSettingType::String}
                        <input id="{$name}" type="text" size="50" name="{$name}" value="{$setting->Value|escape}"
                               class="form-control"/>
                    {else}
                        <div>
                            <div class="radio radio-inline">
                                <input id="radio{$name}t" type="radio" value="true"
                                       name="{$name}"{if $setting->Value == 'true'} checked="checked"{/if} />
                                <label for="radio{$name}t">{translate key="True"}</label>
                            </div>
                            <div class="radio radio-inline">
                                <input id="radio{$name}f" type="radio" value="false"
                                       name="{$name}"{if $setting->Value == 'false'} checked="checked"{/if} />
                                <label for="radio{$name}f">{translate key="False"}</label>
                            </div>
                        </div>
                    {/if}
                </div>
            </div>
        {/foreach}
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

        {assign var=HelpUrl value="$ScriptUrl/help.php?ht=admin"}
        <h3>{translate key=ConfigurationUpdateHelp args=$HelpUrl}</h3>
        <div id="updatedMessage" class="alert alert-success" style="display:none;">
            {translate key=ConfigurationUpdated}
        </div>
        <div id="configSettings">

            <input type="button" value="{translate key=Update}" class='btn btn-success save'/>

            <form id="frmConfigSettings" method="post" ajaxAction="{ConfigActions::Update}"
                  action="{$smarty.server.SCRIPT_NAME}">
                <h3>{translate key=GeneralConfigSettings}</h3>
                <fieldset>
                    <div class="no-style config-settings">
                        {list_settings settings=$Settings}
                    </div>
                </fieldset>

                {foreach from=$SectionSettings key=section item=settings}
                    <h3>{$section}</h3>
                    <fieldset>
                        <div class="no-style config-settings">
                            {list_settings settings=$settings}
                        </div>
                    </fieldset>
                {/foreach}

                <input type="hidden" name="setting_names" value="{$SettingNames}"/>
            </form>
            <input type="button" value="{translate key=Update}" class='btn btn-success save'/>

        </div>

        <form id="updateHomepageForm"
            method="post" ajaxAction="{ConfigActions::SetHomepage}"
            action="{$smarty.server.SCRIPT_NAME}">
            <input type="hidden" name="homepage_id" id="homepage_id" />
        </form>

        {csrf_token}

        {include file="javascript-includes.tpl"}

        {jsfile src="ajax-helpers.js"}
        {jsfile src="js/jquery.form-3.09.min.js"}
        {jsfile src="admin/configuration.js"}
        <script type="text/javascript">

            $(document).ready(function () {
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

{include file='globalfooter.tpl'}