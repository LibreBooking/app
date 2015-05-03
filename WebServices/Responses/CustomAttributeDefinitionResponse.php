<?php
/**
Copyright 2012-2015 Nick Korbel

This file is part of Booked Scheduler.

Booked Scheduler is free software: you can redistribute it and/or modify
it under the terms of the GNU General Public License as published by
the Free Software Foundation, either version 3 of the License, or
(at your option) any later version.

Booked Scheduler is distributed in the hope that it will be useful,
but WITHOUT ANY WARRANTY; without even the implied warranty of
MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
GNU General Public License for more details.

You should have received a copy of the GNU General Public License
along with Booked Scheduler.  If not, see <http://www.gnu.org/licenses/>.
 */

require_once(ROOT_DIR . 'lib/WebService/namespace.php');

class CustomAttributeDefinitionResponse extends RestResponse
{
	public $id;
	public $categoryId;
	public $label;
	public $possibleValues = array();
	public $regex;
	public $required = false;

	public function __construct(IRestServer $server, CustomAttribute $attribute)
	{
		$this->id = $attribute->Id();
		$this->categoryId = $attribute->Category();
		$this->label = $attribute->Label();
		$this->possibleValues = $attribute->PossibleValueList();
		$this->regex = $attribute->Regex();
		$this->required = $attribute->Required();

		$this->AddService($server, WebServices::AllCustomAttributes,
						  array(WebServiceParams::AttributeCategoryId => $this->categoryId));
		$this->AddService($server, WebServices::GetCustomAttribute, array(WebServiceParams::AttributeId => $this->id));
	}

	public static function Example()
	{
		return new ExampleCustomAttributeDefinitionResponse();
	}
}

class ExampleCustomAttributeDefinitionResponse extends CustomAttributeDefinitionResponse
{
	public function __construct()
	{
		$this->id = 1;
		$this->categoryId = CustomAttributeCategory::RESOURCE;
		$this->label = 'display label';
		$this->possibleValues = array('possible', 'values');
		$this->regex = 'validation regex';
		$this->required = true;
	}
}

?>