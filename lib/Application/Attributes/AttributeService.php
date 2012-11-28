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

require_once(ROOT_DIR . 'lib/Common/Helpers/StopWatch.php');

interface IAttributeService
{
	/**
	 * @abstract
	 * @param $category CustomAttributeCategory|int
	 * @param $entityIds array|int[]
	 * @return IEntityAttributeList
	 */
	public function GetAttributes($category, $entityIds);

	/**
	 * @param $category int|CustomAttributeCategory
	 * @param $attributeValues AttributeValue[]|array
	 * @return AttributeServiceValidationResult
	 */
	public function Validate($category, $attributeValues);

	/**
	 * @abstract
	 * @param $category int|CustomAttributeCategory
	 * @return array|CustomAttribute[]
	 */
	public function GetByCategory($category);

	/**
	 * @abstract
	 * @param $attributeId int
	 * @return CustomAttribute
	 */
	public function GetById($attributeId);
}

class AttributeService implements IAttributeService
{
	/**
	 * @var IAttributeRepository
	 */
	private $attributeRepository;

	public function __construct(IAttributeRepository $attributeRepository)
	{
		$this->attributeRepository = $attributeRepository;
	}

	public function GetAttributes($category, $entityIds)
	{
		$attributeList = new AttributeList();
		$attributes = $this->attributeRepository->GetByCategory($category);

		$stopwatch = new StopWatch();
		$stopwatch->Start();
		$values = $this->attributeRepository->GetEntityValues($category, $entityIds);

		foreach ($attributes as $attribute)
		{
			$attributeList->AddDefinition($attribute);
		}

		foreach ($values as $value)
		{
			$attributeList->AddValue($value);
		}
		$stopwatch->Stop();

		Log::Debug('Took %d seconds to load custom attributes for category %s', $stopwatch->GetTotalSeconds(), $category);

		return $attributeList;
	}

	public function Validate($category, $attributeValues)
	{
		$isValid = true;
		$errors = array();

		$resources = Resources::GetInstance();

		$values = array();
		foreach ($attributeValues as $av)
		{
			$values[$av->AttributeId] = $av->Value;
		}

		$attributes = $this->attributeRepository->GetByCategory($category);
		foreach ($attributes as $attribute)
		{
			$value = $values[$attribute->Id()];
			$label = $attribute->Label();

			if (!$attribute->SatisfiesRequired($value))
			{
				$isValid = false;
				$errors[] = $resources->GetString('CustomAttributeRequired', $label);
			}

			if (!$attribute->SatisfiesConstraint($value))
			{
				$isValid = false;
				$errors[] = $resources->GetString('CustomAttributeInvalid', $label);
			}
		}

		return new AttributeServiceValidationResult($isValid, $errors);
	}

	public function GetByCategory($category)
	{
		return $this->attributeRepository->GetByCategory($category);
	}


	public function GetById($attributeId)
	{
		return $this->attributeRepository->LoadById($attributeId);
	}
}

class AttributeServiceValidationResult
{
	/**
	 * @var int
	 */
	private $isValid;

	/**
	 * @var array|string[]
	 */
	private $errors;

	/**
	 * @param $isValid int
	 * @param $errors string[]|array
	 */
	public function __construct($isValid, $errors)
	{
		$this->isValid = $isValid;
		$this->errors = $errors;
	}

	public function IsValid()
	{
		return $this->isValid;
	}

	public function Errors()
	{
		return $this->errors;
	}
}

?>