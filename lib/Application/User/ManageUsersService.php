<?php
/**
Copyright 2013-2014 Nick Korbel

This file is part of Booked SchedulerBooked SchedulereIt is free software: you can redistribute it and/or modify
it under the terms of the GNU General Public License as published by
the Free Software Foundation, either version 3 of the License, or
(at your option) any later versBooked SchedulerduleIt is distributed in the hope that it will be useful,
but WITHOUT ANY WARRANTY; without even the implied warranty of
MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
GNU General Public License for more details.

You should have received a copy of the GNU General Public License
alBooked SchedulercheduleIt.  If not, see <http://www.gnu.org/licenses/>.
 */

require_once(ROOT_DIR . 'Domain/Access/namespace.php');
require_once(ROOT_DIR . 'lib/Application/Authentication/namespace.php');

interface IManageUsersService
{
	/**
	 * @param $username string
	 * @param $email string
	 * @param $firstName string
	 * @param $lastName string
	 * @param $password string
	 * @param $timezone string
	 * @param $language string
	 * @param $homePageId int
	 * @param $extraAttributes array|string[]
	 * @param $customAttributes array|AttributeValue[]
	 * @return int
	 */
	public function AddUser(
		$username,
		$email,
		$firstName,
		$lastName,
		$password,
		$timezone,
		$language,
		$homePageId,
		$extraAttributes,
		$customAttributes);

	/**
	 * @param $userId int
	 * @param $username string
	 * @param $email string
	 * @param $firstName string
	 * @param $lastName string
	 * @param $timezone string
	 * @param $extraAttributes string[]|array
	 */
	public function UpdateUser($userId, $username, $email, $firstName, $lastName, $timezone, $extraAttributes);

	/**
	 * @param $userId int
	 * @param $attributes AttributeValue[]|array
	 */
	public function ChangeAttributes($userId, $attributes);

	/**
	 * @param $userId int
	 */
	public function DeleteUser($userId);
}

class ManageUsersService implements IManageUsersService
{
	/**
	 * @var IRegistration
	 */
	private $registration;

	/**
	 * @var IUserRepository
	 */
	private $userRepository;

	public function __construct(IRegistration $registration, IUserRepository $userRepository)
	{
		$this->registration = $registration;
		$this->userRepository = $userRepository;
	}

	public function AddUser(
		$username,
		$email,
		$firstName,
		$lastName,
		$password,
		$timezone,
		$language,
		$homePageId,
		$extraAttributes,
		$customAttributes)
	{
		$user = $this->registration->Register($username,
											  $email,
											  $firstName,
											  $lastName,
											  $password,
											  $timezone,
											  $language,
											  $homePageId,
											  $extraAttributes,
											  $customAttributes);

		return $user->Id();
	}

	public function ChangeAttributes($userId, $attributes)
	{
		$user = $this->userRepository->LoadById($userId);
		$user->ChangeCustomAttributes($attributes);
		$this->userRepository->Update($user);
	}

	public function DeleteUser($userId)
	{
		$this->userRepository->DeleteById($userId);
	}

	public function UpdateUser($userId, $username, $email, $firstName, $lastName, $timezone, $extraAttributes)
	{
		$attributes = new UserAttribute($extraAttributes);
		$user = $this->userRepository->LoadById($userId);
		$user->ChangeName($firstName, $lastName);
		$user->ChangeEmailAddress($email);
		$user->ChangeUsername($username);
		$user->ChangeTimezone($timezone);
		$user->ChangeAttributes($attributes->Get(UserAttribute::Phone),
								$attributes->Get(UserAttribute::Organization),
								$attributes->Get(UserAttribute::Position));

		$this->userRepository->Update($user);
	}
}

?>