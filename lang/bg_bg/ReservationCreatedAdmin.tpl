    Резервационна информация:
    <br/>
    <br/>

    Потребител: {$UserName}
    Начало: {formatdate date=$StartDate key=reservation_email}<br/>
    Край: {formatdate date=$EndDate key=reservation_email}<br/>
    {if $ResourceNames|default:array()|count > 1}
        Ресурси:<br/>
        {foreach from=$ResourceNames item=resourceName}
            {$resourceName}<br/>
        {/foreach}
        {else}
        Ресурс: {$ResourceName}<br/>
    {/if}

    {if $ResourceImage}
        <div class="resource-image"><img src="{$ScriptUrl}/{$ResourceImage}"/></div>
    {/if}

    Заглавие: {$Title}<br/>
    Описание: {$Description}<br/>

    {if count($RepeatDates) gt 0}
        <br/>
        Резервацията се отнася за следните дати::
        <br/>
    {/if}

    {foreach from=$RepeatDates item=date name=dates}
        {formatdate date=$date}<br/>
    {/foreach}

    {if $Accessories|default:array()|count > 0}
        <br/>Аксесоари:<br/>
        {foreach from=$Accessories item=accessory}
            ({$accessory->QuantityReserved}) {$accessory->Name}<br/>
        {/foreach}
    {/if}

    {if $RequiresApproval}
        <br/>
        Един или повече от ресурсите изискват одобрение преди употреба.  Моля, убедете се, че тази заявка за резервация е одобрена или отхвърлена.
    {/if}

    <br/>
    <a href="{$ScriptUrl}/{$ReservationUrl}">Разгледай тази резервация</a> | <a href="{$ScriptUrl}">Влизане в LibreBooking</a>
