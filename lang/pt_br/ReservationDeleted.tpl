	Detalhes da Reserva:
	<br/>
	<br/>

	Inicio: {formatdate date=$StartDate key=reservation_email}<br/>
	Fim: {formatdate date=$EndDate key=reservation_email}<br/>
	Recurso: {$ResourceName}<br/>

	{if $ResourceImage}
		<div class="resource-image"><img src="{$ScriptUrl}/{$ResourceImage}"/></div>
	{/if}

	T�tulo: {$Title}<br/>
	Descri��o: {$Description|nl2br}<br/>
{$DeleteReason|nl2br}<br/>

	{if count($RepeatDates) gt 0}
		<br/>
		As seguintes datas foram removidas:
		<br/>
	{/if}

	{foreach from=$RepeatDates item=date name=dates}
		{formatdate date=$date}<br/>
	{/foreach}

	<a href="{$ScriptUrl}">Acessar o LibreBooking</a>
