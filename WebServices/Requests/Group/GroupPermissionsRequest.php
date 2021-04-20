<?php

require_once(ROOT_DIR . 'lib/WebService/JsonRequest.php');

class GroupPermissionsRequest extends JsonRequest
{
    /**
     * @var int[]|null
     */
    public $permissions;

    /**
     * @var int[]|null
     */
    public $viewPermissions;

    /**
     * @return ExampleGroupPermissionsRequest
     */
    public static function Example()
    {
        return new ExampleGroupPermissionsRequest();
    }
}

class ExampleGroupPermissionsRequest extends GroupPermissionsRequest
{
    public function __construct()
    {
        $this->permissions = [4, 5, 6];
        $this->viewPermissions = [1, 2, 3];
    }
}
