<?php

require_once(ROOT_DIR . 'Presenters/ActionPresenter.php');
require_once(ROOT_DIR . 'Pages/Admin/ManagePaymentsPage.php');
require_once(ROOT_DIR . 'Domain/Access/PaymentRepository.php');

class ManagePaymentsActions
{
    const UPDATE_CREDIT_COST = 'updateCreditCost';
    const UPDATE_PAYMENT_GATEWAYS = 'updatePaymentGateways';
    const ISSUE_REFUND = 'issueRefund';
}

class ManagePaymentsPresenter extends ActionPresenter
{
    /**
     * @var IManagePaymentsPage
     */
    private $page;
    /**
     * @var IPaymentRepository
     */
    private $paymentRepository;
    /**
     * @var IPaymentTransactionLogger
     */
    private $paymentLogger;

    public function __construct(IManagePaymentsPage $page, IPaymentRepository $paymentRepository, IPaymentTransactionLogger $logger)
    {
        parent::__construct($page);
        $this->page = $page;
        $this->paymentRepository = $paymentRepository;
        $this->paymentLogger = $logger;

        $this->AddAction(ManagePaymentsActions::UPDATE_CREDIT_COST, 'UpdateCreditCost');
        $this->AddAction(ManagePaymentsActions::UPDATE_PAYMENT_GATEWAYS, 'UpdatePaymentGateways');
        $this->AddAction(ManagePaymentsActions::ISSUE_REFUND, 'IssueRefund');
    }

    public function PageLoad()
    {
        $cost = $this->paymentRepository->GetCreditCost();
        $this->page->SetCreditCost($cost->Cost(), $cost->Currency());

        $paypal = $this->paymentRepository->GetPayPalGateway();
        $stripe = $this->paymentRepository->GetStripeGateway();

        $this->page->SetPayPalSettings($paypal->IsEnabled(), $paypal->ClientId(), $paypal->Secret(), $paypal->Environment());
        $this->page->SetStripeSettings($stripe->IsEnabled(), $stripe->PublishableKey(), $stripe->SecretKey());
    }

    public function UpdateCreditCost()
    {
        $cost = max(0, floatval($this->page->GetCreditCost()));
        $currency = $this->page->GetCreditCurrency();

        Log::Debug('Updating credit cost. %s, %s', $cost, $currency);
        $this->paymentRepository->UpdateCreditCost(new CreditCost($cost, $currency));
    }

    public function UpdatePaymentGateways()
    {
        $paypalGateway = new PayPalGateway($this->page->GetPayPalIsEnabled(), $this->page->GetPayPalClientId(), $this->page->GetPayPalSecret(), $this->page->GetPayPalEnvironment());
        $stripeGateway = new StripeGateway($this->page->GetStripeIsEnabled(), $this->page->GetStripePublishableKey(), $this->page->GetStripeSecretKey());

        Log::Debug('Updating payment gateways');

        $this->paymentRepository->UpdatePayPalGateway($paypalGateway);
        $this->paymentRepository->UpdateStripeGateway($stripeGateway);
    }

    public function ProcessDataRequest($dataRequest, $userSession)
    {
        if ($dataRequest == 'transactionLog') {
            $this->GetTransactionLog();
        }
        else {
            $this->GetTransactionDetails();
        }
    }

    public function GetTransactionLog()
    {
        $page = $this->page->GetPageNumber();
        $size = $this->page->GetPageSize();
        $log = $this->paymentRepository->GetList($page, $size);

        $this->page->BindTransactionLog($log);
    }

    public function GetTransactionDetails()
    {
        $id = $this->page->GetTransactionLogId();
        $transactionLogView = $this->paymentRepository->GetTransactionLogView($id);
        if ($transactionLogView != null) {
            $this->page->BindTransactionLogView($transactionLogView);
        }
    }

    public function IssueRefund()
    {
        $id = $this->page->GetRefundTransactionLogId();
        $amount = $this->page->GetRefundAmount();
        $transactionLogView = $this->paymentRepository->GetTransactionLogView($id);

        if ($transactionLogView->GatewayName == PaymentGateways::PAYPAL) {
            $gateway = $this->paymentRepository->GetPayPalGateway();
            $refund = $gateway->Refund($transactionLogView, $amount, $this->paymentLogger);

            $this->page->BindRefundIssued($refund->state == 'completed');
        }
        else{
            $gateway = $this->paymentRepository->GetStripeGateway();

            $refunded = $gateway->Refund($transactionLogView, $amount, $this->paymentLogger);

            $this->page->BindRefundIssued($refunded);
        }
    }
}
