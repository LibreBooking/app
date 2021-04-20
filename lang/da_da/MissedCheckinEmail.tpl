Du har ikke tjekket ind på din reservation.<br/>
	<br/>
	<br/>
	Starttidspunkt: {formatdate date=$StartDate key=reservation_email}<br/>
	Sluttidspunkt: {formatdate date=$EndDate key=reservation_email}<br/>
	Facilitet: {$ResourceName}<br/>
  Overskrift: {$Title}<br/>
	Beskrivelse: {$Description|nl2br}
    {if $IsAutoRelease}
        <br/>
        Hvis du ikke tjekker ind, bliver reservationen automatisk slettet den {formatdate date=$AutoReleaseTime key=reservation_email}
    {/if}
<br/>
<br/>
<a href="{$ScriptUrl}/{$ReservationUrl}">Se denne reservation</a> |
<a href="{$ScriptUrl}">Log på {$AppTitle}</a>
