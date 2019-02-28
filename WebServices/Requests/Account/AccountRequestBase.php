<?php
/**
 * Copyright 2019 Nick Korbel
 *
 * This file is part of Booked Scheduler.
 *
 * Booked Scheduler is free software: you can redistribute it and/or modify
 * it under the terms of the GNU General Public License as published by
 * the Free Software Foundation, either version 3 of the License, or
 * (at your option) any later version.
 *
 * Booked Scheduler is distributed in the hope that it will be useful,
 * but WITHOUT ANY WARRANTY; without even the implied warranty of
 * MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
 * GNU General Public License for more details.
 *
 * You should have received a copy of the GNU General Public License
 * along with Booked Scheduler.  If not, see <http://www.gnu.org/licenses/>.
 */

require_once(ROOT_DIR . 'lib/WebService/JsonRequest.php');

abstract class AccountRequestBase extends JsonRequest
{
    public $firstName;
    public $lastName;
    public $emailAddress;
    public $userName;
    public $language;
    public $timezone;
    public $phone;
    public $organization;
    public $position;
    /** @var array|AttributeValueRequest[] */
    public $customAttributes = array();

    /**
     * @return string
     */
    public function GetTimezone()
    {
        if (empty($this->timezone)) {
            return Configuration::Instance()->GetDefaultTimezone();
        }

        return $this->timezone;
    }

    /**
     * @return string
     */
    public function GetLanguage()
    {
        if (empty($this->language)) {
            return Configuration::Instance()->GetKey(ConfigKeys::LANGUAGE);
        }

        return $this->language;
    }

    /**
     * @return array|AttributeValueRequest[]
     */
    public function GetCustomAttributes()
    {
        if (!empty($this->customAttributes)) {
            return $this->customAttributes;
        }
        return array();
    }

    /**
     * @return array
     */
    public function GetAdditionalFields()
    {
        return array('phone' => $this->phone,
            'organization' => $this->organization,
            'position' => $this->position);
    }
}