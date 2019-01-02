<?php
/**
Copyright 2011-2019 Nick Korbel

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
 */

require_once(ROOT_DIR . 'Pages/SecurePage.php');
require_once(ROOT_DIR . 'Pages/Ajax/IReservationSaveResultsView.php');
require_once(ROOT_DIR . 'Presenters/Reservation/ReservationPresenterFactory.php');

interface IReservationDeletePage extends IReservationSaveResultsView
{
	/**
	 * @return string
	 */
	public function GetReferenceNumber();

	/**
	 * @return SeriesUpdateScope|string
	 */
	public function GetSeriesUpdateScope();

    /**
     * @return string
     */
    public function GetReason();
}

class ReservationDeletePage extends SecurePage implements IReservationDeletePage
{
	/**
	 * @var ReservationDeletePresenter
	 */
	protected $presenter;

	/**
	 * @var bool
	 */
	protected $reservationSavedSuccessfully = false;

	public function __construct()
	{
		parent::__construct();

		$factory = new ReservationPresenterFactory();
		$this->presenter = $factory->Delete($this, ServiceLocator::GetServer()->GetUserSession());
	}

	public function PageLoad()
	{
		try
		{
			$this->EnforceCSRFCheck();
			$reservation = $this->presenter->BuildReservation();
			$this->presenter->HandleReservation($reservation);

			if ($this->reservationSavedSuccessfully)
			{
				$this->Display('Ajax/reservation/delete_successful.tpl');
			}
			else
			{
				$this->Display('Ajax/reservation/delete_failed.tpl');
			}
		} catch (Exception $ex)
		{
			Log::Error('ReservationDeletePage - Critical error saving reservation: %s', $ex);
			$this->Display('Ajax/reservation/reservation_error.tpl');
		}
	}

	public function SetSaveSuccessfulMessage($succeeded)
	{
		$this->reservationSavedSuccessfully = $succeeded;
	}

	public function SetErrors($errors)
	{
		$this->Set('Errors', $errors);
	}

	public function SetWarnings($warnings)
	{
		// set warnings variable
	}

	public function GetReferenceNumber()
	{
		return $this->GetForm(FormKeys::REFERENCE_NUMBER);
	}

	public function GetSeriesUpdateScope()
	{
		return $this->GetForm(FormKeys::SERIES_UPDATE_SCOPE);
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
		// no-op
	}

    public function SetCanJoinWaitList($canJoinWaitlist)
    {
        // no-op
    }

    public function GetReason()
    {
       return $this->GetForm(FormKeys::DELETE_REASON);
    }
}

class ReservationDeleteJsonPage extends ReservationDeletePage implements IReservationDeletePage
{
	public function __construct()
	{
		parent::__construct();
	}

	public function PageLoad()
	{
		$reservation = $this->presenter->BuildReservation();
        $this->presenter->HandleReservation($reservation);
	}

	/**
	 * @param bool $succeeded
	 */
	public function SetSaveSuccessfulMessage($succeeded)
	{
		if ($succeeded)
		{
			$this->SetJson(array('deleted' => (string)$succeeded));
		}
	}

	public function SetErrors($errors)
	{
		if (!empty($errors))
		{
			$this->SetJson(array('deleted' => (string)false), $errors);
		}
	}

	public function SetWarnings($warnings)
	{
		// no-op
	}

	/**
	 * @param array|string[] $messages
	 */
	public function SetRetryMessages($messages)
	{
		// no-op
	}

	/**
	 * @param bool $canBeRetried
	 */
	public function SetCanBeRetried($canBeRetried)
	{
		// no-op
	}

	/**
	 * @param ReservationRetryParameter[] $retryParameters
	 */
	public function SetRetryParameters($retryParameters)
	{
		// no-op
	}

	/**
	 * @return ReservationRetryParameter[]
	 */
	public function GetRetryParameters()
	{
		// no-op
	}
}