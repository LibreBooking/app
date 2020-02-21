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

class FileTypeValidator extends ValidatorBase implements IValidator
{
	/**
	 * @var null|UploadedFile
	 */
	private $file;

	/**
	 * @var array|string[]
	 */
	private $allowedTypes;

	/**
	 * @param UploadedFile|null $file
	 * @param array|string|string[] $allowedTypes
	 */
	public function __construct($file, $allowedTypes = array())
	{
		$this->file = $file;
		if (!is_array($allowedTypes))
		{
			$this->allowedTypes = array($allowedTypes);
		}
		else
		{
			$this->allowedTypes = $allowedTypes;
		}
	}

	public function Validate()
	{
		if ($this->file == null)
		{
			return;
		}
		$this->isValid = in_array($this->file->Extension(), $this->allowedTypes);
		if (!$this->IsValid())
		{
			$this->AddMessage(Resources::GetInstance()->GetString('InvalidAttachmentExtension', array(implode(',', $this->allowedTypes))));
		}
	}
}
