Détails de la réservation :
<br/>
<br/>

Début: {formatdate date=$StartDate key=reservation_email}<br/>
Fin: {formatdate date=$EndDate key=reservation_email}<br/>
{if $ResourceNames|default:array()|count > 1}
    Ressources:
    <br/>
    {foreach from=$ResourceNames item=resourceName}
        {$resourceName}
        <br/>
    {/foreach}
{else}
    Ressource: {$ResourceName}
    <br/>
{/if}
Libellé: {$Title}<br/>
Description: {$Description|nl2br}<br/>
{$DeleteReason|nl2br}<br/>

{if count($RepeatDates) gt 0}
    <br/>
    Les dates suivantes ont été effacées:
    <br/>
{/if}

{foreach from=$RepeatDates item=date name=dates}
    {formatdate date=$date}
    <br/>
{/foreach}

{if $Accessories|default:array()|count > 0}
    <br/>
    Accessoires:
    <br/>
    {foreach from=$Accessories item=accessory}
        ({$accessory->QuantityReserved}) {$accessory->Name}
        <br/>
    {/foreach}
{/if}

<a href="{$ScriptUrl}">Connexion à LibreBooking</a>


