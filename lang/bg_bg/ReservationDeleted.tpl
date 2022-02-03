	Резервационна информация:
	<br/>
	<br/>

	Начало: {formatdate date=$StartDate key=reservation_email}<br/>
	Край: {formatdate date=$EndDate key=reservation_email}<br/>
	{if $ResourceNames|default:array()|count > 1}
		Ресурси:<br/>
		{foreach from=$ResourceNames item=resourceName}
			{$resourceName}<br/>
		{/foreach}
		{else}
		Ресурс: {$ResourceName}<br/>
	{/if}

	{if $ResourceImage}
		<div class="resource-image"><img src="{$ScriptUrl}/{$ResourceImage}"/></div>
	{/if}

	Заглавие: {$Title}<br/>
	Описание: {$Description|nl2br}<br/>
    {$DeleteReason|nl2br}<br/>

	{if count($RepeatDates) gt 0}
		<br/>
		Следните дати са премахнати:
		<br/>
	{/if}

	{foreach from=$RepeatDates item=date name=dates}
		{formatdate date=$date}<br/>
	{/foreach}

	{if $Accessories|default:array()|count > 0}
		<br/>Аксесоари:<br/>
		{foreach from=$Accessories item=accessory}
			({$accessory->QuantityReserved}) {$accessory->Name}<br/>
		{/foreach}
	{/if}

	<a href="{$ScriptUrl}">Влизане в LibreBooking</a>
