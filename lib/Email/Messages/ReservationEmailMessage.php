<?php
/**
Copyright 2012-2015 Nick Korbel

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

require_once(ROOT_DIR . 'lib/Email/namespace.php');
require_once(ROOT_DIR . 'Pages/Pages.php');

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

    public function __construct(User $reservationOwner, ReservationSeries $reservationSeries, $language = null, IAttributeRepository $attributeRepository)
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
        if ($this->reservationSeries->IsRecurring())
        {
            foreach ($this->reservationSeries->Instances() as $repeated)
            {
                $repeatDates[] = $repeated->StartDate()->ToTimezone($this->timezone);
            }
        }
        $this->Set('RepeatDates', $repeatDates);
        $this->Set('RequiresApproval', $this->reservationSeries->RequiresApproval());
        $this->Set('ReservationUrl', sprintf("%s?%s=%s", Pages::RESERVATION, QueryStringKeys::REFERENCE_NUMBER, $currentInstance->ReferenceNumber()));
        $icalUrl = sprintf("export/%s?%s=%s", Pages::CALENDAR_EXPORT, QueryStringKeys::REFERENCE_NUMBER, $currentInstance->ReferenceNumber());
        $this->Set('ICalUrl', $icalUrl);

		$resourceNames = array();
		foreach($this->reservationSeries->AllResources() as $resource)
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
    }

    private function GetFullImagePath($img)
    {
        return Configuration::Instance()->GetKey(ConfigKeys::IMAGE_UPLOAD_URL) . '/' . $img;
    }
}