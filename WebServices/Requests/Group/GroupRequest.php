<?php

require_once(ROOT_DIR . 'lib/WebService/JsonRequest.php');

class GroupRequest extends JsonRequest
{
    /**
     * @var string
     */
    public $name;

    /**
     * @var bool
     */
    public $isDefault = false;

    /**
     * @return ExampleGroupRequest
     */
    public static function Example()
    {
        return new ExampleGroupRequest();
    }
}

class ExampleGroupRequest extends GroupRequest
{
    public function __construct()
    {
        $this->name = 'group name';
        $this->isDefault = true;
    }
}
