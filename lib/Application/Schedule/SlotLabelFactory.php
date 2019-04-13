<?php

/**
 * Copyright 2012-2019 Nick Korbel
 *
 * This file is part of Booked Scheduler is free software: you can redistribute it and/or modify
 * it under the terms of the GNU General Public License as published by
 * the Free Software Foundation, either version 3 of the License, or
 * (at your option) any later version is distributed in the hope that it will be useful,
 * but WITHOUT ANY WARRANTY; without even the implied warranty of
 * MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
 * GNU General Public License for more details.
 *
 * You should have received a copy of the GNU General Public License
 * along with Booked Scheduler.  If not, see <http://www.gnu.org/licenses/>.
 */

class SlotLabelFactory
{
    /**
     * @var null|UserSession
     */
    private $user = null;

    /**
     * @var IAuthorizationService
     */
    private $authorizationService;

    /**
     * @var IAttributeRepository
     */
    private $attributeRepository;

    public function __construct($user = null, $authorizationService = null, $attributeRepository = null)
    {
        $this->user = $user;
        if ($this->user == null) {
            $this->user = ServiceLocator::GetServer()->GetUserSession();
        }

        $this->authorizationService = $authorizationService;
        if ($this->authorizationService == null) {
            $this->authorizationService = new AuthorizationService(new UserRepository());
        }

        $this->attributeRepository = $attributeRepository;
        if ($this->attributeRepository == null) {
            $this->attributeRepository = new AttributeRepository();
        }
    }

    /**
     * @static
     * @param ReservationItemView $reservation
     * @return string
     */
    public static function Create(ReservationItemView $reservation)
    {
        $f = new SlotLabelFactory();
        return $f->Format($reservation);
    }

    /**
     * @param ReservationItemView $reservation
     * @param string $format
     * @return string
     */
    public function Format(ReservationItemView $reservation, $format = null)
    {
        $shouldHideUser = Configuration::Instance()->GetSectionKey(ConfigSection::PRIVACY, ConfigKeys::PRIVACY_HIDE_USER_DETAILS, new BooleanConverter());
        $shouldHideDetails = ReservationDetailsFilter::HideReservationDetails($reservation->StartDate, $reservation->EndDate);

        if ($shouldHideUser || $shouldHideDetails) {
            $canSeeUserDetails = $reservation->OwnerId == $this->user->UserId || $this->user->IsAdmin || $this->user->IsAdminForGroup($reservation->OwnerGroupIds());
            $canEditResource = $this->authorizationService->CanEditForResource($this->user, new SlotLabelResource($reservation));
            $shouldHideUser = $shouldHideUser && !$canSeeUserDetails && !$canEditResource;
            $shouldHideDetails = $shouldHideDetails && !$canEditResource && !$canSeeUserDetails;
        }

        if ($shouldHideDetails) {
            return '';
        }

        if (empty($format)) {
            $format = Configuration::Instance()->GetSectionKey(ConfigSection::SCHEDULE,
                ConfigKeys::SCHEDULE_RESERVATION_LABEL);
        }

        if ($format == 'none' || empty($format)) {
            return '';
        }

        $name = $shouldHideUser ? Resources::GetInstance()->GetString('Private') : $this->GetFullName($reservation);

        $timezone = 'UTC';
        $dateFormat = Resources::GetInstance()->GetDateFormat('res_popup');
        if (!is_null($this->user)) {
            $timezone = $this->user->Timezone;
        }
        $label = $format;
        $label = str_replace('{name}', $name, $label);
        $label = str_replace('{title}', $reservation->Title, $label);
        $label = str_replace('{description}', $reservation->Description, $label);
        $label = str_replace('{email}', $reservation->OwnerEmailAddress, $label);
        $label = str_replace('{organization}', $reservation->OwnerOrganization, $label);
        $label = str_replace('{phone}', $reservation->OwnerPhone, $label);
        $label = str_replace('{position}', $reservation->OwnerPosition, $label);
        $label = str_replace('{startdate}', $reservation->StartDate->ToTimezone($timezone)->Format($dateFormat), $label);
        $label = str_replace('{enddate}', $reservation->EndDate->ToTimezone($timezone)->Format($dateFormat), $label);
        $label = str_replace('{resourcename}', implode(', ', $reservation->ResourceNames), $label);
        if (!$shouldHideUser) {
            $label = str_replace('{participants}', trim(implode(', ', $reservation->ParticipantNames)), $label);
            $label = str_replace('{invitees}', trim(implode(', ', $reservation->InviteeNames)), $label);
        }

        $matches = array();
        preg_match_all('/\{(att\d+?)\}/', $format, $matches);

        $matches = $matches[0];
        if (count($matches) > 0) {
            for ($m = 0; $m < count($matches); $m++) {
                $id = filter_var($matches[$m], FILTER_SANITIZE_NUMBER_INT);
                $value = $reservation->GetAttributeValue($id);

                $label = str_replace($matches[$m], $value, $label);
            }
        }

        if (BookedStringHelper::Contains($label, '{reservationAttributes}')) {
            $attributesLabel = new StringBuilder();
            $attributes = $this->attributeRepository->GetByCategory(CustomAttributeCategory::RESERVATION);
            foreach ($attributes as $attribute) {
                $attributesLabel->Append($attribute->Label() . ': ' . $reservation->GetAttributeValue($attribute->Id()) . ', ');
            }

            $label = str_replace('{reservationAttributes}', rtrim($attributesLabel->ToString(), ', '), $label);
        }

        return $label;
    }

    protected function GetFullName(ReservationItemView $reservation)
    {
        $name = new FullName($reservation->FirstName, $reservation->LastName);
        return $name->__toString();
    }
}

class NullSlotLabelFactory extends SlotLabelFactory
{
    public function Format(ReservationItemView $reservation, $format = null)
    {
        return '';
    }
}

class AdminSlotLabelFactory extends SlotLabelFactory
{
    protected function GetFullName(ReservationItemView $reservation)
    {
        $name = new FullName($reservation->FirstName, $reservation->LastName);
        return $name->__toString();
    }
}

class SlotLabelResource implements IResource
{
    /**
     * @var int|null
     */
    private $id;
    /**
     * @var string|null
     */
    private $name;
    /**
     * @var int|null
     */
    private $adminGroupId;
    /**
     * @var int|null
     */
    private $scheduleId;
    /**
     * @var $scheduleAdminGroupId
     */
    private $scheduleAdminGroupId;
    /**
     * @var int
     */
    private $statusId;

    public function __construct(ReservationItemView $reservation)
    {
        $this->id = $reservation->ResourceId;
        $this->name = $reservation->ResourceName;
        $this->adminGroupId = $reservation->ResourceAdminGroupId;
        $this->scheduleId = $reservation->ScheduleId;
        $this->scheduleAdminGroupId = $reservation->ScheduleAdminGroupId;
        $this->statusId = $reservation->ResourceStatusId;
    }

    public function GetId()
    {
        return $this->id;
    }

    public function GetName()
    {
        return $this->name;
    }

    public function GetAdminGroupId()
    {
       return $this->adminGroupId;
    }

    public function GetScheduleId()
    {
        return $this->scheduleId;
    }

    public function GetScheduleAdminGroupId()
    {
        return $this->scheduleAdminGroupId;
    }

    public function GetStatusId()
    {
       return $this->statusId;
    }

    public function GetResourceId()
    {
        return $this->id;
    }
}