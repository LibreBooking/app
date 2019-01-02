<?php
/**
 * Copyright 2017-2019 Nick Korbel
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

require_once(ROOT_DIR . 'Presenters/Reservation/ReservationMovePresenter.php');
require_once(ROOT_DIR . 'Pages/Ajax/IReservationSaveResultsView.php');

interface IReservationMovePage extends IReservationSaveResultsView
{
	/**
	 * @return string
	 */
	public function GetStartDate();

	/**
	 * @return string
	 */
	public function GetReferenceNumber();

	/**
	 * @return int
	 */
	public function GetResourceId();

	/**
	 * @return int
	 */
	public function GetOriginalResourceId();
}

class ReservationMovePage extends Page implements IReservationMovePage
{
	/**
	 * @var ReservationMovePresenter
	 */
	private $presenter;

	private $successful = false;
	private $errors = array();
	private $warnings = array();

	public function __construct()
	{
		parent::__construct();

		$userSession = ServiceLocator::GetServer()->GetUserSession();
		$persistenceFactory = new ReservationPersistenceFactory();
		$reservationAction = ReservationAction::Update;
		$handler = ReservationHandler::Create($reservationAction,
											  $persistenceFactory->Create($reservationAction),
											  $userSession);

		$this->presenter = new ReservationMovePresenter($this, $persistenceFactory->Create(ReservationAction::Update), $handler, new ResourceRepository(), $userSession);
	}

	public function PageLoad()
	{
		$this->EnforceCSRFCheck();
		$this->presenter->PageLoad();

		$this->SetJson(array('success' => $this->successful, 'errors' => $this->errors, 'warnings' => $this->warnings));
	}

	public function GetStartDate()
	{
		return $this->GetForm(FormKeys::BEGIN_DATE);
	}

	public function GetReferenceNumber()
	{
		return $this->GetForm(FormKeys::REFERENCE_NUMBER);
	}

	public function GetResourceId()
	{
		return $this->GetForm(FormKeys::RESOURCE_ID);
	}

	public function GetOriginalResourceId()
	{
		return $this->GetForm(FormKeys::ORIGINAL_RESOURCE_ID);
	}

	public function SetSaveSuccessfulMessage($succeeded)
	{
		$this->successful = $succeeded;
	}

	public function SetErrors($errors)
	{
		$this->errors = $errors;
	}

	public function SetWarnings($warnings)
	{
		$this->warnings = $warnings;
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

    /**
     * @param bool $canJoinWaitlist
     */
    public function SetCanJoinWaitList($canJoinWaitlist)
    {
        // no-op
    }
}