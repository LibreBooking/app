<?php
/**
Copyright 2011-2013 Nick Korbel

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

require_once(ROOT_DIR . 'Domain/Access/namespace.php');

class FakeReservationRepository
{
	public $_Reservations = array();

	public function __construct()
	{
		$this->FillRows();
	}

	public static function GetReservationRows()
	{
		$row1 =  array(ColumnNames::RESERVATION_INSTANCE_ID => 1,
					ColumnNames::RESERVATION_START => '2008-05-20 09:00:00',
					ColumnNames::RESERVATION_END => '2008-05-20 15:30:00',
					ColumnNames::RESERVATION_TYPE => 1,
					ColumnNames::RESERVATION_DESCRIPTION => 'summary1',
					ColumnNames::RESERVATION_TITLE => 'summary1',
					ColumnNames::RESOURCE_ID => 1,
					ColumnNames::USER_ID => 1,
					ColumnNames::FIRST_NAME => 'first',
					ColumnNames::LAST_NAME => 'last',
					ColumnNames::REPEAT_START => null,
					ColumnNames::REPEAT_END => null,
					ColumnNames::REFERENCE_NUMBER => 'r1',
					ColumnNames::RESERVATION_STATUS => ReservationStatus::Created,
                    ColumnNames::RESOURCE_NAME => 'rn',
                    ColumnNames::RESERVATION_USER_LEVEL => ReservationUserLevel::OWNER,
                    ColumnNames::SCHEDULE_ID => 1,
                    ColumnNames::OWNER_FIRST_NAME => 'first',
                    ColumnNames::OWNER_LAST_NAME => 'last',
                    ColumnNames::OWNER_USER_ID => 1,
                    ColumnNames::OWNER_PHONE => null,
					ColumnNames::OWNER_ORGANIZATION => null,
					ColumnNames::OWNER_POSITION => null,
					ColumnNames::PARTICIPANT_LIST => null,
					ColumnNames::INVITEE_LIST => null,
					ColumnNames::ATTRIBUTE_LIST => null,
					ColumnNames::USER_PREFERENCES => null,
					);

		$row2 =  array(ColumnNames::RESERVATION_INSTANCE_ID => 1,
					ColumnNames::RESERVATION_START => '2008-05-20 09:00:00',
					ColumnNames::RESERVATION_END => '2008-05-20 15:30:00',
					ColumnNames::RESERVATION_TYPE => 1,
					ColumnNames::RESERVATION_DESCRIPTION => 'summary1',
					ColumnNames::RESERVATION_TITLE => 'summary1',
					ColumnNames::RESERVATION_PARENT_ID => null,
					ColumnNames::RESOURCE_ID => 2,
					ColumnNames::USER_ID => 1,
					ColumnNames::FIRST_NAME => 'first',
					ColumnNames::LAST_NAME => 'last',
					ColumnNames::REPEAT_START => null,
					ColumnNames::REPEAT_END => null,
					ColumnNames::REFERENCE_NUMBER => 'r2',
					ColumnNames::RESERVATION_STATUS => ReservationStatus::Created,
                    ColumnNames::RESOURCE_NAME => 'rn',
                    ColumnNames::RESERVATION_USER_LEVEL => ReservationUserLevel::OWNER,
                    ColumnNames::SCHEDULE_ID => 1,
                    ColumnNames::OWNER_FIRST_NAME => 'first',
                    ColumnNames::OWNER_LAST_NAME => 'last',
                    ColumnNames::OWNER_USER_ID => 1,
					ColumnNames::OWNER_PHONE => null,
					ColumnNames::OWNER_ORGANIZATION => null,
					ColumnNames::OWNER_POSITION => null,
					ColumnNames::PARTICIPANT_LIST => null,
					ColumnNames::INVITEE_LIST => null,
					ColumnNames::ATTRIBUTE_LIST => null,
					ColumnNames::USER_PREFERENCES => null,
					);

		$row3 =  array(ColumnNames::RESERVATION_INSTANCE_ID => 2,
					ColumnNames::RESERVATION_START => '2008-05-22 06:00:00',
					ColumnNames::RESERVATION_END => '2008-05-24 09:30:00',
					ColumnNames::RESERVATION_TYPE => 1,
					ColumnNames::RESERVATION_DESCRIPTION => 'summary2',
					ColumnNames::RESERVATION_TITLE => 'summary2',
					ColumnNames::RESERVATION_PARENT_ID => null,
					ColumnNames::RESOURCE_ID => 1,
					ColumnNames::USER_ID => 1,
					ColumnNames::FIRST_NAME => 'first',
					ColumnNames::LAST_NAME => 'last',
					ColumnNames::REPEAT_START => null,
					ColumnNames::REPEAT_END => null,
					ColumnNames::REFERENCE_NUMBER => 'r3',
					ColumnNames::RESERVATION_STATUS => ReservationStatus::Pending,
                    ColumnNames::RESOURCE_NAME => 'rn',
                    ColumnNames::RESERVATION_USER_LEVEL => ReservationUserLevel::OWNER,
                    ColumnNames::SCHEDULE_ID => 1,
                    ColumnNames::OWNER_FIRST_NAME => 'first',
                    ColumnNames::OWNER_LAST_NAME => 'last',
                    ColumnNames::OWNER_USER_ID => 1,
					ColumnNames::OWNER_PHONE => null,
					ColumnNames::OWNER_ORGANIZATION => null,
					ColumnNames::OWNER_POSITION => null,
					ColumnNames::PARTICIPANT_LIST => null,
					ColumnNames::INVITEE_LIST => null,
					ColumnNames::ATTRIBUTE_LIST => null,
					ColumnNames::USER_PREFERENCES => null,
					);

		return array(
			$row1,
			$row2,
			$row3
			);
	}

	private function FillRows()
	{
		$rows = self::GetReservationRows();

		foreach($rows as $row)
		{
			$this->_Reservations[] = ReservationFactory::CreateForSchedule($row);
		}
	}
}

?>