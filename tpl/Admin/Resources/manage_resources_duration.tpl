<div class="minDuration"
	 data-value="{$resource->GetMinLength()}"
	 data-days="{$resource->GetMinLength()->Days()}"
	 data-hours="{$resource->GetMinLength()->Hours()}"
	 data-minutes="{$resource->GetMinLength()->Minutes()}">
	{if $resource->HasMinLength()}
		{translate key='ResourceMinLength' args=$resource->GetMinLength()}
	{else}
		{translate key='ResourceMinLengthNone'}
	{/if}
</div>

<div class="maxDuration"
	 data-value="{$resource->GetMaxLength()}"
	 data-days="{$resource->GetMaxLength()->Days()}"
	 data-hours="{$resource->GetMaxLength()->Hours()}"
	 data-minutes="{$resource->GetMaxLength()->Minutes()}">
	{if $resource->HasMaxLength()}
		{translate key='ResourceMaxLength' args=$resource->GetMaxLength()}
	{else}
		{translate key='ResourceMaxLengthNone'}
	{/if}
</div>

<div class="bufferTime"
	 data-value="{$resource->GetBufferTime()}"
	 data-days="{$resource->GetBufferTime()->Days()}"
	 data-hours="{$resource->GetBufferTime()->Hours()}"
	 data-minutes="{$resource->GetBufferTime()->Minutes()}">
	{if $resource->HasBufferTime()}
		{translate key='ResourceBufferTime' args=$resource->GetBufferTime()}
	{else}
		{translate key='ResourceBufferTimeNone'}
	{/if}
</div>

<div class="allowMultiDay"
	 data-value="{$resource->GetAllowMultiday()}">
	{if $resource->GetAllowMultiday()}
		{translate key='ResourceAllowMultiDay'}
	{else}
		{translate key='ResourceNotAllowMultiDay'}
	{/if}
</div>
