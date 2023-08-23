รายละเอียดการจอง:
<br/>
<br/>

ผู้ใช้: {$UserName}<br/>
{if !empty($CreatedBy)}
	สร้างโดย: {$CreatedBy}
	<br/>
{/if}
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

ชื่อเรื่อง: {$Title}<br/>
รายละเอียด: {$Description|nl2br}

{if count($RepeatRanges) gt 0}
    <br/>
    การจองจะเกิดขึ้นในวันที่ดังต่อไปนี้:
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

{if $Attributes|default:array()|count > 0}
	<br/>
	{foreach from=$Attributes item=attribute}
		<div>{control type="AttributeControl" attribute=$attribute readonly=true}</div>
	{/foreach}
{/if}

{if $RequiresApproval}
	<br/>
	ทรัพยากรที่สงวนไว้อย่างน้อยหนึ่งรายการต้องได้รับอนุมัติก่อนการใช้งาน โปรดตรวจสอบให้แน่ใจว่าคำขอจองนี้ได้รับการอนุมัติหรือปฏิเสธ
{/if}

{if $CheckInEnabled}
	<br/>
	ทรัพยากรที่สงวนไว้อย่างน้อยหนึ่งรายการกำหนดให้ผู้ใช้เช็คอินและออกจากการจอง
	{if $AutoReleaseMinutes != null}
		การจองนี้จะถูกยกเลิกเว้นแต่ผู้ใช้จะเช็คอินภายใน {$AutoReleaseMinutes} นาทีหลังจากเวลาเริ่มต้นที่กำหนดไว้
	{/if}
{/if}

<br/>
หมายเลขอ้างอิง: {$ReferenceNumber}

<br/>
<br/>
<a href="{$ScriptUrl}/{$ReservationUrl}">ดูการจองนี้</a> | <a href="{$ScriptUrl}">เข้าสู่ระบบ LibreBooking</a>
