<p><strong>Broneeringu üksikasjad:</strong></p>

<p>
	<strong>Algus:</strong> {formatdate date=$StartDate key=reservation_email}<br/>
	<strong>Lõpp:</strong> {formatdate date=$EndDate key=reservation_email}<br/>
	<strong>Pealkiri:</strong> {$Title}<br/>
	<strong>Kirjeldus:</strong> {$Description|nl2br}
	{if $Attributes|default:array()|count > 0}
		<br/>
	    {foreach from=$Attributes item=attribute}
			<div>{control type="AttributeControl" attribute=$attribute readonly=true}</div>
	    {/foreach}
	{/if}
</p>

<p>
    {if $Resources|default:array()|count > 1}
        <strong>Ressursid ({$Resources|default:array()|count}):</strong> <br />
    {else}
        <strong>Ressurss:</strong><br/>
    {/if}
    {foreach from=$Resources item=resource name=resourceLoop}
        <strong>{$resource.name|escape}</strong><br/>
        {if $resource.scheduleName}<strong>Kava:</strong> {$resource.scheduleName|escape}<br/>{/if}
        <strong>Ressurssi ID:</strong> {$resource.id}<br/>
        {if $resource.location}<strong>Asukoht:</strong> {$resource.location|escape}<br/>{/if}
        {if $resource.contact}<strong>Kontakt:</strong> {$resource.contact|escape}<br/>{/if}
        {if $resource.description}<strong>Kirjeldus:</strong> {$resource.description|sanitize_rich_text|url2link|nl2br}<br/>{/if}
        {if $resource.notes}<strong>Märkused:</strong> {$resource.notes|sanitize_rich_text|url2link|nl2br}<br/>{/if}
        {if $resource.resourceAdministrator}<strong>Ressurssi administraator:</strong> {$resource.resourceAdministrator|escape}<br/>{/if}

        {if $resource.attributeRows|default:array()|count > 0}
            <strong>Ressursi üksikasjad:</strong><br/>
            <table cellpadding="4" cellspacing="0" border="1" style="border-collapse: collapse; margin-top: 4px;">
                {foreach from=$resource.attributeRows item=row}
                    <tr>
                        <th scope="row" valign="top" style="text-align: left;"><strong>{$row.label|escape}</strong></th>
                        <td valign="top">{$row.displayValue|escape|nl2br}</td>
                    </tr>
                {/foreach}
            </table>
        {/if}

        {if $resource.image}
            <div class="resource-image"><img alt="{$resource.name|escape}" src="{$ScriptUrl}/{$resource.image|escape}"/></div>
        {/if}

        {if !$smarty.foreach.resourceLoop.last}<br/>{/if}
    {/foreach}
</p>

{if $RequiresApproval}
	<p>* Vähemalt üks reserveeritud ressurssidest vajab enne kasutamist kinnitust. See reserveering jääb ootele kuni kinnitamiseni. *</p>
{/if}

{if $CheckInEnabled}
	<p>
	Vähemalt ühe broneeritud ressursi kasutamiseks on vaja broneeringusse sisse ja välja registreeruda.
    {if $AutoReleaseMinutes != null}
		See broneering tühistatakse, kui te ei registreeru sisse {$AutoReleaseMinutes} minuti jooksul pärast planeeritud algusaega.
    {/if}
	</p>
{/if}

{if count($RepeatRanges) gt 0}
    <br/>
    <strong>Broneering toimub järgmistel kuupäevadel ({$RepeatRanges|default:array()|count}):</strong>
    <br/>
	{foreach from=$RepeatRanges item=date name=dates}
	    {formatdate date=$date->GetBegin()}
	    {if !$date->IsSameDate()} - {formatdate date=$date->GetEnd()}{/if}
	    <br/>
	{/foreach}
{/if}

{if $Participants|default:array()|count >0}
    <br />
    <strong>Osalejad ({$Participants|default:array()|count + $ParticipatingGuests|default:array()|count}):</strong>
    <br />
    {foreach from=$Participants item=user}
        {$user->FullName()}
        <br/>
    {/foreach}
{/if}

{if $ParticipatingGuests|default:array()|count >0}
    {foreach from=$ParticipatingGuests item=email}
        {$email}
        <br/>
    {/foreach}
{/if}

{if $Invitees|default:array()|count >0}
    <br />
    <strong>Kutsutud ({$Invitees|default:array()|count + $InvitedGuests|default:array()|count}):</strong>
    <br />
    {foreach from=$Invitees item=user}
        {$user->FullName()}
        <br/>
    {/foreach}
{/if}

{if $InvitedGuests|default:array()|count >0}
    {foreach from=$InvitedGuests item=email}
        {$email}
        <br/>
    {/foreach}
{/if}

{if $Accessories|default:array()|count > 0}
    <br />
       <strong>Aksessuaarid ({$Accessories|default:array()|count}):</strong>
       <br />
    {foreach from=$Accessories item=accessory}
        ({$accessory->QuantityReserved}) {$accessory->Name}
        <br/>
    {/foreach}
{/if}

{if $CreditsCurrent > 0}
	<br/>
	See broneering maksab {$CreditsCurrent} krediiti.
    {if $CreditsCurrent != $CreditsTotal}
		Kogu see broneeringute seeria maksab {$CreditsTotal} krediiti.
    {/if}
{/if}


{if !empty($CreatedBy)}
	<p><strong>Loonud:</strong> {$CreatedBy}</p>
{/if}

{if !empty($ApprovedBy)}
	<p><strong>Kiitis heaks:</strong> {$ApprovedBy}</p>
{/if}

<p><strong>Broneeringu number:</strong> {$ReferenceNumber}</p>

{if !$Deleted}
	<a href="{$ScriptUrl}/{$ReservationUrl}">Vaata seda broneeringut</a>
	|
	<a href="{$ScriptUrl}/{$ICalUrl}">Lisa kalendrisse</a>
	|
	<a href="{$GoogleCalendarUrl}" target="_blank" rel="nofollow">Lisa Google kalendrisse</a>
	|
{/if}
<a href="{$ScriptUrl}">Logi sisse: {$AppTitle}</a>
