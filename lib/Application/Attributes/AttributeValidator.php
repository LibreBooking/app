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

require_once(ROOT_DIR . 'lib/Common/Validators/namespace.php');

class AttributeValidator extends ValidatorBase
{
	/**
	 * @var IAttributeService
	 */
	private $service;

	/**
	 * @var CustomAttributeCategory|int
	 */
	private $category;

	/**
	 * @var array|AttributeValue[]
	 */
	private $attributes;

	/**
	 * @var array|string[]
	 */
	private $messages;

	/**
	 * @param IAttributeService $service
	 * @param $category int|CustomAttributeCategory
	 * @param $attributes array|AttributeValue[]
	 */
	public function __construct(IAttributeService $service, $category, $attributes)
	{
		$this->service = $service;
		$this->category = $category;
		$this->attributes = $attributes;
	}

	/**
	 * @return void
	 */
	public function Validate()
	{
		if (empty($this->attributes))
		{
			$this->isValid = true;
			return;
		}

		$result = $this->service->Validate($this->category, $this->attributes);
		$this->isValid = $result->IsValid();
		$this->messages = $result->Errors();
	}

	public function Messages()
	{
		return $this->messages;
	}

}
?>