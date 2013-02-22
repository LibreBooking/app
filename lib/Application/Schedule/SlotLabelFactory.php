<?php
/**
Copyright 2012 Nick Korbel

This file is part of phpScheduleIt.

phpScheduleIt is free software: you can redistribute it and/or modify
it under the terms of the GNU General Public License as published by
the Free Software Foundation, either version 3 of the License, or
(at your option) any later version.

phpScheduleIt is distributed in the hope that it will be useful,
but WITHOUT ANY WARRANTY; without even the implied warranty of
MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
GNU General Public License for more details.

You should have received a copy of the GNU General Public License
along with phpScheduleIt.  If not, see <http://www.gnu.org/licenses/>.
 */

class SlotLabelFactory
{
    /**
     * @static
     * @param ReservationItemView $reservation
     * @return string
     */
    public static function Create(ReservationItemView $reservation)
    {
        $property = Configuration::Instance()->GetSectionKey(ConfigSection::SCHEDULE, ConfigKeys::SCHEDULE_RESERVATION_LABEL);
		$name = new FullName($reservation->FirstName, $reservation->LastName);

        if ( ($property == 'titleORuser') && strlen($reservation->Title))
        {
            return $reservation->Title;
        }
        if ($property == 'title')
        {
            return $reservation->Title;
        }
        if ($property == 'none' || empty($property))
        {
            return '';
        }
		if ($property == 'name')
		{
			return $name->__toString();
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
}

?>