Zure erreserba laster amaituko da.<br/>
Erreserbaren xehetasunak:
	<br/>
	<br/>
	Hasiera: {formatdate date=$StartDate key=reservation_email}<br/>
	Amaiera: {formatdate date=$EndDate key=reservation_email}<br/>
	Baliabidea: {$ResourceName}<br/>
	Izenburua: {$Title}<br/>
	Deskripzioa: {$Description|nl2br}<br/>
<br/>
<a href="{$ScriptUrl}/{$ReservationUrl}">Ikusi erreserba hau</a> |
<a href="{$ScriptUrl}/{$ICalUrl}">Gehitu egutegi bati</a> |
<a href="{$ScriptUrl}">Saioa hasi LibreBooking-en</a>
