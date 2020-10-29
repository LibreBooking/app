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
<p><strong>Detalhes da Reserva:</strong></p>

<p>
	<strong>Utilizador:</strong> {$UserName}<br/>
    {if !empty($CreatedBy)}
		<strong>Criado por:</strong>
        {$CreatedBy}
		<br/>
    {/if}
	<strong>Start:</strong> {formatdate date=$StartDate key=reservation_email}<br/>
	<strong>Início:</strong> {formatdate date=$EndDate key=reservation_email}<br/>
	<strong>Título:</strong> {$Title}<br/>
	<strong>Descrição:</strong> {$Description|nl2br}
    {if $Attributes|count > 0}
	<br/>
    {foreach from=$Attributes item=attribute}
	<div>{control type="AttributeControl" attribute=$attribute readonly=true}</div>
    {/foreach}
{/if}
</p>

<p>
    {if $ResourceNames|count > 1}
		<strong>Recursos:</strong>
		<br/>
        {foreach from=$ResourceNames item=resourceName}
            {$resourceName}
			<br/>
        {/foreach}
    {else}
		<strong>Recurso:</strong>
        {$ResourceName}
    {/if}
</p>

{if $ResourceImage}
	<div class="resource-image"><img alt="{$ResourceName}" src="{$ScriptUrl}/{$ResourceImage}"/></div>
{/if}


{if $RequiresApproval}
	<p>* Pelo menos um dos recursos reservados requer aprovação antes do uso. Por favor garanta que este pedido de reserva é aprovado ou rejeitado. *</p>
{/if}

{if $CheckInEnabled}
	<p>
		Pelo menos um dos recursos reservados requer que seja efetuado o check-in/check-out da reserva.
        {if $AutoReleaseMinutes != null}
			Esta reserva será cancelada a não ser que o check-in seja efetuado dentro de {$AutoReleaseMinutes} minutos após a hora marcada de ínicio da reserva.
        {/if}
	</p>
{/if}

{if count($RepeatRanges) gt 0}
	<p>
		A reserva ocorre nas seguintes datas ({$RepeatRanges|count}):
		<br/>
        {foreach from=$RepeatRanges item=date name=dates}
            {formatdate date=$date->GetBegin()}
            {if !$date->IsSameDate()} - {formatdate date=$date->GetEnd()}{/if}
			<br/>
        {/foreach}
	</p>
{/if}

{if $Participants|count >0}
	<br/>
	<strong>Participantes ({$Participants|count + $ParticipatingGuests|count}):</strong>
	<br/>
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
	<br/>
	<strong>Convidados ({$Invitees|count + $InvitedGuests|count}):</strong>
	<br/>
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
	<br/>
	<strong>Acessórios ({$Accessories|count}):</strong>
	<br/>
    {foreach from=$Accessories item=accessory}
		({$accessory->QuantityReserved}) {$accessory->Name}
		<br/>
    {/foreach}
{/if}

<p><strong>Número de referência:</strong> {$ReferenceNumber}</p>

<p>
	<a href="{$ScriptUrl}/{$ReservationUrl}">Ver esta reserva</a> | <a href="{$ScriptUrl}">Entrar em {$AppTitle}</a>
</p>
