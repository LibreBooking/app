<?php

/**
 * Copyright 2017-2019 Nick Korbel
 *
 * This file is part of Booked Scheduler.
 *
 * Booked Scheduler is free software: you can redistribute it and/or modify
 * it under the terms of the GNU General Public License as published by
 * the Free Software Foundation, either version 3 of the License, or
 * (at your option) any later version.
 *
 * Booked Scheduler is distributed in the hope that it will be useful,
 * but WITHOUT ANY WARRANTY; without even the implied warranty of
 * MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
 * GNU General Public License for more details.
 *
 * You should have received a copy of the GNU General Public License
 * along with Booked Scheduler.  If not, see <http://www.gnu.org/licenses/>.
 */

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
