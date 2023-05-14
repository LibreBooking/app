{if $Deleted}
    <p>{$UserName} a supprimé la réservation</p>
    {else}
    <p>{$UserName} vous a ajouté à la réservation</p>
{/if}

{if !empty($DeleteReason)}
    <p><strong>Raison de l'annulation:</strong>{$DeleteReason|nl2br}</p>
{/if}

<p><strong>Détails de la réservation:</strong></p>

<p>
    <strong>Début:</strong> {formatdate date=$StartDate key=reservation_email}<br/>
    <strong>Fin:</strong> {formatdate date=$EndDate key=reservation_email}<br/>
</p>

<p>
{if $ResourceNames|default:array()|count > 1}
    <strong>Ressources ({$ResourceNames|default:array()|count}):</strong> <br />
    {foreach from=$ResourceNames item=resourceName}
        {$resourceName}<br/>
    {/foreach}
{else}
    <strong>Ressource:</strong> {$ResourceName}<br/>
{/if}
</p>

{if $ResourceImage}
    <div class="resource-image"><img alt="{$ResourceName|escape}" src="{$ScriptUrl}/{$ResourceImage}"/></div>
{/if}

{if $RequiresApproval && !$Deleted}
    <p>* Une ou plusieurs ressources réservées nécessitent une approbation avant leur utilisation. Cette réservation est en attente jusqu'à son approbation. *</p>
{/if}

<p>
    <strong>Libellé:</strong> {$Title}<br/>
    <strong>Description:</strong> {$Description|nl2br}
</p>

{if count($RepeatRanges) gt 0}
    <br/>
    <strong>Cette réservation se répète aux dates suivantes ({$RepeatRanges|default:array()|count}):</strong>
    <br/>
{/if}

{foreach from=$RepeatRanges item=date name=dates}
    {formatdate date=$date->GetBegin()}
    {if !$date->IsSameDate()} - {formatdate date=$date->GetEnd()}{/if}
    <br/>
{/foreach}

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

{if !$Deleted && !$Updated}
<p>
    <strong>Votre présence?</strong> <a href="{$ScriptUrl}/{$AcceptUrl}">Oui</a> <a href="{$ScriptUrl}/{$DeclineUrl}">Non</a>
</p>
{/if}

{if !$Deleted}
<a href="{$ScriptUrl}/{$ReservationUrl}">Voir cette réservation</a> |
<a href="{$ScriptUrl}/{$ICalUrl}">Ajouter au calendrier</a> |
<a href="{$GoogleCalendarUrl}" target="_blank" rel="nofollow">Ajouter au calendrier Google</a> |
{/if}
<a href="{$ScriptUrl}">Connexion à {$AppTitle}</a>
