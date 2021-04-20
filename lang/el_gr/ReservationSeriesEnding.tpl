<p>Η επαναλαμβανόμενη κράτησή σας για το {$ResourceName} τελειώνει στις {formatdate date=$StartDate key=reservation_email}.</p>
<p><strong>Πληροφορίες κράτησης:</strong></p>
<p>
	<strong>Έναρξη:</strong> {formatdate date=$StartDate key=reservation_email}<br/>
	<strong>Λήξη:</strong> {formatdate date=$EndDate key=reservation_email}<br/>
	<strong>Πόρος:</strong> {$ResourceName}<br/>
	<strong>Τίτλος:</strong> {$Title}<br/>
	<strong>Περιγραφή:</strong> {$Description|nl2br}
</p>

<p>
	<a href="{$ScriptUrl}/{$ReservationUrl}">Δείτε την κράτηση</a> |
	<a href="{$ScriptUrl}">Κάνετε είσοδο στο {$AppTitle}</a>
</p>
