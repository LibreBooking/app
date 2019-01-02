{*
Copyright 2011-2019 Nick Korbel

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

<div id="server-settings-page" class="admin-page">
    <div class="default-box col-xs-12 col-sm-8 col-sm-offset-2">

        <h1>{translate key=ServerSettings}</h1>

        <ul class="indented">
            <li>Current Time: {$currentTime}</li>
            <li>Image Upload Physical Directory: {$imageUploadDirectory} ({translate key=Permissions}
                : {$imageUploadDirPermissions}) <a
                        href="{$smarty.server.SCRIPT_URL}?{QueryStringKeys::ACTION}=changePermissions">Try to apply
                    correct permissions</a></li>
            <li>Template Cache Directory: {$tempalteCacheDirectory} <a
                        href="{$smarty.server.SCRIPT_URL}?{QueryStringKeys::ACTION}=flush">Try to flush cached files</a>
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