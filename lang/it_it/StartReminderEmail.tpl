La tua prenotazione sta per iniziare.<br />
Dettagli prenotazione:
	<br />
	<br />
	Inizio: {formatdate date=$StartDate key=reservation_email}<br />
	Fine: {formatdate date=$EndDate key=reservation_email}<br />
	Risorsa: {$ResourceName}<br />
	Note: {$Title}<br />
	Descrizione: {$Description|nl2br}<br />
<br />
<br />
<a href="{$ScriptUrl}/{$ReservationUrl}">Vedi questa prenotazione</a> |
<a href="{$ScriptUrl}/{$ICalUrl}">Aggiungi al calendario</a> |
<a href="{$ScriptUrl}">Accedi a Booked Scheduler</a>

