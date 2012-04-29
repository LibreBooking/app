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

require_once(ROOT_DIR . 'Domain/Access/namespace.php');
require_once(ROOT_DIR . 'Pages/Admin/ManageAttributesPage.php');

class ManageAttributesPresenterTests extends TestBase
{
	/**
	 * @var FakeAttributePage
	 */
	private $page;

	/**
	 * @var IAttributeRepository|PHPUnit_Framework_MockObject_MockObject
	 */
	private $attributeRepository;

	/**
	 * @var ManageAttributesPresenter
	 */
	private $presenter;

	public function setup()
	{
		parent::setup();

		$this->page = new FakeAttributePage();
		$this->attributeRepository = $this->getMock('IAttributeRepository');

		$this->presenter = new ManageAttributesPresenter($this->page, $this->attributeRepository);
	}
	
	public function testBindsAttributesForRequestedCategory()
	{
		$categoryId = CustomAttributeCategory::RESERVATION;
		$this->page->_requestedCategoryId = $categoryId;

		$attributes = array(CustomAttribute::Create('abc', CustomAttributeTypes::SINGLE_LINE_TEXTBOX, CustomAttributeCategory::RESERVATION, null, false, null));

		$this->attributeRepository->expects($this->once())
							->method('GetByCategory')
							->with($this->equalTo($categoryId))
							->will($this->returnValue($attributes));

		$this->presenter->PageLoad();

		$this->assertSame($attributes, $this->page->_boundAttributes);
	}
	
	public function testAddsNewAttribute()
	{
		$label = 'new label';
		$scope = CustomAttributeCategory::RESERVATION;
		$type = CustomAttributeTypes::SINGLE_LINE_TEXTBOX;
		$required = true;
		$regex = '/$\d^/';
		$possibleValues = '1,2,3';

		$this->page->_label = $label;
		$this->page->_type = $type;
		$this->page->_scope = $scope;
		$this->page->_required = $required;
		$this->page->_regex = $regex;
		$this->page->_possibleValues = $possibleValues;

		$expectedAttribute = CustomAttribute::Create($label, $type, $scope, $regex, $required, $possibleValues);

		$this->attributeRepository->expects($this->once())
					->method('Add')
					->with($this->equalTo($expectedAttribute))
					->will($this->returnValue(1));

		$this->presenter->AddAttribute();
	}
}

class FakeAttributePage extends FakeActionPageBase implements IManageAttributesPage
{
	public $_label;
	public $_type;
	public $_scope;
	public $_required;
	public $_regex;
	public $_possibleValues;
	public $_requestedCategoryId;
	public $_boundAttributes;

	public function GetLabel()
	{
		return $this->_label;
	}

	public function GetType()
	{
		return $this->_type;
	}

	public function GetCategory()
	{
		return $this->_scope;
	}

	public function GetValidationExpression()
	{
		return $this->_regex;
	}

	public function GetIsRequired()
	{
		return $this->_required;
	}

	public function GetPossibleValues()
	{
		return $this->_possibleValues;
	}

	public function GetRequestedCategory()
	{
		return $this->_requestedCategoryId;
	}

	public function BindAttributes($attributes)
	{
		$this->_boundAttributes = $attributes;
	}

	/**
	 * @param $categoryId int|CustomAttributeCategory
	 */
	public function SetCategory($categoryId)
	{
		// TODO: Implement SetCategory() method.
	}
}

?>