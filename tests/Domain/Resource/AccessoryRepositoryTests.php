<?php
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
