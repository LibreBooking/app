<?php
/**
Copyright 2012-2014 Nick Korbel

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

class SlotLabelFactory
{
	/**
	 * @var null|UserSession
	 */
	private $user = null;

	public function __construct($user = null)
	{
		$this->user = $user;
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
	 * @return string
	 */
	public function Format(ReservationItemView $reservation)
	{
		$property = Configuration::Instance()->GetSectionKey(ConfigSection::SCHEDULE,
															 ConfigKeys::SCHEDULE_RESERVATION_LABEL);

		$name = $this->GetFullName($reservation);

		if ($property == 'titleORuser')
		{
			if (strlen($reservation->Title))
			{
				return $reservation->Title;
			}
			else
			{
				return $name;
			}
		}
		if ($property == 'title')
		{
			return $reservation->Title;
		}
		if ($property == 'none' || empty($property))
		{
			return '';
		}
		if ($property == 'name' || $property == 'user')
		{
			return $name;
		}

		$label = $property;
		$label = str_replace('{name}', $name, $label);
		$label = str_replace('{title}', $reservation->Title, $label);
		$label = str_replace('{description}', $reservation->Description, $label);
		$label = str_replace('{email}', $reservation->OwnerEmailAddress, $label);
		$label = str_replace('{organization}', $reservation->OwnerOrganization, $label);
		$label = str_replace('{phone}', $reservation->OwnerPhone, $label);
		$label = str_replace('{position}', $reservation->OwnerPosition, $label);

		return $label;
	}

	protected function GetFullName(ReservationItemView $reservation)
	{
		$shouldHide = Configuration::Instance()->GetSectionKey(ConfigSection::PRIVACY,
															   ConfigKeys::PRIVACY_HIDE_USER_DETAILS,
															   new BooleanConverter());
		if ($shouldHide && (is_null($this->user) || $this->user->UserId != $reservation->UserId))
		{
			return Resources::GetInstance()->GetString('Private');
		}

		$name = new FullName($reservation->FirstName, $reservation->LastName);
		return $name->__toString();

	}
}

class NullSlotLabelFactory extends SlotLabelFactory
{
	public function Format(ReservationItemView $reservation)
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

?>