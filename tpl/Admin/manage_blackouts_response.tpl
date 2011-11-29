<div>
	{if $Successful}
		<h3>Blackout Created!</h3>
		<button class="reload button">{translate key="OK"}</button>
	{else}
		<h3>Blackout could not be created!</h3>
		<button class="close button">{translate key="OK"}</button>
	{/if}

	{if !empty($Message)}
		<h5>{$Message}</h5>
	{/if}

	{if !empty($Blackouts)}
		<h5>There are conflicting blackout times</h5>
		{foreach from=$Blackouts item=blackout}
			{format_date date=$blackout->StartDate timezone=$Timezone}
		{/foreach}
	{/if}

	{if !empty($Reservations)}
		<h5>There are conflicting reservations times</h5>
		{foreach from=$Reservations item=reservation}
			{format_date date=$reservation->StartDate timezone=$Timezone}
		{/foreach}
	{/if}
</div>