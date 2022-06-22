<p>Twoja seria cyklicznych rezerwacji zasobu {$ResourceName} kończy się {formatdate date=$StartDate key=reservation_email}.</p>
<p><strong>Szczegóły rezerwacji:</strong></p>
<p>
	<strong>Początek:</strong> {formatdate date=$StartDate key=reservation_email}<br/>
	<strong>Koniec:</strong> {formatdate date=$EndDate key=reservation_email}<br/>
	<strong>Zasób:</strong> {$ResourceName}<br/>
	<strong>Tytuł:</strong> {$Title}<br/>
	<strong>Opis:</strong> {$Description|nl2br}
</p>

<p>
	<a href="{$ScriptUrl}/{$ReservationUrl}">Pokaż rezerwację</a> |
	<a href="{$ScriptUrl}">Zaloguj się do {$AppTitle}</a>
</p>
