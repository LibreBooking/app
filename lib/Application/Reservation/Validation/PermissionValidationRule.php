<?php
/**
Copyright 2011-2020 Nick Korbel

This file is part of Booked Scheduler is free software: you can redistribute it and/or modify
it under the terms of the GNU General Public License as published by
the Free Software Foundation, either version 3 of the License, or
(at your option) any later version is distributed in the hope that it will be useful,
but WITHOUT ANY WARRANTY; without even the implied warranty of
MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
GNU General Public License for more details.

You should have received a copy of the GNU General Public License
along with Booked Scheduler.  If not, see <http://www.gnu.org/licenses/>.
*/

require_once(ROOT_DIR . 'lib/Application/Authorization/namespace.php');
require_once(ROOT_DIR . 'lib/Common/namespace.php');

class PermissionValidationRule implements IReservationValidationRule
{
	/**
	 * @var IPermissionServiceFactory
	 */
	private $permissionServiceFactory;

	public function __construct(IPermissionServiceFactory $permissionServiceFactory)
	{
		$this->permissionServiceFactory = $permissionServiceFactory;
	}

	/**
	 * @param ReservationSeries $reservationSeries
	 * @param $retryParameters
	 * @return ReservationRuleResult
	 */
	public function Validate($reservationSeries, $retryParameters)
	{
		$reservationSeries->UserId();

		$permissionService = $this->permissionServiceFactory->GetPermissionService();

		$resourceIds = $reservationSeries->AllResourceIds();

		foreach ($resourceIds as $resourceId)
		{
			if (!$permissionService->CanBookResource(new ReservationResource($resourceId), $reservationSeries->BookedBy()))
			{
				return new ReservationRuleResult(false, Resources::GetInstance()->GetString('NoResourcePermission'));
			}
		}

		return new ReservationRuleResult(true);
	}
}