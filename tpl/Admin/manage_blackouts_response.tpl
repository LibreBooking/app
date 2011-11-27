<div>
	{if $Successful}
		<h3>Blackout Created!</h3>
		<button class="reload button">{translate key="OK"}</button>
	{else}
		<h3>Blackout could not be created!</h3>
		<button class="close button">{translate key="OK"}</button>
	{/if}

	{$Message}

	{if !empty($Blackouts)}
		There are conflicting blackout times
		{foreach from=$Blackouts item=blackout}
			{format_date date=$blackout->StartDate timezone=$Timezone}
		{/foreach}
	{/if}

	{if !empty($Reservations)}
		There are conflicting reservations times
		{foreach from=$Reservations item=reservation}
			{format_date date=$reservation->StartDate timezone=$Timezone}
		{/foreach}
	{/if}
</div>