<p><strong>Détails de la réservation:</strong></p>

<p>
	<strong>Utilisateur:</strong> {$UserName}<br/>
    {if !empty($CreatedBy)}
		<strong>Créé par:</strong>
        {$CreatedBy}
		<br/>
    {/if}
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
		<strong>Ressources:</strong>
		<br/>
        {foreach from=$ResourceNames item=resourceName}
            {$resourceName}
			<br/>
        {/foreach}
    {else}
		<strong>Ressource:</strong>
        {$ResourceName}
    {/if}
</p>

{if $ResourceImage}
	<div class="resource-image"><img alt="{$ResourceName}" src="{$ScriptUrl}/{$ResourceImage}"/></div>
{/if}


{if $RequiresApproval}
	<p>* Une ou plusieurs ressources réservées nécessitent une approbation. Vérifiez que la demande de réservation soit approuvée ou rejetée. *</p>
{/if}

{if $CheckInEnabled}
	<p>
		Une ou plusieurs ressources réservées nécessitent que l'utilisateur fasse un check-in et un check-out de la réservation.
        {if $AutoReleaseMinutes != null}
			Cette réservation sera annulée sauf si vous faîtes un check-in dans les {$AutoReleaseMinutes} minutes suivant l'heure de début.
        {/if}
	</p>
{/if}

{if count($RepeatRanges) gt 0}
	<p>
		Cette réservation se répète aux dates suivantes ({$RepeatRanges|default:array()|count}):
		<br/>
        {foreach from=$RepeatRanges item=date name=dates}
            {formatdate date=$date->GetBegin()}
            {if !$date->IsSameDate()} - {formatdate date=$date->GetEnd()}{/if}
			<br/>
        {/foreach}
	</p>
{/if}

{if $Participants|default:array()|count >0}
	<br/>
	<strong>Participants ({$Participants|default:array()|count + $ParticipatingGuests|default:array()|count}):</strong>
	<br/>
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
	<br/>
	<strong>Invités ({$Invitees|default:array()|count + $InvitedGuests|default:array()|count}):</strong>
	<br/>
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
	<br/>
	<strong>Accessoires ({$Accessories|default:array()|count}):</strong>
	<br/>
    {foreach from=$Accessories item=accessory}
		({$accessory->QuantityReserved}) {$accessory->Name}
		<br/>
    {/foreach}
{/if}

<p><strong>Numéro de réference:</strong> {$ReferenceNumber}</p>

<p>
	<a href="{$ScriptUrl}/{$ReservationUrl}">Voir cette réservation</a> | <a href="{$ScriptUrl}">Connexion à {$AppTitle}</a>
</p>
