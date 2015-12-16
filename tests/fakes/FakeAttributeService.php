<?php
/**
Copyright 2015 Nick Korbel

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

class FakeAttributeService implements IAttributeService
{

	/**
	 * @param $category CustomAttributeCategory|int
	 * @param $entityIds array|int[]|int
	 * @return IEntityAttributeList
	 */
	public function GetAttributes($category, $entityIds = array())
	{
		// TODO: Implement GetAttributes() method.
	}

	/**
	 * @param $category int|CustomAttributeCategory
	 * @param $attributeValues AttributeValue[]|array
	 * @param $entityIds int[]
	 * @param bool $ignoreEmpty
	 * @param bool $isAdmin
	 * @return AttributeServiceValidationResult
	 */
	public function Validate($category, $attributeValues, $entityIds = array(), $ignoreEmpty = false, $isAdmin = false)
	{
		// TODO: Implement Validate() method.
	}

	/**
	 * @param $category int|CustomAttributeCategory
	 * @return array|CustomAttribute[]
	 */
	public function GetByCategory($category)
	{
		// TODO: Implement GetByCategory() method.
	}

	/**
	 * @param $attributeId int
	 * @return CustomAttribute
	 */
	public function GetById($attributeId)
	{
		// TODO: Implement GetById() method.
	}

	/**
	 * @param UserSession $userSession
	 * @param ReservationView $reservationView
	 * @param int $requestedUserId
	 * @return Attribute[]
	 */
	public function GetReservationAttributes(UserSession $userSession, ReservationView $reservationView, $requestedUserId = 0, $requestedResourceIds = array())
	{
		// TODO: Implement GetReservationAttributes() method.
	}
}