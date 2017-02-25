<?php
/**
 * Copyright 2011-2017 Nick Korbel
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

// TODO: Need a way to unit test this
class ReservationCreatedEmailAdmin extends EmailMessage
{
	/**
	 * @var UserDto
	 */
	private $adminDto;

	/**
	 * @var User
	 */
	private $reservationOwner;

	/**
	 * @var ReservationSeries
	 */
	private $reservationSeries;

	/**
	 * @var IResource
	 */
	private $resource;

	/**
	 * @var IAttributeRepository
	 */
	private $attributeRepository;

	/**
	 * @param UserDto $adminDto
	 * @param User $reservationOwner
	 * @param ReservationSeries $reservationSeries
	 * @param IResource $primaryResource
	 * @param IAttributeRepository $attributeRepository
	 */
	public function __construct(UserDto $adminDto, User $reservationOwner, ReservationSeries $reservationSeries, IResource $primaryResource,
								IAttributeRepository $attributeRepository)
	{
		parent::__construct($adminDto->Language());

		$this->adminDto = $adminDto;
		$this->reservationOwner = $reservationOwner;
		$this->reservationSeries = $reservationSeries;
		$this->resource = $primaryResource;
		$this->attributeRepository = $attributeRepository;
		$this->timezone = $adminDto->Timezone();
	}

	/**
	 * @see IEmailMessage::To()
	 */
	public function To()
	{
		$address = $this->adminDto->EmailAddress();
		$name = $this->adminDto->FullName();

		return array(new EmailAddress($address, $name));
	}

	public function From()
	{
		return new EmailAddress($this->reservationOwner->EmailAddress(), $this->reservationOwner->FullName());
	}

	/**
	 * @see IEmailMessage::Subject()
	 */
	public function Subject()
	{
		return $this->Translate('ReservationCreatedAdminSubject');
	}

	/**
	 * @see IEmailMessage::Body()
	 */
	public function Body()
	{
		$this->PopulateTemplate();
		return $this->FetchTemplate($this->GetTemplateName());
	}

	protected function GetTemplateName()
	{
		return 'ReservationCreatedAdmin.tpl';
	}

	private function PopulateTemplate()
	{
		$this->Set('UserName', $this->reservationOwner->FullName());

		$currentInstance = $this->reservationSeries->CurrentInstance();

		$this->Set('StartDate', $currentInstance->StartDate()->ToTimezone($this->timezone));
		$this->Set('EndDate', $currentInstance->EndDate()->ToTimezone($this->timezone));
		$this->Set('ResourceName', $this->resource->GetName());
		$this->Set('Title', $this->reservationSeries->Title());
		$this->Set('Description', $this->reservationSeries->Description());

		$repeatDates = array();
		foreach ($this->reservationSeries->Instances() as $repeated)
		{
			$repeatDates[] = $repeated->StartDate()->ToTimezone($this->timezone);
		}
		$this->Set('RequiresApproval', $this->reservationSeries->RequiresApproval());
		$this->Set('RepeatDates', $repeatDates);
		$this->Set('ReservationUrl', Pages::RESERVATION . "?" . QueryStringKeys::REFERENCE_NUMBER . '=' . $currentInstance->ReferenceNumber());

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

		$this->Set('ReferenceNumber', $this->reservationSeries->CurrentInstance()->ReferenceNumber());
	}
}