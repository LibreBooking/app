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
<label class="customAttribute" for="{$attributeName}">{$attribute->Label()|escape}</label>
{if $align=='vertical'}
<br/>
{/if}
{if $readonly}
<span class="attributeValue">{$attribute->Value()|escape}</span>
{else}
<select id="{$attributeName}" name="{$attributeName}" class="customAttribute textbox">
	{if !$attribute->Required()}
	<option value="">--</option>
	{/if}
	{foreach from=$attribute->PossibleValueList() item=value}
	<option value="{$value|escape}" {if $attribute->Value() == $value}selected="selected"{/if}>{$value|escape}</option>
	{/foreach}
</select>
{/if}
