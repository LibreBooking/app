<?php
/**
Copyright 2011-2019 Nick Korbel

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

require_once('config/config.php');

#echo 'Please update the $conf[\'settings\'][\'script.url\'] setting in your config file to be http://' . $_SERVER['SERVER_NAME'] . str_replace('/index.php', '', $_SERVER['PHP_SELF']) . '/Web';
#echo '<br/>You will be redirected automatically in 20 seconds, but portions of Booked Scheduler will not function correctly.';

header( "refresh:0;url=Web?" . urlencode($_SERVER['QUERY_STRING']) );
exit;
?>