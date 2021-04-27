	Broneeringu detailid:
	<br/>
	<br/>

	Algus: {formatdate date=$StartDate key=reservation_email}<br/>
	Lõpp: {formatdate date=$EndDate key=reservation_email}<br/>
	{if $ResourceNames|default:array()|count > 1}
		Väljak:<br/>
		{foreach from=$ResourceNames item=resourceName}
			{$resourceName}<br/>
		{/foreach}
		{else}
		Väljak: {$ResourceName}<br/>
	{/if}

	{if $ResourceImage}
		<div class="resource-image"><img src="{$ScriptUrl}/{$ResourceImage}"/></div>
	{/if}

	Pealkiri: {$Title}<br/>
	Kirjeldus: {$Description|nl2br}<br/>
    <br/>
    Ootame Teid broneeritud ajal!<br/>
    Rannahall

	{if count($RepeatDates) gt 0}
		<br/>
		The reservation occurs on the following dates:
		<br/>
	{/if}

	{foreach from=$RepeatDates item=date name=dates}
		{formatdate date=$date}<br/>
	{/foreach}

	{if $Accessories|default:array()|count > 0}
		<br/>Accessories:<br/>
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
		One or more of the resources reserved require approval before usage.  This reservation will be pending until it is approved.
	{/if}

	{if !empty($ApprovedBy)}
		<br/>
		Approved by: {$ApprovedBy}
	{/if}

	{if !empty($CreatedBy)}
		<br/>
		Broneerija: {$CreatedBy}
	{/if}

	<br/>
	<br/>
	<a href="{$ScriptUrl}/{$ReservationUrl}">Vaata broneeringut</a> |
	<a href="{$ScriptUrl}/{$ICalUrl}">Lisa kalendrisse</a> |
	<a href="{$ScriptUrl}">Logi sisse Rannahalli kalendrisse</a>
