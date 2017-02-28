<?php
/**
Copyright 2013-2017 Nick Korbel

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

class ScheduleLayoutSerializableTests extends TestBase
{
	public function setup()
	{
		parent::setup();
	}

	public function testCreatesSerializableLayout()
	{
		$baseDate = Date::Now();

		$b1 = $baseDate->AddDays(1);
		$e1 = $baseDate->AddDays(2);
		$b2 = $baseDate->AddDays(3);
		$e2 = $baseDate->AddDays(4);
		$b3 = $baseDate->AddDays(5);
		$e3 = $baseDate->AddDays(6);
		$b4 = $baseDate->AddDays(7);
		$e4 = $baseDate->AddDays(8);

		$l1 = 'label 1';
		$l2 = 'label 2';

		$p1 = new SchedulePeriod($b1, $e1);
		$p2 = new NonSchedulePeriod($b2, $e2);
		$p3 = new SchedulePeriod($b3, $e3, $l1);
		$p4 = new NonSchedulePeriod($b4, $e4, $l2);
		$periods = array($p1, $p2, $p3, $p4,);

		$actual = new ScheduleLayoutSerializable($periods);

		$actualPeriods = $actual->periods;

		$this->assertEquals(count($periods), count($actualPeriods));

		$this->assertEquals($p1->Begin()->__toString(), $actualPeriods[0]->begin);
		$this->assertEquals($p1->End()->__toString(), $actualPeriods[0]->end);
		$this->assertEquals($p1->BeginDate()->__toString(), $actualPeriods[0]->beginDate);
		$this->assertEquals($p1->EndDate()->__toString(), $actualPeriods[0]->endDate);
		$this->assertEquals($p1->Label(), $actualPeriods[0]->label);
		$this->assertEquals($p1->LabelEnd(), $actualPeriods[0]->labelEnd);
		$this->assertEquals($p1->IsReservable(), $actualPeriods[0]->isReservable);

		$this->assertEquals($p2->Begin()->__toString(), $actualPeriods[1]->begin);
		$this->assertEquals($p2->End()->__toString(), $actualPeriods[1]->end);
		$this->assertEquals($p2->Label(), $actualPeriods[1]->label);
		$this->assertEquals($p2->LabelEnd(), $actualPeriods[1]->labelEnd);
		$this->assertEquals($p2->IsReservable(), $actualPeriods[1]->isReservable);
	}
}
?>