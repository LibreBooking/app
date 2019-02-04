<?php

/**
 * Copyright 2017-2019 Nick Korbel
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

require_once(ROOT_DIR . 'Domain/ReservationWaitlistRequest.php');

interface IReservationWaitlistRepository
{
	/**
	 * @param ReservationWaitlistRequest $request
	 * @return int
	 */
	public function Add(ReservationWaitlistRequest $request);

	/**
	 * @return ReservationWaitlistRequest[]
	 */
	public function GetAll();

	/**
	 * @param int $waitlistId
	 * @return ReservationWaitlistRequest
	 */
	public function LoadById($waitlistId);

	/**
	 * @param ReservationWaitlistRequest $request
	 */
	public function Delete(ReservationWaitlistRequest $request);
}

class ReservationWaitlistRepository implements IReservationWaitlistRepository
{
	/**
	 * @param ReservationWaitlistRequest $request
	 * @return int
	 */
	public function Add(ReservationWaitlistRequest $request)
	{
		$command = new AddReservationWaitlistCommand($request->UserId(), $request->StartDate(), $request->EndDate(), $request->ResourceId());
		$id = ServiceLocator::GetDatabase()->ExecuteInsert($command);

		$request->WithId($id);

		return $id;
	}

	public function GetAll()
	{
		$reader = ServiceLocator::GetDatabase()->Query(new GetAllReservationWaitlistRequests());

		$requests = array();

		while ($row = $reader->GetRow())
		{
			$requests[] = ReservationWaitlistRequest::FromRow($row);
		}

		$reader->Free();

		return $requests;
	}

	public function Delete(ReservationWaitlistRequest $request)
	{
		ServiceLocator::GetDatabase()->Execute(new DeleteReservationWaitlistCommand($request->Id()));
	}

	public function LoadById($waitlistId)
	{
		$reader = ServiceLocator::GetDatabase()->Query(new GetReservationWaitlistRequestCommand($waitlistId));

		if ($row = $reader->GetRow())
		{
			$reader->Free();
			return ReservationWaitlistRequest::FromRow($row);
		}

		return null;
	}
}