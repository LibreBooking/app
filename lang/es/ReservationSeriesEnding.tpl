<p>Tu serie de reservas recurrentes para {$ResourceName} está terminando en {formatdate date=$StartDate key=reservation_email}.</p>
<p><strong>Detalles de la reserva:</strong></p>
<p>
	<strong>Inicio:</strong> {formatdate date=$StartDate key=reservation_email}<br/>
	<strong>Fin:</strong> {formatdate date=$EndDate key=reservation_email}<br/>
	<strong>Recurso:</strong> {$ResourceName}<br/>
	<strong>Título:</strong> {$Title}<br/>
	<strong>Descripción:</strong> {$Description|nl2br}
</p>

<p>
	<a href="{$ScriptUrl}/{$ReservationUrl}">Ver esta reserva</a> |
	<a href="{$ScriptUrl}">Iniciar sesión en {$AppTitle}</a>
</p>
