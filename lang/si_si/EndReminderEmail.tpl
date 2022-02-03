Vaša rezervacija bo kmalu potekla.<br/>
Podrobnosti rezervacije:
	<br/>
	<br/>
	Začetek: {formatdate date=$StartDate key=reservation_email}<br/>
	Konec: {formatdate date=$EndDate key=reservation_email}<br/>
	Vir: {$ResourceName}<br/>
	Naslov: {$Title}<br/>
	Opis: {$Description|nl2br}<br/>
<br/>
<a href="{$ScriptUrl}/{$ReservationUrl}">Ogled rezervacije</a> |
<a href="{$ScriptUrl}/{$ICalUrl}">Dodaj v Koledar (Outlook)</a> |
<a href="{$ScriptUrl}">Prijava v program LibreBooking</a>
