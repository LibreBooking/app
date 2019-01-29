<?php
/**
Copyright 2019 Nick Korbel

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

require_once(ROOT_DIR . 'lib/Email/Messages/ReservationEmailMessage.php');

class ReservationSeriesEndingEmail extends EmailMessage
{
    /**
     * @var string
     */
	private $email;

    /**
     * @var ExistingReservationSeries
     */
    private $reservationSeries;

    /**
     * @var string
     */
    private $timezone;

    /**
     * @var Reservation
     */
    private $currentInstance;

    public function __construct(ExistingReservationSeries $reservationSeries, $language, $timezone, $email)
	{
		parent::__construct($language);

		$this->reservationSeries = $reservationSeries;
		$this->timezone = $timezone;
		$this->email = $email;
		$this->currentInstance = $this->reservationSeries->CurrentInstance();
    }

	public function To()
	{
		return array(new EmailAddress($this->email));
	}

	public function Subject()
	{
		return $this->Translate('ReservationSeriesEndingSubject', array(
		    $this->reservationSeries->Resource()->GetName(),
            $this->currentInstance->StartDate()->ToTimezone($this->timezone)->Format(Resources::GetInstance()->GetDateFormat('general_date'))));
	}

    public function Body()
    {
        $this->Set('ResourceName', $this->reservationSeries->Resource()->GetName());
        $this->Set('Title', $this->reservationSeries->Title());
        $this->Set('Description', $this->reservationSeries->Description());
        $this->Set('StartDate', $this->currentInstance->StartDate()->ToTimezone($this->timezone));
        $this->Set('EndDate', $this->currentInstance->EndDate()->ToTimezone($this->timezone));
        $this->Set('ReservationUrl', sprintf("%s?%s=%s", Pages::RESERVATION, QueryStringKeys::REFERENCE_NUMBER, $this->currentInstance->ReferenceNumber()));

        return $this->FetchTemplate('ReservationSeriesEnding.tpl');
    }
}