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
    <p>* Um ou mais recursos reservados requerem aprovação antes do uso. Esta reservation reserva ficará pendente até que seja aprovada. *</p>
{/if}

<p>
    <strong>Título:</strong> {$Title}<br/>
    <strong>Descrição:</strong> {$Description|nl2br}
</p>

{if count($RepeatRanges) gt 0}
    <br/>
    <strong>A reserva ocorre nas seguintes datas ({$RepeatRanges|default:array()|count}):</strong>
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
    <strong>Convidados ({$Invitees|default:array()|count + $InvitedGuests|default:array()|count}):</strong>
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
       <strong>Acessórios ({$Accessories|default:array()|count}):</strong>
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
