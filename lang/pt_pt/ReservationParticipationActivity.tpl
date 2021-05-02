<p>{$ParticipantDetails}
    {if ($InvitationAction == InvitationAction::Decline || $InvitationAction == InvitationAction::CancelAll || $InvitationAction == InvitationAction::CancelInstance)}
		declinou o seu convite de participação na reserva.
    {elseif ($InvitationAction == InvitationAction::Join || $InvitationAction == InvitationAction::JoinAll)}
		aceitou o seu convite.
    {else}
		aceitou o seu convite de participação na reserva.
    {/if}
</p>
<p><strong>Detalhes da reserva:</strong></p>

<p>
	<strong>Início:</strong> {formatdate date=$StartDate key=reservation_email}<br/>
	<strong>Fim:</strong> {formatdate date=$EndDate key=reservation_email}<br/>
	<strong>Title:</strong> {$Title}<br/>
	<strong>Descrição:</strong> {$Description|nl2br}
    {if $Attributes|default:array()|count > 0}
	<br/>
    {foreach from=$Attributes item=attribute}
	<div>{control type="AttributeControl" attribute=$attribute readonly=true}</div>
    {/foreach}
{/if}
</p>

<p>
    {if $ResourceNames|default:array()|count > 1}
		<strong>Recursos ({$ResourceNames|default:array()|count}):</strong>
		<br/>
        {foreach from=$ResourceNames item=resourceName}
            {$resourceName}
			<br/>
        {/foreach}
    {else}
		<strong>Recurso:</strong>
        {$ResourceName}
		<br/>
    {/if}
</p>

{if $ResourceImage}
	<div class="resource-image"><img alt="{$ResourceName|escape}" src="{$ScriptUrl}/{$ResourceImage}"/></div>
{/if}

<p><strong>Número de referência:</strong> {$ReferenceNumber}</p>

<p>
	<a href="{$ScriptUrl}/{$ReservationUrl}">Ver esta reserva</a> |
	<a href="{$ScriptUrl}">Entrar em {$AppTitle}</a>
</p>
