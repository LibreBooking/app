<p>{$ParticipantDetails} 
    {if ($InvitationAction == InvitationAction::Decline || $InvitationAction == InvitationAction::CancelAll || $InvitationAction == InvitationAction::CancelInstance)}
		odrzucił/a Twoje zaproszenie do rezerwacji.
    {elseif ($InvitationAction == InvitationAction::Join || $InvitationAction == InvitationAction::JoinAll)}
		Dołączył/a do Twojej rezerwacji.
    {else}
		Zaakceptował/a Twoją rezerwację.
    {/if}
</p>
<p><strong>Szczegóły rezerwacji:</strong></p>

<p>
	<strong>Początek:</strong> {formatdate date=$StartDate key=reservation_email}<br/>
	<strong>Koniec:</strong> {formatdate date=$EndDate key=reservation_email}<br/>
	<strong>Tytuł:</strong> {$Title}<br/>
	<strong>Opis:</strong> {$Description|nl2br}
    {if $Attributes|default:array()|count > 0}
	<br/>
    {foreach from=$Attributes item=attribute}
	<div>{control type="AttributeControl" attribute=$attribute readonly=true}</div>
    {/foreach}
{/if}
</p>

<p>
    {if $ResourceNames|default:array()|count > 1}
		<strong>Zasoby ({$ResourceNames|default:array()|count}):</strong>
		<br/>
        {foreach from=$ResourceNames item=resourceName}
            {$resourceName}
			<br/>
        {/foreach}
    {else}
		<strong>Zasób:</strong>
        {$ResourceName}
		<br/>
    {/if}
</p>

{if $ResourceImage}
	<div class="resource-image"><img alt="{$ResourceName|escape}" src="{$ScriptUrl}/{$ResourceImage}"/></div>
{/if}

<p><strong>Numer referencyjny:</strong> {$ReferenceNumber}</p>

<p>
	<a href="{$ScriptUrl}/{$ReservationUrl}">Pokaż rezerwację</a> |
	<a href="{$ScriptUrl}">Zaloguj się do {$AppTitle}</a>
</p>
