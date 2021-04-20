	Detalhes da Reserva:
	<br/>
	<br/>

	Inicio: {formatdate date=$StartDate key=reservation_email}<br/>
	Fim: {formatdate date=$EndDate key=reservation_email}<br/>
	Recurso: {$ResourceName}<br/>
	T�tulo: {$Title}<br/>
	Descri��o: {$Description|nl2br}<br/>

	{if count($RepeatDates) gt 0}
		<br/>
		A reserva ocorrer� nas seguintes datas:
		<br/>
	{/if}

	{foreach from=$RepeatDates item=date name=dates}
		{formatdate date=$date}<br/>
	{/foreach}

	{if $RequiresApproval}
		<br/>
		Um ou mais recursos necessitam de aprova��o antes do seu uso. Essa reserva ficar� pendente at� que a mesma seja aprovada.
	{/if}

	<br/>
	Aceitar o convite? <a href="{$ScriptUrl}/{$AcceptUrl}">Sim</a> <a href="{$ScriptUrl}/{$DeclineUrl}">N�o</a>
	<br/>

	<a href="{$ScriptUrl}/{$ReservationUrl}">Verifique esta reserva</a> |
	<a href="{$ScriptUrl}/{$ICalUrl}">Adicionar ao Outlook</a> |
	<a href="{$ScriptUrl}">Acessar o Booked Scheduler</a>

