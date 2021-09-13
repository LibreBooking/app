<?php

require_once(ROOT_DIR . 'lib/WebService/namespace.php');

class UserUpdatedResponse extends RestResponse
{
    public $userId;

    public function __construct(IRestServer $server, $userId)
    {
        $this->userId = $userId;
        $this->AddService($server, WebServices::GetUser, [WebServiceParams::UserId => $userId]);
        $this->AddService($server, WebServices::UpdateUser, [WebServiceParams::UserId => $userId]);
    }

    public static function Example()
    {
        return new ExampleUserUpdatedResponse();
    }
}

class ExampleUserUpdatedResponse extends UserCreatedResponse
{
    public function __construct()
    {
        $this->AddLink('http://url/to/user', WebServices::GetUser);
        $this->AddLink('http://url/to/update/user', WebServices::UpdateUser);
    }
}
