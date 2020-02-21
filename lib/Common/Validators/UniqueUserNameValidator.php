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

class UniqueUserNameValidator extends ValidatorBase implements IValidator
{
	private $_username;
	private $_userid;
	private $userRepository;

	public function __construct(IUserViewRepository $userRepository, $username, $userid = null)
	{
		$this->_username = $username;
		$this->_userid = $userid;
		$this->userRepository = $userRepository;
	}

	public function Validate()
	{
		$this->isValid = true;
		$userId = $this->userRepository->UserExists(null, $this->_username);

		if (!empty($userId))
		{
			$this->isValid = $userId == $this->_userid;
		}

		if (!$this->isValid)
		{
			$this->AddMessageKey('UniqueUsernameRequired');
		}
	}
}
