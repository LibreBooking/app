{*
Copyright 2011-2019 Nick Korbel, Paul Menchini

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
<p>{$FullName},</p>

<p>在{$AppTitle}上有一个账户已为您建立，以下是该账户信息：<br/>
邮箱: {$EmailAddress}<br/>
姓名: {$FullName}<br/>
电话: {$Phone}<br/>
单位: {$Organization}<br/>
职位: {$Position}<br/>
密码: {$Password}</p>
{if !empty($CreatedBy)}
	创建者: {$CreatedBy}
{/if}

<a href="{$ScriptUrl}">登录到{$AppTitle}</a>