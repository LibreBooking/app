Erreserbaren xehetasunak:
<br/>
<br/>

Erabiltzailea: {$UserName}<br/>
Hasiera: {formatdate date=$StartDate key=reservation_email}<br/>
Amaiera: {formatdate date=$EndDate key=reservation_email}<br/>
{if $ResourceNames|count > 1}
    Baliabideak:
    <br/>
    {foreach from=$ResourceNames item=resourceName}
        {$resourceName}
        <br/>
    {/foreach}
{else}
    Baliabidea: {$ResourceName}
    <br/>
{/if}

{if $ResourceImage}
    <div class="resource-image"><img src="{$ScriptUrl}/{$ResourceImage}"/></div>
{/if}

Izenburua: {$Title}<br/>
Deskripzioa: {$Description|nl2br}<br/>
{$DeleteReason|nl2br}<br/>


{if count($RepeatDates) gt 0}
    <br/>
    Data hauek ezabatu dira:
    <br/>
{/if}

{foreach from=$RepeatDates item=date name=dates}
    {formatdate date=$date}
    <br/>
{/foreach}

{if $Accessories|count > 0}
    <br/>
    Osagarriak:
    <br/>
    {foreach from=$Accessories item=accessory}
        ({$accessory->QuantityReserved}) {$accessory->Name}
        <br/>
    {/foreach}
{/if}

<br/>
<br/>
<a href="{$ScriptUrl}">Saioa hasi Booked Scheduler-en</a>
