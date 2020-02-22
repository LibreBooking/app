<?php
/**
Copyright 2011-2020 Nick Korbel

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

define('ROOT_DIR', dirname(__FILE__) . '/../');

require_once(ROOT_DIR . 'lib/Common/namespace.php');
require_once(ROOT_DIR . 'lib/Database/namespace.php');
require_once(ROOT_DIR . 'lib/Database/Commands/namespace.php');

$command = new GetReservationListCommand(Date::Parse('2010-01-01'), Date::Parse('2012-01-01'), 1, 1);

$result = ServiceLocator::GetDatabase()->Query($command);

while ($row = $result->GetRow())
{
	foreach ($row as $name => $val)
	{
		echo "$name = $val, ";
	}
	echo PHP_EOL;
}
?>