<?php
/**
Copyright 2011-2020 Nick Korbel

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

abstract class ValidatorBase implements IValidator
{
	/**
	 * @var bool
	 */
	protected $isValid = true;

	/**
	 * @var array|string[]
	 */
	private $messages = array();

	/**
	 * @return bool
	 */
	public function IsValid()
	{
		return $this->isValid;
	}

	/**
	 * @return array|null|string[]
	 */
	public function Messages()
	{
		return $this->messages;
	}

	/**
	 * @return bool
	 */
	public function ReturnsErrorResponse()
	{
		return false;
	}

	/**
	 * @param string $message
	 */
	protected function AddMessage($message)
	{
		$this->messages[] = $message;
	}

	/**
	 * @param string $resourceKey
	 * @param array $params
	 */
	protected function AddMessageKey($resourceKey, $params = array())
	{
		$this->AddMessage(Resources::GetInstance()->GetString($resourceKey, $params));
	}
}
