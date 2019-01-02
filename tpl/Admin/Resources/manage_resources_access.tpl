{*
Copyright 2017-2019 Nick Korbel

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

<div class="startNoticeAdd"
	 data-value="{$resource->GetMinNoticeAdd()}"
	 data-days="{$resource->GetMinNoticeAdd()->Days()}"
	 data-hours="{$resource->GetMinNoticeAdd()->Hours()}"
	 data-minutes="{$resource->GetMinNoticeAdd()->Minutes()}">
	{if $resource->HasMinNoticeAdd()}
		{translate key='ResourceMinNotice' args=$resource->GetMinNoticeAdd()}
	{else}
		{translate key='ResourceMinNoticeNone'}
	{/if}
</div>
<div class="startNoticeUpdate"
	 data-value="{$resource->GetMinNoticeUpdate()}"
	 data-days="{$resource->GetMinNoticeUpdate()->Days()}"
	 data-hours="{$resource->GetMinNoticeUpdate()->Hours()}"
	 data-minutes="{$resource->GetMinNoticeUpdate()->Minutes()}">
	{if $resource->HasMinNoticeUpdate()}
		{translate key='ResourceMinNoticeUpdate' args=$resource->GetMinNoticeUpdate()}
	{else}
		{translate key='ResourceMinNoticeNoneUpdate'}
	{/if}
</div>
<div class="startNoticeDelete"
	 data-value="{$resource->GetMinNoticeDelete()}"
	 data-days="{$resource->GetMinNoticeDelete()->Days()}"
	 data-hours="{$resource->GetMinNoticeDelete()->Hours()}"
	 data-minutes="{$resource->GetMinNoticeDelete()->Minutes()}">
	{if $resource->HasMinNoticeDelete()}
		{translate key='ResourceMinNoticeDelete' args=$resource->GetMinNoticeDelete()}
	{else}
		{translate key='ResourceMinNoticeNoneDelete'}
	{/if}
</div>
<div class="endNotice"
	 data-value="{$resource->GetMaxNotice()}"
	 data-days="{$resource->GetMaxNotice()->Days()}"
	 data-hours="{$resource->GetMaxNotice()->Hours()}"
	 data-minutes="{$resource->GetMaxNotice()->Minutes()}">
	{if $resource->HasMaxNotice()}
		{translate key='ResourceMaxNotice' args=$resource->GetMaxNotice()}
	{else}
		{translate key='ResourceMaxNoticeNone'}
	{/if}
</div>
<div class="requiresApproval"
	 data-value="{$resource->GetRequiresApproval()}">
	{if $resource->GetRequiresApproval()}
		{translate key='ResourceRequiresApproval'}
	{else}
		{translate key='ResourceRequiresApprovalNone'}
	{/if}
</div>
<div class="autoAssign"
	 data-value="{$resource->GetAutoAssign()}">
	{if $resource->GetAutoAssign()}
		{translate key='ResourcePermissionAutoGranted'}
	{else}
		{translate key='ResourcePermissionNotAutoGranted'}
	{/if}
</div>
<div class="enableCheckin"
	 data-value="{$resource->IsCheckInEnabled()}">
	{if $resource->IsCheckInEnabled()}
		{translate key=RequiresCheckInNotification}
	{else}
		{translate key=NoCheckInRequiredNotification}
	{/if}
</div>
<div class="autoRelease"
	 data-value="{$resource->GetAutoReleaseMinutes()}">
	{if $resource->IsAutoReleased()}
		{translate key=AutoReleaseNotification args=$resource->GetAutoReleaseMinutes()}
	{/if}
</div>
