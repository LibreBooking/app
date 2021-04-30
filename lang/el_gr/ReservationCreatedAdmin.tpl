<p><strong>Πληροφορίες κράτησης:</strong></p>

<p>
	<strong>Χρήστης:</strong> {$UserName}<br/>
	{if !empty($CreatedBy)}
		<strong>Δημιουργήθηκε από:</strong>
		{$CreatedBy}
		<br/>
	{/if}
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
		<strong>Πόροι:</strong>
		<br/>
		{foreach from=$ResourceNames item=resourceName}
			{$resourceName}
			<br/>
		{/foreach}
	{else}
		<strong>Πόρος:</strong> {$ResourceName}
		<br/>
	{/if}
</p>

{if $ResourceImage}
	<div class="resource-image"><img alt="{$ResourceName}" src="{$ScriptUrl}/{$ResourceImage}"/></div>
{/if}


{if $RequiresApproval}
	<p>* Τουλάχιστον ένας από τους κρατημένους πόρους απαιτεί έγκριση πριν τη χρήση του. Παρακαλώ βεβαιωθείτε ότι η αίτηση για την κράτηση θα εγκριθεί ή απορριφθεί. *</p>
{/if}

{if $CheckInEnabled}
	<p>
		Τουλάχιστον ένας από τους κρατημένους πόρους απαιτεί από το χρήστη να κάνει check in και check out στην κράτηση.
        {if $AutoReleaseMinutes != null}
			Η κράτηση θα ακυρωθεί αυτόματα εκτός αν ο χρήστης δεν κάνει check in μέσα σε διάστημα {$AutoReleaseMinutes} λεπτών μετά την προγραμματισμένη έναρξη.
        {/if}
	</p>
{/if}

{if count($RepeatRanges) gt 0}
	<p>
		Η κράτηση θα ισχύει για τις εξής ημερομηνίες ({$RepeatRanges|default:array()|count}):
		<br/>
        {foreach from=$RepeatRanges item=date name=dates}
            {formatdate date=$date->GetBegin()}
            {if !$date->IsSameDate()} - {formatdate date=$date->GetEnd()}{/if}
			<br/>
        {/foreach}
	</p>
{/if}

{if $Participants|default:array()|count >0}
	<br/>
	<strong>Συμμετέχοντες ({$Participants|default:array()|count + $ParticipatingGuests|default:array()|count}):</strong>
	<br/>
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
	<br/>
	<strong>Προσκαλεσμένοι ({$Invitees|default:array()|count + $InvitedGuests|default:array()|count}):</strong>
	<br/>
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
	<br/>
	<strong>Εξοπλισμός ({$Accessories|default:array()|count}):</strong>
	<br/>
    {foreach from=$Accessories item=accessory}
		({$accessory->QuantityReserved}) {$accessory->Name}
		<br/>
    {/foreach}
{/if}

<p><strong>Αριθμός Αναφοράς:</strong> {$ReferenceNumber}</p>

<p>
	<a href="{$ScriptUrl}/{$ReservationUrl}">Δείτε την κράτηση</a> | <a href="{$ScriptUrl}">Κάνετε είσοδο στο {$AppTitle}</a>
</p>
