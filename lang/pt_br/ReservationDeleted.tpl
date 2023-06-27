<p>
    <strong>Detalhes da Reserva:</strong>
</p>

<p>
    <strong>Início:</strong> {formatdate date=$StartDate key=reservation_email}
    <br />
    <strong>Fim:</strong> {formatdate date=$EndDate key=reservation_email}
    <br />
    <strong>Título:</strong> {$Title}
    <br />
    <strong>Descrição:</strong> {$Description|nl2br}
    {if $Attributes|default:array()|count > 0}
        <br />
        {foreach from=$Attributes item=attribute}
        <div>{control type="AttributeControl" attribute=$attribute readonly=true}</div>
        {/foreach}
    {/if}
</p>

<p>
    {if $ResourceNames|default:array()|count > 1}
        <strong>Recursos ({$ResourceNames|default:array()|count}):</strong>
        {foreach from=$ResourceNames item=resourceName}
            <br />
            {$resourceName}
        {/foreach}
    {else}
        <strong>Recurso:</strong> {$ResourceName}
    {/if}
</p>

{if $ResourceImage}
    <div class="resource-image">
        <img alt="{$ResourceName|escape}" src="{$ScriptUrl}/{$ResourceImage}" />
    </div>
{/if}

{if count($RepeatRanges) gt 0}
    <p>
        A reserva ocorre nas seguintes datas ({$RepeatRanges|default:array()|count})
        {foreach from=$RepeatRanges item=date name=dates}
            <br />
            {formatdate date=$date->GetBegin()}
            {if !$date->IsSameDate()} - {formatdate date=$date->GetEnd()}{/if}
        {/foreach}
    </p>
{/if}


{if !empty($CreatedBy)}
    <p>
        <strong>Removido por:</strong> {$CreatedBy}
        <br />
        <strong>Razão da remoção:</strong> {$DeleteReason|nl2br}
    </p>
{/if}

<p>
    <strong>Número de Referência:</strong> {$ReferenceNumber}
</p>

<p>
    <a href="{$ScriptUrl}">Acessar {$AppTitle}</a>
</p>
