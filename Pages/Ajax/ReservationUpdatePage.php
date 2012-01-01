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
 
require_once(ROOT_DIR . 'Pages/Ajax/ReservationSavePage.php');
require_once(ROOT_DIR . 'Presenters/ReservationUpdatePresenter.php');

interface IReservationUpdatePage extends IReservationSavePage
{
	/**
	 * @return int
	 */
	public function GetReservationId();

	/**
	 * @return SeriesUpdateScope
	 */
	public function GetSeriesUpdateScope();
}

class ReservationUpdatePage extends ReservationSavePage implements IReservationUpdatePage
{
	/**
	 * @var ReservationUpdatePresenter
	 */
	private $_presenter;

	/**
	 * @var bool
	 */
	private $_reservationSavedSuccessfully = false;

	public function __construct()
	{
		parent::__construct();

		$persistenceFactory = new ReservationPersistenceFactory();
		$updateAction = ReservationAction::Update;

		$handler = ReservationHandler::Create($updateAction, $persistenceFactory->Create($updateAction));
		$this->_presenter = new ReservationUpdatePresenter(
			$this,
			$persistenceFactory->Create($updateAction),
			$handler,
			new ResourceRepository()
		);
	}

	public function PageLoad()
	{
		$reservation = $this->_presenter->BuildReservation();
		$this->_presenter->HandleReservation($reservation);

		if ($this->_reservationSavedSuccessfully) {
			$this->Display('Ajax/reservation/update_successful.tpl');
		}
		else
		{
			$this->Display('Ajax/reservation/save_failed.tpl');
		}
	}

	public function SetSaveSuccessfulMessage($succeeded)
	{
		$this->_reservationSavedSuccessfully = $succeeded;
	}

	public function SetReferenceNumber($referenceNumber)
	{
		$this->Set('ReferenceNumber', $referenceNumber);
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

?>