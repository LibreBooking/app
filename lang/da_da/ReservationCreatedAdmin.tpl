{*
Copyright 2011-2020 Nick Korbel

Denne fil er en del af programmet Booked Schduler.

Booked Scheduler er et gratis program.

Du må genudgive og ændre i det så længe du følger retningslinjerne under
"GNU General Public License" som er udgivet af "The Free Software Foundation",
enten version 3 af retningslinjerne, eller en hvilken som helst senere version.

Booked Scheduler er udgivet i håbet om, at det er nyttigt og brugbart,
men uden NOGEN GARANTI; Ikke engang med almindelige gældende handelsbetingelser
eller en garanti om, at det kan bruges til et bestemt formål.  Se alle detaljer
i "GNU General Public License".

Du skulle have modtaget en kopi af "GNU General Public License" sammen med
Booked Scheduler. Hvis ikke, se <http://www.gnu.org/licenses/>.

*}
Oplysninger om reservation:
<br/>
<br/>

Bruger: {$UserName}<br/>
{if !empty($CreatedBy)}
	Oprettet af: {$CreatedBy}
	<br/>
{/if}
Begynder: {formatdate date=$StartDate key=reservation_email}<br/>
Slutter: {formatdate date=$EndDate key=reservation_email}<br/>
{if $ResourceNames|count > 1}
	Faciliteter:
	<br/>
	{foreach from=$ResourceNames item=resourceName}
		{$resourceName}
		<br/>
	{/foreach}
{else}
	Facilitet: {$ResourceName}
	<br/>
{/if}

{if $ResourceImage}
	<div class="resource-image"><img src="{$ScriptUrl}/{$ResourceImage}"/></div>
{/if}

Overskrift: {$Title}<br/>
Beskrivelse: {$Description|nl2br}

{if count($RepeatRanges) gt 0}
    <br/>
    Reservationen gælder for følgende datoer:
    <br/>
{/if}

{foreach from=$RepeatRanges item=date name=dates}
    {formatdate date=$date->GetBegin()}
    {if !$date->IsSameDate()} - {formatdate date=$date->GetEnd()}{/if}
    <br/>
{/foreach}

{if $Participants|count >0}
    <br/>
    Deltagere:
    {foreach from=$Participants item=user}
        {$user->FullName()} <a href="mailto:{$user->EmailAddress()}">{$user->EmailAddress()}</a>
        <br/>
    {/foreach}
{/if}

{if $ParticipatingGuests|count >0}
    {foreach from=$ParticipatingGuests item=email}
        <a href="mailto:{$email}">{$email}</a>
        <br/>
    {/foreach}
{/if}

{if $Invitees|count >0}
    <br/>
    Inviterede:
    {foreach from=$Invitees item=user}
        {$user->FullName()} <a href="mailto:{$user->EmailAddress()}">{$user->EmailAddress()}</a>
        <br/>
    {/foreach}
{/if}

{if $InvitedGuests|count >0}
    {foreach from=$InvitedGuests item=email}
        <a href="mailto:{$email}">{$email}</a>
        <br/>
    {/foreach}
{/if}

{if $Accessories|count > 0}
	<br/>
	Udstyr:
	<br/>
	{foreach from=$Accessories item=accessory}
		({$accessory->QuantityReserved}) {$accessory->Name}
		<br/>
	{/foreach}
{/if}

{if $Attributes|count > 0}
	<br/>
	{foreach from=$Attributes item=attribute}
		<div>{control type="AttributeControl" attribute=$attribute readonly=true}</div>
	{/foreach}
{/if}

{if $RequiresApproval}
	<br/>
	Mindst én af reservationerne skal godkendes. Husk at godkende eller afvise anmodningen.
{/if}

{if $CheckInEnabled}
	<br/>

  For mindst én af reservationerne, er det påkrævet, at brugeren tjekker ind og ud.
	{if $AutoReleaseMinutes != null}
		Reservationen annulleres, hvis brugeren ikke foretager tjek ind, senest {$AutoReleaseMinutes} minutter efter det planlagte starttidspunkt.
	{/if}
{/if}

<br/>
Referencenummer: {$ReferenceNumber}

<br/>
<br/>
<a href="{$ScriptUrl}/{$ReservationUrl}">Se denne reservation</a> | <a href="{$ScriptUrl}">Log på {$AppTitle}</a>
