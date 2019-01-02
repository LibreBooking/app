{*
Copyright 2017-2019 Nick Korbel

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
<div class="minDuration"
	 data-value="{$resource->GetMinLength()}"
	 data-days="{$resource->GetMinLength()->Days()}"
	 data-hours="{$resource->GetMinLength()->Hours()}"
	 data-minutes="{$resource->GetMinLength()->Minutes()}">
	{if $resource->HasMinLength()}
		{translate key='ResourceMinLength' args=$resource->GetMinLength()}
	{else}
		{translate key='ResourceMinLengthNone'}
	{/if}
</div>

<div class="maxDuration"
	 data-value="{$resource->GetMaxLength()}"
	 data-days="{$resource->GetMaxLength()->Days()}"
	 data-hours="{$resource->GetMaxLength()->Hours()}"
	 data-minutes="{$resource->GetMaxLength()->Minutes()}">
	{if $resource->HasMaxLength()}
		{translate key='ResourceMaxLength' args=$resource->GetMaxLength()}
	{else}
		{translate key='ResourceMaxLengthNone'}
	{/if}
</div>

<div class="bufferTime"
	 data-value="{$resource->GetBufferTime()}"
	 data-days="{$resource->GetBufferTime()->Days()}"
	 data-hours="{$resource->GetBufferTime()->Hours()}"
	 data-minutes="{$resource->GetBufferTime()->Minutes()}">
	{if $resource->HasBufferTime()}
		{translate key='ResourceBufferTime' args=$resource->GetBufferTime()}
	{else}
		{translate key='ResourceBufferTimeNone'}
	{/if}
</div>

<div class="allowMultiDay"
	 data-value="{$resource->GetAllowMultiday()}">
	{if $resource->GetAllowMultiday()}
		{translate key='ResourceAllowMultiDay'}
	{else}
		{translate key='ResourceNotAllowMultiDay'}
	{/if}
</div>