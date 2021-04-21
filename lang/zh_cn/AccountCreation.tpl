<p>{$To},</p>

<p>以下是新注册用户的具体信息：<br/>
邮件: {$EmailAddress}<br/>
名字: {$FullName}<br/>
电话: {$Phone}<br/>
单位: {$Organization}<br/>
职位: {$Position}</p>
{if !empty($CreatedBy)}
	创建者: {$CreatedBy}
{/if}
