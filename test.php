<?php
define('ROOT_DIR', './');

foreach (DateTimeZone::listIdentifiers() as $tz)
{
	echo "AddTimezone('$tz');<br/>";
}

?>