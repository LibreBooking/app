Tu reserva termina pronto.<br/>
Detalles de la reserva:
	<br/>
	<br/>
	Inicio: {formatdate date=$StartDate key=reservation_email}<br/>
	Fin: {formatdate date=$EndDate key=reservation_email}<br/>
	Recurso: {$ResourceName}<br/>
	Título: {$Title}<br/>
	Descripción: {$Description|nl2br}<br/>
<br/>
<a href="{$ScriptUrl}/{$ReservationUrl}">Ver esta reserva</a> |
<a href="{$ScriptUrl}/{$ICalUrl}">Agregar a un calendario</a> |
<a href="{$ScriptUrl}">Iniciar sesión en Booked Scheduler</a>
