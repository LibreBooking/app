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

require_once(ROOT_DIR . 'lib/Email/namespace.php');
require_once(ROOT_DIR . 'Pages/Pages.php');
require_once(ROOT_DIR . 'Pages/Export/CalendarExportDisplay.php');
require_once(ROOT_DIR . 'lib/Application/Schedule/namespace.php');
require_once(ROOT_DIR . 'lib/Application/Reservation/namespace.php');
require_once(ROOT_DIR . 'Domain/Access/namespace.php');

abstract class ReservationEmailMessage extends EmailMessage
{
	/**
	 * @var User
	 */
	protected $reservationOwner;

	/**
	 * @var ReservationSeries
	 */
	protected $reservationSeries;

	/**
	 * @var IResource
	 */
	protected $primaryResource;

	/**
	 * @var string
	 */
	protected $timezone;

	/**
	 * @var IAttributeRepository
	 */
	protected $attributeRepository;

    /**
     * @var IUserRepository
     */
	protected $userRepository;

	public function __construct(User $reservationOwner,
                                ReservationSeries $reservationSeries,
                                $language,
                                IAttributeRepository $attributeRepository,
                                IUserRepository $userRepository)
	{
		if (empty($language))
		{
			$language = $reservationOwner->Language();
		}
		parent::__construct($language);

		$this->reservationOwner = $reservationOwner;
		$this->reservationSeries = $reservationSeries;
		$this->timezone = $reservationOwner->Timezone();
		$this->attributeRepository = $attributeRepository;
		$this->primaryResource = $reservationSeries->Resource();
        $this->userRepository = $userRepository;
    }

	/**
	 * @abstract
	 * @return string
	 */
	protected abstract function GetTemplateName();

	public function To()
	{
		$address = $this->reservationOwner->EmailAddress();
		$name = $this->reservationOwner->FullName();

		return array(new EmailAddress($address, $name));
	}

	public function Body()
	{
		$this->PopulateTemplate();
		return $this->FetchTemplate($this->GetTemplateName());
	}

	public function From()
	{
		$bookedBy = $this->reservationSeries->BookedBy();
		if ($bookedBy != null)
		{
			$name = new FullName($bookedBy->FirstName, $bookedBy->LastName);
			return new EmailAddress($bookedBy->Email, $name->__toString());
		}
		return new EmailAddress($this->reservationOwner->EmailAddress(), $this->reservationOwner->FullName());
	}

