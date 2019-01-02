{*
Copyright 2011-2019 Nick Korbel

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
预约详情:
<br/>
<br/>

用户: {$UserName}<br/>
{if !empty($CreatedBy)}
	创建者: {$CreatedBy}
	<br/>
{/if}
开始时间: {formatdate date=$StartDate key=reservation_email}<br/>
结束时间: {formatdate date=$EndDate key=reservation_email}<br/>
{if $ResourceNames|count > 1}
	资源名称:
	<br/>
	{foreach from=$ResourceNames item=resourceName}
		{$resourceName}
		<br/>
	{/foreach}
{else}
	资源名称: {$ResourceName}
	<br/>
{/if}

{if $ResourceImage}
	<div class="resource-image"><img src="{$ScriptUrl}/{$ResourceImage}"/></div>
{/if}

预约名称: {$Title}<br/>
预约说明: {$Description|nl2br}

{if count($RepeatRanges) gt 0}
    <br/>
    The reservation occurs on the following dates:
    <br/>
{/if}

{foreach from=$RepeatRanges item=date name=dates}
    {formatdate date=$date->GetBegin()}
    {if !$date->IsSameDate()} - {formatdate date=$date->GetEnd()}{/if}
    <br/>
{/foreach}

{if $Accessories|count > 0}
	<br/>
	自主添加的附件列表:
	<br/>
	{foreach from=$Accessories item=accessory}
		({$accessory->QuantityReserved}) {$accessory->Name}
		<br/>
	{/foreach}
{/if}

{if $Attributes|count > 0}
	<br/>
	{foreach from=$Attributes item=attribute}
		<div>{control type="AttributeControl" attribute=$attribute readonly=true}</div>
	{/foreach}
{/if}

{if $RequiresApproval}
	<br/>
	至少有一个预约的资源在使用之前需要批准。请确认当前请求的预约是否批准。
{/if}

{if $CheckInEnabled}
	<br/>
	预订的资源中至少有一个需要用户进行Check in 或者 Check out操作。
	{if $AutoReleaseMinutes != null}
		除非您在预约开始之后的 {$AutoReleaseMinutes} 分钟内进行Check in，否则此预约将被取消。
	{/if}
{/if}

<br/>
参考数字: {$ReferenceNumber}

<br/>
<br/>
<a href="{$ScriptUrl}/{$ReservationUrl}">查看此预约</a> | <a href="{$ScriptUrl}">登录到 CVC Rental</a>