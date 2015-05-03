<?php
/**
Copyright 2012-2015 Nick Korbel

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

require_once(ROOT_DIR . 'Controls/Control.php');

class RecurrenceControl extends Control
{
	public function PageLoad()
	{
		$this->Set('RepeatEveryOptions', range(1, 20));
		$this->Set('RepeatOptions', array (
						'none' => array('key' => 'DoesNotRepeat', 'everyKey' => ''),
						'daily' => array('key' => 'Daily', 'everyKey' => 'days'),
						'weekly' => array('key' => 'Weekly', 'everyKey' => 'weeks'),
						'monthly' => array('key' => 'Monthly', 'everyKey' => 'months'),
						'yearly' => array('key' => 'Yearly', 'everyKey' => 'years'),
								)
		);
		$this->Set('DayNames', array(
								0 => 'DaySundayAbbr',
								1 => 'DayMondayAbbr',
								2 => 'DayTuesdayAbbr',
								3 => 'DayWednesdayAbbr',
								4 => 'DayThursdayAbbr',
								5 => 'DayFridayAbbr',
								6 => 'DaySaturdayAbbr',
								)
		);

		$this->Display('Controls/RecurrenceDiv.tpl');
	}
}

?>