<p>Je terugkerende reserveringen voor {$ResourceName} gaan eindigen op {formatdate date=$StartDate key=reservation_email}.</p>
<p><strong>Reservering details:</strong></p>
<p>
	<strong>Start:</strong> {formatdate date=$StartDate key=reservation_email}<br/>
	<strong>Eind:</strong> {formatdate date=$EndDate key=reservation_email}<br/>
	<strong>Bron:</strong> {$ResourceName}<br/>
	<strong>Titel:</strong> {$Title}<br/>
	<strong>Omschrijving:</strong> {$Description|nl2br}
</p>

<p>
	<a href="{$ScriptUrl}/{$ReservationUrl}">Bekijk de reservering</a> |
	<a href="{$ScriptUrl}">Login in {$AppTitle}</a>
</p>
