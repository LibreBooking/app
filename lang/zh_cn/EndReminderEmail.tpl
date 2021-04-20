您的预约即将结束<br/>
预约详情:
	<br/>
	<br/>
	开始时间: {formatdate date=$StartDate key=reservation_email}<br/>
	结束时间: {formatdate date=$EndDate key=reservation_email}<br/>
	资源名称: {$ResourceName}<br/>
	预约标题: {$Title}<br/>
	预约说明: {$Description|nl2br}
<br/>
<a href="{$ScriptUrl}/{$ReservationUrl}">查看此预约</a> |
<a href="{$ScriptUrl}/{$ICalUrl}">添加到日历</a> |
<a href="{$ScriptUrl}">登录到CVC Rental</a>
