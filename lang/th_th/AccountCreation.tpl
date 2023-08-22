<p>{$To},</p>

<p>ผู้ใช้ใหม่ได้ลงทะเบียนด้วยข้อมูลต่อไปนี้:<br/>
Email: {$EmailAddress}<br/>
ชื่อ: {$FullName}<br/>
โทรศัพท์: {$Phone}<br/>
หน่วยงาน: {$Organization}<br/>
ตำแหน่ง: {$Position}</p>
{if !empty($CreatedBy)}
	สร้างโดย: {$CreatedBy}
{/if}
