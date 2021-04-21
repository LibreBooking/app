<?php

class ReservationUserView
{
    public $UserId;
    public $FirstName;
    public $LastName;
    public $Email;
    public $LevelId;
    public $FullName;

    public function __construct($userId, $firstName, $lastName, $email, $levelId)
    {
        $this->UserId = $userId;
        $this->FirstName = $firstName;
        $this->LastName = $lastName;
        $this->FullName = $firstName . ' ' . $lastName;
        $this->Email = $email;
        $this->LevelId = $levelId;
    }

    public function IsOwner()
    {
        return $this->LevelId == ReservationUserLevel::OWNER;
    }

    public function __toString()
    {
        return $this->UserId;
    }
}
