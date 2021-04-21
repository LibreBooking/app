Detalles de la Reserva:
<br/>
<br/>

Usuario: {$UserName}<br/>
Inicio: {formatdate date=$StartDate key=reservation_email}<br/>
Fin: {formatdate date=$EndDate key=reservation_email}<br/>
{if $ResourceNames|count > 1}
    Recursos:
    <br/>
    {foreach from=$ResourceNames item=resourceName}
        {$resourceName}
        <br/>
    {/foreach}
{else}
    Recurso: {$ResourceName}
    <br/>
{/if}

{if $ResourceImage}
    <div class="resource-image"><img src="{$ScriptUrl}/{$ResourceImage}"/></div>
{/if}

Título: {$Title}<br/>
Descripción: {$Description|nl2br}<br/>
{$DeleteReason|nl2br}<br/>


{if count($RepeatDates) gt 0}
    <br/>
    Se han eliminado las siguientes fechas:
    <br/>
{/if}

{foreach from=$RepeatDates item=date name=dates}
    {formatdate date=$date}
    <br/>
{/foreach}

{if $Accessories|count > 0}
    <br/>
    Accesorios:
    <br/>
    {foreach from=$Accessories item=accessory}
        ({$accessory->QuantityReserved}) {$accessory->Name}
        <br/>
    {/foreach}
{/if}

<br/>
<br/>
<a href="{$ScriptUrl}">Iniciar sesión en Booked Scheduler</a>
