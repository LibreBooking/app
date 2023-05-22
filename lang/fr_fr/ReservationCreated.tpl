<p><strong>Détails de la réservation:</strong></p>

<p>
	<strong>Début:</strong> {formatdate date=$StartDate key=reservation_email}<br/>
	<strong>Fin:</strong> {formatdate date=$EndDate key=reservation_email}<br/>
	<strong>Libellé:</strong> {$Title}<br/>
	<strong>Description:</strong> {$Description|nl2br}
	{if $Attributes|default:array()|count > 0}
		<br/>
	    {foreach from=$Attributes item=attribute}
			<div>{control type="AttributeControl" attribute=$attribute readonly=true}</div>
	    {/foreach}
	{/if}
</p>

<p>
{if $ResourceNames|default:array()|count > 1}
    <strong>Ressources ({$ResourceNames|default:array()|count}):</strong> <br />
    {foreach from=$ResourceNames item=resourceName}
        {$resourceName}<br/>
    {/foreach}
{else}Title
    <strong>Resource:</strong> {$ResourceName}<br/>
{/if}
</p>

{if $ResourceImage}
    <div class="resource-image"><img alt="{$ResourceName|escape}" src="{$ScriptUrl}/{$ResourceImage}"/></div>
{/if}

{if $RequiresApproval}
	<p>* Une ou plusieurs ressources réservées nécessitent une validation avant leur utilisation. Cette réservation est en attente jusqu'à son approbation. *</p>
{/if}

{if $CheckInEnabled}
	<p>
	Au moins une des ressources réservées nécessite de faire un check-in et un check-out de votre réservation.
    {if $AutoReleaseMinutes != null}
		Cette réservation sera annulée si vous ne faîtes pas un check-in dans les {$AutoReleaseMinutes} minutes qui suivent l'heure de début.
    {/if}
	</p>
{/if}

{if count($RepeatRanges) gt 0}
    <br/>
    <strong>La réservation se répète aux dates suivantes ({$RepeatRanges|default:array()|count}):</strong>
    <br/>
	{foreach from=$RepeatRanges item=date name=dates}
	    {formatdate date=$date->GetBegin()}
	    {if !$date->IsSameDate()} - {formatdate date=$date->GetEnd()}{/if}
	    <br/>
	{/foreach}
{/if}

{if $Participants|default:array()|count >0}
    <br />
    <strong>Participants ({$Participants|default:array()|count + $ParticipatingGuests|default:array()|count}):</strong>
    <br />
    {foreach from=$Participants item=user}
        {$user->FullName()}
        <br/>
    {/foreach}
{/if}

{if $ParticipatingGuests|default:array()|count >0}
    {foreach from=$ParticipatingGuests item=email}
        {$email}
        <br/>
    {/foreach}
{/if}

{if $Invitees|default:array()|count >0}
    <br />
    <strong>Invités ({$Invitees|default:array()|count + $InvitedGuests|default:array()|count}):</strong>
    <br />
    {foreach from=$Invitees item=user}
        {$user->FullName()}
        <br/>
    {/foreach}
{/if}

{if $InvitedGuests|default:array()|count >0}
    {foreach from=$InvitedGuests item=email}
        {$email}
        <br/>
    {/foreach}
{/if}

{if $Accessories|default:array()|count > 0}
    <br />
       <strong>Accessoires ({$Accessories|default:array()|count}):</strong>
       <br />
    {foreach from=$Accessories item=accessory}
        ({$accessory->QuantityReserved}) {$accessory->Name}
        <br/>
    {/foreach}
{/if}

{if $CreditsCurrent > 0}
	<br/>
	Cette réservation coûte {$CreditsCurrent} crédits.
    {if $CreditsCurrent != $CreditsTotal}
		La série complète de réservations coûte {$CreditsTotal} crédits.
    {/if}
{/if}


{if !empty($CreatedBy)}
	<p><strong>Créé par:</strong> {$CreatedBy}</p>
{/if}

{if !empty($ApprovedBy)}
	<p><strong>Approuvé par:</strong> {$ApprovedBy}</p>
{/if}

<p><strong>Numéro de réference:</strong> {$ReferenceNumber}</p>

{if !$Deleted}
	<a href="{$ScriptUrl}/{$ReservationUrl}">Voir cette réservation</a>
	|
	<a href="{$ScriptUrl}/{$ICalUrl}">Ajouter au calendrier</a>
	|
	<a href="{$GoogleCalendarUrl}" target="_blank" rel="nofollow">Ajouter au calendrier Google</a>
	|
{/if}
<a href="{$ScriptUrl}">Connexion à {$AppTitle}</a>

