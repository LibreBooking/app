	Détails de la réservation:
	<br/>
	<br/>

	Utilisateur: {$UserName}
	Début: {formatdate date=$StartDate key=reservation_email}<br/>
	Fin: {formatdate date=$EndDate key=reservation_email}<br/>
	Libellé: {$Title}<br/>
	Description: {$Description}<br/>

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
		Une ou plusieurs ressources réservées nécessitent une approbation.  Vérifiez que la demande de réservation soit approuvée ou rejetée.
	{/if}

	<br/>
	<a href="{$ScriptUrl}/{$ReservationUrl}">Voir cette réservation</a> | <a href="{$ScriptUrl}">Connexion à Booked Scheduler</a>


