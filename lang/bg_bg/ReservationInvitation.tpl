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

	{if count($RepeatDates) gt 0}
		<br/>
		Резервацията се отнася за следните дати:
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

	{if $RequiresApproval}
		<br/>
		Един или повече от ресурсите изискват одобрение преди употреба. Тази резервация ще чака докато бъде одобрена.
	{/if}

	<br/>
	Участие? <a href="{$ScriptUrl}/{$AcceptUrl}">Да</a> <a href="{$ScriptUrl}/{$DeclineUrl}">Не</a>
	<br/>

	<a href="{$ScriptUrl}/{$ReservationUrl}">Разгледай тази резервация</a> |
	<a href="{$ScriptUrl}/{$ICalUrl}">Добави в Outlook</a> |
	<a href="{$ScriptUrl}">Влизане в LibreBooking</a>
