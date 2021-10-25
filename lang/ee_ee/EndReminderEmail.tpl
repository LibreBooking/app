Sinu broneering lõpeb varsti.<br/>
Broneeringu detailid:
	<br/>
	<br/>
	Algus: {formatdate date=$StartDate key=reservation_email}<br/>
	Lõpp: {formatdate date=$EndDate key=reservation_email}<br/>
	Väljak: {$ResourceName}<br/>
	Pealkiri: {$Title}<br/>
	Kirjeldus: {$Description|nl2br}
<br/>
<a href="{$ScriptUrl}/{$ReservationUrl}">Vaata seda broneeringut</a> |
<a href="{$ScriptUrl}/{$ICalUrl}">Lisa kalendrisse</a> |
<a href="{$ScriptUrl}">Logi sisse broneeringu kalendrisse</a>
