您错过了对预约进行check in操作的时间。<br/>
预约详情:
	<br/>
	<br/>
	开始时间: {formatdate date=$StartDate key=reservation_email}<br/>
	结束时间: {formatdate date=$EndDate key=reservation_email}<br/>
	资源名称: {$ResourceName}<br/>
	预约名称: {$Title}<br/>
	预约说明: {$Description|nl2br}
    {if $IsAutoRelease}
        <br/>
        If you do not check in, this reservation will be automatically cancelled at {formatdate date=$AutoReleaseTime key=reservation_email}
		如果您没准时进行check in 操作，那么这个预约将会在{formatdate date=$AutoReleaseTime key=reservation_email}自动取消。
    {/if}
<br/>
<br/>
<a href="{$ScriptUrl}/{$ReservationUrl}">查看此预约</a> |
<a href="{$ScriptUrl}">登录到 CVC Rental</a>
