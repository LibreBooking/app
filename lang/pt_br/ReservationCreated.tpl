<p>
    <strong>Detalhes da Reserva:</strong>
</p>

<p>
    <strong>Início:</strong> {formatdate date=$StartDate key=reservation_email}
    <br />
    <strong>Fim:</strong> {formatdate date=$EndDate key=reservation_email}
    <br />
    <strong>Título:</strong> {$Title}
    <br />
    <strong>Descrição:</strong> {$Description|nl2br}
    {if $Attributes|default:array()|count > 0}
        <br />
        {foreach from=$Attributes item=attribute}
        <div>{control type="AttributeControl" attribute=$attribute readonly=true}</div>
        {/foreach}
    {/if}
</p>

<p>
    {if $ResourceNames|default:array()|count > 1}
        <strong>Recursos ({$ResourceNames|default:array()|count}):</strong>
        {foreach from=$ResourceNames item=resourceName}
            <br />
            {$resourceName}
        {/foreach}
    {else}
        <strong>Recurso:</strong> {$ResourceName}
    {/if}
</p>

{if $ResourceImage}
    <div class="resource-image">
        <img alt="{$ResourceName|escape}" src="{$ScriptUrl}/{$ResourceImage}" />
    </div>
{/if}

{if $RequiresApproval}
    <p>
        Pelo menos um dos recursos reservados requer aprovação antes do uso.
        Esta solicitação de ficará pendente até que seja aprovada ou rejeitada.
    </p>
{/if}

{if $CheckInEnabled}
    <p>
        Pelo menos um dos recursos reservados requer que seja efetuado o check-in/check-out da sua reserva.
        {if $AutoReleaseMinutes != null}
            Esta reserva será cancelada a não ser que o check-in seja efetuado dentro de {$AutoReleaseMinutes} minutos após a hora marcada de ínicio da reserva.
        {/if}
    </p>
{/if}

{if count($RepeatRanges) gt 0}
    <p>
        A reserva ocorre nas seguintes datas ({$RepeatRanges|default:array()|count})
        {foreach from=$RepeatRanges item=date name=dates}
            <br />
            {formatdate date=$date->GetBegin()}
            {if !$date->IsSameDate()} - {formatdate date=$date->GetEnd()}{/if}
        {/foreach}
    </p>
{/if}


{if ($Participants|default:array()|count > 0) or ($ParticipatingGuests|default:array()|count > 0)}
    <p>
        <strong>Participantes ({$Participants|default:array()|count + $ParticipatingGuests|default:array()|count}):</strong>
        {foreach from=$Participants item=user}
            <br />
            {$user->FullName()}
        {/foreach}
        {foreach from=$ParticipatingGuests item=email}
            <br />
            {$email}
        {/foreach}
    </p>
{/if}

{if ($Invitees|default:array()|count > 0) or ($InvitedGuests|default:array()|count > 0)}
    <p>
        <strong>Convidados ({$Invitees|default:array()|count + $InvitedGuests|default:array()|count}):</strong>
        {foreach from=$Invitees item=user}
            <br />
            {$user->FullName()}
        {/foreach}
        {foreach from=$InvitedGuests item=email}
            <br />
            {$email}
        {/foreach}
    </p>
{/if}

{if $Accessories|default:array()|count > 0}
    <p>
        <strong>Acessórios ({$Accessories|default:array()|count}):</strong>
        {foreach from=$Accessories item=accessory}
            <br />
            ({$accessory->QuantityReserved}) {$accessory->Name}
        {/foreach}
    </p>
{/if}

{if $CreditsCurrent > 0}
    <p>
        Esta reserva custa {$CreditsCurrent} créditos.
        {if $CreditsCurrent != $CreditsTotal}
            Estas reservas custam, em sua totalidade, {$CreditsTotal} créditos.
        {/if}
    </p>
{/if}


{if !empty($CreatedBy)}
    <p>
        <strong>Criada por:</strong> {$CreatedBy}
    </p>
{/if}

{if !empty($ApprovedBy)}
    <p>
        <strong>Aprovada por:</strong> {$ApprovedBy}
    </p>
{/if}

<p>
    <strong>Número de Referência:</strong> {$ReferenceNumber}
</p>

<p>
    {if !$Deleted}
        <a href="{$ScriptUrl}/{$ReservationUrl}">Ver esta reserva</a> |
        <a href="{$ScriptUrl}/{$ICalUrl}">Adicionar ao calendário</a> |
        <a href="{$GoogleCalendarUrl}" target="_blank" rel="nofollow">Adicionar à Agenda do Google</a> |
    {/if}
    <a href="{$ScriptUrl}">Acessar {$AppTitle}</a>
</p>
