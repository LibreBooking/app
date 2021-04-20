Foglalása hamarosan befejeződik.<br/>
A foglalás részletei:
	<br/>
	<br/>
	Kezdés: {formatdate date=$StartDate key=reservation_email}<br/>
	Befejezés: {formatdate date=$EndDate key=reservation_email}<br/>
	Elem: {$ResourceName}<br/>
	Megnevezés: {$Title}<br/>
	Leírás: {$Description|nl2br}
<br/>
<a href="{$ScriptUrl}/{$ReservationUrl}">Ezen foglalás megtekintése</a> |
<a href="{$ScriptUrl}/{$ICalUrl}">Naptárhoz adás</a> |
<a href="{$ScriptUrl}">Bejelentkezés ide: {$AppTitle}</a>
