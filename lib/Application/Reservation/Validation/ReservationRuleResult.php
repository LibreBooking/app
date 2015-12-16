<?php
/**
Copyright 2011-2015 Nick Korbel

This file is part of Booked Scheduler is free software: you can redistribute it and/or modify
it under the terms of the GNU General Public License as published by
the Free Software Foundation, either version 3 of the License, or
(at your option) any later version is distributed in the hope that it will be useful,
but WITHOUT ANY WARRANTY; without even the implied warranty of
MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
GNU General Public License for more details.

You should have received a copy of the GNU General Public License
along with Booked Scheduler.  If not, see <http://www.gnu.org/licenses/>.
*/

class ReservationRuleResult
{
	private $_isValid;
	private $_errorMessage;
	private $_canBeRetried;
	private $_retryMessage;
	private $_retryParameters;

	/**
	 * @param bool $isValid
	 * @param string $errorMessage
	 * @param bool $canBeRetried
	 * @param null $retryMessage
	 * @param array|ReservationRetryParameter[] $retryParams
	 */
	public function __construct($isValid = true, $errorMessage = null, $canBeRetried = false, $retryMessage = null, $retryParams = array())
	{
		$this->_isValid = $isValid;
		$this->_errorMessage = $errorMessage;
		$this->_canBeRetried = $canBeRetried;
		$this->_retryMessage = $retryMessage;
		$this->_retryParameters = $retryParams;
	}

	/**
	 * @return bool
	 */
	public function IsValid()
	{
		return $this->_isValid;
	}

	/**
	 * @return string
	 */
	public function ErrorMessage()
	{
		return $this->_errorMessage;
	}

	/**
	 * @return bool
	 */
	public function CanBeRetried()
	{
		return $this->_canBeRetried;
	}

	/**
	 * @return string
	 */
	public function RetryMessage()
	{
		return $this->_retryMessage;
	}

	public function RetryParameters()
	{
		return $this->_retryParameters;
	}
}