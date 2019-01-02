<?php
/**
 * Copyright 2011-2019 Nick Korbel
 *
 * This file is part of Booked Scheduler.
 *
 * Booked Scheduler is free software: you can redistribute it and/or modify
 * it under the terms of the GNU General Public License as published by
 * the Free Software Foundation, either version 3 of the License, or
 * (at your option) any later version.
 *
 * Booked Scheduler is distributed in the hope that it will be useful,
 * but WITHOUT ANY WARRANTY; without even the implied warranty of
 * MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
 * GNU General Public License for more details.
 *
 * You should have received a copy of the GNU General Public License
 * along with Booked Scheduler.  If not, see <http://www.gnu.org/licenses/>.
 */

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
		try
		{
			$this->EnforceCSRFCheck();
			$this->_presenter->PageLoad();

			$this->Set('IsCheckingIn', $this->GetAction() == ReservationAction::Checkin);
			$this->Set('IsCheckingOut', $this->GetAction() != ReservationAction::Checkin);
			if ($this->_reservationSavedSuccessfully)
			{
				$this->Display('Ajax/reservation/checkin_successful.tpl');
			}
			else
			{
				$this->Display('Ajax/reservation/checkin_failed.tpl');
			}
		} catch (Exception $ex)
		{
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
		return array();
	}

    public function SetCanJoinWaitList($canJoinWaitlist)
    {
        // no-op
    }
}