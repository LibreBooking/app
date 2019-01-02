<?php
/**
Copyright 2012-2019 Nick Korbel

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

class ReservationAttachment
{
	/**
	 * @var int
	 */
	protected $fileId;

	/**
	 * @var string
	 */
	protected $fileName;

	/**
	 * @var string
	 */
	protected $fileType;

	/**
	 * @var int
	 */
	protected $fileSize;

	/**
	 * @var string
	 */
	protected $fileContent;

	/**
	 * @var string
	 */
	protected $fileExtension;

	/**
	 * @var int
	 */
	protected $seriesId;

	/**
	 * @return int
	 */
	public function FileId()
	{
		return $this->fileId;
	}

	/**
	 * @return string
	 */
	public function FileName()
	{
		return $this->fileName;
	}

	/**
	 * @return string
	 */
	public function FileContents()
	{
		return $this->fileContent;
	}

	/**
	 * @return string
	 */
	public function FileExtension()
	{
		return $this->fileExtension;
	}

	/**
	 * @return int
	 */
	public function FileSize()
	{
		return $this->fileSize;
	}

	/**
	 * @return string
	 */
	public function FileType()
	{
		return $this->fileType;
	}

	/**
	 * @return int
	 */
	public function SeriesId()
	{
		return $this->seriesId;
	}

	protected function __construct()
	{

	}

	/**
	 * @static
	 * @param string $fileName
	 * @param string $fileType
	 * @param int $fileSize
	 * @param mixed $fileContent
	 * @param string $fileExtension
	 * @param int $seriesId
	 * @return ReservationAttachment
	 */
	public static function Create($fileName, $fileType, $fileSize, $fileContent, $fileExtension, $seriesId)
	{
		$file = new ReservationAttachment();
		$file->fileName = $fileName;
		$file->fileType = $fileType;
		$file->fileSize = $fileSize;
		$file->fileContent = $fileContent;
		$file->fileExtension = $fileExtension;
		$file->seriesId = $seriesId;

		return $file;
	}

	/**
	 * @param $fileId int
	 */
	public function WithFileId($fileId)
	{
		$this->fileId = $fileId;
	}

	/**
	 * @param $seriesId int
	 */
	public function WithSeriesId($seriesId)
	{
		$this->seriesId = $seriesId;
	}
}