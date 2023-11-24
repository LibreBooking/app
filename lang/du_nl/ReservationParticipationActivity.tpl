<p>{$ParticipantDetails} heeft
    {if ($InvitationAction == InvitationAction::Decline || $InvitationAction == InvitationAction::CancelAll || $InvitationAction == InvitationAction::CancelInstance)}
		jouw reservering geweigerd.
    {elseif ($InvitationAction == InvitationAction::Join || $InvitationAction == InvitationAction::JoinAll)}
		zich aangesloten bij jouw reservering.
    {else}
		jouw uitnodiging bij de reservering bevestigd.
    {/if}
</p>
<p><strong>Reservering details:</strong></p>

<p>
	<strong>Start:</strong> {formatdate date=$StartDate key=reservation_email}<br/>
	<strong>Eind:</strong> {formatdate date=$EndDate key=reservation_email}<br/>
	<strong>Titel:</strong> {$Title}<br/>
	<strong>Omschrijving:</strong> {$Description|nl2br}
    {if $Attributes|default:array()|count > 0}
	<br/>
    {foreach from=$Attributes item=attribute}
	<div>{control type="AttributeControl" attribute=$attribute readonly=true}</div>
    {/foreach}
{/if}
</p>

<p>
    {if $ResourceNames|default:array()|count > 1}
		<strong>Bron ({$ResourceNames|default:array()|count}):</strong>
		<br/>
        {foreach from=$ResourceNames item=resourceName}
            {$resourceName}
			<br/>
        {/foreach}
    {else}
		<strong>Resource:</strong>
        {$ResourceName}
		<br/>
    {/if}
</p>

{if $ResourceImage}
	<div class="resource-image"><img alt="{$ResourceName|escape}" src="{$ScriptUrl}/{$ResourceImage}"/></div>
{/if}

<p><strong>Referentie nummer:</strong> {$ReferenceNumber}</p>

<p>
	<a href="{$ScriptUrl}/{$ReservationUrl}">Bekijk de reservering</a> |
	<a href="{$ScriptUrl}">Login in {$AppTitle}</a>
</p>
