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
	 * @var int|null
	 */
	private $entityId;

	/**
	 * @var bool
	 */
	private $ignoreEmpty;

	/**
	 * @var bool
	 */
	private $isAdmin;

	/**
	 * @param IAttributeService $service
	 * @param $category int|CustomAttributeCategory
	 * @param $attributes AttributeValue|array|AttributeValue[]
	 * @param $entityId int
	 * @param bool $ignoreEmpty
	 * @param bool $isAdmin
	 */
	public function __construct(IAttributeService $service, $category, $attributes, $entityId = null, $ignoreEmpty = false, $isAdmin = false)
	{
		$this->service = $service;
		$this->category = $category;
		$this->attributes = is_array($attributes) ? $attributes : array($attributes);
		$this->entityId = $entityId;
		$this->ignoreEmpty = $ignoreEmpty;
		$this->isAdmin = $isAdmin;
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

		$result = $this->service->Validate($this->category, $this->attributes, $this->entityId, $this->ignoreEmpty, $this->isAdmin);
		$this->isValid = $result->IsValid();
		$this->messages = $result->Errors();
	}

	public function Messages()
	{
		return $this->messages;
	}

}

class AttributeValidatorInline extends AttributeValidator
{
	public function ReturnsErrorResponse()
	{
		return true;
	}
}