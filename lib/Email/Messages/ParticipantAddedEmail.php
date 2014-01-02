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

require_once(ROOT_DIR . 'lib/Email/Messages/ReservationEmailMessage.php');

class ParticipantAddedEmail extends ReservationEmailMessage
{
	/**
	 * @var User
	 */
	private $participant;

	public function __construct(User $reservationOwner, User $participant, ReservationSeries $reservationSeries, IAttributeRepository $attributeRepository)
	{
		parent::__construct($reservationOwner, $reservationSeries, $participant->Language(), $attributeRepository);

		$this->reservationOwner = $reservationOwner;
		$this->reservationSeries = $reservationSeries;
		$this->timezone = $participant->Timezone();
		$this->participant = $participant;
	}

	public function To()
	{
		$address = $this->participant->EmailAddress();
		$name = $this->participant->FullName();

		return array(new EmailAddress($address, $name));
	}

	public function Subject()
	{
		return $this->Translate('ParticipantAddedSubject');
	}

	public function From()
	{
		return new EmailAddress($this->reservationOwner->EmailAddress(), $this->reservationOwner->FullName());
	}

    public function GetTemplateName()
    {
        return 'ReservationCreated.tpl';
    }
}