<?php
/**
Copyright 2011-2012 Nick Korbel

This file is part of phpScheduleIt.

phpScheduleIt is free software: you can redistribute it and/or modify
it under the terms of the GNU General Public License as published by
the Free Software Foundation, either version 3 of the License, or
(at your option) any later version.

phpScheduleIt is distributed in the hope that it will be useful,
but WITHOUT ANY WARRANTY; without even the implied warranty of
MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
GNU General Public License for more details.

You should have received a copy of the GNU General Public License
along with phpScheduleIt.  If not, see <http://www.gnu.org/licenses/>.
*/
 
require_once(ROOT_DIR . 'Pages/SecurePage.php');
require_once(ROOT_DIR . 'Pages/Ajax/IReservationSaveResultsPage.php');
require_once(ROOT_DIR . 'Presenters/ReservationDeletePresenter.php');

interface IReservationDeletePage extends IReservationSaveResultsPage
{
	/**
	 * @return int
	 */
	public function GetReservationId();

	/**
	 * @return SeriesUpdateScope|string
	 */
	public function GetSeriesUpdateScope();
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

		$persistenceFactory = new ReservationPersistenceFactory();

		$updateAction = ReservationAction::Delete;

		$handler = ReservationHandler::Create($updateAction, $persistenceFactory->Create($updateAction));
		$this->presenter = new ReservationDeletePresenter(
			$this,
			$persistenceFactory->Create($updateAction),
			$handler
		);
	}

	public function PageLoad()
	{
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
	}

	public function SetSaveSuccessfulMessage($succeeded)
	{
		$this->reservationSavedSuccessfully = $succeeded;
	}

	public function ShowErrors($errors)
	{
		$this->Set('Errors', $errors);
	}

	public function ShowWarnings($warnings)
	{
		// set warnings variable
	}

	public function GetReservationId()
	{
		return $this->GetForm(FormKeys::RESERVATION_ID);
	}

	public function GetSeriesUpdateScope()
	{
		return $this->GetForm(FormKeys::SERIES_UPDATE_SCOPE);
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

	public function ShowErrors($errors)
	{
		if (!empty($errors))
		{
			$this->SetJson(array('deleted' => (string)false), $errors);
		}
	}

	public function ShowWarnings($warnings)
	{
		// nothing to do
	}
}
?>