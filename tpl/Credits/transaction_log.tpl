<div style="overflow-x:auto;">
    <table class="table" id="transaction-log-list">
        <thead>
        <tr>
            <th>{translate key=Date}</th>
            <th>{translate key=Status}</th>
            <th>{translate key=Total}</th>
            <th>{translate key=TransactionFee}</th>
            <th>{translate key=AmountRefunded}</th>
            <th>{translate key=InvoiceNumber}</th>
            <th>{translate key=TransactionId}</th>
            <th>{translate key=Gateway}</th>
        </tr>
        </thead>
        <tbody>
        {foreach from=$TransactionLog item=log}
            {cycle values='row0,row1' assign=rowCss}
            <tr class="{$rowCss}">
                <td>{formatdate date=$log->TransactionDate timezone=$Timezone key='general_datetime'}</td>
                <td>{$log->Status}</td>
                <td>{formatcurrency amount=$log->Total currency=$log->Currency}</td>
                <td>{formatcurrency amount=$log->Fee currency=$log->Currency}</td>
                <td>{formatcurrency amount=$log->AmountRefunded currency=$log->Currency}</td>
                <td>{$log->InvoiceNumber}</td>
                <td>{$log->TransactionId}</td>
                <td>{$log->GatewayName}</td>
            </tr>
        {/foreach}
        </tbody>
    </table>
</div>
{pagination pageInfo=$PageInfo}