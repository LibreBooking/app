<?php
/**
Copyright 2012 Nick Korbel

This file is part of phpScheduleIt.

phpScheduleIt is free software: you can redistribute it and/or modify
it under the terms of the GNU General Public License as published by
the Free Software Foundation, either version 3 of the License, or
(at your option) any later version.

phpScheduleIt is distributed in the hope that it will be useful,
but WITHOUT ANY WARRANTY; without even the implied warranty of
MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
GNU General Public License for more details.

You should have received a copy of the GNU General Public License
along with phpScheduleIt.  If not, see <http://www.gnu.org/licenses/>.
 */

interface ICannedReport
{
	/**
	 * @return ReportCommandBuilder
	 */
	public function GetBuilder();
}

class CannedReport implements ICannedReport
{
	const RESOURCE_COUNT_ALLTIME = 1;
	const RESOURCE_COUNT_THISWEEK = 2;
	const RESOURCE_COUNT_THISMONTH = 3;
	const RESOURCE_TIME_ALLTIME = 4;
	const RESOURCE_TIME_THISWEEK = 5;
	const RESOURCE_TIME_THISMONTH = 6;


	/**
	 * @var array
	 */
	private static $mapping = array(
		self::RESOURCE_COUNT_ALLTIME => 'ResourceCountAllTime',
		self::RESOURCE_COUNT_THISWEEK => 'ResourceCountThisWeek',
		self::RESOURCE_COUNT_THISMONTH => 'ResourceCountThisMonth',
		self::RESOURCE_TIME_ALLTIME => 'ResourceTimeAllTime',
		self::RESOURCE_TIME_THISWEEK => 'ResourceTimeThisWeek',
		self::RESOURCE_TIME_THISMONTH => 'ResourceTimeThisMonth',
	);

	/**
	 * @var UserSession
	 */
	private $user;

	/**
	 * @var string
	 */
	private $method;

	public function __construct($type, UserSession $userSession)
	{
		$this->user = $userSession;

		if (array_key_exists($type, self::$mapping))
		{
			$this->method = self::$mapping[$type];
		}
		else
		{
			throw new Exception("Unknown canned report: $type");
		}
	}

	/**
	 * @return ReportCommandBuilder
	 */
	public function GetBuilder()
	{
		$methodName = $this->method;
		return $this->$methodName();
	}

	private function ResourceCountAllTime()
	{
		$builder = new ReportCommandBuilder();
		$builder->SelectCount()
				->OfResources()
				->GroupByResource();

		return $builder;
	}

	private function ResourceCountThisWeek()
	{
		$range = new Report_Range(Report_Range::CURRENT_WEEK, null, null, $this->user->Timezone);
		$builder = $this->ResourceCountAllTime();
		$builder->Within($range->Start(), $range->End());

		return $builder;
	}

	private function ResourceCountThisMonth()
	{
		$range = new Report_Range(Report_Range::CURRENT_MONTH, null, null, $this->user->Timezone);
		$builder = $this->ResourceCountAllTime();
		$builder->Within($range->Start(), $range->End());

		return $builder;
	}

	private function ResourceTimeAllTime()
	{
		$builder = new ReportCommandBuilder();
		$builder->SelectTime()
				->OfResources()
				->GroupByResource();

		return $builder;
	}

	private function ResourceTimeThisWeek()
	{
		$range = new Report_Range(Report_Range::CURRENT_WEEK, null, null, $this->user->Timezone);
		$builder = $this->ResourceTimeAllTime();
		$builder->Within($range->Start(), $range->End());

		return $builder;
	}

	private function ResourceTimeThisMonth()
	{
		$range = new Report_Range(Report_Range::CURRENT_MONTH, null, null, $this->user->Timezone);
		$builder = $this->ResourceTimeAllTime();
		$builder->Within($range->Start(), $range->End());

		return $builder;
	}
}

?>