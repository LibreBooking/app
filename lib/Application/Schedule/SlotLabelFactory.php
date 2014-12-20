<?php
/**
Copyright 2012-2014 Nick Korbel

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
	 * @param string $format
	 * @return string
	 */
	public function Format(ReservationItemView $reservation, $format = null)
	{
		if (empty($format))
		{
			$format = Configuration::Instance()->GetSectionKey(ConfigSection::SCHEDULE, ConfigKeys::SCHEDULE_RESERVATION_LABEL);
		}

		if ($format == 'none' || empty($format))
		{
			return '';
		}

		$name = $this->GetFullName($reservation);

		$timezone = 'UTC';
		$dateFormat = Resources::GetInstance()->GetDateFormat('res_popup');
		if (!is_null($this->user))
		{
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
		$label = str_replace('{resourcename}', $reservation->ResourceName, $label);
		$label = str_replace('{participants}', trim(implode(', ', $reservation->ParticipantNames)), $label);
		$label = str_replace('{invitees}', trim(implode(', ', $reservation->InviteeNames)), $label);

		$matches = array();
		preg_match_all('/\{(att\d+?)\}/', $format, $matches);

		$matches = $matches[0];
		if (count($matches) > 0)
		{
			for ($m = 0; $m < count($matches); $m++)
			{
				$id = filter_var($matches[$m], FILTER_SANITIZE_NUMBER_INT);
				$value = $reservation->GetAttributeValue($id);

				$label = str_replace($matches[$m], $value, $label);
			}
		}

		return $label;
	}

	protected function GetFullName(ReservationItemView $reservation)
	{
		$shouldHide = Configuration::Instance()->GetSectionKey(ConfigSection::PRIVACY,
															   ConfigKeys::PRIVACY_HIDE_USER_DETAILS,
															   new BooleanConverter());

		if ($shouldHide && (is_null($this->user) || ($this->user->UserId != $reservation->UserId && !$this->user->IsAdminForGroup($reservation->OwnerGroupIds()))))
		{
			return Resources::GetInstance()->GetString('Private');
		}

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