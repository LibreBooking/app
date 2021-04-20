<p>A série de reservas recorrentes de {$ResourceName} irá terminar em {formatdate date=$StartDate key=reservation_email}.</p>
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
	<a href="{$ScriptUrl}">Entrar em {$AppTitle}</a>
</p>
