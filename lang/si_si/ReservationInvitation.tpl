	Podrobnosti rezervacije:
	<br/>
	<br/>

	Začetek: {formatdate date=$StartDate key=reservation_email}<br/>
	Konec: {formatdate date=$EndDate key=reservation_email}<br/>
	Vir: {$ResourceName}<br/>

	{if $ResourceImage}
		<div class="resource-image"><img src="{$ScriptUrl}/{$ResourceImage}"/></div>
	{/if}

	Nalsov: {$Title}<br/>
	Opis: {$Description|nl2br}<br/>

	{if count($RepeatDates) gt 0}
		<br/>
		Rezervacija je narejena za naslednje dneve:
		<br/>
	{/if}

	{foreach from=$RepeatDates item=date name=dates}
		{formatdate date=$date}<br/>
	{/foreach}

	{if $RequiresApproval}
		<br/>
		Eden ali več rezerviranih virov pred uporabo potrebuje potrditev. Ta rezervacija je na čakanju, dokler ni potrjena.
	{/if}

	<br/>
	Sprejmete? <a href="{$ScriptUrl}/{$AcceptUrl}">Da</a> <a href="{$ScriptUrl}/{$DeclineUrl}">Ne</a>
	<br/>

	<a href="{$ScriptUrl}/{$ReservationUrl}">Ogled rezervacije</a> |
	<a href="{$ScriptUrl}/{$ICalUrl}">Dodaj v Koledar (Outlook)</a> |
	<a href="{$ScriptUrl}">Prijava v program LibreBooking</a>
