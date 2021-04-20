<?php

class CustomAttributeCreatedResponse extends RestResponse
{
	public $attributeId;

	public function __construct(IRestServer $server, $attributeId)
	{
		$this->message = 'The attribute was created';
		$this->attributeId = $attributeId;
		$this->AddService($server, WebServices::GetCustomAttribute, array(WebServiceParams::AttributeId => $attributeId));
		$this->AddService($server, WebServices::UpdateCustomAttribute, array(WebServiceParams::AttributeId => $attributeId));
		$this->AddService($server, WebServices::DeleteCustomAttribute, array(WebServiceParams::AttributeId => $attributeId));
	}

	public static function Example()
	{
		return new ExampleCustomAttributeCreatedResponse();
	}
}

class CustomAttributeUpdatedResponse extends RestResponse
{
	public $attributeId;

	public function __construct(IRestServer $server, $attributeId)
	{
		$this->message = 'The attribute was updated';
		$this->attributeId = $attributeId;
		$this->AddService($server, WebServices::GetCustomAttribute, array(WebServiceParams::AttributeId => $attributeId));
		$this->AddService($server, WebServices::UpdateCustomAttribute, array(WebServiceParams::AttributeId => $attributeId));
	}

	public static function Example()
	{
		return new ExampleCustomAttributeCreatedResponse();
	}
}

class ExampleCustomAttributeCreatedResponse extends CustomAttributeCreatedResponse
{
	public function __construct()
	{
		$this->attributeId = 1;
		$this->AddLink('http://url/to/attribute', WebServices::GetCustomAttribute);
		$this->AddLink('http://url/to/update/attribute', WebServices::UpdateCustomAttribute);
	}
}
