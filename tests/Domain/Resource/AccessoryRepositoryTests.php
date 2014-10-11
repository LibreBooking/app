<?php
/**
Copyright 2011-2014 Nick Korbel

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

require_once(ROOT_DIR . 'Domain/Access/AccessoryRepository.php');

class AccessoryRepositoryTests extends TestBase
{
	/**
	 * @var AccessoryRepository
	 */
	private $repository;

	public function setup()
	{
		parent::setup();

		$this->repository = new AccessoryRepository();
	}

	public function testCanLoadById()
	{
		$accessoryId = 100;
		$name = 'n';
		$available = 100;

		$command = new GetAccessoryByIdCommand($accessoryId);
		$this->db->SetRows(array($this->GetAccessoryRow($accessoryId, $name, $available)));

		$accessory = $this->repository->LoadById($accessoryId);

		$this->assertEquals(new Accessory($accessoryId, $name, $available), $accessory);
		$this->assertTrue($this->db->ContainsCommand($command));
		$this->assertTrue($this->db->ContainsCommand(new GetAccessoryResources($accessoryId)));
	}

	public function testCanAdd()
	{
		$name = 'n';
		$available = 100;

		$accessory = Accessory::Create($name, $available);

		$command = new AddAccessoryCommand($name, $available);

		$this->repository->Add($accessory);

		$this->assertEquals($command, $this->db->_LastCommand);
	}

	public function testCanUpdate()
	{
		$accessoryId = 100;
		$name = 'n';
		$available = 100;

		$accessory = new Accessory($accessoryId, $name, $available);

		$command = new UpdateAccessoryCommand($accessoryId, $name, $available);

		$this->repository->Update($accessory);

		$this->assertTrue($this->db->ContainsCommand($command));
	}

	public function testCanDelete()
	{
		$accessoryId = 100;
		$command = new DeleteAccessoryCommand($accessoryId);

		$this->repository->Delete($accessoryId);

		$this->assertEquals($command, $this->db->_LastCommand);
	}

	private function GetAccessoryRow($accessoryId, $name, $available)
	{
		return array(
			ColumnNames::ACCESSORY_ID => $accessoryId,
			ColumnNames::ACCESSORY_NAME => $name,
			ColumnNames::ACCESSORY_QUANTITY => $available);
	}
}
