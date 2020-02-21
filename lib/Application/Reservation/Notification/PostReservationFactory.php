<?php
/**
Copyright 2012-2020 Nick Korbel

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

interface IPostReservationFactory
{
    /**
     * @param UserSession $userSession
     * @return IReservationNotificationService
     */
    public function CreatePostAddService(UserSession $userSession);

    /**
     * @param UserSession $userSession
     * @return IReservationNotificationService
     */
    public function CreatePostUpdateService(UserSession $userSession);

    /**
     * @param UserSession $userSession
     * @return IReservationNotificationService
     */
    public function CreatePostDeleteService(UserSession $userSession);

    /**
     * @param UserSession $userSession
     * @return IReservationNotificationService
     */
    public function CreatePostApproveService(UserSession $userSession);

    /**
     * @param UserSession $userSession
     * @return IReservationNotificationService
     */
    public function CreatePostCheckinService(UserSession $userSession);

    /**
     * @param UserSession $userSession
     * @return IReservationNotificationService
     */
    public function CreatePostCheckoutService(UserSession $userSession);
}

class PostReservationFactory implements IPostReservationFactory
{
    /**
     * @param UserSession $userSession
     * @return IReservationNotificationService
     */
    public function CreatePostAddService(UserSession $userSession)
    {
        return new AddReservationNotificationService(new UserRepository(), new ResourceRepository(), new AttributeRepository());
    }

    /**
     * @param UserSession $userSession
     * @return IReservationNotificationService
     */
    public function CreatePostUpdateService(UserSession $userSession)
    {
        return new UpdateReservationNotificationService(new UserRepository(), new ResourceRepository(), new AttributeRepository());
    }

    /**
     * @param UserSession $userSession
     * @return IReservationNotificationService
     */
    public function CreatePostDeleteService(UserSession $userSession)
    {
        return new DeleteReservationNotificationService(new UserRepository(), new AttributeRepository());
    }

    /**
     * @param UserSession $userSession
     * @return IReservationNotificationService
     */
    public function CreatePostApproveService(UserSession $userSession)
    {
        return new ApproveReservationNotificationService(new UserRepository(), new ResourceRepository(), new AttributeRepository());
    }

    /**
     * @param UserSession $userSession
     * @return IReservationNotificationService
     */
    public function CreatePostCheckinService(UserSession $userSession)
    {
        return new NullReservationNotificationService();
    }

    /**
     * @param UserSession $userSession
     * @return IReservationNotificationService
     */
    public function CreatePostCheckoutService(UserSession $userSession)
    {
        return new NullReservationNotificationService();
    }
}