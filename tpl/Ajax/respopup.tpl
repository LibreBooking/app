{if $authorized == true}
<div class="res_popup_details">
	<div class="user">{$fname} {$lname}</div>
	<div class="dates">{formatdate date=$startDate key=res_popup} - {formatdate date=$endDate key=res_popup}</div>	
	
	<div class="resources">
	{translate key="Resources"}
	{foreach $resources item=resource name=resource_loop}
		{$resource->Name()}, 
	{/foreach}
	</div>
	
	<div class="users">
	{translate key="Users"} ({$participants|@count})
	{foreach $participants item=user name=participant_loop}
		{if !$user->IsOwner()}
			{$user->FirstName} {$user->LastName}, 
		{/if}
	{/foreach}
	</div>
	
	<div class="summary">{$summary|truncate:300:"..."|nl2br}</div>	
	<!-- {$ReservationId} -->
</div>
{else}
	{translate key='InsufficientPermissionsError'}
{/if}