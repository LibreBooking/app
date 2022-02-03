    פרטי ההזמנה:
	<br/>
	<br/>

	התחלה: {formatdate date=$StartDate key=reservation_email}<br/>
	סיום: {formatdate date=$EndDate key=reservation_email}<br/>
	{if $ResourceNames|default:array()|count > 1}
		משאבים:<br/>
		{foreach from=$ResourceNames item=resourceName}
			{$resourceName}<br/>
		{/foreach}
		{else}
		משאב: {$ResourceName}<br/>
	{/if}
	כותר: {$Title}<br/>
	תאור: {$Description|nl2br}<br/>

	{if count($RepeatDates) gt 0}
		<br/>
		ההזמנה מתקיימת בתאריכים הבאים:
		<br/>
	{/if}

	{foreach from=$RepeatDates item=date name=dates}
		{formatdate date=$date}<br/>
	{/foreach}

	{if $Accessories|default:array()|count > 0}
		<br/>משאבים:<br/>
		{foreach from=$Accessories item=accessory}
			({$accessory->QuantityReserved}) {$accessory->Name}<br/>
		{/foreach}
	{/if}

	{if $RequiresApproval}
		<br/>
                אחד או יותר מהמשאבים המבוקשים דורש אישור. ההזמנה במצב המתנה עד שתאושר.
	{/if}

	<br/>
	משתתף? <a href="{$ScriptUrl}/{$AcceptUrl}">כן</a> <a href="{$ScriptUrl}/{$DeclineUrl}">לא</a>
	<br/>

	<a href="{$ScriptUrl}/{$ReservationUrl}">לצפות בהזמנה זו</a> |
	<a href="{$ScriptUrl}/{$ICalUrl}">להוסיף ללוח אישי בדואר אלקרוני</a> |
	<a href="{$ScriptUrl}">להתחבר ל-LibreBooking</a>


