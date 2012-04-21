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
	 * return int|CustomAttributeScope
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
		$this->presenter->PageLoad();

		$this->Display('manage_attributes.tpl');
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
}

?>