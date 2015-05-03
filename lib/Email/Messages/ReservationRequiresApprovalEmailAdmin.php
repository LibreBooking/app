<?php
/**
Copyright 2011-2015 Nick Korbel

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

require_once(ROOT_DIR . 'lib/Email/namespace.php');

class ReservationRequiresApprovalEmailAdmin extends ReservationCreatedEmailAdmin
{
	/**
	 * @param UserDto $adminDto
	 * @param User $reservationOwner
	 * @param ReservationSeries $reservationSeries
	 * @param IResource $primaryResource
	 * @param IAttributeRepository $attributeRepository
	 */
	public function __construct(UserDto $adminDto, User $reservationOwner, ReservationSeries $reservationSeries, IResource $primaryResource, IAttributeRepository $attributeRepository)
	{
		parent::__construct($adminDto, $reservationOwner, $reservationSeries, $primaryResource, $attributeRepository);
	}

	public function Subject()
	{
		return $this->Translate('ReservationApprovalAdminSubject');
	}
}