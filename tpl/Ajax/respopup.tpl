{if $authorized == true}
	{$ReservationId}<br/>
	{$startDate->Format('Y-m-d H:i')} - {$endDate->Format('Y-m-d H:i')}<br/>
	<b>{$fname} {$lname}</b><br/>
	<i>{$summary}</i>
{else}
	Not Authorized
{/if}