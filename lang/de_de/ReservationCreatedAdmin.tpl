	Reservierungsdetails:
	<br/>
	<br/>

	Benutzer: {$UserName}<br/>
	Beginn: {formatdate date=$StartDate key=reservation_email}<br/>
	Ende: {formatdate date=$EndDate key=reservation_email}<br/>
	{if $ResourceNames|default:array()|count > 1}
		Ressourcen:<br/>
		{foreach from=$ResourceNames item=resourceName}
			{$resourceName}<br/>
		{/foreach}
		{else}
		Ressource: {$ResourceName}<br/>
	{/if}

	{if $ResourceImage}
		<div class="resource-image"><img src="{$ScriptUrl}/{$ResourceImage}"/></div>
	{/if}

	Titel: {$Title}<br/>
	Beschreibung: {$Description}<br/>

	{if count($RepeatDates) gt 0}
		<br/>
		Ihre Reservierung gilt für den/die folgenden Tag(e):
		<br/>
	{/if}

	{foreach from=$RepeatDates item=date name=dates}
		{formatdate date=$date}<br/>
	{/foreach}

	{if $Accessories|default:array()|count > 0}
		<br/>Zubehör:<br/>
		{foreach from=$Accessories item=accessory}
			({$accessory->QuantityReserved}) {$accessory->Name}<br/>
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
		Eine oder mehrere Ressourcen benötigen eine Genehmigung.
		Diese Reservierung wird zurückgehalten, bis sie genehmigt ist.
	{/if}

	<br/>
	<br/>
	<a href="{$ScriptUrl}/{$ReservationUrl}">Reservierung ansehen</a> | <a href="{$ScriptUrl}">Anmelden bei phpScheduleIt</a>

