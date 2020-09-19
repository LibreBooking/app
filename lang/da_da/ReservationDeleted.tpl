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
Beskrivelse: {$Description|nl2br}<br/>
Årsag: {$DeleteReason|nl2br}<br/>

{if count($RepeatRanges) gt 0}
    <br/>
    Disse datoer er slettede:
    <br/>
{/if}

{foreach from=$RepeatRanges item=date name=dates}
    {formatdate date=$date->GetBegin()}
    {if !$date->IsSameDate()} - {formatdate date=$date->GetEnd()}{/if}
    <br/>
{/foreach}

{if $Accessories|count > 0}
    <br/>
    Udstyr:
    <br/>
    {foreach from=$Accessories item=accessory}
        ({$accessory->QuantityReserved}) {$accessory->Name}
        <br/>
    {/foreach}
{/if}

{if !empty($CreatedBy)}
    <br/>
    Slettet af: {$CreatedBy}
{/if}

<br/>
Referencenummer: {$ReferenceNumber}

<br/>
<a href="{$ScriptUrl}">Log på {$AppTitle}</a>
