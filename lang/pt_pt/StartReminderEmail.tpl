<p>A sua reserva irá começar em breve.</p>
<p><strong>Detalhes da reserva:</strong></p>
<p>
	<strong>Início:</strong> {formatdate date=$StartDate key=reservation_email}<br/>
	<strong>Fim:</strong> {formatdate date=$EndDate key=reservation_email}<br/>
	<strong>Recurso:</strong> {$ResourceName}<br/>
	<strong>Título:</strong> {$Title}<br/>
	<strong>Descrição:</strong> {$Description|nl2br}
</p>

<p>
	<a href="{$ScriptUrl}/{$ReservationUrl}">Ver esta reserva</a> |
	<a href="{$ScriptUrl}/{$ICalUrl}">Adicionar ao calendário</a> |
	<a href="{$ScriptUrl}">Entrar em {$AppTitle}</a>
</p>
