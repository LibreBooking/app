Oplysninger om reservation:
<br/>
<br/>

Begynder: {formatdate date=$StartDate key=reservation_email}<br/>
Slutter: {formatdate date=$EndDate key=reservation_email}<br/>
{if $ResourceNames|default:array()|count > 1}
    Faciliteter:
    <br/>
    {foreach from=$ResourceNames item=resourceName}
        {$resourceName}
        <br/>
    {/foreach}
{else}
    Facilitet: {$ResourceName}
    <br/>
{/if}

Overskrift: {$Title}<br/>
Beskrivelse: {$Description|nl2br}

{if $Accessories|default:array()|count > 0}
    <br/>
    Udstyr:
    <br/>
    {foreach from=$Accessories item=accessory}
        ({$accessory->QuantityReserved}) {$accessory->Name}
        <br/>
    {/foreach}
{/if}


<br/>
Referencenummer: {$ReferenceNumber}

<br/>
<br/>
<a href="{$ScriptUrl}/{$ReservationUrl}">Se denne reservation</a> |
<a href="{$ScriptUrl}">Log på {$AppTitle}</a>
