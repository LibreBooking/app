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
							$databaseRow[ColumnNames::START_DATE],
							$databaseRow[ColumnNames::END_DATE],
							$databaseRow[ColumnNames::START_TIME],
							$databaseRow[ColumnNames::END_TIME],
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