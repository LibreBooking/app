A foglalás részletei:
<br/>
<br/>

Felhasználó: {$UserName}<br/>
{if !empty($CreatedBy)}
	Created by: {$CreatedBy}
	<br/>
{/if}
Kezdés: {formatdate date=$StartDate key=reservation_email}<br/>
Befejezés: {formatdate date=$EndDate key=reservation_email}<br/>
{if $ResourceNames|default:array()|count > 1}
	Elemek:
	<br/>
	{foreach from=$ResourceNames item=resourceName}
		{$resourceName}
		<br/>
	{/foreach}
{else}
	Elem: {$ResourceName}
	<br/>
{/if}

{if $ResourceImage}
	<div class="resource-image"><img src="{$ScriptUrl}/{$ResourceImage}"/></div>
{/if}

Megnevezés: {$Title}<br/>
Leírás: {$Description|nl2br}

{if count($RepeatRanges) gt 0}
    <br/>
    A foglalás az alábbi dátumokra esik:
    <br/>
{/if}

{foreach from=$RepeatRanges item=date name=dates}
    {formatdate date=$date->GetBegin()}
    {if !$date->IsSameDate()} - {formatdate date=$date->GetEnd()}{/if}
    <br/>
{/foreach}

{if $Participants|default:array()|count >0}
    <br/>
    Résztvevők:
    {foreach from=$Participants item=user}
        {$user->FullName()} <a href="mailto:{$user->EmailAddress()}">{$user->EmailAddress()}</a>
        <br/>
    {/foreach}
{/if}

{if $ParticipatingGuests|default:array()|count >0}
    {foreach from=$ParticipatingGuests item=email}
        <a href="mailto:{$email}">{$email}</a>
        <br/>
    {/foreach}
{/if}

{if $Invitees|default:array()|count >0}
    <br/>
    Meghívottak:
    {foreach from=$Invitees item=user}
        {$user->FullName()} <a href="mailto:{$user->EmailAddress()}">{$user->EmailAddress()}</a>
        <br/>
    {/foreach}
{/if}

{if $InvitedGuests|default:array()|count >0}
    {foreach from=$InvitedGuests item=email}
        <a href="mailto:{$email}">{$email}</a>
        <br/>
    {/foreach}
{/if}

{if $Accessories|default:array()|count > 0}
	<br/>
	Kiegészítők:
	<br/>
	{foreach from=$Accessories item=accessory}
		({$accessory->QuantityReserved}) {$accessory->Name}
		<br/>
	{/foreach}
{/if}

{if $Attributes|default:array()|count > 0}
	<br/>
	{foreach from=$Attributes item=attribute}
		<div>{control type="AttributeControl" attribute=$attribute readonly=true}</div>
	{/foreach}
{/if}

{if $RequiresApproval}
	<br/>
	A foglalt elemek legalább egyike jóváhagyást igényel. Kérjük, biztosítsa a foglalás jóváhagyását vagy elvetését.
{/if}

{if $CheckInEnabled}
	<br/>
	A foglalt elemek legalább egyike ki- és bejelentkezést igényel a fogalásba/ból.
	{if $AutoReleaseMinutes != null}
		Eza foglalás törlésre kerül, amennyiben nem történik bejelentkezés {$AutoReleaseMinutes} perccel az ütemezett kezdést követően.
	{/if}
{/if}

<br/>
Referenciaszám: {$ReferenceNumber}

<br/>
<br/>
<a href="{$ScriptUrl}/{$ReservationUrl}">Foglalás megtekintése</a> | <a href="{$ScriptUrl}">Bejelentkezés ide: {$AppTitle}</a>
