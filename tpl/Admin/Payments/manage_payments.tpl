{*
Copyright 2017-2020 Nick Korbel

This file is part of Booked Scheduler.

Booked Scheduler is free software: you can redistribute it and/or modify
it under the terms of the GNU General Public License as published by
the Free Software Foundation, either version 3 of the License, or
(at your option) any later version.

Booked Scheduler is distributed in the hope that it will be useful,
but WITHOUT ANY WARRANTY; without even the implied warranty of
MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
GNU General Public License for more details.

You should have received a copy of the GNU General Public License
along with Booked Scheduler.  If not, see <http://www.gnu.org/licenses/>.
*}

{include file='globalheader.tpl'}

<div id="page-manage-payments" class="admin-page">

    <div class="row">
        <h1 class="page-title">{translate key=ManagePayments}</h1>

        <div class="col s12 card success" id="updatedCreditsMessage" style="display:none;">
            <ul>
                <li>{translate key=CreditsUpdated}</li>
            </ul>
        </div>

        <div class="col s12 card success" id="updatedGatewayMessage" style="display:none;">
            <ul>
                <li>{translate key=GatewaysUpdated}</li>
            </ul>
        </div>

        <div class="col s12 card success" id="refundIssuedMessage" style="display:none;">
            <ul>
                <li>{translate key=RefundIssued}</li>
            </ul>
        </div>

        {if !$PaymentsEnabled}
            <div class="col s12 card error">
                <ul>
                    <li>{translate key=CreditPurchaseNotEnabled}</li>
                    <li><a href="{$Path}/admin/manage_configuration.php">{translate key=ManageConfiguration}</a></li>
                </ul>
            </div>
        {else}
            <ul class="tabs" id="tabs">
                <li class="tab">
                    <a class="active" href="#transactions">{translate key=Transactions}</a>
                </li>
                <li class="tab">
                    <a href="#cost">{translate key=Cost}</a>
                </li>
                <li class="tab">
                    <a href="#gateways">{translate key=PaymentGateways}</a>
                </li>
            </ul>
            <div class="tab-content">
                <div class="active" id="transactions">
                    {indicator id=transactionLogIndicator}
                    <div id="transaction-log-content">

                    </div>
                </div>

                <div id="cost">
                    <div>
                        <form role="form" name="updateCreditsForm" id="updateCreditsForm" method="post"
                              ajaxAction="updateCreditCost"
                              action="{$smarty.server.SCRIPT_NAME}">
                            <div>
                                <div class="input-field inline">
                                    <label for="creditCost" class="inline-blocks">{translate key=CreditsCost}</label>
                            <input type="number" min="0" max="1000000000" id="creditCost" step="any"
                                           {formname key=CREDIT_COST}
                                           value="{$CreditCost}"/>
                                </div>
                                <div class="input-field inline">
                                    <label for="creditCurrency" class="active">{translate key=Currency}</label>
                                    <select id="creditCurrency" {formname key=CREDIT_CURRENCY}>
                                        {foreach from=$Currencies item=c}
                                            <option value="{$c->IsoCode()}">{$c->IsoCode()}</option>
                                        {/foreach}
                                    </select>
                                </div>
                                {update_button submit=true}
                                {indicator id="updateCreditsIndicator"}
                            </div>
                        </form>
                    </div>
                </div>

                <div id="gateways">
                    <form role="form" name="updateGatewayForm" id="updateGatewayForm" method="post"
                          ajaxAction="updatePaymentGateways"
                          action="{$smarty.server.SCRIPT_NAME}" class="form-vertical">
                        <div class="col s12 m6">
                            <div class="payment-gateway-title">PayPal</div>

                            <div class="switch">
                                <label>
                                    <input id="paypalEnabled" type="checkbox" value="1" {formname key=PAYPAL_ENABLED}
                                           class="toggleDisabled" data-target="paypal-toggle">
                                    <span class="lever"></span>
                                </label>
                            </div>

                            <div class="input-field">
                                <label for="paypalClientId">{translate key=PayPalClientId}  </label>
                                <input type="text" id="paypalClientId" class="paypal-toggle required"
                                       required
                                       disabled="disabled" {formname key=PAYPAL_CLIENT_ID} value="{$PayPalClientId}"/>

                            </div>
                            <div class="input-field">
                                <label for="paypalSecret">{translate key=PayPalSecret}</label>
                                <input type="text" id="paypalSecret" class="paypal-toggle required"
                                       required
                                       disabled="disabled" {formname key=PAYPAL_SECRET} value="{$PayPalSecret}"/>

                            </div>
                            <div class="input-field">
                                <label for="paypalEnvironment" class="active">{translate key=PayPalEnvironment} </label>
                                <select id="paypalEnvironment" class="paypal-toggle"
                                        disabled="disabled" {formname key=PAYPAL_ENVIRONMENT}>
                                    <option value="live"
                                            {if $PayPalEnvironment =='live'}selected="selected"{/if}>{translate key=Live}</option>
                                    <option value="sandbox"
                                            {if $PayPalEnvironment =='sandbox'}selected="selected"{/if}>{translate key=Sandbox}</option>
                                </select>

                            </div>
                        </div>

                        <div class="col s12 m6">
                            <div class="payment-gateway-title">Stripe</div>

                            <div class="switch">
                                <label>
                                    <input id="stripeEnabled" type="checkbox" value="1" {formname key=STRIPE_ENABLED}
                                           class="toggleDisabled" data-target="stripe-toggle" />
                                    <span class="lever"></span>
                                </label>
                            </div>


                            <div class="input-field">
                                <label for="stripePublishKey">{translate key=StripePublishableKey}</label>
                                <input type="text" id="stripePublishKey" class="stripe-toggle required"
                                       required
                                       disabled="disabled" {formname key=STRIPE_PUBLISHABLE_KEY}
                                       value="{$StripePublishableKey}"/>

                            </div>
                            <div class="input-field">
                                <label for="stripeSecretKey">{translate key=StripeSecretKey} </label>
                                <input type="text" id="stripeSecretKey" class="stripe-toggle required"
                                       required
                                       disabled="disabled" {formname key=STRIPE_SECRET_KEY} value="{$StripeSecretKey}"/>

                            </div>
                        </div>
                        <div class="col s12 align-right">
                            {update_button submit=true}
                            {indicator}
                        </div>
                    </form>
                </div>
            </div>
        {/if}

        <div id="refundDialog" class="modal">
            <div class="modal-content">
                <h4 id="refundDialogLabel">{translate key=IssueRefund}</h4>
                <div class="input-field">
                    <label for="refundAmount">{translate key='RefundAmount'}</label>
                    <input type="number" id="refundAmount" min=".01" {formname key=REFUND_AMOUNT}/>
                    <input type="hidden" id="refundId" {formname key=REFUND_TRANSACTION_ID} />
                </div>
            </div>
            <div class="modal-footer align-right">
                {cancel_button class="modal-close"}
                {update_button submit=true key=IssueRefund}
                {indicator}
            </div>
        </div>

    </div>

    {csrf_token}
    {indicator id="indicator"}

    {include file="javascript-includes.tpl"}
    {jsfile src="ajax-helpers.js"}
    {jsfile src="admin/payments.js"}

    <script type="text/javascript">
        $(function () {
            var opts = {
                transactionLogUrl: '{$smarty.server.SCRIPT_NAME}?dr=transactionLog&page=[page]&pageSize=[pageSize]',
                transactionDetailsUrl: '{$smarty.server.SCRIPT_NAME}?dr=transactionDetails&id=[id]',
            };

            var payments = new Payments(opts);
            payments.init();
            payments.initGateways({$PayPalEnabled}, {$StripeEnabled});

            $('#tabs').tabs();

            // var url = document.location.toString();
            // if (url.match('#')) {
            //     $('.nav-tabs a[href="#' + url.split('#')[1] + '"]').tab('show');
            // }
            //
            // $('.nav-tabs a').on('shown.bs.tab', function (e) {
            //     window.location.hash = e.target.hash;
            // })
        });
    </script>

</div>

{include file='globalfooter.tpl'}