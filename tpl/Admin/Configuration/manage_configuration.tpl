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

{function name="list_settings"}
	{foreach from=$settings item=setting}
		{assign var="name" value=$setting->Key}
		<li><span class="label">{$setting->Key}</span>
			{if $setting->Key == ConfigKeys::SERVER_TIMEZONE}
				<select name="{$name}">
					{html_options values=$TimezoneValues output=$TimezoneOutput selected=$setting->Value}
				</select>
			{elseif $setting->Key == ConfigKeys::LANGUAGE}
				<select name={$name}>
					{object_html_options options=$Languages key='GetLanguageCode' label='GetDisplayName' selected=$setting->Value|strtolower}
				</select>
			{elseif $setting->Type == ConfigSettingType::String}
				<input type="text" size="50" name="{$name}" value="{$setting->Value|escape}" />
			{else}
				<label>{translate key="True"}<input type="radio" value="true" name="{$name}"{if $setting->Value == 'true'} checked="checked"{/if} /></label>
				<label>{translate key="False"}<input type="radio" value="false" name="{$name}"{if $setting->Value == 'false'} checked="checked"{/if} /></label>
			{/if}
		</li>
	{/foreach}
{/function}

<h1>{translate key=ManageConfiguration}</h1>

<h3>Refer to the Configuration section of the <a target="_blank" href="{$Path}help.php?ht=admin">Help File</a> for documentation on these settings.</h3>



<ul class="no-style">
{list_settings settings=$Settings}
</ul>

{foreach from=$SectionSettings key=section item=settings}
<h4>{$section}</h4>
<ul class="no-style">
{list_settings settings=$settings}
</ul>
{/foreach}
{include file='globalfooter.tpl'}