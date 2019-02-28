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

require_once(ROOT_DIR . 'lib/WebService/namespace.php');

class AccountResponse extends RestResponse
{
    public $userId;
    public $firstName;
    public $lastName;
    public $emailAddress;
    public $userName;
    public $language;
    public $timezone;
    public $phone;
    public $organization;
    public $position;
    /** @var array|CustomAttributeResponse[] */
    public $customAttributes = array();
    public $icsUrl;

    public function __construct(IRestServer $server, User $user, IEntityAttributeList $attributeList)
    {
        $this->userId = $user->Id();
        $this->firstName = $user->FirstName();
        $this->lastName = $user->LastName();
        $this->userName = $user->Username();
        $this->phone = $user->GetAttribute(UserAttribute::Phone);
        $this->organization = $user->GetAttribute(UserAttribute::Organization);
        $this->position = $user->GetAttribute(UserAttribute::Position);
        $this->timezone = $user->Timezone();
        $this->language = $user->Language();
        $this->emailAddress = $user->EmailAddress();
        $attributeValues = $attributeList->GetAttributes($this->userId);

        $i = 0;
        foreach ($attributeValues as $av) {
            $this->customAttributes[] = new CustomAttributeResponse($server, $av->Id(), $av->Label(), $av->Value());
            $i++;
        }

        if ($user->GetIsCalendarSubscriptionAllowed()) {
            $url = new CalendarSubscriptionUrl($user->GetPublicId(), null, null);
            $this->icsUrl = $url->__toString();
        }

        $this->AddService($server, WebServices::GetAccount, array(WebServiceParams::UserId, $this->userId));
        $this->AddService($server, WebServices::UpdateAccount, array(WebServiceParams::UserId, $this->userId));
        $this->AddService($server, WebServices::UpdatePassword, array(WebServiceParams::UserId, $this->userId));
    }

    public static function Example()
    {
        return new ExampleAccountResponse();
    }
}

class ExampleAccountResponse extends AccountResponse
{
    public function __construct()
    {
        $this->emailAddress = 'email@address.com';
        $this->timezone = Configuration::Instance()->GetDefaultTimezone();
        $this->language = Configuration::Instance()->GetKey(ConfigKeys::LANGUAGE);
        $this->userId = 1;
        $this->position = 'position';
        $this->organization = 'organization';
        $this->phone = 'phone';
        $this->lastName = 'last';
        $this->firstName = 'first';
        $this->userName = 'username';
        $this->customAttributes = array(CustomAttributeResponse::Example());
        $this->icsUrl = 'webcal://path-to-calendar';
    }
}
