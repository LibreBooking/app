{* Translated by Alenka Kavčič (alenka.kavcic@fri.uni-lj.si) *}
	Podrobnosti rezervacije:
	<br/>
	<br/>

	Uporabnik: {$UserName}<br/>
	Začetek: {formatdate date=$StartDate key=reservation_email}<br/>
	Konec: {formatdate date=$EndDate key=reservation_email}<br/>
	Vir: {$ResourceName}<br/>

	{if $ResourceImage}
		<div class="resource-image"><img src="{$ScriptUrl}/{$ResourceImage}"/></div>
	{/if}

	Naslov: {$Title}<br/>
	Opis: {$Description}<br/>

	{if count($RepeatDates) gt 0}
		<br/>
		Rezervacija je narejena za naslednje dneve:
		<br/>
	{/if}

	{foreach from=$RepeatDates item=date name=dates}
		{formatdate date=$date}<br/>
	{/foreach}

	{if $Accessories|count > 0}
		<br/>Dodatki:<br/>
		{foreach from=$Accessories item=accessory}
			({$accessory->QuantityReserved}) {$accessory->Name}<br/>
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
		Eden ali več rezerviranih virov pred uporabo potrebuje potrditev. Prosimo, poskrbite, da bo ta zahtevek za rezervacijo ali potrjen ali zavrnjen.
	{/if}

	<br/>
	<br/>
	<a href="{$ScriptUrl}/{$ReservationUrl}">Ogled rezervacije</a> | <a href="{$ScriptUrl}">Prijava v program Booked Scheduler</a>
