<?php
/**
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

   This is an example how to write a post-reservation plugin. 
   It's currently under construction. 
   
   Originally posted on http://php.brickhost.com/forums/index.php?topic=11208.0
   Copyright (C) 2012 Matthew Dilley 
   Copyright (C) 2013 Alois Schloegl

 */

class PostReservationExample extends PostReservationFactory
{
    /**
     * @var PosteReservationFactory
     */
    private $factoryToDecorate;

    public function __construct(PostReservationFactory $factoryToDecorate)
    {
        $this->factoryToDecorate = $factoryToDecorate;
//        echo "constructed PostReservactionExample";
    }

    public function CreatePostAddService(UserSession $userSession)
    {
//        echo "called CreatePostAddService";

        // FIXME: show how to access the reservation 

        return $this->factoryToDecorate->CreatePostAddService($userSession);
    }

    /**
     * @param UserSession $userSession
     * @return IReservationNotificationService
     */
    public function CreatePostUpdateService(UserSession $userSession)
    {
//        echo "called CreatePostUpdateService";
        $value = $this->factoryToDecorate->CreatePostUpdateService($userSession);

        // FIXME: show how to access the reservation 

        return $value; 
    }

    /**
     * @param UserSession $userSession
     * @return IReservationNotificationService
     */
    public function CreatePostDeleteService(UserSession $userSession)
    {
//        echo "called CreatePostDeleteService";
        $value = $this->factoryToDecorate->CreatePostDeleteService($userSession);

        // FIXME: show how to access the reservation 

        return $value;
    }

    /**
     * @param UserSession $userSession
     * @return IReservationNotificationService
     */
    public function CreatePostApproveService(UserSession $userSession)
    {
//        echo "called CreatePostApproveService";
        return $this->factoryToDecorate->CreatePostApproveService($userSession);
    }
 
}

?>

