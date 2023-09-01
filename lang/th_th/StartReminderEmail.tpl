การจองของคุณจะเริ่มเร็วๆ นี้<br/>
รายละเอียดการจอง:
<br/>
<br/>
เริ่มต้น: {formatdate date=$StartDate key=reservation_email}<br/>
สิ้นสุด: {formatdate date=$EndDate key=reservation_email}<br/>
ทรัพยากร: {$ResourceName}<br/>
ชื่อเรื่อง: {$Title}<br/>
คำอธิบาย: {$คำอธิบาย|nl2br}
<br/>
<br/>
<a href="{$ScriptUrl}/{$ReservationUrl}">ดูการจองนี้</a> |
<a href="{$ScriptUrl}/{$ICalUrl}">เพิ่มในปฏิทิน</a> |
<a href="{$ScriptUrl}">เข้าสู่ระบบ LibreBooking</a>
