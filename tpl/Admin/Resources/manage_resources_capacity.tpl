<div class="maxParticipants"
	 data-value="{$resource->GetMaxParticipants()}">
	{if $resource->HasMaxParticipants()}
		{translate key='ResourceCapacity' args=$resource->GetMaxParticipants()}
	{else}
		{translate key='ResourceCapacityNone'}
	{/if}
</div>
