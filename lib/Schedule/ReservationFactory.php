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
							Date::Parse($databaseRow[ColumnNames::START_DATE], 'UTC'),
							Date::Parse($databaseRow[ColumnNames::END_DATE], 'UTC'),
							$databaseRow[ColumnNames::RESERVATION_TYPE],
							$databaseRow[ColumnNames::SUMMARY],
							$databaseRow[ColumnNames::PARENT_ID],
							$databaseRow[ColumnNames::RESOURCE_ID],
							$databaseRow[ColumnNames::USER_ID],
							$databaseRow[ColumnNames::FIRST_NAME],
							$databaseRow[ColumnNames::LAST_NAME]
						);
	}
}

?>