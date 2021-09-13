<?php

class ReservationResource implements IPermissibleResource
{
    private $_id;
    private $_resourceName;

    public function __construct($resourceId, $resourceName = '')
    {
        $this->_id = $resourceId;
        $this->_resourceName = $resourceName;
    }

    public function GetResourceId()
    {
        return $this->_id;
    }

    public function GetName()
    {
        return $this->_resourceName;
    }

    public function GetId()
    {
        return $this->_id;
    }
}
