<?php
/**
Copyright 2011-2019 Nick Korbel

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

class PageableDataStore
{
	/**
	 * Returns a limited query based on page number and size
	 * If nulls are passed for both $pageNumber, $pageSize then all results are returned
	 *
	 * @param SqlCommand $command
	 * @param callback $listBuilder callback to for each row of results
	 * @param int|null $pageNumber
	 * @param int|null $pageSize
	 * @param string|null $sortField
	 * @param string|null $sortDirection
	 * @return PageableData
	 */
	public static function GetList($command, $listBuilder, $pageNumber = null, $pageSize = null, $sortField = null, $sortDirection = null)
	{
		$total = null;
		$totalCounter = 0;
		$results = array();
		$db = ServiceLocator::GetDatabase();
		$pageNumber = intval($pageNumber);
		$pageSize = intval($pageSize);

        if (!empty($sortField))
        {
            $command = new SortCommand($command, $sortField, $sortDirection);
        }

		if ((empty($pageNumber) && empty($pageSize)) || $pageSize == PageInfo::All)
		{
			$resultReader = $db->Query($command);
		}
		else
		{
			$totalReader = $db->Query(new CountCommand($command));
			if ($row = $totalReader->GetRow())
			{
				$total = $row[ColumnNames::TOTAL];
			}

			$pageNumber = empty($pageNumber) ? 1 : $pageNumber;
			$pageSize = empty($pageSize) ? 1 : $pageSize;

			$resultReader = $db->LimitQuery($command, $pageSize, ($pageNumber - 1) * $pageSize);
		}

		while ($row = $resultReader->GetRow())
		{
			$results[] = call_user_func($listBuilder, $row);
			$totalCounter++;
		}
		$resultReader->Free();

		return new PageableData($results, is_null($total) ? $totalCounter : $total, $pageNumber, $pageSize);
	}
}

class PageableData
{
	private $results = array();

	public function __construct($results = array(), $total = 0, $pageNumber = 1, $pageSize = 1)
	{
		$this->results = $results;

		$pageNumber = empty($pageNumber) ? 1 : intval($pageNumber);
		$pageSize = empty($pageSize) ? 1 : intval($pageSize);

		$this->pageInfo = PageInfo::Create($total, $pageNumber, $pageSize);
	}

	/**
	 * @return array|mixed
	 */
	public function Results()
	{
		return $this->results;
	}

	/**
	 * @return PageInfo
	 */
	public function PageInfo()
	{
		return $this->pageInfo;
	}
}

class PageInfo
{
	const All = -1;

	public $Total = 0;
	public $TotalPages = 0;
	public $PageSize = 0;
	public $CurrentPage = 0;
    public $ResultsStart = 0;
    public $ResultsEnd = 0;

    public function __construct($totalResults, $pageNumber, $pageSize)
	{
		$this->Total = $totalResults;
		$this->CurrentPage = $pageNumber;
		$this->PageSize = $pageSize;
		$this->TotalPages = ceil($totalResults/max($pageSize, 1));
        $this->ResultsStart = ($pageNumber-1) * $pageSize + 1;
        $this->ResultsEnd = min(($pageNumber * $pageSize), $totalResults);
	}

	public static function Create($total, $pageNumber, $pageSize)
	{
		if ($pageSize == self::All)
		{
			return new PageInfoAll($total);
		}

		return new PageInfo($total, $pageNumber, $pageSize);
	}
}

class PageInfoAll extends PageInfo
{
	public function __construct($totalResults)
	{
		$defaultPageSize = Configuration::Instance()->GetKey(ConfigKeys::DEFAULT_PAGE_SIZE);
	    parent::__construct($totalResults, 1, $defaultPageSize);
		$this->TotalPages = 1;
		$this->ResultsStart = 1;
		$this->ResultsEnd = $totalResults;
	}
}