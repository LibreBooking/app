{*
Copyright 2011-2020 Nick Korbel

This file is part of Booked Scheduler.

Booked Scheduler is free software: you can redistribute it and/or modify
it under the terms of the GNU General Public License as published by
the Free Software Foundation, either version 3 of the License, or
(at your option) any later version.

Booked Scheduler is distributed in the hope that it will be useful,
but WITHOUT ANY WARRANTY; without even the implied warranty of
MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
GNU General Public License for more details.

You should have received a copy of the GNU General Public License
along with Booked Scheduler.  If not, see <http://www.gnu.org/licenses/>.
*}

{if $Deleted}
    <p>{$UserName} removeu a reserva</p>
    {else}
    <p>{$UserName} adicionou-o(a) à reserva</p>
{/if}

{if !empty($DeleteReason)}
    <p><strong>Motivo da exclusão:</strong>{$DeleteReason|nl2br}</p>
{/if}

<p><strong>Detalhes da Reserva:</strong></p>

<p>
    <strong>Início:</strong> {formatdate date=$StartDate key=reservation_email}<br/>
    <strong>Fim:</strong> {formatdate date=$EndDate key=reservation_email}<br/>
</p>

<p>
{if $ResourceNames|count > 1}
    <strong>Recursos ({$ResourceNames|count}):</strong> <br />
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
    <p>* Um ou mais recursos reservados requerem aprovação antes do uso. Esta reservation reserva ficará pendente até que seja aprovada. *</p>
{/if}

<p>
    <strong>Título:</strong> {$Title}<br/>
    <strong>Descrição:</strong> {$Description|nl2br}
</p>

{if count($RepeatRanges) gt 0}
    <br/>
    <strong>A reserva ocorre nas seguintes datas ({$RepeatRanges|count}):</strong>
    <br/>
{/if}

{foreach from=$RepeatRanges item=date name=dates}
    {formatdate date=$date->GetBegin()}
    {if !$date->IsSameDate()} - {formatdate date=$date->GetEnd()}{/if}
    <br/>
{/foreach}

{if $Participants|count >0}
    <br />
    <strong>Participantes ({$Participants|count + $ParticipatingGuests|count}):</strong>
    <br />
    {foreach from=$Participants item=user}
        {$user->FullName()}
        <br/>
    {/foreach}
{/if}

{if $ParticipatingGuests|count >0}
    {foreach from=$ParticipatingGuests item=email}
        {$email}
        <br/>
    {/foreach}
{/if}

{if $Invitees|count >0}
    <br />
    <strong>Convidados ({$Invitees|count + $InvitedGuests|count}):</strong>
    <br />
    {foreach from=$Invitees item=user}
        {$user->FullName()}
        <br/>
    {/foreach}
{/if}

{if $InvitedGuests|count >0}
    {foreach from=$InvitedGuests item=email}
        {$email}
        <br/>
    {/foreach}
{/if}

{if $Accessories|count > 0}
    <br />
       <strong>Acessórios ({$Accessories|count}):</strong>
       <br />
    {foreach from=$Accessories item=accessory}
        ({$accessory->QuantityReserved}) {$accessory->Name}
        <br/>
    {/foreach}
{/if}

{if !$Deleted && !$Updated}
<p>
    <strong>Aceitar?</strong> <a href="{$ScriptUrl}/{$AcceptUrl}">Sim</a> <a href="{$ScriptUrl}/{$DeclineUrl}">Não</a>
</p>
{/if}

{if !$Deleted}
<a href="{$ScriptUrl}/{$ReservationUrl}">Ver esta reserva</a> |
<a href="{$ScriptUrl}/{$ICalUrl}">Adicionar ao calendário</a> |
<a href="{$GoogleCalendarUrl}" target="_blank" rel="nofollow">Adicionar ao Google Calendar</a> |
{/if}
<a href="{$ScriptUrl}">Entrar em {$AppTitle}</a>
