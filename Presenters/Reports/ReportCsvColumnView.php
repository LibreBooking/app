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

class ReportCsvColumnView
{
	/**
	 * @var string[]
	 */
	private $selectedColumns;

	/**
	 * @var int[]
	 */
	private $skippedIterations = array();

	/**
	 * @var bool
	 */
	private $showAll;

	public function __construct($selectedColumns)
	{
		$this->selectedColumns = explode('!s!', $selectedColumns);
		$this->showAll = empty($selectedColumns);
	}

	public function ShouldShowCol(ReportColumn $column, $iteration)
	{
		if ($this->showAll)
		{
			return true;
		}

		$columnName = $column->HasTitle() ? $column->Title() : Resources::GetInstance()->GetString($column->TitleKey());
		if (in_array($columnName, $this->selectedColumns))
		{
			return true;
		}

		$this->skippedIterations[] = $iteration;
		return false;
	}

	public function ShouldShowCell($iteration)
	{
		if ($this->showAll)
		{
			return true;
		}

		return !in_array($iteration, $this->skippedIterations);
	}
}
