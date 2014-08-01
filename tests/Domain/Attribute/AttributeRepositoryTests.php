<?php
/**
 * Copyright 2011-2014 Nick Korbel
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

require_once(ROOT_DIR . 'Domain/Access/AttributeRepository.php');

class AttributeRepositoryTests extends TestBase
{
	/**
	 * @var AttributeRepository
	 */
	private $repository;

	public function setup()
	{
		parent::setup();

		$this->repository = new AttributeRepository();
	}

	public function teardown()
	{
		parent::teardown();
	}

	public function testAddsAttribute()
	{
		$label = 'label';
		$type = CustomAttributeTypes::SINGLE_LINE_TEXTBOX;
		$category = CustomAttributeCategory::RESERVATION;
		$regex = 'regex';
		$required = false;
		$possibleValues = '';
		$sortOrder = '4';
		$entityId = 12;
		$adminOnly = true;
		$secondaryCategory = CustomAttributeCategory::USER;
		$secondaryEntityId = 828;
		$isPrivate = true;

		$attribute = CustomAttribute::Create($label, $type, $category, $regex, $required, $possibleValues, $sortOrder,
											 $entityId, $adminOnly);

		$attribute->WithSecondaryEntity($secondaryCategory, $secondaryEntityId);
		$attribute->WithIsPrivate($isPrivate);

		$this->repository->Add($attribute);
		$this->assertEquals(new AddAttributeCommand($label, $type, $category, $regex, $required, $possibleValues, $sortOrder, $entityId, $adminOnly, $secondaryCategory, $secondaryEntityId, $isPrivate),
							$this->db->_LastCommand);
	}

	public function testLoadsAttributeById()
	{
		$id = 12098;
		$label = 'label';
		$type = CustomAttributeTypes::SINGLE_LINE_TEXTBOX;
		$category = CustomAttributeCategory::RESERVATION;
		$regex = 'regex';
		$required = false;
		$possibleValues = 'val1,val2,val3';
		$sortOrder = '4';
		$entityId = 12;
		$adminOnly = true;

		$row1 = $this->GetAttributeRow($id, $label, $type, $category, $regex, $required, $possibleValues, $sortOrder, $entityId, null, $adminOnly);

		$this->db->SetRows(array($row1));

		$attribute = $this->repository->LoadById($id);

		$expectedFirstAttribute = new CustomAttribute($id, $label, $type, $category, $regex, $required, $possibleValues, $sortOrder, $entityId, $adminOnly);

		$this->assertEquals($expectedFirstAttribute, $attribute);
		$this->assertEquals(new GetAttributeByIdCommand($id), $this->db->_LastCommand);
	}

	public function testUpdatesAttribute()
	{
		$id = 12098;
		$label = 'label';
		$type = CustomAttributeTypes::SINGLE_LINE_TEXTBOX;
		$category = CustomAttributeCategory::RESERVATION;
		$regex = 'regex';
		$required = false;
		$possibleValues = 'val1,val2,val3';
		$sortOrder = '4';
		$entityId = 10;
		$adminOnly = true;
		$secondaryCategory = CustomAttributeCategory::USER;
		$secondaryEntityId = 828;
		$isPrivate = true;

		$attribute = new CustomAttribute($id, $label, $type, $category, $regex, $required, $possibleValues, $sortOrder, $entityId, $adminOnly);
		$attribute->WithSecondaryEntity($secondaryCategory, $secondaryEntityId);
		$attribute->WithIsPrivate($isPrivate);

		$this->repository->Update($attribute);

		$this->assertEquals(new UpdateAttributeCommand($id, $label, $type, $category, $regex, $required, $possibleValues, $sortOrder, $entityId, $adminOnly, $secondaryCategory, $secondaryEntityId, $isPrivate),
							$this->db->_LastCommand);
	}

	public function testDeletesAttributeById()
	{
		$id = 12098;

		$this->repository->DeleteById($id);
		$this->assertEquals(new DeleteAttributeCommand($id), $this->db->_Commands[0]);
		$this->assertEquals(new DeleteAttributeValuesCommand($id), $this->db->_Commands[1]);
	}

	public function testLoadsAttributesByCategory()
	{
		$id = 12098;
		$label = 'label';
		$type = CustomAttributeTypes::SINGLE_LINE_TEXTBOX;
		$category = CustomAttributeCategory::RESERVATION;
		$regex = 'regex';
		$required = false;
		$possibleValues = 'val1,val2,val3';
		$sortOrder = '4';
		$entityId = 12;
		$entityDescription = 'entity desc';

		$row1 = $this->GetAttributeRow($id, $label, $type, $category, $regex, $required, $possibleValues, $sortOrder,
									   $entityId, $entityDescription);
		$row2 = $this->GetAttributeRow(2);

		$this->db->SetRows(array($row1, $row2));

		$attributes = $this->repository->GetByCategory(CustomAttributeCategory::RESERVATION);

		$expectedFirstAttribute = new CustomAttribute($id, $label, $type, $category, $regex, $required, $possibleValues, $sortOrder, $entityId);
		$expectedFirstAttribute->WithEntityDescription($entityDescription);

		$this->assertEquals(2, count($attributes));
		$this->assertEquals($expectedFirstAttribute, $attributes[0]);
		$this->assertEquals(new GetAttributesByCategoryCommand(CustomAttributeCategory::RESERVATION), $this->db->_LastCommand);
	}

	public function testGetsAttributeEntityValues()
	{
		$a1 = 1;
		$a2 = 2;
		$e1 = 10;
		$v1 = '13';
		$v2 = '222';

		$category = CustomAttributeCategory::USER;
		$entityIds = array(1, 4, 6, $e1);

		$row1 = $this->GetAttributeValueRow($a1, $e1, $v1);
		$row2 = $this->GetAttributeValueRow($a2, $e1, $v2);

		$this->db->SetRows(array($row1, $row2));

		$values = $this->repository->GetEntityValues($category, $entityIds);

		$this->assertEquals(new GetAttributeMultipleValuesCommand($category, $entityIds), $this->db->_LastCommand);
		$this->assertEquals($a1, $values[0]->AttributeId);
		$this->assertEquals($e1, $values[0]->EntityId);
		$this->assertEquals($v1, $values[0]->Value);
		$this->assertEquals($a2, $values[1]->AttributeId);
		$this->assertEquals($e1, $values[1]->EntityId);
		$this->assertEquals($v2, $values[1]->Value);
	}

	private function GetAttributeRow($id,
									 $label = '',
									 $type = CustomAttributeTypes::SINGLE_LINE_TEXTBOX,
									 $category = CustomAttributeCategory::RESERVATION,
									 $regex = null,
									 $required = true,
									 $possibleValues = null,
									 $sortOrder = null,
									 $entityId = null,
									 $entityDescription = null,
									 $adminOnly = false
	)
	{
		return array(
				ColumnNames::ATTRIBUTE_ID => $id,
				ColumnNames::ATTRIBUTE_LABEL => $label,
				ColumnNames::ATTRIBUTE_TYPE => $type,
				ColumnNames::ATTRIBUTE_CATEGORY => $category,
				ColumnNames::ATTRIBUTE_CONSTRAINT => $regex,
				ColumnNames::ATTRIBUTE_REQUIRED => $required,
				ColumnNames::ATTRIBUTE_POSSIBLE_VALUES => $possibleValues,
				ColumnNames::ATTRIBUTE_SORT_ORDER => $sortOrder,
				ColumnNames::ATTRIBUTE_ENTITY_ID => $entityId,
				ColumnNames::ATTRIBUTE_ENTITY_DESCRIPTION => $entityDescription,
				ColumnNames::ATTRIBUTE_ADMIN_ONLY => $adminOnly,
		);
	}

	private function GetAttributeValueRow($attributeid, $entityId, $value)
	{
		return array(
				ColumnNames::ATTRIBUTE_ID => $attributeid,
				ColumnNames::ATTRIBUTE_ENTITY_ID => $entityId,
				ColumnNames::ATTRIBUTE_VALUE => $value);
	}
}