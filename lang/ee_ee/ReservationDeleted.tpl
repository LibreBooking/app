Broneeringu detailid:
<br/>
<br/>

Kasutaja: {$UserName}<br/>
Algus: {formatdate date=$StartDate key=reservation_email}<br/>
Lõpp: {formatdate date=$EndDate key=reservation_email}<br/>
{if $ResourceNames|default:array()|count > 1}
    Väljakud:
    <br/>
    {foreach from=$ResourceNames item=resourceName}
        {$resourceName}
        <br/>
    {/foreach}
{else}
    Väljak: {$ResourceName}
    <br/>
{/if}

{if $ResourceImage}
    <div class="resource-image"><img src="{$ScriptUrl}/{$ResourceImage}"/></div>
{/if}

Pealkiri: {$Title}<br/>
Kirjeldus: {$Description|nl2br}
{$DeleteReason|nl2br}<br/>


{if count($RepeatDates) gt 0}
    <br/>
    Järgnevad ajad on tühistatud:
    <br/>
{/if}

{foreach from=$RepeatDates item=date name=dates}
    {formatdate date=$date}
    <br/>
{/foreach}

{if $Accessories|default:array()|count > 0}
    <br/>
    Accessories:
    <br/>
    {foreach from=$Accessories item=accessory}
        ({$accessory->QuantityReserved}) {$accessory->Name}
        <br/>
    {/foreach}
{/if}

<br/>
<br/>
<a href="{$ScriptUrl}">Logi sisse Rannahalli kalendrisse</a>
