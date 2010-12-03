<?php
class ReservationFactory
{
	/**
	 * @param array $databaseRow
	 * @return ScheduleReservation
	 */
	public static function CreateForSchedule($databaseRow) 
	{
		return new ScheduleReservation(
							$databaseRow[ColumnNames::RESERVATION_ID],
							Date::Parse($databaseRow[ColumnNames::RESERVATION_START], 'UTC'),
							Date::Parse($databaseRow[ColumnNames::RESERVATION_END], 'UTC'),
							$databaseRow[ColumnNames::RESERVATION_TYPE],
							$databaseRow[ColumnNames::RESERVATION_DESCRIPTION],
							$databaseRow[ColumnNames::RESERVATION_PARENT_ID],
							$databaseRow[ColumnNames::RESOURCE_ID],
							$databaseRow[ColumnNames::USER_ID],
							$databaseRow[ColumnNames::FIRST_NAME],
							$databaseRow[ColumnNames::LAST_NAME]
						);
	}
}

?>