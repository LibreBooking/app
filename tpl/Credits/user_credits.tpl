{include file='globalheader.tpl'}

<div id="page-user-credits">

    <div class="default-box">
        <div>
            <h1 class="inline-block" style="width:100%">{translate key=YourCredits}
                <div class="inline-block pull-right">{$CurrentCredits}</div>
            </h1>
        </div>

        <div>
            <ul class="nav nav-pills" role="tablist">
                <li class="nav-item active">
                    <a class="nav-link active" data-toggle="tab" href="#credit-log"
                       role="tab">{translate key=CreditHistory}</a>
                </li>

                {if $AllowPurchasingCredits && $IsCreditCostSet}
                    <li class="nav-item">
                        <a class="nav-link" data-toggle="tab" href="#purchase"
                           role="tab">{translate key=BuyMoreCredits}</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" data-toggle="tab" href="#transaction-log"
                           role="tab">{translate key=TransactionHistory}</a>
                    </li>
                {/if}
            </ul>
        </div>

        <div class="tab-content margin-top-25">
            <div class="tab-pane active" id="credit-log" role="tabpanel">
                {indicator id=creditLogIndicator}
                <div id="credit-log-content">

                </div>
            </div>

            {if $AllowPurchasingCredits && $IsCreditCostSet}
                <div class="tab-pane" id="purchase" role="tabpanel">

                    <div class="col-xs-4">
                        <form role="form" name="purchaseCreditsForm" id="purchaseCreditsForm" method="post"
                              action="checkout.php">
                            <div>{translate key=EachCreditCosts} <span class="cost">{$CreditCost}</span></div>
                            <div>{translate key=Quantity}
                                <input id="quantity" {formname key=CREDIT_QUANTITY} type="number"
                                       class="form-control inline-block" min="1"
                                       style="width:100px" value="1"/>
                            </div>
                            <div>
                                {translate key=Total} <span id="totalCost" class="cost">{$CreditCost}</span>
                            </div>
                            <button type="submit" class="btn btn-default col-xs-12">{translate key=Checkout}</button>
                            {csrf_token}
                        </form>
                    </div>

                    <div class="col-xs-8">&nbsp;</div>
                    <div class="clearfix"></div>

                </div>

                <div class="tab-pane" id="transaction-log" role="tabpanel">
                    {indicator id=transactionLogIndicator}
                    <div id="transaction-log-content">

                    </div>
                </div>
            {/if}
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

        var url = document.location.toString();
        if (url.match('#')) {
            $('.nav-pills a[href="#' + url.split('#')[1] + '"]').tab('show');
        }

        $('.nav-pills a').on('shown.bs.tab', function (e) {
            window.location.hash = e.target.hash;
        });
    });
</script>
{include file='globalfooter.tpl'}
