<?php

/**
 * Copyright 2012-2015 Nick Korbel
 *
 * This file is part of Booked Scheduler.
 *
 * Booked Scheduler is free software: you can redistribute it and/or modify
 * it under the terms of the GNU General Public License as published by
 * the Free Software Foundation, either version 3 of the License, or
 * (at your option) any later version.
 *
 * Booked Scheduler is distributed in the hope that it will be useful,
 * but WITHOUT ANY WARRANTY; without even the implied warranty of
 * MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
 * GNU General Public License for more details.
 *
 * You should have received a copy of the GNU General Public License
 * along with Booked Scheduler.  If not, see <http://www.gnu.org/licenses/>.
 */
class SlotLabelFactoryTests extends TestBase
{
	/**
	 * @var ReservationItemView
	 */
	private $reservation;

	public function setup()
	{
		parent::setup();

		$this->SetConfig(null);

		$this->reservation = new ReservationItemView();
		$this->reservation->Title = 'some title';
		$this->reservation->FirstName = 'first';
		$this->reservation->LastName = 'last';
		$this->reservation->StartDate = Date::Now();
		$this->reservation->EndDate = Date::Now();
	}

	public function testGetsNone()
	{
		$this->SetConfig('none');

		$value = SlotLabelFactory::Create($this->reservation);

		$this->assertEquals('', $value);
	}

	public function testWhenUselessValueIsProvided()
	{
		$this->SetConfig('foo');

		$value = SlotLabelFactory::Create($this->reservation);

		$this->assertEquals('foo', $value);
	}

	public function testUsesFormatIfAvailable()
	{
		$this->reservation->Title = 'mytitle';
		$this->reservation->Description = 'mydescription';
		$this->reservation->OwnerEmailAddress = 'myemail';
		$this->reservation->OwnerOrganization = 'myorg';
		$this->reservation->OwnerPhone = 'myphone';
		$this->reservation->OwnerPosition = 'myposition';
		$this->reservation->ParticipantNames = array('p1', 'p2');
		$this->reservation->InviteeNames = array('i1', 'i2');
		$this->reservation->StartDate = Date::Now();
		$this->reservation->EndDate = Date::Now();

		$this->SetConfig('{name} + {title} - {description} {email} {phone} {organization} {position} {participants} {invitees}');
		$value = SlotLabelFactory::Create($this->reservation);

		$this->assertEquals('first last + mytitle - mydescription myemail myphone myorg myposition p1, p2 i1, i2',
							$value);
	}

	public function testFormatsDates()
	{
		$this->reservation->StartDate = Date::Parse('2014-04-05 08:14:12', 'UTC');
		$this->reservation->EndDate = Date::Parse('2014-04-06 17:18:12', 'UTC');

		$this->SetConfig('{startdate} {enddate}');
		$factory = new SlotLabelFactory($this->fakeUser);
		$value = $factory->Format($this->reservation);

		$this->assertEquals($this->reservation->StartDate->ToTimezone($this->fakeUser->Timezone)->Format($this->fakeResources->GetDateFormat('res_popup')) . ' ' . $this->reservation->EndDate->ToTimezone($this->fakeUser->Timezone)->Format($this->fakeResources->GetDateFormat('res_popup')),
							$value);
	}

	public function testParsesAttributes()
	{
		$this->reservation->Attributes = new CustomAttributes();
		$this->reservation->Attributes->Add(2, 'value2');
		$this->reservation->Attributes->Add(1, 'value1');


		$this->SetConfig('{att1} {att2}');

		$value = SlotLabelFactory::Create($this->reservation);
		$this->assertEquals('value1 value2', $value);
	}

	public function testGetsAllAttributes()
	{
		$attributeRepository = new FakeAttributeRepository();
		$attributeRepository->_CustomAttributes = array(new FakeCustomAttribute(1), new FakeCustomAttribute(2));
		$attributes = new CustomAttributes();
		$attributes->Add(1, '1');
		$attributes->Add(2, '2');

		$this->reservation->Attributes = $attributes;

		$this->SetConfig('{reservationAttributes}');
		$factory = new SlotLabelFactory(null, null, $attributeRepository);

		$this->assertEquals('fakeCustomAttribute1: 1, fakeCustomAttribute2: 2', $factory->Format($this->reservation));
	}

	private function SetConfig($value)
	{
		$this->fakeConfig->SetSectionKey(ConfigSection::SCHEDULE, ConfigKeys::SCHEDULE_RESERVATION_LABEL, $value);
	}
}