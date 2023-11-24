<p>Je hebt je check in gemist.</p>
<p><strong>Reservering details:</strong></p>
<p>
	<strong>Start:</strong> {formatdate date=$StartDate key=reservation_email}<br/>
	<strong>Eind:</strong> {formatdate date=$EndDate key=reservation_email}<br/>
	<strong>Bron:</strong> {$ResourceName}<br/>
	<strong>Titel:</strong> {$Title}<br/>
	<strong>Omschrijving:</strong> {$Description|nl2br}
</p>

{if $IsAutoRelease}
	<p>Als je niet incheckt wordt deze reservering automatisch geanuleerd op {formatdate date=$AutoReleaseTime key=reservation_email}</p>
{/if}

<p>
	<a href="{$ScriptUrl}/{$ReservationUrl}">Bekijk deze reservering</a> |
	<a href="{$ScriptUrl}">Login op {$AppTitle}</a>
</p>
