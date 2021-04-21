<?php

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
