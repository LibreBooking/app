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

		$attributes = array(CustomAttribute::Create('abc', CustomAttributeTypes::SINGLE_LINE_TEXTBOX, CustomAttributeCategory::RESERVATION, null, false, null, null, null));

		$this->attributeRepository->expects($this->once())
				->method('GetByCategory')
				->with($this->equalTo($categoryId))
				->will($this->returnValue($attributes));

		$this->presenter->HandleDataRequest('');

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
		$sortOrder = "5";
		$entityId = 10;
		$adminOnly = true;
		$secondaryEntityId = 1029;

		$this->page->_label = $label;
		$this->page->_type = $type;
		$this->page->_category = $scope;
		$this->page->_required = $required;
		$this->page->_regex = $regex;
		$this->page->_possibleValues = $possibleValues;
		$this->page->_sortOrder = $sortOrder;
		$this->page->_entityId = $entityId;
		$this->page->_adminOnly = $adminOnly;
		$this->page->_limitAttributeScope = true;
		$this->page->_secondaryCategory = CustomAttributeCategory::USER;
		$this->page->_secondaryEntityId = $secondaryEntityId;

		$expectedAttribute = CustomAttribute::Create($label, $type, $scope, $regex, $required, $possibleValues, $sortOrder, $entityId, $adminOnly);
		$expectedAttribute->WithSecondaryEntity(CustomAttributeCategory::USER, $secondaryEntityId);

		$this->attributeRepository->expects($this->once())
				->method('Add')
				->with($this->equalTo($expectedAttribute))
				->will($this->returnValue(1));

		$this->presenter->AddAttribute();
	}

	public function testUpdatesAttribute()
	{
		$attributeId = 1091;
		$label = 'new label';
		$required = true;
		$regex = '/$\d^/';
		$possibleValues = '1,2,3';
		$sortOrder = "5";
		$entityId = 123;
		$secondaryEntityId = 555;
		$isPrivate = true;
		$adminOnly = true;

		$this->page->_label = $label;
		$this->page->_required = $required;
		$this->page->_regex = $regex;
		$this->page->_possibleValues = $possibleValues;
		$this->page->_attributeId = $attributeId;
		$this->page->_sortOrder = $sortOrder;
		$this->page->_entityId = $entityId;
		$this->page->_adminOnly = $adminOnly;
		$this->page->_limitAttributeScope = true;
		$this->page->_secondaryCategory = CustomAttributeCategory::USER;
		$this->page->_secondaryEntityId = $secondaryEntityId;
		$this->page->_isPrivate = $isPrivate;

		$expectedAttribute = CustomAttribute::Create('', CustomAttributeTypes::CHECKBOX, CustomAttributeCategory::USER, null, false, null, $sortOrder, $entityId, $adminOnly);

		$this->attributeRepository->expects($this->once())
				->method('LoadById')
				->with($this->equalTo($attributeId))
				->will($this->returnValue($expectedAttribute));

		$this->attributeRepository->expects($this->once())
				->method('Update')
				->with($this->anything());

		$this->presenter->UpdateAttribute();

		$this->assertEquals($label, $expectedAttribute->Label());
		$this->assertEquals($regex, $expectedAttribute->Regex());
		$this->assertEquals($required, $expectedAttribute->Required());
		$this->assertEquals($possibleValues, $expectedAttribute->PossibleValues());
		$this->assertEquals($sortOrder, $expectedAttribute->SortOrder());
		$this->assertEquals($entityId, $expectedAttribute->EntityId());
		$this->assertEquals($adminOnly, $expectedAttribute->AdminOnly());
		$this->assertEquals($secondaryEntityId, $expectedAttribute->SecondaryEntityId());
		$this->assertEquals(CustomAttributeCategory::USER, $expectedAttribute->SecondaryCategory());
		$this->assertEquals($isPrivate, $expectedAttribute->IsPrivate());
	}

	public function testDeletesAttributeById()
	{
		$attributeId = 1091;
		$this->page->_attributeId = $attributeId;

		$this->attributeRepository->expects($this->once())
						->method('DeleteById')
						->with($this->equalTo($attributeId));

		$this->presenter->DeleteAttribute();
	}
}

class FakeAttributePage extends FakeActionPageBase implements IManageAttributesPage
{
	public $_label;
	public $_type;
	public $_category;
	public $_required;
	public $_regex;
	public $_possibleValues;
	public $_requestedCategoryId;
	public $_boundAttributes;
	public $_attributeId;
	public $_sortOrder;
	public $_entityId;
	public $_adminOnly;
	public $_limitAttributeScope;
	public $_secondaryCategory;
	public $_secondaryEntityId;
	public $_isPrivate;


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
		return $this->_category;
	}

	public function GetValidationExpression()
	{
		return $this->_regex;
	}

	public function GetIsRequired()
	{
		return $this->_required;
	}

	public function GetEntityId()
	{
		return $this->_entityId;
	}

	public function GetPossibleValues()
	{
		return $this->_possibleValues;
	}

	public function GetRequestedCategory()
	{
		return $this->_requestedCategoryId;
	}

	public function GetSortOrder()
	{
		return $this->_sortOrder;
	}

	public function BindAttributes($attributes)
	{
		$this->_boundAttributes = $attributes;
	}

	public function SetCategory($categoryId)
	{
		// TODO: Implement SetCategory() method.
	}

	public function GetAttributeId()
	{
		return $this->_attributeId;
	}

	public function GetIsAdminOnly()
	{
		return $this->_adminOnly;
	}

	public function GetSecondaryEntityId()
	{
		return $this->_secondaryEntityId;
	}

	public function GetSecondaryCategory()
	{
		return $this->_secondaryCategory;
	}

	public function GetLimitAttributeScope()
	{
		return $this->_limitAttributeScope;
	}

	public function GetIsPrivate()
	{
		return $this->_isPrivate;
	}
}