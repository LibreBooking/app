<?php

require_once(ROOT_DIR . 'Domain/Access/namespace.php');

class GroupRepositoryTests extends TestBase
{
	public function setup()
	{
		parent::setup();
	}

	public function teardown()
	{
		parent::teardown();
	}

	public function testCanGetPageableListOfGroups()
	{
		$filter = new EqualsSqlFilter(null, null);
		$pageNum = 10;
		$pageSize = 100;
		$count = 1000;

		$countRow = array('total' => $count);
		$row1 = self::GetRow(1, 'g1');
		$row2 = self::GetRow(2, 'g2');
		$rows = array($row1, $row2);

		$this->db->SetRow(0, array($countRow));
		$this->db->SetRow(1, $rows);

		$baseCommand = new GetAllGroupsCommand();
		$expected = new FilterCommand($baseCommand, $filter);

		$repo = new GroupRepository();
		$list = $repo->GetList($pageNum, $pageSize, null, null, $filter);
		
		$results = $list->Results();
		$this->assertEquals(GroupItemView::Create($row1), $results[0]);
		$this->assertEquals(GroupItemView::Create($row2), $results[1]);
		$this->assertEquals($this->db->ContainsCommand($expected), "missing select group command");

		$pageInfo = $list->PageInfo();
		$this->assertEquals($count, $pageInfo->Total);
		$this->assertEquals($pageNum, $pageInfo->CurrentPage);
	}

	public static function GetRow($groupId, $groupName)
	{
		return array(ColumnNames::GROUP_ID => $groupId, ColumnNames::GROUP_NAME => $groupName);
	}
}
?>