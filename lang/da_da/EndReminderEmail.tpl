Denne reservation slutter snart.<br/>
	<br/>
	<br/>
	Starttidspunkt: {formatdate date=$StartDate key=reservation_email}<br/>
	Sluttidspunkt: {formatdate date=$EndDate key=reservation_email}<br/>
	Facilitet: {$ResourceName}<br/>
	Overskrift: {$Title}<br/>
	Beskrivelse: {$Description|nl2br}
<br/>
<a href="{$ScriptUrl}/{$ReservationUrl}">Se denne reservation</a> |
<a href="{$ScriptUrl}/{$ICalUrl}">Tilføj til kalender</a> |
<a href="{$ScriptUrl}">Log på {$AppTitle}</a>
