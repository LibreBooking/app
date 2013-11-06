<?php
/**
 * Copyright 2011-2013 Nick Korbel
 *
 * This file is part of phpScheduleIt.
 *
 * phpScheduleIt is free software: you can redistribute it and/or modify
 * it under the terms of the GNU General Public License as published by
 * the Free Software Foundation, either version 3 of the License, or
 * (at your option) any later version.
 *
 * phpScheduleIt is distributed in the hope that it will be useful,
 * but WITHOUT ANY WARRANTY; without even the implied warranty of
 * MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
 * GNU General Public License for more details.
 *
 * You should have received a copy of the GNU General Public License
 * along with phpScheduleIt.  If not, see <http://www.gnu.org/licenses/>.
 */

class BlackoutSeries
{
	/**
	 * @var int
	 */
	protected $seriesId;

	/**
	 * @var int
	 */
	protected $ownerId;

	/**
	 * @var int[]
	 */
	protected $resourceIds = array();

	/**
	 * @var BlackoutResource[]
	 */
	protected $resources = array();

	/**
	 * @var Blackout[]
	 */
	protected $blackouts= array();

	/**
	 * @var string
	 */
	protected $title;

	/**
	 * @var DateRange
	 */
	protected $blackoutDate;

	/**
	 * @var IRepeatOptions
	 */
	protected $repeatOptions;

	/**
	 * @param int $userId
	 * @param string $title
	 */
	protected function __construct($userId, $title)
	{
		$this->repeatOptions = new RepeatNone();
		$this->ownerId = $userId;
		$this->title = $title;
	}

	/**
	 * @param $userId
	 * @param $title
	 * @param DateRange $blackoutDate
	 * @return BlackoutSeries
	 */
	public static function Create($userId, $title, DateRange $blackoutDate)
	{
		$series = new BlackoutSeries($userId, $title);
		$series->AddBlackout(new Blackout($blackoutDate));
		$series->SetCurrentBlackout($blackoutDate);
		return $series;
	}

	/**
	 * @return int[]
	 */
	public function ResourceIds()
	{
		return $this->resourceIds;
	}

	/**
	 * @return int
	 */
	public function OwnerId()
	{
		return $this->ownerId;
	}

	/**
	 * @return string
	 */
	public function Title()
	{
		return $this->title;
	}

	/**
	 * @param $resourceId int
	 */
	public function AddResourceId($resourceId)
	{
		$this->resourceIds[] = $resourceId;
	}

	public function AddResource(BlackoutResource $resource)
	{
		$this->AddResourceId($resource->GetId());
		$this->resources[] = $resource;
	}

	public function AddBlackout(Blackout $blackout)
	{
		$this->blackouts[$this->ToKey($blackout->Date())] = $blackout;
	}

	/**
	 * @return Blackout[]
	 */
	public function AllBlackouts()
	{
		asort($this->blackouts);
		return array_values($this->blackouts);
	}

	/**
	 * @return int
	 */
	public function ResourceId()
	{
		return $this->resourceIds[0];
	}

	/**
	 * @param int $resourceId
	 * @return bool
	 */
	public function ContainsResource($resourceId)
	{
		return in_array($resourceId, $this->resourceIds);
	}

	/**
	 * @param IRepeatOptions $repeatOptions
	 */
	public function Repeats(IRepeatOptions $repeatOptions)
	{
		$this->repeatOptions = $repeatOptions;
		foreach ($repeatOptions->GetDates($this->blackoutDate) as $date)
		{
			$this->AddBlackout(new Blackout($date));
		}
	}

	/**
	 * @return string
	 */
	public function RepeatType()
	{
		return $this->repeatOptions->RepeatType();
	}

	/**
	 * @return string
	 */
	public function RepeatConfiguration()
	{
		return $this->repeatOptions->ConfigurationString();
	}

	/**
	 * @return int
	 */
	public function Id()
	{
		return $this->seriesId;
	}

	protected function WithId($id)
	{
		$this->seriesId = $id;
	}

	public function SetCurrentBlackout(DateRange $date)
	{
		$this->blackoutDate = $date;
	}

	/**
	 * @param string[] $row
	 * @return BlackoutSeries
	 */
	public static function FromRow($row)
	{
		$series = new BlackoutSeries($row[ColumnNames::OWNER_USER_ID], $row[ColumnNames::BLACKOUT_TITLE]);
		$series->WithId($row[ColumnNames::BLACKOUT_SERIES_ID]);
		$series->SetCurrentBlackout(new DateRange(Date::FromDatabase($row[ColumnNames::BLACKOUT_START]), Date::FromDatabase($row[ColumnNames::BLACKOUT_END])));

		$configuration = RepeatConfiguration::Create($row[ColumnNames::REPEAT_TYPE], $row[ColumnNames::REPEAT_OPTIONS]);
		$factory = new RepeatOptionsFactory();
		$options = $factory->Create($row[ColumnNames::REPEAT_TYPE], $configuration->Interval, $configuration->TerminationDate,
										$configuration->Weekdays, $configuration->MonthlyType);

		$series->Repeats($options);

		return $series;
	}

	/**
	 * @return Blackout
	 */
	public function CurrentBlackout()
	{
		return $this->blackouts[$this->ToKey($this->blackoutDate)];
	}

	/**
	 * @param DateRange $date
	 * @return string
	 */
	private function ToKey(DateRange $date)
	{
		return $date->GetBegin()->Timestamp();
	}

	/**
	 * @return BlackoutResource[]
	 */
	public function Resources()
	{
		return $this->resources;
	}
}

class Blackout
{

	/**
	 * @var DateRange
	 */
	protected $date;

	/**
	 * @param DateRange $blackoutDate
	 */
	public function __construct($blackoutDate)
	{
		$this->date = $blackoutDate;
	}

	/**
	 * @return DateRange
	 */
	public function Date()
	{
		return $this->date;
	}

	/**
	 * @return Date
	 */
	public function StartDate()
	{
		return $this->date->GetBegin();
	}

	/**
	 * @return Date
	 */
	public function EndDate()
	{
		return $this->date->GetEnd();
	}
}

class BlackoutResource implements IResource
{
	private $id;
	private $name;
	private $scheduleId;
	private $adminGroupId;
	private $scheduleAdminGroupId;

	public function __construct($id, $name, $scheduleId, $adminGroupId = null, $scheduleAdminGroupId = null)
	{
		$this->id = $id;
		$this->name = $name;
		$this->scheduleId = $scheduleId;
		$this->adminGroupId = $adminGroupId;
		$this->scheduleAdminGroupId = $scheduleAdminGroupId;
	}

	/**
	 * @return int
	 */
	public function GetId()
	{
		return $this->id;
	}

	/**
	 * @return string
	 */
	public function GetName()
	{
		return $this->name;
	}

	/**
	 * @return int
	 */
	public function GetAdminGroupId()
	{
		return $this->adminGroupId;
	}

	/**
	 * @return int
	 */
	public function GetScheduleId()
	{
		return $this->scheduleId;
	}

	/**
	 * @return int
	 */
	public function GetScheduleAdminGroupId()
	{
		return $this->scheduleAdminGroupId;
	}

	/**
	 * @return int
	 */
	public function GetResourceId()
	{
		return $this->id;
	}
}

?>