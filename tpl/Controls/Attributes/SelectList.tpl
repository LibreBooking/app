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
<div class="form-group {$class} {if !$searchmode && $attribute->Required()}has-feedback{/if}">
    <label class="customAttribute {if $readonly}readonly{elseif $searchmode}search{else}standard{/if}"
           for="{$attributeId}">{$attribute->Label()}</label>
    {if $readonly}
        <span class="attributeValue {$class}">{$attribute->Value()}</span>
    {else}
        <select id="{$attributeId}" name="{$attributeName}" class="customAttribute form-control {$inputClass}"
                {if $attribute->Required() && !$searchmode}required{/if}>
            <option value="">--</option>
            {foreach from=$attribute->PossibleValueList() item=value}
                <option value="{$value}"
                        {if $attribute->Value() == $value}selected="selected"{/if}>{$value}</option>
            {/foreach}
        </select>
        {if $attribute->Required() && !$searchmode}
            <i class="glyphicon glyphicon-asterisk form-control-feedback" data-bv-icon-for="{$attributeId}"></i>
        {/if}
    {/if}
</div>
