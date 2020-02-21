{*
Copyright 2012-2020 Nick Korbel

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
<div class="form-group {$class}">
    {if $readonly}
        <label class="customAttribute readonly" for="{$attributeId}">{$attribute->Label()}</label>
        <span class="attributeValue {$class}">{if $attribute->Value() == "1"}{translate key='True'}{else}{translate key='False'}{/if}</span>
    {elseif $searchmode}
        <label class="customAttribute search" for="{$attributeId}">{$attribute->Label()}</label>
        <select id="{$attributeId}" name="{$attributeName}" class="customAttribute form-control {$inputClass}">
            <option value="">--</option>
            <option value="0" {if $attribute->Value() == "0"}selected="selected"{/if}>{translate key=No}</option>
            <option value="1" {if $attribute->Value() == "1"}selected="selected"{/if}>{translate key=Yes}</option>
        </select>
    {else}
        <div class="checkbox">
            <input type="checkbox" value="1" id="{$attributeId}" name="{$attributeName}"
                   {if $attribute->Value() == "1"}checked="checked"{/if} class="{$inputClass}"/>
            <label class="customAttribute standard" for="{$attributeId}">{$attribute->Label()}
                {if $attribute->Required() && !$searchmode}
                    <i class="glyphicon glyphicon-asterisk"></i>
                {/if}
            </label>
        </div>
    {/if}
</div>
