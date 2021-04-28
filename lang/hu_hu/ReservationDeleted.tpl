Foglalás részletei:
<br/>
<br/>

Felhasználó: {$UserName}<br/>
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

{if $ResourceImage}
    <div class="resource-image"><img src="{$ScriptUrl}/{$ResourceImage}"/></div>
{/if}

Megnevezés: {$Title}<br/>
Leírás: {$Description|nl2br}<br/>
Törlés oka: {$DeleteReason|nl2br}<br/>

{if count($RepeatRanges) gt 0}
    <br/>
    Az alábbi dátumok eltávolításra kerültek:
    <br/>
{/if}

{foreach from=$RepeatRanges item=date name=dates}
    {formatdate date=$date->GetBegin()}
    {if !$date->IsSameDate()} - {formatdate date=$date->GetEnd()}{/if}
    <br/>
{/foreach}

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
<a href="{$ScriptUrl}">Bejelentkezés ide: {$AppTitle}</a>
