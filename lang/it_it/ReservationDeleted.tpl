Dettagli prenotazione:
<br/>
<br/>

Utente: {$UserName}<br/>
Inizio: {formatdate date=$StartDate key=reservation_email}<br/>
Fine: {formatdate date=$EndDate key=reservation_email}<br/>
{if $ResourceNames|count > 1}
    Risorse:
    <br/>
    {foreach from=$ResourceNames item=resourceName}
        {$resourceName}
        <br/>
    {/foreach}
{else}
    Risorsa: {$ResourceName}
    <br/>
{/if}

{if $ResourceImage}
    <div class="resource-image"><img src="{$ScriptUrl}/{$ResourceImage}"/></div>
{/if}

Note: {$Title}<br/>
Descrizione: {$Description|nl2br}<br/>
{$DeleteReason|nl2br}<br/>


{if count($RepeatDates) gt 0}
    <br/>
    Le seguenti date sono state rimosse:
    <br/>
{/if}

{foreach from=$RepeatDates item=date name=dates}
    {formatdate date=$date}
    <br/>
{/foreach}

{if $Accessories|count > 0}
    <br/>
    Accessori:
    <br/>
    {foreach from=$Accessories item=accessory}
        ({$accessory->QuantityReserved}) {$accessory->Name}
        <br/>
    {/foreach}
{/if}

<br/>
<br/>
<a href="{$ScriptUrl}">Accedi a Booked Scheduler</a>

