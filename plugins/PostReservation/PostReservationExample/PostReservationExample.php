<?php
/**
Copyright 2014-2015 Nick Korbel

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

class PostReservationExample implements IPostReservationFactory
{
    /**
     * @var PostReservationFactory
     */
    private $factoryToDecorate;

    public function __construct(PostReservationFactory $factoryToDecorate)
    {
        $this->factoryToDecorate = $factoryToDecorate;
    }

	/**
	 * @param UserSession $userSession
	 * @return IReservationNotificationService
	 */
	public function CreatePostAddService(UserSession $userSession)
	{
		// custom logic to be executed
		$base = $this->factoryToDecorate->CreatePostAddService($userSession);
		return new PostReservationCreatedExample($base);
	}

	/**
	 * @param UserSession $userSession
	 * @return IReservationNotificationService
	 */
	public function CreatePostUpdateService(UserSession $userSession)
	{
		$base = $this->factoryToDecorate->CreatePostUpdateService($userSession);
		return new PostReservationUpdateExample($base);
	}

	/**
	 * @param UserSession $userSession
	 * @return IReservationNotificationService
	 */
	public function CreatePostDeleteService(UserSession $userSession)
	{
		// showing how to not add custom behavior during the post deletion stage
		return $this->factoryToDecorate->CreatePostAddService($userSession);
	}

	/**
	 * @param UserSession $userSession
	 * @return IReservationNotificationService
	 */
	public function CreatePostApproveService(UserSession $userSession)
	{
		// showing how to not add custom behavior during the post approval stage
		return $this->factoryToDecorate->CreatePostAddService($userSession);
	}
}

class PostReservationCreatedExample implements IReservationNotificationService
{
	/**
	 * @var IReservationNotificationService
	 */
	private $base;

	public function __construct(IReservationNotificationService $base)
	{
		$this->base = $base;
	}

	/**
	 * @param $reservationSeries ReservationSeries|ExistingReservationSeries
	 * @return void
	 */
	public function Notify($reservationSeries)
	{
		// implement any custom post reservation created logic here

		// then let the main application continue
		$this->base->Notify($reservationSeries);
	}
}

class PostReservationUpdateExample implements IReservationNotificationService
{
	/**
	 * @var IReservationNotificationService
	 */
	private $base;

	public function __construct(IReservationNotificationService $base)
	{
		$this->base = $base;
	}

	/**
	 * @param $reservationSeries ReservationSeries|ExistingReservationSeries
	 * @return void
	 */
	public function Notify($reservationSeries)
	{
		// implement any custom post reservation updated logic here

		// do not call the base Notify method if you want to completely override the base behavior
	}
}
