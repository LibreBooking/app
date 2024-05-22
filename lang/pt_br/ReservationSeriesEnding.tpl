<p>
    Sua série de reservas recorrentes para {$ResourceName} irá terminar em {formatdate date=$StartDate key=reservation_email}.
</p>

<p>
    <strong>Reservation Details:</strong>
</p>

<p>
	<strong>Início:</strong> {formatdate date=$StartDate key=reservation_email}
    <br/>
	<strong>Fim:</strong> {formatdate date=$EndDate key=reservation_email}
    <br/>
	<strong>Recurso:</strong> {$ResourceName}
    <br/>
	<strong>Título:</strong> {$Title}
    <br/>
	<strong>Descrição:</strong> {$Description|nl2br}
</p>

<p>
	<a href="{$ScriptUrl}/{$ReservationUrl}">Ver esta reserva</a> |
    <a href="{$ScriptUrl}">Acessar {$AppTitle}</a>
</p>
