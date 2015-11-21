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

	public function Validate($reservationSeries, $retryParameters)
	{
		$errors = array();

		/** @var ReservationAccessory[] $bookedAccessories */
		$bookedAccessories = array();

		foreach ($reservationSeries->Accessories() as $accessory)
		{
			$bookedAccessories[$accessory->AccessoryId] = $accessory;
		}

		$accessories = $this->accessoryRepository->LoadAll();

		$association = $this->GetResourcesAndRequiredAccessories($accessories);

//		if ($accessoriesCannotBeBookedWithGivenResources())
//		{
//
//		}
		$bookedResourceIds = $reservationSeries->AllResourceIds();
//		$missingAccessories = $association->GetAccessoriesMissingRequiredResources($bookedResourceIds, $bookedAccessories, $bookedResourceIds);
//		if (!empty($missingAccessories))
//		{
//			foreach ($missingAccessories as $accessory)
//			{
//				$errors[] = $this->strings->GetString('AccessoryResourceAssociationErrorMessage', $accessory->GetName());
//			}
//		}

		$badAccessories = $association->GetAccessoriesThatCannotBeBookedWithGivenResources($bookedAccessories, $bookedResourceIds);

		foreach($badAccessories as $accessoryName)
		{
			$errors[] = $this->strings->GetString('AccessoryResourceAssociationErrorMessage', $accessoryName);
		}

		foreach ($reservationSeries->AllResources() as $resource)
		{

			$resourceId = $resource->GetResourceId();
			if ($association->ContainsResource($resourceId))
			{
				/** @var Accessory[] $resourceAccessories */
				$resourceAccessories = $association->GetResourceAccessories($resourceId);
				foreach ($resourceAccessories as $accessory)
				{
					$accessoryId = $accessory->GetId();

					$resource = $accessory->GetResource($resourceId);
					if (!empty($resource->MinQuantity) && $bookedAccessories[$accessoryId]->QuantityReserved < $resource->MinQuantity)
					{
						$errors[] = $this->strings->GetString('AccessoryMinQuantityErrorMessage', array($resource->MinQuantity, $accessory->GetName()));
					}

					if (!empty($resource->MaxQuantity) && $bookedAccessories[$accessoryId]->QuantityReserved > $resource->MaxQuantity)
					{
						$errors[] = $this->strings->GetString('AccessoryMinQuantityErrorMessage', array($resource->MinQuantity, $accessory->GetName()));
					}
				}
			}
		}

		return new ReservationRuleResult(count($errors) == 0, implode("\n", $errors));
	}

	/**
	 * @param Accessory[] $accessories
	 * @return ResourceAccessoryAssociation
	 */
	private function GetResourcesAndRequiredAccessories($accessories)
	{
		$association = new ResourceAccessoryAssociation();
		foreach ($accessories as $accessory)
		{
			$association->AddAccessory($accessory);
			foreach ($accessory->Resources() as $resource)
			{
				$association->AddRelationship($resource, $accessory);
			}
		}

		return $association;
	}
}

class ResourceAccessoryAssociation
{
	private $resources = array();
	private $requiredResources = array();

	/** @var Accessory[] */
	private $accessories = array();

	/**
	 * @param ResourceAccessory $resource
	 * @param Accessory $accessory
	 */
	public function AddRelationship($resource, $accessory)
	{
		$this->resources[$resource->ResourceId][$accessory->GetId()] = $accessory;

		if (!empty($resource->MinQuantity))
		{
			$this->requiredResources[$accessory->GetId()][] = $resource->ResourceId;
		}
	}

//	/**
//	 * @param int[] $resourceIds
//	 * @param ReservationAccessory[] $bookedAccessories
//	 * @param int[] $bookedResourceIds
//	 * @return Accessory[]
//	 */
//	public function GetAccessoriesMissingRequiredResources($resourceIds, $bookedAccessories, $bookedResourceIds)
//	{
//		$accessories = array();
//
//		foreach ($this->requiredResources as $accessoryId => $requiredResourceIds)
//		{
//			if (!array_key_exists($accessoryId, $bookedAccessories))
//			{
//				// if this accessory isn't booked then we dont care if the resources are present
//				continue;
//			}
//
//			if (in_array($b))
//
//			$intersect = array_intersect($requiredResourceIds, $resourceIds);
//
//			if (count($intersect) != count($requiredResourceIds))
//			{
//				// this accessory can only be booked with specific resources
//				$accessories[] = $this->accessories[$accessoryId];
//			}
//		}
//
//		return $accessories;
//	}

	/**
	 * @param int $resourceId
	 * @return bool
	 */
	public function ContainsResource($resourceId)
	{
		return array_key_exists($resourceId, $this->resources);
	}

	/**
	 * @param int $resourceId
	 * @return Accessory[]
	 */
	public function GetResourceAccessories($resourceId)
	{
		return $this->resources[$resourceId];
	}

	/**
	 * @param Accessory $accessory
	 */
	public function AddAccessory(Accessory $accessory)
	{
		$this->accessories[$accessory->GetId()] = $accessory;
	}

	/**
	 * @param ReservationAccessory[] $bookedAccessories
	 * @param int[] $bookedResourceIds
	 * @return string[]
	 */
	public function GetAccessoriesThatCannotBeBookedWithGivenResources($bookedAccessories, $bookedResourceIds)
	{
		$badAccessories = array();

		$bookedAccessoryIds = array();
		foreach ($bookedAccessories as $accessory)
		{
			$bookedAccessoryIds[] = $accessory->AccessoryId;
		}

		foreach ($bookedResourceIds as $resourceId)
		{
			if (!$this->ContainsResource($resourceId))
			{
				continue;
			}
			$resourceAccessories = $this->GetResourceAccessories($resourceId);

			foreach ($bookedAccessoryIds as $accessoryId)
			{
				if (!array_key_exists($accessoryId, $resourceAccessories))
				{
					$badAccessories = $this->accessories[$accessoryId]->GetName();
				}
			}
		}

		return $badAccessories;

	}
}