{*
Copyright 2011-2020 Nick Korbel

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
<p><strong>Reservation Details:</strong></p>

<p>
	<strong>Start:</strong> {formatdate date=$StartDate key=reservation_email}<br/>
	<strong>End:</strong> {formatdate date=$EndDate key=reservation_email}<br/>
	<strong>Title:</strong> {$Title}<br/>
	<strong>Description:</strong> {$Description|nl2br}
    {if $Attributes|count > 0}
	<br/>
    {foreach from=$Attributes item=attribute}
	<div>{control type="AttributeControl" attribute=$attribute readonly=true}</div>
    {/foreach}
{/if}
</p>

<p>
    {if $ResourceNames|count > 1}
		<strong>Resources ({$ResourceNames|count}):</strong>
		<br/>
        {foreach from=$ResourceNames item=resourceName}
            {$resourceName}
			<br/>
        {/foreach}
    {else}
		<strong>Resource:</strong>
        {$ResourceName}
		<br/>
    {/if}
</p>

{if $ResourceImage}
	<div class="resource-image"><img alt="{$ResourceName|escape}" src="{$ScriptUrl}/{$ResourceImage}"/></div>
{/if}

{if count($RepeatRanges) gt 0}
	<br/>
	<strong>The reservation occurs on the following dates ({$RepeatRanges|count}):</strong>
	<br/>
    {foreach from=$RepeatRanges item=date name=dates}
        {formatdate date=$date->GetBegin()}
        {if !$date->IsSameDate()} - {formatdate date=$date->GetEnd()}{/if}
		<br/>
    {/foreach}
{/if}

<p>
    {if !empty($CreatedBy)}
		<strong>Deleted by:</strong>
        {$CreatedBy}
		<br/>
		<strong>Delete Reason: {$DeleteReason|nl2br}</strong>
    {/if}
</p>

<p><strong>Reference Number:</strong> {$ReferenceNumber}</p>

<a href="{$ScriptUrl}">Log in to {$AppTitle}</a>