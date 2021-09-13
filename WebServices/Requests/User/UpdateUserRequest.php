<?php

require_once(ROOT_DIR . 'WebServices/Requests/User/UserRequestBase.php');

class UpdateUserRequest extends UserRequestBase
{
    public static function Example()
    {
        $request = new UpdateUserRequest();
        $request->firstName = 'first';
        $request->lastName = 'last';
        $request->emailAddress = 'email@address.com';
        $request->userName = 'username';
        $request->timezone = 'America/Chicago';
        $request->phone = '123-456-7989';
        $request->organization = 'organization';
        $request->position = 'position';
        $request->customAttributes = [new AttributeValueRequest(99, 'attribute value')];
        $request->groups = [1,2,4];
        return $request;
    }
}
