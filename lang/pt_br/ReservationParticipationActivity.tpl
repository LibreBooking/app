<p>
    {$ParticipantDetails}
    {if ($InvitationAction == InvitationAction::Decline || $InvitationAction == InvitationAction::CancelAll || $InvitationAction == InvitationAction::CancelInstance)}
        declinou o seu convite de participação na reserva.
    {elseif ($InvitationAction == InvitationAction::Join || $InvitationAction == InvitationAction::JoinAll)}
        aceitou o seu convite.
    {else}
        aceitou o seu convite de participação na reserva.
    {/if}
</p>

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
        {foreach from=$Attributes item=attribute}
            <br />
            <div>{control type="AttributeControl" attribute=$attribute readonly=true}</div>
        {/foreach}
    {/if}
</p>

<p>
    {if $ResourceNames|default:array()|count > 1}
        <strong>Resources ({$ResourceNames|default:array()|count}):</strong>
        {foreach from=$ResourceNames item=resourceName}
            <br />
            {$resourceName}
        {/foreach}
    {else}
        <strong>Resource:</strong> {$ResourceName}
    {/if}
</p>

{if $ResourceImage}
    <div class="resource-image">
            <img alt="{$ResourceName|escape}" src="{$ScriptUrl}/{$ResourceImage}" />
    </div>
{/if}

<p>
    <strong>Número de Referência:</strong> {$ReferenceNumber}
</p>

<p>
    <a href="{$ScriptUrl}/{$ReservationUrl}">Ver esta reserva</a> |
    <a href="{$ScriptUrl}">Acessar o {$AppTitle}</a>
</p>
