{include file='globalheader.tpl'}
<script src="https://www.paypalobjects.com/api/checkout.js"></script>

<div id="currentCredits">

</div>
<h1>{$CurrentCredits}</h1>


{if $AllowPurchasingCredits && ($PayPalEnabled || $StripeEnabled)}Buy more credits{/if}

<div id="paypal-button"></div>

{include file="javascript-includes.tpl"}
{jsfile src="ajax-helpers.js"}

<form id="responseData">
    <input id="paymentResponseData" type="hidden" {formname key=PAYMENT_RESPONSE_DATA} />
</form>

<script>
    {if $PayPalEnabled}

    var CREATE_PAYMENT_URL = '{$smarty.server.SCRIPT_NAME}?action=createPayPalPayment';
    var EXECUTE_PAYMENT_URL = '{$smarty.server.SCRIPT_NAME}?action=executePayPalPayment';

    ajaxPost($('#payment'), CREATE_PAYMENT_URL);

    paypal.Button.render({
        env: '{$PayPalEnvironment}',
        commit: true,

        payment: function () {
            return paypal.request.post(CREATE_PAYMENT_URL, {
                CSRF_TOKEN: $('#csrf_token').val()
            }).then(function (res) {
                return res.paymentID;
            });
        },

        onAuthorize: function (data) {
            return paypal.request.post(EXECUTE_PAYMENT_URL, {
                paymentID: data.paymentID,
                payerID: data.payerID,
                CSRF_TOKEN: $('#csrf_token').val()
            }).then(function () {

                // The payment is complete!
                // You can now show a confirmation message to the customer
            });
        },

        onError: function (err) {
            // Show an error page here, when an error occurs
        }

    }, '#paypal-button');

    {/if}
</script>

{csrf_token}


{include file='globalfooter.tpl'}
