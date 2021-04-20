<?php

require_once(ROOT_DIR . 'lib/WebService/JsonRequest.php');

class GroupUsersRequest extends JsonRequest
{
    /**
     * @var int[]|null
     */
    public $userIds;

    /**
     * @return ExampleGroupUsersRequest
     */
    public static function Example()
    {
        return new ExampleGroupUsersRequest();
    }
}

class ExampleGroupUsersRequest extends GroupUsersRequest
{
    public function __construct()
    {
        $this->userIds = [4, 5, 6];
    }
}
