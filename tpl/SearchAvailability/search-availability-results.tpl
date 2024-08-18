{if $Openings|default:array()|count == 0}
    <div class="alert alert-warning shadow mt-3 text-center">
        <h4 class="alert-heading">
            <i class="bi bi-exclamation-triangle-fill"></i> {translate key=NoAvailableMatchingTimes}
        </h4>
    </div>
{else}
    <div class="card shadow">
        <div class="card-body py-4">
            <div class="row gy-3">
                {foreach from=$Openings item=opening}
                    <div class="col-sm-3">
                        <div class="opening border rounded-1 mx-2 shadow-sm" data-resourceid="{$opening->Resource()->Id}"
                            data-startdate="{format_date date=$opening->Start() key=system_datetime}"
                            data-enddate="{format_date date=$opening->End() key=system_datetime}">
                            <div {if $opening->Resource()->HasColor()}
                                    style="background-color: {$opening->Resource()->Color};color:{$opening->Resource()->TextColor};"
                                {else} class="bg-success bg-opacity-10 text-success" 
                                {/if}>
                                <div class="resourceName d-inline-flex px-2 py-1" data-resourceId="{$opening->Resource()->Id}">
                                    <i class="bi bi-info-circle-fill pe-1"></i> {$opening->Resource()->Name}
                                </div>
                            </div>
                            {*<div data-resourceId="{$opening->Resource()->Id}" {if $opening->Resource()->HasColor()}
                                        class="resourceName"
                                        style="background-color: {$opening->Resource()->Color};color:{$opening->Resource()->TextColor};"
                                    {else} class="resourceName bg-success bg-opacity-10" 
                                    {/if}>
                                    {$opening->Resource()->Name}
                                </div>*}
                            {assign var=key value=short_reservation_date}
                            {if $opening->SameDate()}
                                {assign var=key value=period_time}
                            {/if}
                            <div class="dates px-2 py-1">
                                {format_date date=$opening->Start() key=res_popup} -
                                {format_date date=$opening->End() key=$key}
                            </div>
                        </div>
                    </div>
                {/foreach}
            </div>
        </div>
    </div>
{/if}