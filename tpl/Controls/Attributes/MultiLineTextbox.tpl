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

<div class="{$class}">
{if $readonly}
    <label class="customAttribute readonly">{$attribute->Label()}</label>
    <span class="attributeValue {$class}">{$attribute->Value()|nl2br}</span>
{else}
    <div class="input-field">
        <label class="customAttribute {if $searchmode}search{else}standard{/if}" for="{$attributeId}">{$attribute->Label()}</label>
        {if $attribute->Required() && !$searchmode}
            *
        {/if}
        <textarea id="{$attributeId}" name="{$attributeName}" rows="2" class="customAttribute form-control {$inputClass}" {if $attribute->Required() && !$searchmode}required{/if}>{$attribute->Value()}</textarea>
        {if $searchmode}
            <span class="searchclear searchclear-label fa fa-remove-circle" ref="{$attributeId}"></span>
        {/if}
    </div>
{/if}
</div>