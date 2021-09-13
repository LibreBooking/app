<?php

require_once(ROOT_DIR . 'Pages/SecurePage.php');
require_once(ROOT_DIR . 'Presenters/Reservation/ReservationPresenterFactory.php');
require_once(ROOT_DIR . 'Pages/Ajax/IReservationSaveResultsView.php');

interface IReservationCheckinPage extends IReservationSaveResultsView
{
    /**
     * @return string
     */
    public function GetReferenceNumber();

    /**
     * @return string
     */
    public function GetAction();
}

class ReservationCheckinPage extends Page implements IReservationCheckinPage
{
    /**
     * @var ReservationCheckinPresenter
     */
    private $_presenter;

    /**
     * @var bool
     */
    private $_reservationSavedSuccessfully;

    public function __construct()
    {
        parent::__construct();

        $factory = new ReservationPresenterFactory();
        $this->_presenter = $factory->Checkin($this, ServiceLocator::GetServer()->GetUserSession());
    }

    public function PageLoad()
    {
        try {
            $this->EnforceCSRFCheck();
            $this->_presenter->PageLoad();

            $this->Set('IsCheckingIn', $this->GetAction() == ReservationAction::Checkin);
            $this->Set('IsCheckingOut', $this->GetAction() != ReservationAction::Checkin);
            if ($this->_reservationSavedSuccessfully) {
                $this->Display('Ajax/reservation/checkin_successful.tpl');
            } else {
                $this->Display('Ajax/reservation/checkin_failed.tpl');
            }
        } catch (Exception $ex) {
            Log::Error('ReservationCheckinPage - Critical error checking in reservation: %s', $ex);
            $this->Display('Ajax/reservation/reservation_error.tpl');
        }
    }

    public function GetReferenceNumber()
    {
        return $this->GetForm(FormKeys::REFERENCE_NUMBER);
    }

    public function GetAction()
    {
        return $this->GetQuerystring(QueryStringKeys::ACTION);
    }

    /**
     * @param bool $succeeded
     */
    public function SetSaveSuccessfulMessage($succeeded)
    {
        $this->_reservationSavedSuccessfully = $succeeded;
    }

    public function SetErrors($errors)
    {
        $this->Set('Errors', $errors);
    }

    public function SetWarnings($warnings)
    {
        // no-op
    }

    public function SetRetryMessages($messages)
    {
        // no-op
    }

    public function SetCanBeRetried($canBeRetried)
    {
        // no-op
    }

    public function SetRetryParameters($retryParameters)
    {
        // no-op
    }

    public function GetRetryParameters()
    {
        return [];
    }

    public function SetCanJoinWaitList($canJoinWaitlist)
    {
        // no-op
    }
}
