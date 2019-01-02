<?php
/**
Copyright 2011-2019 Nick Korbel

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

require_once(ROOT_DIR . 'Controls/Control.php');

class AttributeControl extends Control
{
	public function __construct(SmartyPage $smarty)
	{
		parent::__construct($smarty);
	}

	public function PageLoad()
	{
		$templates[CustomAttributeTypes::CHECKBOX] = 'Checkbox.tpl';
		$templates[CustomAttributeTypes::MULTI_LINE_TEXTBOX] = 'MultiLineTextbox.tpl';
		$templates[CustomAttributeTypes::SELECT_LIST] = 'SelectList.tpl';
		$templates[CustomAttributeTypes::SINGLE_LINE_TEXTBOX] = 'SingleLineTextbox.tpl';
		$templates[CustomAttributeTypes::DATETIME] = 'Date.tpl';

		/** @var $attribute Attribute|CustomAttribute */
		$attribute = $this->Get('attribute');

		if (is_a($attribute, 'CustomAttribute'))
		{
			$attributeVal = $this->Get('value');
			$attribute = new Attribute($attribute, $attributeVal);
			$this->Set('attribute', $attribute);
		}

		$prefix = $this->Get('namePrefix');
		$idPrefix = $this->Get('idPrefix');

		$this->Set('attributeName', sprintf('%s%s[%s]', $prefix, FormKeys::ATTRIBUTE_PREFIX, $attribute->Id()));
		$this->Set('attributeId', sprintf('%s%s%s', $idPrefix, FormKeys::ATTRIBUTE_PREFIX, $attribute->Id()));
		$this->Display('Controls/Attributes/' . $templates[$attribute->Type()]);
	}
}