<?php
/**
Copyright 2011-2014 Nick Korbel

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


class AuthenticatedUser
{
	/**
	 * @var string
	 */
	private $username;

	/**
	 * @var string
	 */
	private $email;

	/**
	 * @var string
	 */
	private $fname;

	/**
	 * @var string
	 */
	private $lname;

	/**
	 * @var string
	 */
	private $password;

	/**
	 * @var string
	 */
	private $languageCode;

	/**
	 * @var string
	 */
	private $timezoneName;

	/**
	 * @var string
	 */
	private $phone;

	/**
	 * @var string
	 */
	private $organization;

	/**
	 * @var string
	 */
	private $title;

	/**
	 * @param string $username
	 * @param string $email
	 * @param string $fname
	 * @param string $lname
	 * @param string $password
	 * @param string $languageCode
	 * @param string $timezoneName
	 * @param string $phone
	 * @param string $organization
	 * @param string $title
	 */
	public function __construct($username, $email, $fname, $lname, $password, $languageCode, $timezoneName, $phone, $organization, $title)
	{
		$this->username = $username;
		$this->email = $email;
		$this->fname = $fname;
		$this->lname = $lname;
		$this->password = $password;
		$this->languageCode = $languageCode;
		$this->timezoneName = $timezoneName;
		$this->phone = $phone;
		$this->organization = $organization;
		$this->title = $title;
	}

	/**
	 * @return string
	 */
	public function Email()
	{
		return $this->EnsureNull($this->email);
	}

	/**
	 * @return string
	 */
	public function FirstName()
	{
		return $this->EnsureNull($this->fname);
	}

	/**
	 * @return string
	 */
	public function LanguageCode()
	{
		return $this->EnsureNull($this->languageCode);
	}

	/**
	 * @return string
	 */
	public function LastName()
	{
		return $this->EnsureNull($this->lname);
	}

	/**
	 * @return string
	 */
	public function Organization()
	{
		return $this->EnsureNull($this->organization);
	}

	/**
	 * @return string
	 */
	public function Password()
	{
		return $this->password;
	}

	/**
	 * @return string
	 */
	public function Phone()
	{
		return $this->EnsureNull($this->phone);
	}

	/**
	 * @return string
	 */
	public function TimezoneName()
	{
		return $this->timezoneName;
	}

	/**
	 * @return string
	 */
	public function Title()
	{
		return $this->EnsureNull($this->title);
	}

	/**
	 * @return string
	 */
	public function Username()
	{
		return $this->username;
	}

	private function EnsureNull($value)
	{
		$value = trim($value);
		if (empty($value))
		{
			return null;
		}

		return trim($value);
	}

}

?>