Oplysninger om reservation:
<br/>
<br/>

Bruger: {$UserName}<br/>
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

{if $ResourceImage}
    <div class="resource-image"><img src="{$ScriptUrl}/{$ResourceImage}"/></div>
{/if}

Overskrift: {$Title}<br/>
Beskrivelse: {$Description|nl2br}<br/>
Årsag: {$DeleteReason|nl2br}<br/>

{if count($RepeatRanges) gt 0}
    <br/>
    Disse datoer er slettede:
    <br/>
{/if}

{foreach from=$RepeatRanges item=date name=dates}
    {formatdate date=$date->GetBegin()}
    {if !$date->IsSameDate()} - {formatdate date=$date->GetEnd()}{/if}
    <br/>
{/foreach}

{if $Accessories|default:array()|count > 0}
    <br/>
    Udstyr:
    <br/>
    {foreach from=$Accessories item=accessory}
        ({$accessory->QuantityReserved}) {$accessory->Name}
        <br/>
    {/foreach}
{/if}

{if !empty($CreatedBy)}
    <br/>
    Slettet af: {$CreatedBy}
{/if}

<br/>
Referencenummer: {$ReferenceNumber}

<br/>
<a href="{$ScriptUrl}">Log på {$AppTitle}</a>
