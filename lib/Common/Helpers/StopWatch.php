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

class StopWatch
{
	/**
	 * @var float
	 */
	private $startTime;

	/**
	 * @var float
	 */
	private $stopTime;

	/**
	 * @var array|float[]
	 */
	private $times = array();

	public function Start()
	{
		$this->startTime = microtime(true);
	}

	public function Stop()
	{
		$this->stopTime = microtime(true);
	}

	/**
	 * @param string $label
	 */
	public function Record($label)
	{
		$this->times[$label] = microtime(true);
	}

	/**
	 * @param string $label
	 * @return float
	 */
	public function GetRecordSeconds($label)
	{
		return $this->times[$label] - $this->startTime;
	}

	/**
	 * @param string $label1
	 * @param string $label2
	 * @return float
	 */
	public function TimeBetween($label1, $label2)
	{
		return $this->times[$label1] - $this->times[$label2];
	}

	/**
	 * @return float
	 */
	public function GetTotalSeconds()
	{
		return $this->stopTime - $this->startTime;
	}
}

?>