<?php

/**
 * Copyright 2017-2019 Nick Korbel
 *
 * This file is part of Booked Scheduler.
 *
 * Booked Scheduler is free software: you can redistribute it and/or modify
 * it under the terms of the GNU General Public License as published by
 * the Free Software Foundation, either version 3 of the License, or
 * (at your option) any later version.
 *
 * Booked Scheduler is distributed in the hope that it will be useful,
 * but WITHOUT ANY WARRANTY; without even the implied warranty of
 * MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
 * GNU General Public License for more details.
 *
 * You should have received a copy of the GNU General Public License
 * along with Booked Scheduler.  If not, see <http://www.gnu.org/licenses/>.
 */

class FileExtensionValidator extends ValidatorBase implements IValidator
{
	/**
	 * @var string[]
	 */
	private $validExtensions;

	/**
	 * @var string
	 */
	private $fileExtension;

	/**
	 * @param $validExtensions string|string[]
	 * @param $file UploadedFile
	 */
	public function __construct($validExtensions, $file)
	{
		if (!is_array($validExtensions))
		{
			$validExtensions = array($validExtensions);
		}
		$this->validExtensions = $validExtensions;

		if ($file == null || !is_a($file, 'UploadedFile'))
		{
			$this->fileExtension = '';
		}
		else
		{
			$this->fileExtension = $file->Extension();
		}
	}

	/**
	 * @return void
	 */
	public function Validate()
	{
		$this->isValid = in_array($this->fileExtension, $this->validExtensions);
	}

	public function Messages()
	{
		return array(Resources::GetInstance()->GetString('InvalidAttachmentExtension', implode(',', $this->validExtensions)));
	}
}
