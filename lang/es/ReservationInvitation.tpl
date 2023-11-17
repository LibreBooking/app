{if $Deleted}
    <p>{$UserName} ha eliminado una reserva</p>
    {else}
    <p>{$UserName} te ha añadido a una reserva</p>
{/if}

{if !empty($DeleteReason)}
    <p><strong>Motivo de Eliminación:</strong>{$DeleteReason|nl2br}</p>
{/if}

<p><strong>Detalles de la Reserva:</strong></p>

<p>
    <strong>Inicio:</strong> {formatdate date=$StartDate key=reservation_email}<br/>
    <strong>Fin:</strong> {formatdate date=$EndDate key=reservation_email}<br/>
</p>

<p>
{if $ResourceNames|default:array()|count > 1}
    <strong>Recursos ({$ResourceNames|default:array()|count}):</strong> <br />
    {foreach from=$ResourceNames item=resourceName}
        {$resourceName}<br/>
    {/foreach}
{else}
    <strong>Recurso:</strong> {$ResourceName}<br/>
{/if}
</p>

{if $ResourceImage}
    <div class="resource-image"><img alt="{$ResourceName|escape}" src="{$ScriptUrl}/{$ResourceImage}"/></div>
{/if}

{if $RequiresApproval && !$Deleted}
    <p>* Uno o más de los recursos reservados requieren aprobación antes de su uso. Esta reserva estará pendiente hasta que sea aprobada. *</p>
{/if}

<p>
    <strong>Título:</strong> {$Title}<br/>
    <strong>Descripción:</strong> {$Description|nl2br}
</p>

{if count($RepeatRanges) gt 0}
    <br/>
    <strong>La reserva ocurre en las siguientes fechas ({$RepeatRanges|default:array()|count}):</strong>
    <br/>
{/if}

{foreach from=$RepeatRanges item=date name=dates}
    {formatdate date=$date->GetBegin()}
    {if !$date->IsSameDate()} - {formatdate date=$date->GetEnd()}{/if}
    <br/>
{/foreach}

{if $Participants|default:array()|count >0}
    <br />
    <strong>Participantes ({$Participants|default:array()|count + $ParticipatingGuests|default:array()|count}):</strong>
    <br />
    {foreach from=$Participants item=user}
        {$user->FullName()}
        <br/>
    {/foreach}
{/if}

{if $ParticipatingGuests|default:array()|count >0}
    {foreach from=$ParticipatingGuests item=email}
        {$email}
        <br/>
    {/foreach}
{/if}

{if $Invitees|default:array()|count >0}
    <br />
    <strong>Invitados ({$Invitees|default:array()|count + $InvitedGuests|default:array()|count}):</strong>
    <br />
    {foreach from=$Invitees item=user}
        {$user->FullName()}
        <br/>
    {/foreach}
{/if}

{if $InvitedGuests|default:array()|count >0}
    {foreach from=$InvitedGuests item=email}
        {$email}
        <br/>
    {/foreach}
{/if}

{if $Accessories|default:array()|count > 0}
    <br />
       <strong>Accesorios ({$Accessories|default:array()|count}):</strong>
       <br />
    {foreach from=$Accessories item=accessory}
        ({$accessory->QuantityReserved}) {$accessory->Name}
        <br/>
    {/foreach}
{/if}

{if !$Deleted && !$Updated}
<p>
    <strong>¿Asistir?</strong> <a href="{$ScriptUrl}/{$AcceptUrl}">Si</a> <a href="{$ScriptUrl}/{$DeclineUrl}">No</a>
</p>
{/if}

{if !$Deleted}
<a href="{$ScriptUrl}/{$ReservationUrl}">Ver esta reserva</a> |
<a href="{$ScriptUrl}/{$ICalUrl}">Agregar a un calendario</a> |
<a href="{$GoogleCalendarUrl}" target="_blank" rel="nofollow">Agregar a Google Calendar</a> |
{/if}
<a href="{$ScriptUrl}">Iniciar sesión en {$AppTitle}</a>
