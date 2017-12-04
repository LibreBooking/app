<div style="overflow-x:auto;">
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
</div>
{pagination pageInfo=$PageInfo}