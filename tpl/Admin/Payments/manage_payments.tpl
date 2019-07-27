{*
Copyright 2017-2019 Nick Korbel

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

    <h1>{translate key=ManagePayments}</h1>

    <div id="updatedCreditsMessage" class="alert alert-success" style="display:none;">
        {translate key=CreditsUpdated}
    </div>
    <div id="updatedGatewayMessage" class="alert alert-success" style="display:none;">
        {translate key=GatewaysUpdated}
    </div>
    <div id="refundIssuedMessage" class="alert alert-success" style="display:none;">
        {translate key=RefundIssued}
    </div>

    {if !$PaymentsEnabled}
        <div class="error alert alert-danger">
            {translate key=CreditPurchaseNotEnabled}<br/>
            <a href="{$Path}/admin/manage_configuration.php">{translate key=ManageConfiguration}</a>
        </div>
    {else}
        <ul class="nav nav-tabs" role="tablist">
            <li class="nav-item active">
                <a class="nav-link active" data-toggle="tab" href="#transactions"
                   role="tab">{translate key=Transactions}</a>
            </li>
            <li class="nav-item">
                <a class="nav-link" data-toggle="tab" href="#cost" role="tab">{translate key=Cost}</a>
            </li>
            <li class="nav-item">
                <a class="nav-link" data-toggle="tab" href="#gateways" role="tab">{translate key=PaymentGateways}</a>
            </li>
        </ul>
        <div class="tab-content">
            <div class="tab-pane active" id="transactions" role="tabpanel">
                {indicator id=transactionLogIndicator}
                <div id="transaction-log-content">

                </div>
            </div>

            <div class="tab-pane" id="cost" role="tabpanel">
                <div>
                    <form role="form" name="updateCreditsForm" id="updateCreditsForm" method="post"
                          ajaxAction="updateCreditCost"
                          action="{$smarty.server.SCRIPT_NAME}">
                        <div class="form-group">
                            <label for="creditCost" class="inline-block">{translate key=CreditsCost}</label>
                            <input type="number" min="0" max="1000000000" id="creditCost" step="any"
                                   class="form-control inline-block" style="width:auto;" {formname key=CREDIT_COST}
                                   value="{$CreditCost}"/>
                            <label for="creditCurrency" class="inline-block no-show">{translate key=Currency}</label>
                            <select id="creditCurrency" {formname key=CREDIT_CURRENCY} class="form-control inline-block"
                                    style="width:auto;">
                                {foreach from=$Currencies item=c}
                                    <option value="{$c->IsoCode()}">{$c->IsoCode()}</option>
                                {/foreach}
                            </select>
                            {update_button submit=true}
                            {indicator id="updateCreditsIndicator"}
                        </div>
                    </form>
                </div>
            </div>

            <div class="tab-pane" id="gateways" role="tabpanel">
                <form role="form" name="updateGatewayForm" id="updateGatewayForm" method="post"
                      ajaxAction="updatePaymentGateways"
                      action="{$smarty.server.SCRIPT_NAME}" class="form-vertical">
                    <div class="col-xs-12 col-sm-6">
                        <div class="payment-gateway-title">PayPal</div>
                        <div class="form-group">
                            <label class="switch">
                                <input id="paypalEnabled" type="checkbox" value="1" {formname key=PAYPAL_ENABLED}
                                       class="toggleDisabled" data-target="paypal-toggle">
                                <span class="slider round"></span>
                            </label>
                        </div>
                        <div class="form-group">
                            <label for="paypalClientId">{translate key=PayPalClientId}  </label>
                            <input type="text" id="paypalClientId" class="form-control paypal-toggle required" required
                                   disabled="disabled" {formname key=PAYPAL_CLIENT_ID} value="{$PayPalClientId}"/>

                        </div>
                        <div class="form-group">
                            <label for="paypalSecret">{translate key=PayPalSecret}</label>
                            <input type="text" id="paypalSecret" class="form-control paypal-toggle required" required
                                   disabled="disabled" {formname key=PAYPAL_SECRET} value="{$PayPalSecret}"/>

                        </div>
                        <div class="form-group">
                            <label for="paypalEnvironment">{translate key=PayPalEnvironment} </label>
                            <select id="paypalEnvironment" class="form-control paypal-toggle"
                                    disabled="disabled" {formname key=PAYPAL_ENVIRONMENT}>
                                <option value="live"
                                        {if $PayPalEnvironment =='live'}selected="selected"{/if}>{translate key=Live}</option>
                                <option value="sandbox"
                                        {if $PayPalEnvironment =='sandbox'}selected="selected"{/if}>{translate key=Sandbox}</option>
                            </select>

                        </div>
                    </div>

                    <div class="form-group col-xs-12 col-sm-6">
                        <div class="payment-gateway-title">Stripe</div>
                        <div class="form-group">
                            <label class="switch">
                                <input id="stripeEnabled" type="checkbox" value="1" {formname key=STRIPE_ENABLED}
                                       class="toggleDisabled" data-target="stripe-toggle">
                                <span class="slider round"></span>
                            </label>
                        </div>
                        <div class="form-group">
                            <label for="stripePublishKey">{translate key=StripePublishableKey}</label>
                            <input type="text" id="stripePublishKey" class="form-control stripe-toggle required"
                                   required
                                   disabled="disabled" {formname key=STRIPE_PUBLISHABLE_KEY}
                                   value="{$StripePublishableKey}"/>

                        </div>
                        <div class="form-group">
                            <label for="stripeSecretKey">{translate key=StripeSecretKey} </label>
                            <input type="text" id="stripeSecretKey" class="form-control stripe-toggle required" required
                                   disabled="disabled" {formname key=STRIPE_SECRET_KEY} value="{$StripeSecretKey}"/>

                        </div>
                    </div>
                    <div class="col-xs-12">
                        {update_button submit=true class="col-xs-12"}
                        {indicator}
                    </div>
                </form>
            </div>
        </div>
    {/if}

    <div class="modal fade" id="refundDialog" tabindex="-1" role="dialog" aria-labelledby="refundDialogLabel"
         aria-hidden="true">
        <div class="modal-dialog">
            <form role="form" name="issueRefundForm" id="issueRefundForm" method="post"
                  ajaxAction="issueRefund"
                  action="{$smarty.server.SCRIPT_NAME}" class="form-vertical">
                <div class="modal-content">
                    <div class="modal-header">
                        <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                        <h4 class="modal-title" id="refundDialogLabel">{translate key=IssueRefund}</h4>
                    </div>
                    <div class="modal-body">
                        <div class="form-group">
                            <label for="refundAmount">{translate key='RefundAmount'}</label>
                            <input type="number" id="refundAmount" min=".01" class="form-control" {formname key=REFUND_AMOUNT}/>
                            <input type="hidden" id="refundId" {formname key=REFUND_TRANSACTION_ID} />
                        </div>
                    </div>
                    <div class="modal-footer">
                        {cancel_button}
                        {update_button submit=true key=IssueRefund}
                        {indicator}
                    </div>
                </div>
            </form>
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

                var url = document.location.toString();
                if (url.match('#')) {
                    $('.nav-tabs a[href="#' + url.split('#')[1] + '"]').tab('show');
                }

                $('.nav-tabs a').on('shown.bs.tab', function (e) {
                    window.location.hash = e.target.hash;
                })
            });
        </script>

    </div>

{include file='globalfooter.tpl'}