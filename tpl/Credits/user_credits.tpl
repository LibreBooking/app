{include file='globalheader.tpl'}

<div id="page-user-credits">

    <h1>{$CurrentCredits}</h1>

    {if $AllowPurchasingCredits && $IsCreditCostSet}
        <div>{translate key=BuyMoreCredits}</div>
        {translate key=EachCreditCosts} {$CreditCost}
        <div>
            <form role="form" name="purchaseCreditsForm" id="purchaseCreditsForm" method="post" action="checkout.php">
                {translate key=Quantity} <input id="quantity" {formname key=CREDIT_QUANTITY} type="number"
                                                class="form-control inline-block" min="1"
                                                style="width:100px" value="1"/>
                <button type="submit" class="btn btn-default">{translate key=Checkout}</button>
                {csrf_token}
            </form>

        </div>
        <div>
            {translate key=Total} <span id="totalCost">{$CreditCost}</span>
        </div>
    {/if}

    {include file="javascript-includes.tpl"}
    {jsfile src="ajax-helpers.js"}

</div>

<script type="text/javascript">
    $(function () {
        $('#quantity').on('change', function (e) {
            ajaxGet('{$smarty.server.SCRIPT_NAME}?dr=calcQuantity&quantity=' + $('#quantity').val(), null, function(data) {
                $('#totalCost').text(data);
            });
        });
    });
</script>
{include file='globalfooter.tpl'}
