<?php

/**
 * Copyright 2015 Nick Korbel
 *
 * This file is part of phpScheduleIt.
 *
 * phpScheduleIt is free software: you can redistribute it and/or modify
 * it under the terms of the GNU General Public License as published by
 * the Free Software Foundation, either version 3 of the License, or
 * (at your option) any later version.
 *
 * phpScheduleIt is distributed in the hope that it will be useful,
 * but WITHOUT ANY WARRANTY; without even the implied warranty of
 * MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
 * GNU General Public License for more details.
 *
 * You should have received a copy of the GNU General Public License
 * along with phpScheduleIt.  If not, see <http://www.gnu.org/licenses/>.
 */

require_once(ROOT_DIR . 'Pages/Reservation/ReservationPage.php');

class GuestReservationPage extends ReservationPage
{
	public function PageLoad()
	{
		if (Configuration::Instance()->GetSectionKey(ConfigSection::PRIVACY, ConfigKeys::PRIVACY_ALLOW_GUEST_BOOKING, new BooleanConverter()))
		{
			parent::PageLoad();
		}
		else {
			$this->RedirectToError(ErrorMessages::INSUFFICIENT_PERMISSIONS);
		}
	}

	/**
	 * @return IReservationPresenter
	 */
	protected function GetPresenter()
	{
		// TODO: Implement GetPresenter() method.
	}

	/**
	 * @return string
	 */
	protected function GetTemplateName()
	{
		// TODO: Implement GetTemplateName() method.
	}

	/**
	 * @return string
	 */
	protected function GetReservationAction()
	{
		// TODO: Implement GetReservationAction() method.
	}
}