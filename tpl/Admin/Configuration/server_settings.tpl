{include file='globalheader.tpl'}

<div id="server-settings-page" class="admin-page">
    <div class="default-box col-xs-12 col-sm-8 col-sm-offset-2">

        <h1>{translate key=ServerSettings}</h1>

        <ul class="indented">
            <li>Current Time: {$currentTime}</li>
            <li>Image Upload Physical Directory: {$imageUploadDirectory} ({translate key=Permissions}
                : {$imageUploadDirPermissions}) <a
                        href="{$smarty.server.SCRIPT_NAME}?{QueryStringKeys::ACTION}=changePermissions">Try to apply
                    correct permissions</a></li>
            <li>Template Cache Directory: {$templateCacheDirectory} <a
                        href="{$smarty.server.SCRIPT_NAME}?{QueryStringKeys::ACTION}=flush">Try to flush cached files</a>
            </li>
        </ul>

        <h3 style="margin-top: 20px;">Plugins</h3>
        <ul class="indented">
            {foreach from=$plugins key=category item=items}
                <li>{$category}
                    <ul>
                        {foreach from=$items item=pluginName}
                            <li>{$pluginName}</li>
                        {/foreach}
                    </ul>
                </li>
            {/foreach}
        </ul>
    </div>
</div>

{include file="javascript-includes.tpl"}
{include file='globalfooter.tpl'}
