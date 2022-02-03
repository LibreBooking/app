	פרטי הזמנה:
	<br/>
	<br/>

	משתמש: {$UserName}
	החל מ-: {formatdate date=$StartDate key=reservation_email}<br/>
	עד: {formatdate date=$EndDate key=reservation_email}<br/>
	{if $ResourceNames|default:array()|count > 1}
		משאבים:<br/>
		{foreach from=$ResourceNames item=resourceName}
			{$resourceName}<br/>
		{/foreach}
		{else}
		משאב: {$ResourceName}<br/>
	{/if}
	כותר: {$Title}<br/>
	תאור: {$Description}<br/>

	{if count($RepeatDates) gt 0}
		<br/>
		ההזמנה קיימת בתאריכים אלו:
		<br/>
	{/if}

	{foreach from=$RepeatDates item=date name=dates}
		{formatdate date=$date}<br/>
	{/foreach}

	{if $Accessories|default:array()|count > 0}
		<br/>אביזרים:<br/>
		{foreach from=$Accessories item=accessory}
			({$accessory->QuantityReserved}) {$accessory->Name}<br/>
		{/foreach}
	{/if}

	{if $RequiresApproval}
		<br/>
                לאחד או יותר מהמשאבים המוזמנים דרוש אישור לפני שימוש. נא לוודא אישור של בקשת הזמנה זו.
	{/if}

	<br/>
	<a href="{$ScriptUrl}/{$ReservationUrl}">לצפות בהזמנה זו</a> | <a href="{$ScriptUrl}">כניסה ל-LibreBooking</a>


