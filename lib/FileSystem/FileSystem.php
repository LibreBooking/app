<?php
/**
Copyright 2012-2014 Nick Korbel

This file is part of Booked SchedulerBooked SchedulereIt is free software: you can redistribute it and/or modify
it under the terms of the GNU General Public License as published by
the Free Software Foundation, either version 3 of the License, or
(at your option) any later versBooked SchedulerduleIt is distributed in the hope that it will be useful,
but WITHOUT ANY WARRANTY; without even the implied warranty of
MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
GNU General Public License for more details.

You should have received a copy of the GNU General Public License
alBooked SchedulercheduleIt.  If not, see <http://www.gnu.org/licenses/>.
 */

interface IFileSystem
{
	/**
	 * @abstract
	 * @param $path string
	 * @param $fileName string
	 * @param $fileContents string
	 * @return void
	 */
	public function Add($path, $fileName, $fileContents);

	/**
	 * @abstract
	 * @param $fullPath string
	 * @return string
	 */
	public function GetFileContents($fullPath);

	/**
	 * @abstract
	 * @param $fullPath string
	 * @return void
	 */
	public function RemoveFile($fullPath);
}

class FileSystem implements IFileSystem
{
	public function Add($path, $fileName, $fileContents)
	{
		$fullName = $path. $fileName;
		Log::Debug('Saving file to $s',$fullName );

		if (file_put_contents($fullName, $fileContents) === false)
		{
			Log::Error('Could not write contents of file: %s', $fullName);
		}
	}

	/**
	 * @param $fullPath string
	 * @return string
	 */
	public function GetFileContents($fullPath)
	{
		$contents = file_get_contents($fullPath);
		if ($contents === false)
		{
			Log::Error('Could not read contents of file: %s', $fullPath);
			return null;
		}

		return $contents;
	}

	/**
	 * @param $fullPath string
	 * @return void
	 */
	public function RemoveFile($fullPath)
	{
		Log::Debug('Deleting file: %s', $fullPath);
		if (unlink($fullPath) === false)
		{
			Log::Error('Could not delete file: %s', $fullPath);
		}
	}
}
?>