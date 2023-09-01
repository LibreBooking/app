คุณพลาดการเช็คอิน<br/>
รายละเอียดการจอง:
<br/>
<br/>
เริ่มต้น: {formatdate date=$StartDate key=reservation_email}<br/>
สิ้นสุด: {formatdate date=$EndDate key=reservation_email}<br/>
ทรัพยากร: {$ResourceName}<br/>
ชื่อเรื่อง: {$Title}<br/>
คำอธิบาย: {$Description|nl2br}
     {if $IsAutoRelease}
         <br/>
         หากคุณไม่เช็คอิน การจองนี้จะถูกยกเลิกโดยอัตโนมัติเมื่อ {formatdate date=$AutoReleaseTime key=reservation_email}
     {/if}
<br/>
<br/>
<a href="{$ScriptUrl}/{$ReservationUrl}">ดูการจองนี้</a> |
<a href="{$ScriptUrl}">เข้าสู่ระบบ LibreBooking</a>
