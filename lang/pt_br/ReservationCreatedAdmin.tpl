<p>
    <strong>Detalhes da Reserva:</strong>
</p>

<p>
	<strong>Usuário:</strong> {$UserName}
    <br/>
    {if !empty($CreatedBy)}
		<strong>Criada por:</strong> {$CreatedBy}
		<br/>
    {/if}
	<strong>Início:</strong> {formatdate date=$StartDate key=reservation_email}
    <br/>
	<strong>Fim:</strong> {formatdate date=$EndDate key=reservation_email}
    <br/>
	<strong>Título:</strong> {$Title}
    <br/>
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
        {foreach from=$ResourceNames item=resourceName}
            <br/>
            {$resourceName}
        {/foreach}
    {else}
        <strong>Recurso:</strong> {$ResourceName}
    {/if}
</p>

{if $ResourceImage}
	<div class="resource-image">
        <img alt="{$ResourceName}" src="{$ScriptUrl}/{$ResourceImage}"/>
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
        Pelo menos um dos recursos reservados exige check-in e check-out da reserva.
        {if $AutoReleaseMinutes != null}
			Essa reserva será cancelada caso o usuário não faça o check-in dentro de {$AutoReleaseMinutes} minutos após o horário de início programado.
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

<p>
    <strong>Número de Referência:</strong> {$ReferenceNumber}
</p>

<p>
    <a href="{$ScriptUrl}/{$ReservationUrl}">Ver esta reserva</a> |
    <a href="{$ScriptUrl}">Acessar {$AppTitle}</a>
</p>
