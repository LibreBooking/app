{include file='globalheader.tpl'}
<div id="page-checkout">

    <div class="row">
        <h5>
            {translate key=Checkout}
        </h5>
        <script src="https://www.paypal.com/sdk/js?client-id={$PayPalClientId}&intent=capture&currency={$Currency}&commit=true&disable-funding=credit"></script>
        <script src="https://checkout.stripe.com/checkout.js"></script>

        <div id="checkoutPage" class="col s12">

            {if !$IsCartEmpty}
                <div class="cart" id="cart">

                    <div class="row">
                        <div class="col s6">
                            <div class="col s12 label">{translate key=PurchaseSummary}</div>
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
                                {$CreditQuantity}
                            </div>
                            <div class="col s8 total">
                                {translate key=Total}
                            </div>
                            <div class="col s4 align-right total">
                                {$Total}
                            </div>

                            <div class="clearfix">
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col s6">
                            <div class="checkout-buttons">
                                <div class="checkout-buttons">
                                    {if $PayPalEnabled}
                                        <div class="col s12 m3">
                                            <div id="paypal-button"></div>
                                        </div>
                                    {/if}
                                    {if $StripeEnabled}
                                        <div class="col s12 m9">
                                            <button id="stripe-button" class="btn btn-default"><span
                                                        class="fa fa-credit-card"></span> {translate key=PayWithCard}
                                            </button>
                                        </div>
                                    {/if}
                                </div>
                            </div>
                        </div>
                    </div>

                </div>
                <div class="clearfix"></div>
            {else}
                <div class="col s12 card warning">
                    {translate key=EmptyCart} <a
                            href="{$ScriptUrl}/{Pages::CREDITS}#purchase">{translate key=BuyCredits}</a>
                </div>
            {/if}

            <div class="no-show" id="success">
                <div class="col s12 card success">
                    <h5>{translate key=Success}</h5>
                    <div><strong>{$CreditQuantity}</strong> {translate key=CreditsPurchased}</div>
                    <div><a href="{$ScriptUrl}/{Pages::CREDITS}">{translate key=ViewYourCredits}</a></div>
                </div>
            </div>

            <div class="no-show" id="error">
                <div class="col s12 card error">
                    <div>{translate key=PurchaseFailed}</div>
                    <div><a href="{$ScriptUrl}/{Pages::CREDITS}#purchase">{translate key=TryAgain}</a></div>
                </div>
            </div>

            {csrf_token}

            {include file="javascript-includes.tpl"}
            {jsfile src="ajax-helpers.js"}

            <script type="text/javascript">
                $(function () {
                    {if $PayPalEnabled}

                    const CREATE_PAYMENT_URL = '{$smarty.server.SCRIPT_NAME}?action=createPayPalPayment';
                    const EXECUTE_PAYMENT_URL = '{$smarty.server.SCRIPT_NAME}?action=executePayPalPayment';

                    paypal.Buttons({
                        createOrder: function (data, actions) {
                            const fd = new FormData();
                            fd.append("CSRF_TOKEN", $('#csrf_token').val());
                            return fetch(CREATE_PAYMENT_URL, {
                                method: 'POST', body: fd, credentials: "include",
                            }).then(function (res) {
                                return res.json();
                            }).then(function (data) {
                                return data.id;
                            });
                        },

                        onApprove: function (data, actions) {
                            const fd = new FormData();
                            fd.append("CSRF_TOKEN", $('#csrf_token').val());
                            fd.append("paymentID", data.orderID);
                            return fetch(EXECUTE_PAYMENT_URL, {
                                method: 'POST', body: fd, credentials: "include"
                            }).then(function (res) {
                                return res.json();
                            }).then(function (res) {
                                $('#cart').addClass('no-show');
                                if (res.status != "COMPLETED") {
                                    $('#error').removeClass('no-show');
                                } else {
                                    $('#success').removeClass('no-show');
                                }
                            });
                        }

                    }).render('#paypal-button');

                    {/if}

                    {if $StripeEnabled}

                    const executeStripePaymentUrl = '{$smarty.server.SCRIPT_NAME}?action=executeStripePayment';
                    const handler = StripeCheckout.configure({
                        key: '{$StripePublishableKey}',
                        image: 'https://stripe.com/img/documentation/checkout/marketplace.png',
                        zipCode: true,
                        locale: 'auto',
                        currency: '{$Currency}',
                        email: '{$Email}',
                        token: function (token) {
                            const data = {
                                CSRF_TOKEN: $('#csrf_token').val(), STRIPE_TOKEN: token.id
                            };

                            $.post(executeStripePaymentUrl, data, function (d) {
                                $('#cart').addClass('no-show');

                                if (d.result != true) {
                                    $('#error').removeClass('no-show');
                                } else {
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
                });
            </script>

        </div>
    </div>
</div>

{include file='globalfooter.tpl'}