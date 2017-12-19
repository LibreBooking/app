{include file='globalheader.tpl'}
<div id="page-checkout">

    <div class="default-box">
        <h1>
            {translate key=Checkout}
        </h1>
        <script src="https://www.paypalobjects.com/api/checkout.js"></script>
        <script src="https://checkout.stripe.com/checkout.js"></script>

        <div id="checkoutPage">

            {if !$IsCartEmpty}
                <div class="cart" id="cart">

                    <div class="col-xs-12 col-sm-4">
                        <h4>{translate key=PurchaseSummary}</h4>
                        <div class="col-xs-8">
                            {translate key=EachCreditCosts}
                        </div>
                        <div class="col-xs-4 align-right">
                            {$CreditCost}
                        </div>
                        <div class="col-xs-8">
                            {translate key=Credits}
                        </div>
                        <div class="col-xs-4 align-right">
                            {$CreditQuantity}</div>
                        <div class="col-xs-8 total">
                            {translate key=Total}
                        </div>
                        <div class="col-xs-4 align-right total">
                            {$Total}
                        </div>

                        <div class="clearfix">
                        </div>
                    </div>

                    <div class="col-xs-12 col-sm-8">
                        <div class="checkout-buttons">
                            {if $PayPalEnabled}
                                <div class="col-xs-12 col-sm-3">
                                    <div id="paypal-button"></div>
                                </div>
                            {/if}
                            {if $StripeEnabled}
                                <div class="col-xs-12 col-sm-9">
                                    <button id="stripe-button" class="btn btn-default"><span
                                                class="fa fa-credit-card"></span> {translate key=PayWithCard}</button>
                                </div>
                            {/if}
                        </div>
                    </div>

                </div>
                <div class="clearfix"></div>
            {else}
                <div class="alert alert-danger">
                    {translate key=EmptyCart} <a
                            href="{$ScriptUrl}/{Pages::CREDITS}#purchase">{translate key=BuyCredits}</a>
                </div>
            {/if}

            <div class="no-show" id="success">
                <div class="alert alert-success">
                    <div>{translate key=Success}</div>
                    <div><em>{$CreditQuantity}</em> {translate key=CreditsPurchased}</div>
                    <div><a href="{$ScriptUrl}/{Pages::CREDITS}">{translate key=ViewYourCredits}</a></div>
                </div>
            </div>

            <div class="no-show" id="error">
                <div class="alert alert-danger">
                    <div>{translate key=PurchaseFailed}</div>
                    <div><a href="{$ScriptUrl}/{Pages::CREDITS}#purchase">{translate key=TryAgain}</a></div>
                </div>
            </div>

            {csrf_token}

            {include file="javascript-includes.tpl"}
            {jsfile src="ajax-helpers.js"}

            <script type="text/javascript">
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
                            else {
                                $('#success').removeClass('no-show');
                            }
                        });
                    },

                    onError: function (err) {
                        $('#error').removeClass('no-show');
                    }

                }, '#paypal-button');

                {/if}

                {if $StripeEnabled}

                var executeStripePaymentUrl = '{$smarty.server.SCRIPT_NAME}?action=executeStripePayment';
                var handler = StripeCheckout.configure({
                    key: '{$StripePublishableKey}',
                    image: 'https://stripe.com/img/documentation/checkout/marketplace.png',
                    zipCode: true,
                    locale: 'auto',
                    currency: '{$Currency}',
                    email: '{$Email}',
                    token: function (token) {
                        var data = {
                            CSRF_TOKEN: $('#csrf_token').val(),
                            STRIPE_TOKEN: token.id
                        };

                        $.post(executeStripePaymentUrl, data, function (d) {
                            $('#cart').addClass('no-show');

                            if (d.result != true) {
                                $('#error').removeClass('no-show');
                            }
                            else {
                                $('#success').removeClass('no-show');
                            }
                        });
                    }
                });

                document.getElementById('stripe-button').addEventListener('click', function (e) {
                    handler.open({
                        name: '{translate key=BuyMoreCredits}',
                        description: '{$Total}',
                        amount: {$TotalUnformatted * 100}
                    });
                    e.preventDefault();
                });

                window.addEventListener('popstate', function () {
                    handler.close();
                });

                {/if}
            </script>

        </div>
    </div>
</div>

{include file='globalfooter.tpl'}