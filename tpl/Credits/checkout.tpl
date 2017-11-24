{include file='globalheader.tpl'}
<div id="page-checkout">

    <script src="https://www.paypalobjects.com/api/checkout.js"></script>

    <div id="checkoutPage">

        {if !$IsCartEmpty}
            <div class="cart" id="cart">
                <div>{translate key=OrderSummary}</div>
                <div>{$CreditQuantity}</div>
                <div>{$CreditCost}</div>
                <div>{$Total}</div>
            </div>
            <div id="paypal-button"></div>
        {else}
            <div class="alert alert-danger">
                {translate key=EmptyCart} <a href="{$ScriptUrl}/{Pages::CREDITS}">{translate key=BuyCredits}</a>
            </div>
        {/if}

        <div class="no-show" id="success">
            <div class="alert alert-success">
                <div>{translate key=Success}</div>
                <div>{$CreditQuantity} {translate key=CreditsPurchased}</div>
                <div><a href="{$ScriptUrl}/{Pages::CREDITS}">{translate key=ViewYourCredits}</a></div>
            </div>
        </div>

        <div class="no-show" id="error">
            <div class="alert alert-danger">
                <div{translate key=PurchaseFailed}</div>
                <div><a href="{$ScriptUrl}/{Pages::CREDITS}">{translate key=TryAgain}</a></div>
            </div>
        </div>

        {csrf_token}

        {include file="javascript-includes.tpl"}
        {jsfile src="ajax-helpers.js"}

        <script>
            {if $PayPalEnabled}

            var CREATE_PAYMENT_URL = '{$smarty.server.SCRIPT_NAME}?action=createPayPalPayment';
            var EXECUTE_PAYMENT_URL = '{$smarty.server.SCRIPT_NAME}?action=executePayPalPayment';

            paypal.Button.render({
                env: '{$PayPalEnvironment}',
                commit: true,

                payment: function () {
                    return paypal.request.post(CREATE_PAYMENT_URL, {
                        CSRF_TOKEN: $('#csrf_token').val()
                    }).then(function (res) {
                        return res.id;
                    });
                },

                onAuthorize: function (data) {
                    return paypal.request.post(EXECUTE_PAYMENT_URL, {
                        paymentID: data.paymentID,
                        payerID: data.payerID,
                        CSRF_TOKEN: $('#csrf_token').val()
                    }).then(function (data) {
                        $('#cart').addClass('no-show');
                        if (data.state != "approved") {
                            $('#error').removeClass('no-show');
                        }
                        $('#success').removeClass('no-show');
                    });
                },

                onError: function (err) {
                    $('#error').removeClass('no-show');
                }

            }, '#paypal-button');

            {/if}
        </script>


    </div>
</div>

{include file='globalfooter.tpl'}