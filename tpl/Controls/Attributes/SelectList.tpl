{*
Copyright 2012-2019 Nick Korbel

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

<div class="{$class}">
	{if $readonly}
        <label class="customAttribute readonly">{$attribute->Label()}</label>
        <span class="attributeValue {$class}">{$attribute->Value()}</span>
	{else}
        <div class="input-field">
            <label class="customAttribute active {if $searchmode}search{else}standard{/if}" for="{$attributeId}">{$attribute->Label()}</label>
            <select id="{$attributeId}" name="{$attributeName}" class="customAttribute {$inputClass}">
                {if !$attribute->Required() || $searchmode}
                    <option value="">--</option>
                {/if}
                {foreach from=$attribute->PossibleValueList() item=value}
                    <option value="{$value}"
                            {if $attribute->Value() == $value}selected="selected"{/if}>{$value}</option>
                {/foreach}
            </select>
        </div>
	{/if}
</div>
