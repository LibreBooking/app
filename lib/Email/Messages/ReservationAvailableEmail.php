<?php
/**
Copyright 2012-2019 Nick Korbel

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

require_once(ROOT_DIR . 'lib/Email/EmailMessage.php');
require_once(ROOT_DIR . 'Pages/Pages.php');

class ReservationAvailableEmail extends EmailMessage
{
    /**
     * @var User
     */
    private $user;
    /**
     * @var BookableResource
     */
    private $resource;
    /**
     * @var ReservationWaitlistRequest
     */
    private $request;

    public function __construct(User $user, BookableResource $resource, ReservationWaitlistRequest $request)
    {
        $this->user = $user;
        $this->resource = $resource;
        $this->request = $request;

        parent::__construct($user->Language());
    }

    /**
     * @return string
     */
    function Subject()
    {
        return $this->Translate('ReservationAvailableSubject', array($this->resource->GetName(), $this->request->StartDate()->ToTimezone($this->user->Timezone())));
    }

    /**
     * @return array|EmailAddress[]|EmailAddress
     */
    public function To()
    {
        return new EmailAddress($this->user->EmailAddress(), $this->user->FullName());
    }

    /**
     * @return string
     */
    public function Body()
    {
        $startDate = $this->request->StartDate()->ToTimezone($this->user->Timezone());
        $endDate = $this->request->EndDate()->ToTimezone($this->user->Timezone());
        $format = Resources::GetInstance()->GetDateFormat('system_datetime');

        $this->Set('ResourceName', $this->resource->GetName());
        $this->Set('FirstName', $this->user->FirstName());
        $this->Set('StartDate', $startDate);
        $this->Set('EndDate', $endDate);
        $this->Set('ReservationUrl', sprintf('%s?%s=%s&%s=%s&%s=%s',
            Pages::RESERVATION,
            QueryStringKeys::RESOURCE_ID, $this->request->ResourceId(),
            QueryStringKeys::START_DATE, urlencode($startDate->Format($format)),
            QueryStringKeys::END_DATE, urlencode($endDate->Format($format))
        ));
        
        return $this->FetchTemplate('ReservationAvailable.tpl');
    }
}