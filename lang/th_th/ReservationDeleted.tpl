รายละเอียดการจอง:
<br/>
<br/>

ชื่อผู้ใช้: {$UserName}<br/>
เริ่มต้น: {formatdate date=$StartDate key=reservation_email}<br/>
สิ้นสุด: {formatdate date=$EndDate key=reservation_email}<br/>
{if $ResourceNames|default:array()|count > 1}
    ทรัพยากร:
    <br/>
    {foreach from=$ResourceNames item=resourceName}
        {$resourceName}
        <br/>
    {/foreach}
{else}
    ทรัพยากร: {$ResourceName}
    <br/>
{/if}

{if $ResourceImage}
    <div class="resource-image"><img src="{$ScriptUrl}/{$ResourceImage}"/></div>
{/if}

ชื่อ: {$Title}<br/>
รายละเอียด: {$Description|nl2br}
{$DeleteReason|nl2br}<br/>


{if count($RepeatRanges) gt 0}
    <br/>
    วันที่ต่อไปนี้ถูกลบออกแล้ว:
    <br/>
{/if}

{foreach from=$RepeatRanges item=date name=dates}
    {formatdate date=$date->GetBegin()}
    {if !$date->IsSameDate()} - {formatdate date=$date->GetEnd()}{/if}
    <br/>
{/foreach}

{if $Accessories|default:array()|count > 0}
    <br/>
    อุปกรร์เสริม:
    <br/>
    {foreach from=$Accessories item=accessory}
        ({$accessory->QuantityReserved}) {$accessory->Name}
        <br/>
    {/foreach}
{/if}

<br/>
<br/>
<a href="{$ScriptUrl}">เข้าสู่ระบบ LibreBooking</a>
