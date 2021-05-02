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

{if count($RepeatRanges) gt 0}
	<br/>
	<strong>Η κράτηση συμβαίνει στις ακόλουθες ημερομηνίες ({$RepeatRanges|default:array()|count}):</strong>
	<br/>
    {foreach from=$RepeatRanges item=date name=dates}
        {formatdate date=$date->GetBegin()}
        {if !$date->IsSameDate()} - {formatdate date=$date->GetEnd()}{/if}
		<br/>
    {/foreach}
{/if}

<p>
    {if !empty($CreatedBy)}
		<strong>Διαγράφηκε από:</strong>
        {$CreatedBy}
		<br/>
		<strong>Αιτία διαγραφής: {$DeleteReason|nl2br}</strong>
    {/if}
</p>

<p><strong>Αριθμός αναφοράς:</strong> {$ReferenceNumber}</p>

<a href="{$ScriptUrl}">Κάνετε είσοδο στο {$AppTitle}</a>
