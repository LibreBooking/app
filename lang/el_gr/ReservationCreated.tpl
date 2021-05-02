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
    <strong>Πόροι ({$ResourceNames|default:array()|count}):</strong> <br />
    {foreach from=$ResourceNames item=resourceName}
        {$resourceName}<br/>
    {/foreach}
{else}
    <strong>Πόρος:</strong> {$ResourceName}<br/>
{/if}
</p>

{if $ResourceImage}
    <div class="resource-image"><img alt="{$ResourceName|escape}" src="{$ScriptUrl}/{$ResourceImage}"/></div>
{/if}

{if $RequiresApproval}
	<p>* Τουλάχιστον ένας από τους κρατημένους πόρους απαιτεί έγκριση πριν τη χρήση του. Η κράτηση θα παραμείνει σε εκκρεμότητα μέχρι να εγκριθεί. *</p>
{/if}

{if $CheckInEnabled}
	<p>
	Τουλάχιστον ένας από τους κρατημένους πόρους απαιτεί να κάνετε check in και check out στην κράτηση.
    {if $AutoReleaseMinutes != null}
		Η κράτηση θα ακυρωθεί αυτόματα εκτός αν κάνετε check in μέσα σε διάστημα {$AutoReleaseMinutes} λεπτών μετά την προγραμματισμένη έναρξη.
    {/if}
	</p>
{/if}

{if count($RepeatRanges) gt 0}
    <br/>
    <strong>Η κράτηση θα ισχύει για τις παρακάτω ημερομηνίες: ({$RepeatRanges|default:array()|count}):</strong>
    <br/>
	{foreach from=$RepeatRanges item=date name=dates}
	    {formatdate date=$date->GetBegin()}
	    {if !$date->IsSameDate()} - {formatdate date=$date->GetEnd()}{/if}
	    <br/>
	{/foreach}
{/if}

{if $Participants|default:array()|count >0}
    <br />
    <strong>Συμμετέχοντες ({$Participants|default:array()|count + $ParticipatingGuests|default:array()|count}):</strong>
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
    <strong>Προσκαλεσμένοι ({$Invitees|default:array()|count + $InvitedGuests|default:array()|count}):</strong>
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
       <strong>Εξοπλισμός ({$Accessories|default:array()|count}):</strong>
       <br />
    {foreach from=$Accessories item=accessory}
        ({$accessory->QuantityReserved}) {$accessory->Name}
        <br/>
    {/foreach}
{/if}

{if $CreditsCurrent > 0}
	<br/>
	Η κράτηση κοστίζει {$CreditsCurrent} credits.
    {if $CreditsCurrent != $CreditsTotal}
		Ολόκληρη η σειρά κρατήσεων κοστίζει {$CreditsTotal} credits.
    {/if}
{/if}


{if !empty($CreatedBy)}
	<p><strong>Δημιουργήθηκε από:</strong> {$CreatedBy}</p>
{/if}

{if !empty($ApprovedBy)}
	<p><strong>Εγκρίθηκε από:</strong> {$ApprovedBy}</p>
{/if}

<p><strong>Αριθμός Αναφοράς: </strong> {$ReferenceNumber}</p>

{if !$Deleted}
	<a href="{$ScriptUrl}/{$ReservationUrl}">Δείτε την κράτηση</a>
	|
	<a href="{$ScriptUrl}/{$ICalUrl}">Προσθήκη στο Ημερολόγιο</a>
	|
	<a href="{$GoogleCalendarUrl}" target="_blank" rel="nofollow">Προσθήκη στο Google Calendar</a>
	|
{/if}
<a href="{$ScriptUrl}">Κάνετε είσοδο στο {$AppTitle}</a>

