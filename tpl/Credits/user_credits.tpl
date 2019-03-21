{include file='globalheader.tpl'}

<div id="page-user-credits">

    <div class="row">
        <div class="col s12">
            <div>
                <h5 class="underline">{translate key=YourCredits}
                    <span class="badge">{$CurrentCredits}</span>
                </h5>
            </div>

            <div>
                <ul class="tabs">
                    <li class="tab">
                        <a class="active" href="#credit-log">{translate key=CreditHistory}</a>
                    </li>

                    {if $AllowPurchasingCredits && $IsCreditCostSet}
                        <li class="tab">
                            <a href="#purchase">{translate key=BuyMoreCredits}</a>
                        </li>
                        <li class="tab">
                            <a href="#transaction-log">{translate key=TransactionHistory}</a>
                        </li>
                    {/if}
                </ul>
            </div>

            <div class="tab-content margin-top-25">
                <div class="active" id="credit-log">
                    {indicator id=creditLogIndicator}
                    <div id="credit-log-content">

                    </div>
                </div>

                {if $AllowPurchasingCredits && $IsCreditCostSet}
                    <div id="purchase">
                        <form role="form" name="purchaseCreditsForm" id="purchaseCreditsForm" method="post"
                              action="checkout.php">
                            <div class="row">
                                <div class="col s6">
                                    <div class="col s8">
                                        {translate key=EachCreditCosts}
                                    </div>
                                    <div class="col s4 align-right">
                                        {$CreditCost}
                                    </div>
                                    <div class="col s8">
                                        {translate key=Credits}
                                    </div>
                                    <div class="col s4 align-right">
                                        <input id="quantity" {formname key=CREDIT_QUANTITY} type="number"
                                               class="" min="1" value="1" style="width:100px"/>
                                        <label for="quantity">{translate key=Credits}</label>
                                    </div>
                                    <div class="col s8 total">
                                        {translate key=Total}
                                    </div>
                                    <div class="col s4 align-right total">
                                        <span id="totalCost" class="cost">{$CreditCost}</span>
                                    </div>

                                    <div class="clearfix">
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col s6">
                                    <div class="checkout-buttons">
                                        <button type="submit" class="btn btn-primary waves-effect waves-light right">
                                            {translate key=Checkout}
                                        </button>
                                    </div>
                                </div>
                            </div>
                            {csrf_token}
                        </form>

                    </div>
                    <div id="transaction-log">
                        {indicator id=transactionLogIndicator}
                        <div id="transaction-log-content">

                        </div>
                    </div>
                {/if}
            </div>
        </div>

    </div>
    {include file="javascript-includes.tpl"}
    {jsfile src="user-credits.js"}
    {jsfile src="ajax-helpers.js"}

</div>

<script type="text/javascript">
    $(function () {

        var opts = {
            calcQuantityUrl: '{$smarty.server.SCRIPT_NAME}?dr=calcQuantity&quantity=',
            creditLogUrl: '{$smarty.server.SCRIPT_NAME}?dr=creditLog&page=[page]&pageSize=[pageSize]',
            transactionLogUrl: '{$smarty.server.SCRIPT_NAME}?dr=transactionLog&page=[page]&pageSize=[pageSize]'
        };

        var userCredits = new UserCredits(opts);
        userCredits.init();

        $('.tabs').tabs();

        // var url = document.location.toString();
        // if (url.match('#')) {
        //     $('.nav-pills a[href="#' + url.split('#')[1] + '"]').tab('show');
        // }
        //
        // $('.nav-pills a').on('shown.bs.tab', function (e) {
        //     window.location.hash = e.target.hash;
        // });
    });
</script>
{include file='globalfooter.tpl'}
