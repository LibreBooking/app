<?php
/**
 * Copyright 2014 Nick Korbel
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

require_once(ROOT_DIR . 'Domain/Access/AccessoryRepository.php');

class AccessoryResourceRule implements IReservationValidationRule
{
	/**
	 * @var IAccessoryRepository
	 */
	private $accessoryRepository;

	/**
	 * @var Resources
	 */
	private $strings;

	public function __construct(IAccessoryRepository $accessoryRepository)
	{
		$this->accessoryRepository = $accessoryRepository;
		$this->strings = Resources::GetInstance();
	}

	/**
	 * @param ReservationSeries $reservationSeries
	 * @return ReservationRuleResult
	 */
	public function Validate($reservationSeries)
	{
		$errors = array();
		$accessories = $this->accessoryRepository->LoadAll();

		/** @var ReservationAccessory[] $bookedAccessories */
		$bookedAccessories = array();
		$bookedResources = $reservationSeries->AllResourceIds();

		foreach ($reservationSeries->Accessories() as $accessory)
		{
			$bookedAccessories[$accessory->AccessoryId] = $accessory;
		}

		foreach ($accessories as $accessory)
		{
			if (!$accessory->IsTiedToResource())
			{
				continue;
			}

			if (count(array_intersect($accessory->ResourceIds(), $bookedAccessories)) == 0)
			{
				// accessory isn't tied to any resources being booked
				continue;
			}

			$allowedResources = array();

			foreach ($accessory->Resources() as $resource)
			{
				$allowedResources[] = $resource->ResourceId;

				if ($reservationSeries->ContainsResource($resource->ResourceId))
				{
					$this->CheckMinQuantity($resource, $accessory, $bookedAccessories, $errors);
					$this->CheckMaxQuantity($resource, $accessory, $bookedAccessories, $errors);
				}
			}

			$this->CheckAllowedAccessories($allowedResources, $bookedResources, $errors, $accessory->GetName());
		}

		return new ReservationRuleResult(count($errors) == 0, implode("\n", $errors));
	}

	/**
	 * @param ResourceAccessory $resource
	 * @param Accessory $accessory
	 * @param ReservationAccessory[] $bookedAccessories
	 * @param string[] $errors
	 */
	private function CheckMinQuantity($resource, $accessory, $bookedAccessories, &$errors)
	{
		if (!empty($resource->MinQuantity))
		{
			if (!array_key_exists($accessory->GetId(), $bookedAccessories) ||
					$bookedAccessories[$accessory->GetId()]->QuantityReserved < $resource->MinQuantity)
			{
				$errors[] = $this->strings->GetString('AccessoryMinQuantityErrorMessage', $resource->MinQuantity, $accessory->GetName());
			}
		}
	}

	/**
	 * @param ResourceAccessory $resource
	 * @param Accessory $accessory
	 * @param ReservationAccessory[] $bookedAccessories
	 * @param string[] $errors
	 */
	private function CheckMaxQuantity($resource, $accessory, $bookedAccessories, &$errors)
	{
		if (!empty($resource->MaxQuantity))
		{
			if (array_key_exists($accessory->GetId(), $bookedAccessories) && $bookedAccessories[$accessory->GetId()]->QuantityReserved > $resource->MaxQuantity)
			{
				$errors[] = $this->strings->GetString('AccessoryMinQuantityErrorMessage', $resource->MaxQuantity, $accessory->GetName());
			}
		}
	}

	/**
	 * @param int[] $allowedResources
	 * @param int[] $bookedResources
	 * @param string[] $errors
	 * @param string $accessoryName
	 */
	private function CheckAllowedAccessories($allowedResources, $bookedResources, &$errors, $accessoryName)
	{
//		echo "<br/>checking $accessoryName<br/>";
//		var_dump($allowedResources);
//		var_dump($bookedResources);
		if (count(array_intersect($allowedResources, $bookedResources)) == 0)
		{
			$errors[] = $this->strings->GetString('AccessoryResourceAssociationErrorMessage', $accessoryName);
		}
	}
}
 