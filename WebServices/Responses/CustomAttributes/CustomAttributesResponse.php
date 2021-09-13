<?php

require_once(ROOT_DIR . 'lib/WebService/namespace.php');
require_once(ROOT_DIR . 'WebServices/Responses/CustomAttributes/CustomAttributeDefinitionResponse.php');

class CustomAttributesResponse extends RestResponse
{
    /**
     * @var array|CustomAttributeDefinitionResponse[]
     */
    public $attributes = [];

    /**
     * @param IRestServer $server
     * @param array|CustomAttribute[] $attributes
     */
    public function __construct(IRestServer $server, $attributes)
    {
        foreach ($attributes as $attribute) {
            $this->attributes[] = new CustomAttributeDefinitionResponse($server, $attribute);
        }
    }

    public static function Example()
    {
        return new ExampleCustomAttributesResponse();
    }
}

class ExampleCustomAttributesResponse extends CustomAttributesResponse
{
    public function __construct()
    {
        $this->attributes = [CustomAttributeDefinitionResponse::Example()];
    }
}
