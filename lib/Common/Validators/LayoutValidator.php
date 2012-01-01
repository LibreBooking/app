<?php
/**
Copyright 2011-2012 Nick Korbel

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


class LayoutValidator extends ValidatorBase implements IValidator
{
	/**
	 * @var string
	 */
	private $reservableSlots;

	/**
	 * @var string
	 */
	private $blockedSlots;

	/**
	 * @param string $reservableSlots
	 * @param string $blockedSlots
	 */
	public function __construct($reservableSlots, $blockedSlots)
	{
		$this->reservableSlots = $reservableSlots;
		$this->blockedSlots = $blockedSlots;
	}

	/**
	 * @return void
	 */
	public function Validate()
	{
		try
		{
			$this->isValid = true;

			$layout = ScheduleLayout::Parse('UTC', $this->reservableSlots, $this->blockedSlots);
			$slots = $layout->GetLayout(Date::Now()->ToUtc());

			/** @var $firstDate Date */
			$firstDate = $slots[0]->BeginDate();
			/** @var $lastDate Date */
			$lastDate = $slots[count($slots) - 1]->EndDate();
			if (!$firstDate->IsMidnight() || !$lastDate->IsMidnight())
			{
				$this->isValid = false;
			}

			for ($i = 0; $i < count($slots) - 1; $i++)
			{
				if (!$slots[$i]->EndDate()->Equals($slots[$i + 1]->BeginDate()))
				{
					$this->isValid = false;
				}
			}
		}
		catch (Exception $ex)
		{
			$this->isValid = false;
		}
	}

}
