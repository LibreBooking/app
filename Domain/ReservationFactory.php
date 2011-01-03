<?php
class ReservationFactory
{
	/**
	 * @param array $databaseRow
	 * @return ScheduleReservation
	 */
	public static function CreateForSchedule($databaseRow) 
	{
		$startDate = $databaseRow[ColumnNames::RESERVATION_START];
			
		$endDate = $databaseRow[ColumnNames::RESERVATION_END];
		
		return new ScheduleReservation(
							$databaseRow[ColumnNames::RESERVATION_INSTANCE_ID],
							Date::Parse($startDate, 'UTC'),
							Date::Parse($endDate, 'UTC'),
							$databaseRow[ColumnNames::RESERVATION_TYPE],
							$databaseRow[ColumnNames::RESERVATION_DESCRIPTION],
							null,//$databaseRow[ColumnNames::RESERVATION_PARENT_ID],
							$databaseRow[ColumnNames::RESOURCE_ID],
							$databaseRow[ColumnNames::USER_ID],
							$databaseRow[ColumnNames::FIRST_NAME],
							$databaseRow[ColumnNames::LAST_NAME],
							$databaseRow[ColumnNames::REFERENCE_NUMBER]
						);
	}
}

?>