<?php

class GroupItemResponse extends RestResponse
{
    /**
     * @var int
     */
    public $id;

    /**
     * @var string
     */
    public $name;

    /**
     * @var bool
     */
    public $isDefault;

    public function __construct(IRestServer $server, GroupItemView $group)
    {
        $this->id = $group->Id();
        $this->name = $group->Name();
        $this->isDefault = (bool)$group->IsDefault();

        $this->AddService($server, WebServices::GetGroup, [WebServiceParams::GroupId => $group->Id()]);
    }

    public static function Example()
    {
        return new ExampleGroupItemResponse();
    }
}

class ExampleGroupItemResponse extends GroupItemResponse
{
    public function __construct()
    {
        $this->id = 1;
        $this->name = 'group name';
        $this->isDefault = true;
    }
}
