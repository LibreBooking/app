<?php
/**
Copyright 2014-2020 Nick Korbel

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

class TemplateCacheDirectory
{
	public function Flush()
	{
		try
		{
			$dirName = $this->GetDirectory();
			$cacheDir = opendir($dirName);
		    while (false !== ($file = readdir($cacheDir)))
			{
		        if($file != "." && $file != "..")
				{
		            unlink($dirName . $file);
		        }
		    }
		    closedir($cacheDir);
		}
		catch(Exception $ex)
		{
			Log::Error('Could not flush template cache directory: %s', $ex);
		}
	}

	public function GetDirectory()
	{
		return ROOT_DIR . 'tpl_c/';
	}
}