<?php
/**
Copyright 2012-2020 Nick Korbel

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

require_once(ROOT_DIR . 'lib/Server/UploadedFile.php');

class FakeUploadedFile extends UploadedFile
{
	public function __construct()
	{

	}

	/**
	 * @var string
	 */
	public $OriginalName = 'orig';

	/**
	 * @var string
	 */
	public $TemporaryName = 'temp';

	/**
	 * @var string
	 */
	public $MimeType= 'mime';

	/**
	 * @var int
	 */
	public $Size= 100;

	/**
	 * @var string
	 */
	public $Extension = 'ext';

	/**
	 * @var string
	 */
	public $Contents = 'contents';

	/**
	 * @var bool
	 */
	public $IsError = false;

	/**
	 * @var string
	 */
	public $Error;

	public function OriginalName()
	{
		return $this->OriginalName;
	}

	public function TemporaryName()
	{
		return $this->TemporaryName;
	}

	public function MimeType()
	{
		return $this->MimeType;
	}

	public function Size()
	{
		return $this->Size;
	}

	public function Extension()
	{
		return $this->Extension;
	}

	public function Contents()
	{
		return $this->Contents;
	}

	public function IsError()
	{
		return $this->IsError;
	}

	public function Error()
	{
		$this->Error;
	}
}

?>