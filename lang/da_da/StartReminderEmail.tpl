Din reservation starter snart.<br/>
Oplysninger om reservation:
	<br/>
	<br/>
	Begynder: {formatdate date=$StartDate key=reservation_email}<br/>
	Slutter: {formatdate date=$EndDate key=reservation_email}<br/>
	Facilitet: {$ResourceName}<br/>
	Overskrift: {$Title}<br/>
	Beskrivelse: {$Description|nl2br}
<br/>
<br/>
<a href="{$ScriptUrl}/{$ReservationUrl}">Se denne reservation</a> |
<a href="{$ScriptUrl}/{$ICalUrl}">Tilføj til kalender</a> |
<a href="{$ScriptUrl}">Log på {$AppTitle}</a>
