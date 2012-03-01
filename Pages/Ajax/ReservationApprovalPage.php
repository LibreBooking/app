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
require_once(ROOT_DIR . 'Presenters/ReservationApprovalPresenter.php');

interface IReservationApprovalPage extends IReservationSaveResultsPage
{
	/**
	 * @abstract
	 * @return string
	 */
	public function GetReferenceNumber();
}
class ReservationApprovalPage extends SecurePage implements IReservationApprovalPage
{
	public function PageLoad()
	{
		$reservationAction = ReservationAction::Approve;
		$factory = new ReservationPersistenceFactory();
		$persistenceService = $factory->Create($reservationAction);
		$handler = ReservationHandler::Create($reservationAction, $persistenceService);

		$presenter = new ReservationApprovalPresenter($this, $persistenceService, $handler);
		$presenter->PageLoad();
	}

	/**
	 * @return string
	 */
	public function GetReferenceNumber()
	{
		return $this->GetQuerystring(QueryStringKeys::REFERENCE_NUMBER);
	}
	
	/**
	 * @param bool $succeeded
	 */
	public function SetSaveSuccessfulMessage($succeeded)
	{
		if ($succeeded)
		{
			$this->SetJson(array('approved' => (string)$succeeded));
		}
	}

	public function ShowErrors($errors)
	{
		if (!empty($errors))
		{
			$this->SetJson(array('approved' => (string)false), $errors);
		}
	}
	
	public function ShowWarnings($warnings)
	{
		// nothing to do
	}
}
?>