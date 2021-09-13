<?php

require_once(ROOT_DIR . 'lib/WebService/JsonRequest.php');
require_once(ROOT_DIR . 'WebServices/Requests/CustomAttributes/AttributeValueRequest.php');

abstract class UserRequestBase extends JsonRequest
{
    public $firstName;
    public $lastName;
    public $emailAddress;
    public $userName;
    public $timezone;
    public $phone;
    public $organization;
    public $position;
    /** @var array|AttributeValueRequest[] */
    public $customAttributes = [];
    /** @var array|int[] */
    public $groups = [];

    /**
     * @return array|AttributeValueRequest[]
     */
    public function GetCustomAttributes()
    {
        if (!empty($this->customAttributes)) {
            return $this->customAttributes;
        }
        return [];
    }
}
