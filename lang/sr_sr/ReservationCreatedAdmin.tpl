	Detalji o rezervaciji:
	<br/>
	<br/>

	Korisnik: {$UserName}<br/>
	Početak: {formatdate date=$StartDate key=reservation_email}<br/>
	Kraj: {formatdate date=$EndDate key=reservation_email}<br/>
	{if $ResourceNames|default:array()|count > 1}
		Tereni:<br/>
		{foreach from=$ResourceNames item=resourceName}
			{$resourceName}<br/>
		{/foreach}
		{else}
		Tereni: {$ResourceName}<br/>
	{/if}

	{if $ResourceImage}
		<div class="resource-image"><img src="{$ScriptUrl}/{$ResourceImage}"/></div>
	{/if}

	Naziv: {$Title}<br/>
	Opis: {$Description}<br/>

	{if count($RepeatDates) gt 0}
		<br/>
		Rezevacija važi za navedeni datum:
		<br/>
	{/if}

	{foreach from=$RepeatDates item=date name=dates}
		{formatdate date=$date}<br/>
	{/foreach}

	{if $Accessories|default:array()|count > 0}
		<br/>Dodatno:<br/>
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
		Jedan ili više terena zahtevaju odobrenje pre upotrebe. Molimo proverite da li je rezervacija prihvaćena ili odbijena.
	{/if}

	<br/>
	<br/>
	<a href="{$ScriptUrl}/{$ReservationUrl}">View this reservation</a> | <a href="{$ScriptUrl}">Uloguj se</a>

