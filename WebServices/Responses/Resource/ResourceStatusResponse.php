<?php

require_once(ROOT_DIR . 'lib/WebService/namespace.php');

class ResourceStatusResponse extends RestResponse
{
    public $statuses = [];

    public function __construct()
    {
        $this->statuses = [
            ['id' => ResourceStatus::HIDDEN, 'name' => 'Hidden'],
            ['id' => ResourceStatus::AVAILABLE, 'name' => 'Available'],
            ['id' => ResourceStatus::UNAVAILABLE, 'name' => 'Unavailable'],
        ];
    }
}
