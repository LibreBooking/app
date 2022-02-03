	Erreserbaren xehetasunak:
	<br/>
	<br/>

	Hasiera: {formatdate date=$StartDate key=reservation_email}<br/>
	Amaiera: {formatdate date=$EndDate key=reservation_email}<br/>
	{if $ResourceNames|default:array()|count > 1}
		Baliabideak:<br/>
		{foreach from=$ResourceNames item=resourceName}
			{$resourceName}<br/>
		{/foreach}
		{else}
		Baliabidea: {$ResourceName}<br/>
	{/if}

	{if $ResourceImage}
		<div class="resource-image"><img src="{$ScriptUrl}/{$ResourceImage}"/></div>
	{/if}

	Izenburua: {$Title}<br/>
	Deskripzioa: {$Description|nl2br}<br/>

	{if count($RepeatDates) gt 0}
		<br/>
		Erreserba data hauetarako da:
		<br/>
	{/if}

	{foreach from=$RepeatDates item=date name=dates}
		{formatdate date=$date}<br/>
	{/foreach}

	{if $Accessories|default:array()|count > 0}
		<br/>Osagarria:<br/>
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
		Baliabide batek edo gehiagok onarpena behar du erabili baino lehen. Erreserba hau zain geratuko da onartua izan arte.
	{/if}

	{if !empty($ApprovedBy)}
		<br/>
		Nork onartua: {$ApprovedBy}
	{/if}

	<br/>
	<br/>
	<a href="{$ScriptUrl}/{$ReservationUrl}">Erreserba hau ikusi</a> |
	<a href="{$ScriptUrl}/{$ICalUrl}">Egutegi batera gehitu</a> |
	<a href="{$ScriptUrl}">LibreBooking-en saioa hasi</a>
