Detalji o rezervaciji:
<br/>
<br/>

Korisnik: {$UserName}<br/>
Pocetak: {formatdate date=$StartDate key=reservation_email}<br/>
Kraj: {formatdate date=$EndDate key=reservation_email}<br/>
{if $ResourceNames|default:array()|count > 1}
    Tereni:
    <br/>
    {foreach from=$ResourceNames item=resourceName}
        {$resourceName}
        <br/>
    {/foreach}
{else}
    Tereni: {$ResourceName}
    <br/>
{/if}

{if $ResourceImage}
    <div class="resource-image"><img src="{$ScriptUrl}/{$ResourceImage}"/></div>
{/if}

Naziv: {$Title}<br/>
Opis: {$Description|nl2br}<br/>
{$DeleteReason|nl2br}<br/>


{if count($RepeatDates) gt 0}
    <br/>
    Navedeni datumi su obrisani:
    <br/>
{/if}

{foreach from=$RepeatDates item=date name=dates}
    {formatdate date=$date}
    <br/>
{/foreach}

{if $Accessories|default:array()|count > 0}
    <br/>
    Dodatno:
    <br/>
    {foreach from=$Accessories item=accessory}
        ({$accessory->QuantityReserved}) {$accessory->Name}
        <br/>
    {/foreach}
{/if}
<br/>
<a href="{$ScriptUrl}">Ulogiraj se</a>

