<?php
/**
Copyright 2013-2020 Nick Korbel

This file is part of Booked Scheduler is free software: you can redistribute it and/or modify
it under the terms of the GNU General Public License as published by
the Free Software Foundation, either version 3 of the License, or
(at your option) any later version is distributed in the hope that it will be useful,
but WITHOUT ANY WARRANTY; without even the implied warranty of
MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
GNU General Public License for more details.

You should have received a copy of the GNU General Public License
along with Booked Scheduler.  If not, see <http://www.gnu.org/licenses/>.
 */

class FileUploadValidator extends ValidatorBase implements IValidator
{
	/**
	 * @var null|UploadedFile
	 */
	private $file;

	/**
	 * @param UploadedFile|null $file
	 */
	public function __construct($file)
	{
		$this->file = $file;
	}

	public function Validate()
	{
		if ($this->file == null)
		{
			return;
		}
		$this->isValid = !$this->file->IsError();
		if (!$this->IsValid())
		{
			Log::Debug('Uploaded file %s is not valid. %s', $this->file->OriginalName(), $this->file->Error());
			$this->AddMessage($this->file->Error());
		}
	}
}
