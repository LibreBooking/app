<?php

/**
 * Copyright 2017 Nick Korbel
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

require_once(ROOT_DIR . 'lib/WebService/JsonRequest.php');

class CustomAttributeRequest extends JsonRequest
{
	/**
	 * @var string
	 */
	public $label;

	/**
	 * @var int|CustomAttributeTypes
	 */
	public $type;

	/**
	 * @var int|CustomAttributeCategory
	 */
	public $categoryId;

	/**
	 * @var string
	 */
	public $regex;

	/**
	 * @var bool
	 */
	public $required;

	/**
	 * @var array|string
	 */
	public $possibleValues;

	/**
	 * @var int
	 */
	public $sortOrder;

	/**
	 * @var int[]
	 */
	public $appliesToIds = array();

	/**
	 * @var bool
	 */
	public $adminOnly;

	/**
	 * @var bool
	 */
	public $isPrivate;

	/**
	 * @return ExampleCustomAttributeRequest
	 */
	public static function Example()
	{
		return new ExampleCustomAttributeRequest();
	}
}

class ExampleCustomAttributeRequest extends CustomAttributeRequest
{
	public function __construct()
	{
		$this->label = 'attribute name';
		$this->type = sprintf('Allowed values for type: %s (checkbox), %s (multi line), %s (select list), %s (single line)',
										CustomAttributeTypes::CHECKBOX,
										CustomAttributeTypes::MULTI_LINE_TEXTBOX,
										CustomAttributeTypes::SELECT_LIST,
										CustomAttributeTypes::SINGLE_LINE_TEXTBOX);

		$this->categoryId = sprintf('Allowed values for category: %s (reservation), %s (resource), %s (resource type), %s (user)',
										CustomAttributeCategory::RESERVATION,
										CustomAttributeCategory::RESOURCE,
										CustomAttributeCategory::RESOURCE_TYPE,
										CustomAttributeCategory::USER);

		$this->regex = 'validation regex';
		$this->required = true;
		$this->possibleValues = array('possible','values','only valid for select list');
		$this->sortOrder = 100;
		$this->appliesToIds = array(10);
		$this->adminOnly = true;
		$this->isPrivate = true;
	}
}
