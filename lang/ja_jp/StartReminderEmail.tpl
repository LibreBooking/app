{* -*-coding:utf-8-*-
Copyright 2013 Nick Korbel

This file is part of phpScheduleIt.

phpScheduleIt is free software: you can redistribute it and/or modify
it under the terms of the GNU General Public License as published by
the Free Software Foundation, either version 3 of the License, or
(at your option) any later version.

phpScheduleIt is distributed in the hope that it will be useful,
but WITHOUT ANY WARRANTY; without even the implied warranty of
MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
GNU General Public License for more details.

You should have received a copy of the GNU General Public License
along with phpScheduleIt.  If not, see <http://www.gnu.org/licenses/>.
*}
{include file='..\..\tpl\Email\emailheader.tpl'}
予約が間もなく始まります。<br/>
予約の詳細:
	<br/>
	<br/>
	開始: {formatdate date=$StartDate key=reservation_email}<br/>
	終了: {formatdate date=$EndDate key=reservation_email}<br/>
	リソース: {$ResourceName}<br/>
	件名: {$Title}<br/>
	説明: {$Description|nl2br}<br/>
<br/>
<a href="{$ScriptUrl}/{$ReservationUrl}">予約の表示</a> |
<a href="{$ScriptUrl}/{$ICalUrl}">カレンダーへ追加</a> |
<a href="{$ScriptUrl}">phpScheduleItへログイン</a>

{include file='..\..\tpl\Email\emailfooter.tpl'}