预约详情:
<br/>
<br/>

开始时间: {formatdate date=$StartDate key=reservation_email}<br/>
结束时间: {formatdate date=$EndDate key=reservation_email}<br/>
{if $ResourceNames|default:array()|count > 1}
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

{if $Accessories|default:array()|count > 0}
	<br/>
	自主添加的附件列表:
	<br/>
	{foreach from=$Accessories item=accessory}
		({$accessory->QuantityReserved}) {$accessory->Name}
		<br/>
	{/foreach}
{/if}

{if $Attributes|default:array()|count > 0}
	<br/>
	{foreach from=$Attributes item=attribute}
		<div>{control type="AttributeControl" attribute=$attribute readonly=true}</div>
	{/foreach}
{/if}

{if $RequiresApproval}
	<br/>
	至少有一个预约的资源在使用之前需要批准，这个预约在经批准之前处于待审批阶段。
{/if}

{if $CheckInEnabled}
	<br/>
	预约的资源中至少有一个需要您对该预约进行Check in 或者Check out操作。
	{if $AutoReleaseMinutes != null}
		除非您在预约开始之前的 {$AutoReleaseMinutes} 分钟内对预约进行Check in 操作，否则此预约将被取消。
	{/if}
{/if}

{if !empty($ApprovedBy)}
	<br/>
	批准者: {$ApprovedBy}
{/if}


{if !empty($CreatedBy)}
	<br/>
	创建者: {$CreatedBy}
{/if}

<br/>
参考数字: {$ReferenceNumber}

<br/>
<br/>
<a href="{$ScriptUrl}/{$ReservationUrl}">查看此预约</a> |
<a href="{$ScriptUrl}/{$ICalUrl}">添加到日历</a> |
<a href="{$ScriptUrl}">登录到 CVC Rental</a>
