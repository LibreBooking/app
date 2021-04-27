	Detalles de la Reserva:
	<br/>
	<br/>

	Inicio: {formatdate date=$StartDate key=reservation_email}<br/>
	Fin: {formatdate date=$EndDate key=reservation_email}<br/>
	{if $ResourceNames|default:array()|count > 1}
		Recursos:<br/>
		{foreach from=$ResourceNames item=resourceName}
			{$resourceName}<br/>
		{/foreach}
		{else}
		Recurso: {$ResourceName}<br/>
	{/if}

	{if $ResourceImage}
		<div class="resource-image"><img src="{$ScriptUrl}/{$ResourceImage}"/></div>
	{/if}

	Título: {$Title}<br/>
	Descripción: {$Description|nl2br}<br/>

	{if count($RepeatDates) gt 0}
		<br/>
		La reserva ocurre en las siguientes fechas:
		<br/>
	{/if}

	{foreach from=$RepeatDates item=date name=dates}
		{formatdate date=$date}<br/>
	{/foreach}

	{if $Accessories|default:array()|count > 0}
		<br/>Accesorios:<br/>
		{foreach from=$Accessories item=accessory}
			({$accessory->QuantityReserved}) {$accessory->Name}<br/>
		{/foreach}
	{/if}

	{if $RequiresApproval}
		<br/>
		Uno o más recursos reservados requiere aprobación antes de su uso. Esta reserva quedará pendiente hasta que se apruebe.
	{/if}

	<br/>
	¿Asistir? <a href="{$ScriptUrl}/{$AcceptUrl}">Sí</a> <a href="{$ScriptUrl}/{$DeclineUrl}">No</a>
	<br/>
	<br/>

	<a href="{$ScriptUrl}/{$ReservationUrl}">Ver esta reserva</a> |
	<a href="{$ScriptUrl}/{$ICalUrl}">Agregar a un calendario</a> |
	<a href="{$ScriptUrl}">Iniciar sesión en Booked Scheduler</a>
