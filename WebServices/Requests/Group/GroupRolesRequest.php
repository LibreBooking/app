<?php

require_once(ROOT_DIR . 'lib/WebService/JsonRequest.php');

class GroupRolesRequest extends JsonRequest
{
    /**
     * @var int[]|null
     */
    public $roleIds;

    /**
     * @return ExampleGroupRolesRequest
     */
    public static function Example()
    {
        return new ExampleGroupRolesRequest();
    }
}

class ExampleGroupRolesRequest extends GroupRolesRequest
{
    public function __construct()
    {
        $this->roleIds = [RoleLevel::GROUP_ADMIN, RoleLevel::APPLICATION_ADMIN, RoleLevel::RESOURCE_ADMIN, RoleLevel::SCHEDULE_ADMIN];
    }
}
