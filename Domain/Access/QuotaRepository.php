<?php

interface IQuotaRepository
{
	/**
	 * @abstract
	 * @return array|Quota[]
	 */
	function LoadAll();

	/**
	 * @abstract
	 * @param Quota $quota
	 * @return void
	 */
	function Add(Quota $quota);
}

interface IQuotaViewRepository
{
	/**
	 * @abstract
	 * @return array|QuotaItemView[]
	 */
	function GetAll();
}

class QuotaRepository implements IQuotaRepository, IQuotaViewRepository
{
	public function LoadAll()
	{
		$quotas = array();

		$command = new GetAllQuotasCommand();
		$reader = ServiceLocator::GetDatabase()->Query($command);

		while ($row = $reader->GetRow())
		{
			$quotaId = $row[ColumnNames::QUOTA_ID];

			$limit = Quota::CreateLimit($row[ColumnNames::QUOTA_LIMIT], $row[ColumnNames::QUOTA_UNIT]);
			$duration = Quota::CreateDuration($row[ColumnNames::QUOTA_DURATION]);

			$quotas[] = new Quota($quotaId, $duration, $limit);
		}

		return $quotas;
	}

	/**
	 * @return array|QuotaItemView[]
	 */
	function GetAll()
	{
		$quotas = array();

		$command = new GetAllQuotasCommand();
		$reader = ServiceLocator::GetDatabase()->Query($command);

		while ($row = $reader->GetRow())
		{
			$quotaId = $row[ColumnNames::QUOTA_ID];

			$limit = $row[ColumnNames::QUOTA_LIMIT];
			$unit = $row[ColumnNames::QUOTA_UNIT];
			$duration = $row[ColumnNames::QUOTA_DURATION];
			$groupName = $row['group_name'];
			$resourceName = $row['resource_name'];
			
			$quotas[] = new QuotaItemView($quotaId, $limit, $unit, $duration, $groupName, $resourceName);
		}

		return $quotas;
	}

	/**
	 * @param Quota $quota
	 * @return void
	 */
	function Add(Quota $quota)
	{
		$command = new AddQuotaCommand($quota->GetDuration()->Name(), $quota->GetLimit()->Amount(), $quota->GetLimit()->Name(), $quota->ResourceId(), $quota->GroupId());

		ServiceLocator::GetDatabase()->Execute($command);
	}
}

class QuotaItemView
{
	public $Id;
	public $Limit;
	public $Unit;
	public $Duration;
	public $GroupName;
	public $ResourceName;

	/**
	 * @param int $quotaId
	 * @param decimal $limit
	 * @param string $unit
	 * @param string $duration
	 * @param string $groupName
	 * @param string $resourceName
	 */
	public function __construct($quotaId, $limit, $unit, $duration, $groupName, $resourceName)
	{
		$this->Id = $quotaId;
		$this->Limit = $limit;
		$this->Unit = $unit;
		$this->Duration = $duration;
		$this->GroupName = $groupName;
		$this->ResourceName = $resourceName;
	}
}
?>