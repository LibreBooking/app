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
<div class="allowConcurrent"
	 data-allow-concurrent="{$resource->GetAllowConcurrentReservations()}"
	 data-max-concurrent="{$resource->GetMaxConcurrentReservations()}">
    {if $resource->GetAllowConcurrentReservations()}
        {translate key=ResourceConcurrentReservations args=$resource->GetMaxConcurrentReservations()}
    {else}
        {translate key=ResourceConcurrentReservationsNone}
    {/if}
</div>
