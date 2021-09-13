<?php

require_once(ROOT_DIR . 'lib/WebService/namespace.php');

class AccountActionResponse extends RestResponse
{
    public $userId;

    public function __construct(IRestServer $server, $userId)
    {
        $this->userId = $userId;
        $this->AddService($server, WebServices::GetAccount, [WebServiceParams::UserId => $userId]);
        $this->AddService($server, WebServices::UpdateAccount, [WebServiceParams::UserId => $userId]);
    }

    public static function Example()
    {
        return new ExampleAccountActionResponse();
    }
}

class ExampleAccountActionResponse extends AccountActionResponse
{
    public function __construct()
    {
        $this->AddLink('http://url/to/account', WebServices::GetAccount);
        $this->AddLink('http://url/to/update/account', WebServices::UpdateAccount);
    }
}
