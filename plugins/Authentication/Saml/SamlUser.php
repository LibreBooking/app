<?php
/**
Copyright 2018-2019 Nick Korbel

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

class SamlUser
{
	private $username;
	private $fname;
	private $lname;
	private $mail;
	private $phone;
	private $institution;
	private $title;

	/**
	 * @param array of SAML user attributes
	 * @param array of configuration options
	 */
	public function __construct($saml_attributes = array(), $options = array())
	{
		Log::Debug('Inside construct SamlUser');
		if (count($options) > 0)
		{
			Log::Debug('Inside construct SamlUser and count options is %d', count($options));
			$this->username = $this->GetAttributeValue($saml_attributes, $options, "ssphp_username");
			Log::Debug('Value of username is %s', $this->GetUserName());

			$this->fname = $this->GetAttributeValue($saml_attributes, $options, "ssphp_firstname");
			Log::Debug('Value of fname is %s', $this->GetFirstName());

			$this->lname = $this->GetAttributeValue($saml_attributes, $options, "ssphp_lastname");
			Log::Debug('Value of lname is %s', $this->GetLastName());

			$this->mail = $this->GetAttributeValue($saml_attributes, $options, "ssphp_email");
			Log::Debug('Value of email is %s', $this->GetEmail());

			$this->phone = $this->GetAttributeValue($saml_attributes, $options, "ssphp_phone");
			Log::Debug('Value of phone is %s', $this->GetPhone());

			$this->institution = $this->GetAttributeValue($saml_attributes, $options, "ssphp_organization");
			Log::Debug('Value of institution is %s', $this->GetInstitution());

			$this->title = $this->GetAttributeValue($saml_attributes, $options, "ssphp_position");
			Log::Debug('Value of title is %s', $this->GetTitle());
		}
	}

	public function GetUserName()
	{
		return $this->username;
	}

	public function GetFirstName()
	{
		return $this->fname;
	}

	public function GetLastName()
	{
		return $this->lname;
	}

	public function GetEmail()
	{
		return $this->mail;
	}

	public function GetPhone()
	{
		return $this->phone;
	}

	public function GetInstitution()
	{
		return $this->institution;
	}

	public function GetTitle()
	{
		return $this->title;
	}

    public function GetGroups()
    {
        return array();
    }

	/**
	 * @param $saml_attributes array
	 * @param $options array
	 * @param $key string
	 * @return mixed
	 */
	private function GetAttributeValue($saml_attributes, $options, $key)
	{
		$attributeKeys = array_map('trim', explode(',', $options[$key]));
		foreach ($attributeKeys as $attributeKey)
		{
			if (array_key_exists($attributeKey, $saml_attributes))
			{
				return $saml_attributes[$attributeKey][0];
			}
		}
		return '';
	}

}