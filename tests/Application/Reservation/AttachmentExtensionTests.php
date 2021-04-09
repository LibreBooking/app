<?php

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
