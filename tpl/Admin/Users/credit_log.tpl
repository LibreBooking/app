{include file='globalheader.tpl'}

<div id="page-admin-credit-log" class="admin-page">
    <h1>{translate key=CreditHistory} - {$UserName}</h1>

    {if $ShowError}
        <div class="alert alert-danger">
            {translate key=UserNotFound}
        </div>
    {else}
        <table class="table" id="credit-log-list">
            <thead>
            <tr>
                <th>{translate key=Date}</th>
                <th>{translate key=Note}</th>
                <th>{translate key=CreditsBefore}</th>
                <th>{translate key=CreditsAfter}</th>
            </tr>
            </thead>
            <tbody>
            {foreach from=$CreditLog item=log}
                {cycle values='row0,row1' assign=rowCss}
                <tr class="{$rowCss}">
                    <td>{formatdate date=$log->Date timezone=$Timezone key='general_datetime'}</td>
                    <td>{$log->Note}</td>
                    <td>{$log->OriginalCreditCount}</td>
                    <td>{$log->CreditCount}</td>
                </tr>
            {/foreach}
            </tbody>
        </table>
        {pagination pageInfo=$PageInfo}
    {/if}

</div>

{include file="javascript-includes.tpl"}


{include file='globalfooter.tpl'}