	protected function PopulateTemplate()
	{
		$currentInstance = $this->reservationSeries->CurrentInstance();
		$this->Set('UserName', $this->reservationOwner->FullName());
		$this->Set('StartDate', $currentInstance->StartDate()->ToTimezone($this->timezone));
		$this->Set('EndDate', $currentInstance->EndDate()->ToTimezone($this->timezone));
		$this->Set('ResourceName', $this->reservationSeries->Resource()->GetName());
		$img = $this->reservationSeries->Resource()->GetImage();
		if (!empty($img))
		{
			$this->Set('ResourceImage', $this->GetFullImagePath($img));
		}
		$this->Set('Title', $this->reservationSeries->Title());
		$this->Set('Description', $this->reservationSeries->Description());

		$repeatDates = array();
		$repeatRanges = array();
		if ($this->reservationSeries->IsRecurring())
		{
			foreach ($this->reservationSeries->Instances() as $repeated)
			{
				$repeatDates[] = $repeated->StartDate()->ToTimezone($this->timezone);
				$repeatRanges[] = $repeated->Duration()->ToTimezone($this->timezone);
			}
		}
		$this->Set('RepeatDates', $repeatDates);
		$this->Set('RepeatRanges', $repeatRanges);
		$this->Set('RequiresApproval', $this->reservationSeries->RequiresApproval());
		$this->Set('ReservationUrl', sprintf("%s?%s=%s", Pages::RESERVATION, QueryStringKeys::REFERENCE_NUMBER, $currentInstance->ReferenceNumber()));
		$icalUrl = sprintf("export/%s?%s=%s", Pages::CALENDAR_EXPORT, QueryStringKeys::REFERENCE_NUMBER, $currentInstance->ReferenceNumber());
		$this->Set('ICalUrl', $icalUrl);

		$resourceNames = array();
		foreach ($this->reservationSeries->AllResources() as $resource)
		{
			$resourceNames[] = $resource->GetName();
		}
		$this->Set('ResourceNames', $resourceNames);
		$this->Set('Accessories', $this->reservationSeries->Accessories());

		$attributes = $this->attributeRepository->GetByCategory(CustomAttributeCategory::RESERVATION);
		$attributeValues = array();
		foreach ($attributes as $attribute)
		{
			$attributeValues[] = new Attribute($attribute, $this->reservationSeries->GetAttributeValue($attribute->Id()));
		}

		$this->Set('Attributes', $attributeValues);

		$bookedBy = $this->reservationSeries->BookedBy();
		if ($bookedBy != null && ($bookedBy->UserId != $this->reservationOwner->Id()))
		{
			$this->Set('CreatedBy', new FullName($bookedBy->FirstName, $bookedBy->LastName));
		}

		$minimumAutoRelease = null;
		foreach ($this->reservationSeries->AllResources() as $resource)
		{
			if ($resource->IsCheckInEnabled())
			{
				$this->Set('CheckInEnabled', true);
			}

			if ($resource->IsAutoReleased())
			{
				if ($minimumAutoRelease == null || $resource->GetAutoReleaseMinutes() < $minimumAutoRelease)
				{
					$minimumAutoRelease = $resource->GetAutoReleaseMinutes();
				}
			}
		}

        $this->PopulateIcsAttachment($currentInstance, $attributeValues);

		$this->Set('AutoReleaseMinutes', $minimumAutoRelease);
		$this->Set('ReferenceNumber', $currentInstance->ReferenceNumber());

        $participants = array();
		foreach($currentInstance->Participants() as $id)
        {
            $participants[] = $this->userRepository->GetById($id);
        }
        $this->Set('Participants', $participants);
		$this->Set('ParticipatingGuests', $currentInstance->ParticipatingGuests());

		$invitees = array();
        foreach($currentInstance->Invitees() as $id)
        {
            $invitees[] = $this->userRepository->GetById($id);
        }
        $this->Set('Invitees', $invitees);
        $this->Set('InvitedGuests', $currentInstance->InvitedGuests());

        $this->Set('CreditsCurrent', $currentInstance->GetCreditsRequired());
        $this->Set('CreditsTotal', $this->reservationSeries->GetCreditsRequired());
	}

	private function GetFullImagePath($img)
	{
		return Configuration::Instance()->GetKey(ConfigKeys::IMAGE_UPLOAD_URL) . '/' . $img;
	}

    /**
     * @param Reservation $currentInstance
     * @param Attribute[] $attributeValues
     */
    protected function PopulateIcsAttachment($currentInstance, $attributeValues)
    {
        $rv = new ReservationItemView($currentInstance->ReferenceNumber(),
            $currentInstance->StartDate()->ToUTC(),
            $currentInstance->EndDate()->ToUTC(),
            $this->reservationSeries->Resource()->GetName(),
            $this->reservationSeries->Resource()->GetResourceId(),
            $currentInstance->ReservationId(),
            null,
            $this->reservationSeries->Title(),
            $this->reservationSeries->Description(),
            $this->reservationSeries->ScheduleId(),
            $this->reservationOwner->FirstName(),
            $this->reservationOwner->LastName(),
            $this->reservationOwner->Id(),
            $this->reservationOwner->GetAttribute(UserAttribute::Phone),
            $this->reservationOwner->GetAttribute(UserAttribute::Organization),
            $this->reservationOwner->GetAttribute(UserAttribute::Position)
        );

        $ca = new CustomAttributes();
        /** @var Attribute $attribute */
        foreach ($attributeValues as $attribute) {
            $ca->Add($attribute->Id(), $attribute->Value());
        }
        $rv->Attributes = $ca;
        $rv->UserPreferences = $this->reservationOwner->GetPreferences();
		$rv->OwnerEmailAddress = $this->reservationOwner->EmailAddress();

        $icsView = new iCalendarReservationView($rv, $this->reservationSeries->BookedBy(), new NullPrivacyFilter());

        $display = new CalendarExportDisplay();
        $icsContents = $display->Render(array($icsView));
        $this->AddStringAttachment($icsContents, 'reservation.ics');
    }
}