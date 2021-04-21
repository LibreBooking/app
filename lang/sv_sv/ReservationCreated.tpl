	Bokningsdetaljer:
	<br/>
	<br/>

	Er tid börjar: {formatdate date=$StartDate key=reservation_email}<br/>
	Välkommen till oss 10min innan bokad tid.<br/>

	Slutar: {formatdate date=$EndDate key=reservation_email}<br/>
	<br/>
	Bokning: {$ResourceName}<br/>

	{if $ResourceImage}
		<div class="resource-image"><img src="{$ScriptUrl}/{$ResourceImage}"/></div>
	{/if}

	<br/>
	Rubrik: {$Title}<br/>
	<br/>
	Beskrivning: {$Description|nl2br}<br/>

	{if count($RepeatDates) gt 0}
		<br/>
		Ni har reserverat följande tid / er:
		<br/>
	{/if}

	{foreach from=$RepeatDates item=date name=dates}
		{formatdate date=$date}<br/>
	{/foreach}

	{if $RequiresApproval}
		<br/>
		Innan er reservation övergår i bokning behöver den godkännas först.
	{/if}

	<br/>
	<a href="{$ScriptUrl}/{$ReservationUrl}">Visa Bokning</a> |
	<a href="{$ScriptUrl}/{$ICalUrl}">Lägg till i Outlook</a> |
	<a href="{$ScriptUrl}">Logga in i Bokningsprogrammet</a>

