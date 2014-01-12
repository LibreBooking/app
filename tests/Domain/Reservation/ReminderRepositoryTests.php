<?php
/**
Copyright 2013-2014 Nick Korbel

This file is part of Booked Scheduler.

Booked Scheduler is free software: you can redistribute it and/or modify
it under the terms of the GNU General Public License as published by
the Free Software Foundation, either version 3 of the License, or
(at your option) any later version.

Booked Scheduler is distributed in the hope that it will be useful,
but WITHOUT ANY WARRANTY; without even the implied warranty of
MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
GNU General Public License for more details.

You should have received a copy of the GNU General Public License
along with Booked Scheduler.  If not, see <http://www.gnu.org/licenses/>.
 */

require_once(ROOT_DIR . 'Domain/Access/ReminderRepository.php');

class ReminderRepositoryTests extends TestBase
{
	/**
	 * @var ReminderRepository
	 */
	public $repository;

	public function setup()
	{
		parent::setup();
		$this->repository = new ReminderRepository();
	}

	public function testGetsAllReservationsWithReminderDateOfThisMinute()
	{
		$seriesId = 123;
		$instanceId = 456;
		$referenceNumber = 'refnum1';
		$startDate = Date::Now()->AddDays(1)->ToDatabase();
		$endDate = Date::Now()->AddDays(2)->ToDatabase();
		$title = 'reservation title';
		$description = 'reservation description';
		$resourceName = 'resource name';
		$emailAddress = 'e@m.com';
		$fname = 'first';
		$lname = 'last';
		$timezone = 'America/Chicago';
		$reminder_minutes = 100;
		$now = Date::Now();
		$language = 'en_us';

		$row1 = new ReminderNoticeRow($seriesId, $instanceId, $referenceNumber, $startDate, $endDate, $title, $description, $resourceName, $emailAddress, $fname, $lname, $timezone, $reminder_minutes, $language);
		$row2 = new ReminderNoticeRow();
		$rows = array_merge(
									   $row1->Rows(),
									   $row2->Rows()
								   );
		$this->db->SetRows($rows);

		$reminderNotices = $this->repository->GetReminderNotices($now, ReservationReminderType::Start);

		$expectedCommand = new GetReminderNoticesCommand($now->ToTheMinute(), ReservationReminderType::Start);

		$this->assertEquals(2, count($reminderNotices));
		$this->assertEquals($expectedCommand, $this->db->_LastCommand);

		$expectedReminderNotice = ReminderNotice::FromRow($rows[0]);

		$this->assertEquals($expectedReminderNotice, $reminderNotices[0]);
	}
}