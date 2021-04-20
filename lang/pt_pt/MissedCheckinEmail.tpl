<p>Falhou o check-in</p>
<p><strong>Detalhes da reserva:</strong></p>
<p>
	<strong>Início:</strong> {formatdate date=$StartDate key=reservation_email}<br/>
	<strong>Fim:</strong> {formatdate date=$EndDate key=reservation_email}<br/>
	<strong>Recurso:</strong> {$ResourceName}<br/>
	<strong>Título:</strong> {$Title}<br/>
	<strong>Descrição:</strong> {$Description|nl2br}
</p>

{if $IsAutoRelease}
	<p>Se não efetuar o check-in, esta reserva será automatically automáticamente cancelada em {formatdate date=$AutoReleaseTime key=reservation_email}</p>
{/if}

<p>
	<a href="{$ScriptUrl}/{$ReservationUrl}">Ver esta reserva</a> |
	<a href="{$ScriptUrl}">Entrar em {$AppTitle}</a>
</p>
