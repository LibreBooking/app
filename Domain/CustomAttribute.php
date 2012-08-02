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

class CustomAttributeTypes
{
	const SINGLE_LINE_TEXTBOX = 1;
	const MULTI_LINE_TEXTBOX = 2;
	const SELECT_LIST = 3;
	const CHECKBOX = 4;
}

class CustomAttributeCategory
{
	const RESERVATION = 1;
	const USER = 2;
	//const GROUP = 3;
	const RESOURCE = 4;
}

class CustomAttribute
{
	/**
	 * @var int
	 */
	protected $id;

	/**
	 * @var string
	 */
	protected $label;

	/**
	 * @var CustomAttributeTypes|int
	 */
	protected $type;

	/**
	 * @var CustomAttributeCategory|int
	 */
	protected $category;

	/**
	 * @var string
	 */
	protected $regex;

	/**
	 * @var bool
	 */
	protected $required;

	/**
	 * @var string
	 */
	protected $possibleValues;

	/**
	 * @var int
	 */
	protected $sortOrder;

	/**
	 * @return int
	 */
	public function Id()
	{
		return $this->id;
	}

	/**
	 * @return string
	 */
	public function Label()
	{
		return $this->label;
	}

	/**
	 * @return string
	 */
	public function PossibleValues()
	{
		return $this->possibleValues;
	}

	/**
	 * @return array|string[]
	 */
	public function PossibleValueList()
	{
		return explode(',', $this->possibleValues);
	}

	/**
	 * @return string
	 */
	public function Regex()
	{
		return $this->regex;
	}

	/**
	 * @return boolean
	 */
	public function Required()
	{
		return $this->required;
	}

	/**
	 * @return \CustomAttributeCategory|int
	 */
	public function Category()
	{
		return $this->category;
	}

	/**
	 * @return \CustomAttributeTypes|int
	 */
	public function Type()
	{
		return $this->type;
	}

	/**
	 * @return int
	 */
	public function SortOrder()
	{
		return $this->sortOrder;
	}

	/**
	 * @param int $id
	 * @param string $label
	 * @param CustomAttributeTypes|int $type
	 * @param CustomAttributeCategory|int $category
	 * @param string $regex
	 * @param bool $required
	 * @param string $possibleValues
	 * @param int $sortOrder
	 * @return CustomAttribute
	 */
	public function __construct($id, $label, $type, $category, $regex, $required, $possibleValues, $sortOrder)
	{
		$this->id = $id;
		$this->label = $label;
		$this->type = $type;
		$this->category = $category;
		$this->regex = $regex;
		$this->required = $required;
		$this->SetSortOrder($sortOrder);
		$this->SetPossibleValues($possibleValues);
	}

	/**
	 * @static
	 * @param string $label
	 * @param CustomAttributeTypes|int $type
	 * @param CustomAttributeCategory|int $category
	 * @param string $regex
	 * @param bool $required
	 * @param string $possibleValues
	 * @param int $sortOrder
	 * @return CustomAttribute
	 */
	public static function Create($label, $type, $category, $regex, $required, $possibleValues, $sortOrder)
	{
		return new CustomAttribute(null, $label, $type, $category, $regex, $required, $possibleValues, $sortOrder);
	}

	/**
	 * @static
	 * @param $row array
	 * @return Attribute
	 */
	public static function FromRow($row)
	{
		return new CustomAttribute(
			$row[ColumnNames::ATTRIBUTE_ID],
			$row[ColumnNames::ATTRIBUTE_LABEL],
			$row[ColumnNames::ATTRIBUTE_TYPE],
			$row[ColumnNames::ATTRIBUTE_CATEGORY],
			$row[ColumnNames::ATTRIBUTE_CONSTRAINT],
			$row[ColumnNames::ATTRIBUTE_REQUIRED],
			$row[ColumnNames::ATTRIBUTE_POSSIBLE_VALUES],
			$row[ColumnNames::ATTRIBUTE_SORT_ORDER]
		);
	}

	/**
	 * @param $value mixed
	 * @return bool
	 */
	public function SatisfiesRequired($value)
	{
		if (!$this->required)
		{
			return true;
		}

		$trimmed = trim($value);
		return !empty($trimmed);
	}

	/**
	 * @param $value mixed
	 * @return bool
	 */
	public function SatisfiesConstraint($value)
	{
		if (!empty($this->regex))
		{
			return preg_match($this->regex, $value) > 0;
		}

		if (!empty($this->possibleValues))
		{
			if (!$this->required)
			{
				return true;
			}

			$list = $this->PossibleValueList();
			return in_array($value, $list);
		}

		return true;
	}

	/**
	 * @param string $label
	 * @param string $regex
	 * @param bool $required
	 * @param string $possibleValues
	 * @param int $sortOrder
	 */
	public function Update($label, $regex, $required, $possibleValues, $sortOrder)
	{
		$this->label = $label;
		$this->regex = $regex;
		$this->required = $required;
		$this->SetPossibleValues($possibleValues);
		$this->SetSortOrder($sortOrder);
	}

	/**
	 * @param string $possibleValues
	 */
	private function SetPossibleValues($possibleValues)
	{
		if (!empty($possibleValues))
		{
			$this->possibleValues = preg_replace('/\s*,\s*/', ',', trim($possibleValues));
		}
	}

	/**
	 * @param int $sortOrder
	 */
	private function SetSortOrder($sortOrder)
	{
		$this->sortOrder = intval($sortOrder);
	}
}

?>