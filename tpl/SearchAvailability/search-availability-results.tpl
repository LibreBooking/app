{foreach from=$Openings item=opening}
    <div class="opening"
         data-resourceid="{$opening->Resource()->Id}"
         data-startdate="{format_date date=$opening->Start() key=system_datetime}"
         data-enddate="{format_date date=$opening->End() key=system_datetime}">
        <div class="resourceName" data-resourceId="{$opening->Resource()->Id}" {if $opening->Resource()->HasColor()}style="background-color: {$opening->Resource()->Color};color:{$opening->Resource()->TextColor};"{/if}>
            {$opening->Resource()->Name}
        </div>
        {assign var=key value=short_reservation_date}
        {if $opening->SameDate()}
            {assign var=key value=period_time}
        {/if}
        <div class="dates">
        {format_date date=$opening->Start() key=res_popup} -
        {format_date date=$opening->End() key=$key}
        </div>
    </div>
{/foreach}

{if $Openings|count == 0}
    <div class="alert alert-warning">
        <i class="fa fa-frown-o"></i> {translate key=NoAvailableMatchingTimes}
    </div>
{/if}