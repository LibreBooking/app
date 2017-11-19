{include file='globalheader.tpl'}
<script src="https://www.paypalobjects.com/api/checkout.js"></script>

<div id="checkoutPage">

    <div>{translate key=OrderSummary}</div>
    <div>{$CreditQuantity}</div>
    <div>{$CreditCost}</div>
    <div>{$Total}</div>


    <div id="paypal-button"></div>

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
                }).then(function () {
                    console.log('done');
                    // The payment is complete!
                    // You can now show a confirmation message to the customer
                });
            },

            onError: function (err) {
                console.log(err);
            }

        }, '#paypal-button');

        {/if}
    </script>


</div>

{include file='globalfooter.tpl'}