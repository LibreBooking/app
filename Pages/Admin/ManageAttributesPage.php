<?php
/**
Copyright 2012 Nick Korbel

This file is part of phpScheduleIt.

phpScheduleIt is free software: you can redistribute it and/or modify
it under the terms of the GNU General Public License as published by
the Free Software Foundation, either version 3 of the License, or
(at your option) any later version.

phpScheduleIt is distributed in the hope that it will be useful,
but WITHOUT ANY WARRANTY; without even the implied warranty of
MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
GNU General Public License for more details.

You should have received a copy of the GNU General Public License
along with phpScheduleIt.  If not, see <http://www.gnu.org/licenses/>.
*/

require_once(ROOT_DIR . 'Pages/Admin/AdminPage.php');
require_once(ROOT_DIR . 'Presenters/Admin/ManageAttributesPresenter.php');

interface IManageAttributesPage extends IActionPage
{
	/**
	 * @abstract
	 * return string
	 */
	public function GetLabel();

	/**
	 * @abstract
	 * return int|CustomAttributeTypes
	 */
	public function GetType();

	/**
	 * @abstract
	 * return int|CustomAttributeCategory
	 */
	public function GetCategory();

	/**
	 * @abstract
	 * return string
	 */
	public function GetValidationExpression();

	/**
	 * @abstract
	 * return bool
	 */
	public function GetIsRequired();

	/**
	 * @abstract
	 * return string
	 */
	public function GetPossibleValues();

	/**
	 * @abstract
	 * return int|CustomAttributeCategory
	 */
	public function GetRequestedCategory();

	/**
	 * @abstract
	 * @return int
	 */
	public function GetSortOrder();

	/**
	 * @abstract
	 * @param $attributes CustomAttribute[]|array
	 */
	public function BindAttributes($attributes);

	/**
	 * @abstract
	 * @param $categoryId int|CustomAttributeCategory
	 */
	public function SetCategory($categoryId);

	public function GetAttributeId();
}

class ManageAttributesPage extends AdminPage implements IManageAttributesPage
{
	/**
	 * @var ManageAttributesPresenter
	 */
	private $presenter;

	public function __construct()
	{
		parent::__construct('CustomAttributes');
		$this->presenter = new ManageAttributesPresenter($this, new AttributeRepository());
	}

	public function PageLoad()
	{
		$typeLookup = array(
							CustomAttributeTypes::SINGLE_LINE_TEXTBOX => 'SingleLineTextbox',
							CustomAttributeTypes::MULTI_LINE_TEXTBOX => 'MultiLineTextbox',
							CustomAttributeTypes::CHECKBOX => 'Checkbox',
							CustomAttributeTypes::SELECT_LIST => 'SelectList'
						);

		$this->Set('Types', $typeLookup);
		parent::PageLoad();
	}

	public function HandlePageLoad()
	{
		$this->presenter->PageLoad();
		$this->Display('Attributes/manage_attributes.tpl');
	}

	public function HandleDataRequest($dataRequest)
	{
		$this->presenter->HandleDataRequest($dataRequest);
	}

	public function ProcessAction()
	{
		$this->presenter->ProcessAction();
	}

	public function GetLabel()
	{
		return $this->GetForm(FormKeys::ATTRIBUTE_LABEL);
	}

	public function GetType()
	{
		return $this->GetForm(FormKeys::ATTRIBUTE_TYPE);
	}

	public function GetCategory()
	{
		return $this->GetForm(FormKeys::ATTRIBUTE_CATEGORY);
	}

	public function GetValidationExpression()
	{
		return $this->GetForm(FormKeys::ATTRIBUTE_VALIDATION_EXPRESSION);
	}

	public function GetIsRequired()
	{
		$required = $this->GetForm(FormKeys::ATTRIBUTE_IS_REQUIRED);
		return !empty($required);
	}

	public function GetPossibleValues()
	{
		return $this->GetForm(FormKeys::ATTRIBUTE_POSSIBLE_VALUES);
	}

	/**
	 * @return int
	 */
	public function GetSortOrder()
	{
		return $this->GetForm(FormKeys::ATTRIBUTE_SORT_ORDER);
	}

	public function GetRequestedCategory()
	{
		return $this->GetQuerystring(QueryStringKeys::ATTRIBUTE_CATEGORY);
	}

	public function BindAttributes($attributes)
	{
		$this->Set('Attributes', $attributes);
		$this->Display('Attributes/attribute-list.tpl');
	}

	public function SetCategory($categoryId)
	{
		$this->Set('Category', $categoryId);
	}

	public function GetAttributeId()
	{
		return $this->GetQuerystring(QueryStringKeys::ATTRIBUTE_ID);
	}
}

?>