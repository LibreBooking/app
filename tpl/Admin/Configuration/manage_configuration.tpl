{*
Copyright 2012 Nick Korbel

This file is part of phpScheduleIt.

phpScheduleIt is free software: you can redistribute it and/or modify
it under the terms of the GNU General Public License as published by
the Free Software Foundation, either version 3 of the License, or
(at your option) any later version.

phpScheduleIt is distributed in the hope that it will be useful,
but WITHOUT ANY WARRANTY; without even the implied warranty of
MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
GNU General Public License for more details.

You should have received a copy of the GNU General Public License
along with phpScheduleIt.  If not, see <http://www.gnu.org/licenses/>.
*}

{include file='globalheader.tpl' cssFiles='css/admin.css'}

<h1>{translate key=ManageConfiguration}</h1>

<ul class="no-style">
{foreach from=$Settings item=setting}
	{assign var="name" value=$setting->Key}
	<li><span class="label">{$setting->Key}</span>
		{if $setting->Type == ConfigSettingType::String}
			<input type="text" name="{$name}" value="{$setting->Value|escape}" />
		{else}
			<label for="{$name}">{translate key="True"}</label> <input type="radio" value="true" name="{$name}"{if $setting->Value == 'true'} checked="checked"{/if} />
			<label for="{$name}">{translate key="False"}</label> <input type="radio" value="false" name="{$name}"{if $setting->Value == 'false'} checked="checked"{/if} />
		{/if}
	</li>

{/foreach}
</ul>
{include file='globalfooter.tpl'}