การจองของคุณกำลังจะสิ้นสุดเร็วๆ นี้<br/>
รายละเอียดการจอง:
<br/>
<br/>
เริ่มต้น: {formatdate date=$StartDate key=reservation_email}<br/>
สิ้นสุด: {formatdate date=$EndDate key=reservation_email}<br/>
แหล่งข้อมูล: {$ResourceName}<br/>
ชื่อเรื่อง: {$Title}<br/>
คำอธิบาย: {$Description|nl2br}
<br/>
<a href="{$ScriptUrl}/{$ReservationUrl}">ดูการจองนี้</a> |
<a href="{$ScriptUrl}/{$ICalUrl}">เพิ่มในปฏิทิน</a> |
<a href="{$ScriptUrl}">เข้าสู่ระบบ LibreBooking</a>
