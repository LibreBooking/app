<?php
require_once(ROOT_DIR . 'Domain/namespace.php');
require_once(ROOT_DIR . 'Domain/Access/namespace.php');

class QuotaRepositoryTests extends TestBase
{
	/**
	 * @var QuotaRepository
	 */
	private $repository;
	
	public function setup()
	{
		parent::setup();
		
		$this->repository = new QuotaRepository();
	}
	
	public function teardown()
	{
		parent::teardown();
		
		$this->repository = null;
	}
	
	public function testCanGetQuotas()
	{
		$limit = 12;
		$resourceId = 100;
		$groupId = 923;

		$rows[] = $this->GetRow(1, $limit, QuotaUnit::Reservations, QuotaDuration::Month, $resourceId, $groupId);
		$rows[] = $this->GetRow(2, $limit, QuotaUnit::Hours, QuotaDuration::Day, null, null);
		$rows[] = $this->GetRow(3, $limit, QuotaUnit::Hours, QuotaDuration::Week, null, $groupId);

		$this->db->SetRows($rows);

		/** @var $quotas Quota[] */
		$quotas = $this->repository->LoadAll();

		$quota1 = $quotas[0];
		$quota2 = $quotas[1];
		$quota3 = $quotas[2];

		$command = new GetAllQuotasCommand();
		$this->assertEquals($command, $this->db->_LastCommand);
		
		$this->assertEquals(new QuotaLimitCount($limit), $quota1->GetLimit());
		$this->assertEquals(new QuotaLimitHours($limit), $quota2->GetLimit());
		$this->assertEquals(new QuotaLimitHours($limit), $quota3->GetLimit());

		$this->assertEquals(new QuotaDurationMonth(), $quota1->GetDuration());
		$this->assertEquals(new QuotaDurationDay(), $quota2->GetDuration());
		$this->assertEquals(new QuotaDurationWeek(), $quota3->GetDuration());

		$this->assertTrue($quota1->AppliesToResource($resourceId));
		$this->assertTrue($quota1->AppliesToGroup($groupId));

		$this->assertTrue($quota2->AppliesToResource(89123987));
		$this->assertTrue($quota2->AppliesToGroup(128973));

		$this->assertTrue($quota2->AppliesToResource(89123987));
		$this->assertTrue($quota2->AppliesToGroup($groupId));

	}

	private function GetRow($quotaId, $limit, $unit, $duration, $resourceId, $groupId)
	{
		return array(ColumnNames::QUOTA_ID => $quotaId,
					 ColumnNames::QUOTA_LIMIT => $limit,
					 ColumnNames::QUOTA_UNIT => $unit,
					 ColumnNames::QUOTA_DURATION => $duration,
					 ColumnNames::RESOURCE_ID => $resourceId,
					 ColumnNames::GROUP_ID => $groupId
			);
	}
}
?>
