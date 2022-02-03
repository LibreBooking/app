	Détails de la réservation:
	<br/>
	<br/>

	Début: {formatdate date=$StartDate key=reservation_email}<br/>
	Fin: {formatdate date=$EndDate key=reservation_email}<br/>
	Libellé: {$Title}<br/>
	Description: {$Description|nl2br}<br/>

	{if count($RepeatDates) gt 0}
		<br/>
		La réservation se répète aux dates suivantes:
		<br/>
	{/if}

	{foreach from=$RepeatDates item=date name=dates}
		{formatdate date=$date}<br/>
	{/foreach}

	{if $RequiresApproval}
		<br/>
		Une ou plusieurs ressources réservées nécessitent une approbation. Cette réservation sera donc provisoirement mise en attente puis un administrateur la validera (ou non)
	{/if}

	<br/>
	Confirmer votre présence? <a href="{$ScriptUrl}/{$AcceptUrl}">Oui</a> <a href="{$ScriptUrl}/{$DeclineUrl}">Non</a>
	<br/>

	<a href="{$ScriptUrl}/{$ReservationUrl}">Voir cette réservation</a> |
	<a href="{$ScriptUrl}/{$ICalUrl}">Ajouter à Outlook</a> |
	<a href="{$ScriptUrl}">Connexion à LibreBooking</a>


