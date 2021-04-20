Ismétlődő foglalási sorozata {$ResourceName} hamarosan befejeződik {formatdate date=$StartDate key=reservation_email}.<br/>
Fogalás részletei:
	<br/>
	<br/>
	Kezdés: {formatdate date=$StartDate key=reservation_email}<br/>
	Befejezés: {formatdate date=$EndDate key=reservation_email}<br/>
	Elem: {$ResourceName}<br/>
	Megnevezés: {$Title}<br/>
	Leírás: {$Description|nl2br}
<br/>
<br/>
<a href="{$ScriptUrl}/{$ReservationUrl}">A foglalás megtekintése</a> |
<a href="{$ScriptUrl}">Bejelentkezés ide: {$AppTitle}</a>
