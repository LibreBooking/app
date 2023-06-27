<p>
    Check-in não efetuado.
</p>

<p>
    <strong>Detalhes da Reserva:</strong>
</p>

<p>
    <strong>Início:</strong> {formatdate date=$StartDate key=reservation_email}
    <br />
    <strong>Fim:</strong> {formatdate date=$EndDate key=reservation_email}
    <br />
    <strong>Recurso:</strong> {$ResourceName}
    <br />
    <strong>Título:</strong> {$Title}
    <br />
    <strong>Descrição:</strong> {$Description|nl2br}
</p>

{if $IsAutoRelease}
    <p>
        Se não efetuar o check-in, esta reserva será automaticamente cancelada em {formatdate date=$AutoReleaseTime key=reservation_email}
    </p>
{/if}

<p>
    <a href="{$ScriptUrl}/{$ReservationUrl}">Ver esta reserva</a> |
    <a href="{$ScriptUrl}">Acessar {$AppTitle}</a>
</p>
