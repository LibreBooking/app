{*
Copyright 2012-2014 Nick Korbel

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
<label class="customAttribute" for="{$attributeName}">{$attribute->Label()|escape}:</label>
{if $align=='vertical'}
<br/>
{/if}
{if $readonly}
<span class="attributeValue {$class}">{$attribute->Value()|escape}</span>
{else}
<input type="text" id="{$attributeName}" name="{$attributeName}" value="{$attribute->Value()|escape}" class="customAttribute textbox {$class}" />
{/if}