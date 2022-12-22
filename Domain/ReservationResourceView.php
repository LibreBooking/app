<?php

require_once(ROOT_DIR . 'Domain/BookableResource.php');

class ReservationResourceView implements IResource
{
    private $id;
    private $resourceName;
    private $adminGroupId;
    private $scheduleId;
    private $scheduleAdminGroupId;
    private $statusId;
    private $checkinEnabled;
    private $autoReleaseMinutes;
    private $color;

    public function __construct(
        $resourceId,
        $resourceName,
        $adminGroupId,
        $scheduleId,
        $scheduleAdminGroupId,
        $enableCheckin,
        $autoReleaseMinutes,
        $statusId = ResourceStatus::AVAILABLE
    ) {
        $this->id = $resourceId;
        $this->resourceName = $resourceName;
        $this->adminGroupId = $adminGroupId;
        $this->scheduleId = $scheduleId;
        $this->scheduleAdminGroupId = $scheduleAdminGroupId;
        $this->statusId = $statusId;
        $this->checkinEnabled = $enableCheckin;
        $this->autoReleaseMinutes = $autoReleaseMinutes;
    }

    /**
     * @return int
     */
    public function Id()
    {
        return $this->id;
    }

    /**
     * @return string
     */
    public function Name()
    {
        return $this->resourceName;
    }

    /**
     * @return int|null
     */
    public function GetAdminGroupId()
    {
        return $this->adminGroupId;
    }

    /**
     * alias of GetId()
     * @return int
     */
    public function GetResourceId()
    {
        return $this->Id();
    }

    /**
     * @return int
     */
    public function GetId()
    {
        return $this->Id();
    }

    /**
     * @return string
     */
    public function GetName()
    {
        return $this->Name();
    }

    /**
     * @return int
     */
    public function GetScheduleId()
    {
        return $this->scheduleId;
    }

    /**
     * @return int
     */
    public function GetScheduleAdminGroupId()
    {
        return $this->scheduleAdminGroupId;
    }

    /**
     * @return int
     */
    public function GetStatusId()
    {
        return $this->statusId;
    }

    /**
     * @return bool
     */
    public function IsCheckInEnabled()
    {
        return $this->checkinEnabled;
    }

    /**
     * @return bool
     */
    public function IsAutoReleased()
    {
        return !is_null($this->autoReleaseMinutes);
    }

    /**
     * @return int|null
     */
    public function GetAutoReleaseMinutes()
    {
        return $this->autoReleaseMinutes;
    }

    public function SetColor($color)
    {
        $this->color = $color;
    }

    public function GetColor()
    {
        return $this->color;
    }
}
