<?php
/**
Copyright 2012 Nick Korbel

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
    }

    public function testGetsTitle()
    {
        $this->SetConfig('title');

        $value = SlotLabelFactory::Create($this->reservation);

        $this->assertEquals('some title', $value);
    }

    public function testGetsName()
    {
        $this->SetConfig('name');

        $value = SlotLabelFactory::Create($this->reservation);

        $this->assertEquals('first last', $value);
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

		$this->SetConfig('{name} + {title} - {description} {email} {phone} {organization} {position}');
		$value = SlotLabelFactory::Create($this->reservation);

        $this->assertEquals('first last + mytitle - mydescription myemail myphone myorg myposition', $value);
    }

    private function SetConfig($value)
    {
        $this->fakeConfig->SetSectionKey(ConfigSection::SCHEDULE, ConfigKeys::SCHEDULE_RESERVATION_LABEL, $value);
    }
}

?>