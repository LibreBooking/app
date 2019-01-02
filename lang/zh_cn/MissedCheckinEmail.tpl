{*
Copyright 2013-2019 Nick Korbel

This file is part of Booked Scheduler.

Booked Scheduler is free software: you can redistribute it and/or modify
it under the terms of the GNU General Public License as published by
the Free Software Foundation, either version 3 of the License, or
(at your option) any later version.

Booked Scheduler is distributed in the hope that it will be useful,
but WITHOUT ANY WARRANTY; without even the implied warranty of
MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
GNU General Public License for more details.

You should have received a copy of the GNU General Public License
along with Booked Scheduler.  If not, see <http://www.gnu.org/licenses/>.
*}
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