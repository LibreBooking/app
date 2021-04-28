预约详情:
<br/>
<br/>

用户: {$UserName}<br/>
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
{$DeleteReason|nl2br}<br/>

{if count($RepeatRanges) gt 0}
    <br/>
    The following dates have been removed:
    <br/>
{/if}

{foreach from=$RepeatRanges item=date name=dates}
    {formatdate date=$date->GetBegin()}
    {if !$date->IsSameDate()} - {formatdate date=$date->GetEnd()}{/if}
    <br/>
{/foreach}

{if $Accessories|default:array()|count > 0}
    <br/>
    自主添加的附件:
    <br/>
    {foreach from=$Accessories item=accessory}
        ({$accessory->QuantityReserved}) {$accessory->Name}
        <br/>
    {/foreach}
{/if}

<br/>
<br/>
<a href="{$ScriptUrl}">登录到 CVC Rental</a>
