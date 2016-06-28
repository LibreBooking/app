<?php
/**
 * Copyright 2016 Nick Korbel
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

require_once(ROOT_DIR . 'Pages/Ajax/ReservationCheckinPage.php');

class FakeReservationCheckinPage implements IReservationCheckinPage
{
	public $_ReferenceNumber;
	public $_Action;

	/**
	 * @param bool $succeeded
	 */
	public function SetSaveSuccessfulMessage($succeeded)
	{
		// TODO: Implement SetSaveSuccessfulMessage() method.
	}

	/**
	 * @param array|string[] $errors
	 */
	public function SetErrors($errors)
	{
		// TODO: Implement SetErrors() method.
	}

	/**
	 * @param array|string[] $warnings
	 */
	public function SetWarnings($warnings)
	{
		// TODO: Implement SetWarnings() method.
	}

	/**
	 * @param array|string[] $messages
	 */
	public function SetRetryMessages($messages)
	{
		// TODO: Implement SetRetryMessages() method.
	}

	/**
	 * @param bool $canBeRetried
	 */
	public function SetCanBeRetried($canBeRetried)
	{
		// TODO: Implement SetCanBeRetried() method.
	}

	/**
	 * @param ReservationRetryParameter[] $retryParameters
	 */
	public function SetRetryParameters($retryParameters)
	{
		// TODO: Implement SetRetryParameters() method.
	}

	/**
	 * @return ReservationRetryParameter[]
	 */
	public function GetRetryParameters()
	{
		// TODO: Implement GetRetryParameters() method.
	}

	/**
	 * @return string
	 */
	public function GetReferenceNumber()
	{
		return $this->_ReferenceNumber;
	}

	/**
	 * @return string
	 */
	public function GetAction()
	{
		return $this->_Action;
	}

    /**
     * @param bool $canJoinWaitlist
     */
    public function SetCanJoinWaitList($canJoinWaitlist)
    {
        // TODO: Implement SetCanJoinWaitList() method.
    }
}