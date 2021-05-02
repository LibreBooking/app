<p>Ο/Η {$ParticipantDetails}
    {if ($InvitationAction == InvitationAction::Decline || $InvitationAction == InvitationAction::CancelAll || $InvitationAction == InvitationAction::CancelInstance)}
		απέρριψε την πρόσκληση για την κράτησή σας.
    {elseif ($InvitationAction == InvitationAction::Join || $InvitationAction == InvitationAction::JoinAll)}
		έκανε εγγραφή στην κράτησή σας.
    {else}
		δέχτηκε την πρόσκληση για την κράτησή σας.
    {/if}
</p>
<p><strong>Πληροφορίες κράτησης:</strong></p>

<p>
	<strong>Έναρξη:</strong> {formatdate date=$StartDate key=reservation_email}<br/>
	<strong>Λήξη:</strong> {formatdate date=$EndDate key=reservation_email}<br/>
	<strong>Τίτλος:</strong> {$Title}<br/>
	<strong>Περιγραφή:</strong> {$Description|nl2br}
    {if $Attributes|default:array()|count > 0}
		<br/>
		{foreach from=$Attributes item=attribute}
			<div>{control type="AttributeControl" attribute=$attribute readonly=true}</div>
		{/foreach}
	{/if}
</p>

<p>
    {if $ResourceNames|default:array()|count > 1}
		<strong>Πόροι ({$ResourceNames|default:array()|count}):</strong>
		<br/>
        {foreach from=$ResourceNames item=resourceName}
            {$resourceName}
			<br/>
        {/foreach}
    {else}
		<strong>Πόρος:</strong>
        {$ResourceName}
		<br/>
    {/if}
</p>

{if $ResourceImage}
	<div class="resource-image"><img alt="{$ResourceName|escape}" src="{$ScriptUrl}/{$ResourceImage}"/></div>
{/if}

<p><strong>Αριθμός αναφοράς:</strong> {$ReferenceNumber}</p>

<p>
	<a href="{$ScriptUrl}/{$ReservationUrl}">Δείτε την κράτηση</a> |
	<a href="{$ScriptUrl}">Κάνετε είσοδο στο {$AppTitle}</a>
</p>
