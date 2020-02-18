<?php
/**
Copyright 2012-2019 Nick Korbel

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

require_once(ROOT_DIR . 'Domain/namespace.php');
require_once(ROOT_DIR . 'lib/Application/Reservation/namespace.php');

class AttachmentExtensionTests extends TestBase
{
	/**
	 * @var ReservationAttachmentRule
	 */
	private $validator;

	/**
	 * @var TestReservationSeries
	 */
	private $series;

	public function setUp(): void
	{
		$this->series = new TestReservationSeries();
		$this->validator = new ReservationAttachmentRule();
		parent::setup();
	}

	public function testRuleIsValidIfExtensionIsInListWithDot()
	{
		$this->fakeConfig->SetSectionKey(ConfigSection::UPLOADS, ConfigKeys::UPLOAD_RESERVATION_EXTENSIONS, '.pdf, .doc');

		$attachment = new FakeReservationAttachment();
		$attachment->SetExtension('doc');
		$this->series->AddAttachment($attachment);

		$result = $this->validator->Validate($this->series, null);

		$this->assertTrue($result->IsValid());
	}

	public function testRuleIsValidIfExtensionIsInListWithoutDot()
	{
		$this->fakeConfig->SetSectionKey(ConfigSection::UPLOADS, ConfigKeys::UPLOAD_RESERVATION_EXTENSIONS, 'pdf,doc');

		$attachment = new FakeReservationAttachment();
		$attachment->SetExtension('doc');
		$this->series->AddAttachment($attachment);

		$result = $this->validator->Validate($this->series, null);

		$this->assertTrue($result->IsValid());
	}

	public function testRuleIsValidIfExtensionListIsEmpty()
	{
		$this->fakeConfig->SetSectionKey(ConfigSection::UPLOADS, ConfigKeys::UPLOAD_RESERVATION_EXTENSIONS, '');

		$attachment = new FakeReservationAttachment();
		$attachment->SetExtension('doc');
		$this->series->AddAttachment($attachment);

		$result = $this->validator->Validate($this->series, null);

		$this->assertTrue($result->IsValid());
	}

	public function testRuleIsInvalidIfExtensionIsNotInList()
	{
		$this->fakeConfig->SetSectionKey(ConfigSection::UPLOADS, ConfigKeys::UPLOAD_RESERVATION_EXTENSIONS, '.pdf');

		$attachment = new FakeReservationAttachment();
		$attachment->SetExtension('doc');
		$this->series->AddAttachment($attachment);

		$result = $this->validator->Validate($this->series, null);

		$this->assertFalse($result->IsValid());
	}
}

?>