Zure erreeserba laster hasiko da.<br/>
Erreserbaren xehetasunak:
	<br/>
	<br/>
	Hasiera: {formatdate date=$StartDate key=reservation_email}<br/>
	Data: {formatdate date=$EndDate key=reservation_email}<br/>
	Baliabidea: {$ResourceName}<br/>
	Izenburua: {$Title}<br/>
	Deskripzioa: {$Description|nl2br}<br/>
<br/>
<br/>
<a href="{$ScriptUrl}/{$ReservationUrl}">Erreserba hau ikusi</a> |
<a href="{$ScriptUrl}/{$ICalUrl}">Egutegi batera gehitu</a> |
<a href="{$ScriptUrl}">Saioa hasi LibreBooking-en</a>
