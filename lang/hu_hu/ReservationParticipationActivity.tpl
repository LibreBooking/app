Foglalás részletei:
<br/>
<br/>

Kezdés: {formatdate date=$StartDate key=reservation_email}<br/>
Befejezés: {formatdate date=$EndDate key=reservation_email}<br/>
{if $ResourceNames|default:array()|count > 1}
    Elemek:
    <br/>
    {foreach from=$ResourceNames item=resourceName}
        {$resourceName}
        <br/>
    {/foreach}
{else}
    Elem: {$ResourceName}
    <br/>
{/if}

Megnevezés: {$Title}<br/>
Leírás: {$Description|nl2br}

{if $Accessories|default:array()|count > 0}
    <br/>
    Kiegészítők:
    <br/>
    {foreach from=$Accessories item=accessory}
        ({$accessory->QuantityReserved}) {$accessory->Name}
        <br/>
    {/foreach}
{/if}


<br/>
Referenciaszám: {$ReferenceNumber}

<br/>
<br/>
<a href="{$ScriptUrl}/{$ReservationUrl}">A fogalás megtekintése</a> |
<a href="{$ScriptUrl}">Bejelentkezés ide: {$AppTitle}</a>
