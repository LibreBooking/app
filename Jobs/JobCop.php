<?php
/**
Copyright 2013-2020 Nick Korbel

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

class JobCop
{
	public static function EnsureCommandLine()
	{
		try
		{
			if (array_key_exists('REQUEST_METHOD', $_SERVER))
			{
				die('This can only be accessed via the command line');
			}
		}
		catch(Exception $ex){
			Log::Error('Error in JobCop->EnsureCommandLine: %s', $ex);
		}
	}
}
