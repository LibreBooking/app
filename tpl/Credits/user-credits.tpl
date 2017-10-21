{include file='globalheader.tpl'}
<script src="https://www.paypalobjects.com/api/checkout.js"></script>

<div id="currentCredits">

</div>
<h1>{$CurrentCredits}</h1>


{if $AllowPurchasingCredits}Buy more credits{/if}

<div id="paypal-button"></div>

<script>
    paypal.Button.render({
        env: '{$PayPalEnvironment}',
        commit: true,
        client: {
            sandbox:    '{$PayPalClientId}',
            production: '{$PayPalClientId}'
        },
        payment: function(data, actions) {
            return actions.payment.create({
                payment: {
                    transactions: [
                        {
                            amount: { total: '1.00', currency: 'USD' }
                        }
                    ]
                }
            });
        },

        onAuthorize: function(data, actions) {
            return actions.payment.execute().then(function(payment) {

                console.log(payment);

                /**
                 * {id: "PAY-48376726T12145322LHPMZZA", intent: "sale", state: "approved", cart: "3RS72835R7198190N", create_time: "2017-10-12T02:02:50Z", …}cart: "3RS72835R7198190N"create_time: "2017-10-12T02:02:50Z"id: "PAY-48376726T12145322LHPMZZA"intent: "sale"payer: {payment_method: "paypal", status: "VERIFIED", payer_info: {…}}state: "approved"transactions: [{…}]__proto__: Object
                 */
                // The payment is complete!
                // You can now show a confirmation message to the customer
            });
        }

    }, '#paypal-button');
</script>

{csrf_token}

{include file="javascript-includes.tpl"}

{include file='globalfooter.tpl'}
