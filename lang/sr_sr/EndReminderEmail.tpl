Vaša rezervacija uskoro ističe.<br/>
Detalji rezervacije:
	<br/>
	<br/>
	Početak: {formatdate date=$StartDate key=reservation_email}<br/>
	Kraj: {formatdate date=$EndDate key=reservation_email}<br/>
	Teren: {$ResourceName}<br/>
	Naziv: {$Title}<br/>
	Opis: {$Description|nl2br}<br/>
<br/>
<a href="{$ScriptUrl}/{$ReservationUrl}">Pregled rezervacije</a> |
<a href="{$ScriptUrl}/{$ICalUrl}">Dodaj u kalendar</a> |
<a href="{$ScriptUrl}">Uloguj se</a>

