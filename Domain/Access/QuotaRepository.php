<?php

interface IQuotaRepository
{
	/**
	 * @abstract
	 * @return array|Quota[]
	 */
	function LoadAll();
}

class QuotaRepository implements IQuotaRepository
{
	public function LoadAll()
	{
		$quotas = array();
		
		$command = new GetAllQuotasCommand();
		$reader = ServiceLocator::GetDatabase()->Query($command);

		while ($row = $reader->GetRow())
		{
			$quotaId = $row[ColumnNames::QUOTA_ID];

			$limit = $this->GetLimit($row[ColumnNames::QUOTA_LIMIT], $row[ColumnNames::QUOTA_UNIT]);
			$duration = $this->GetDuration($row[ColumnNames::QUOTA_DURATION]);

			$quotas[] = new Quota($quotaId, $duration, $limit);
		}

		return $quotas;
	}

	private function GetLimit($limit, $unit)
	{
		if ($unit == QuotaUnit::Reservations)
		{
			return new QuotaLimitCount($limit);
		}

		return new QuotaLimitHours($limit);
	}

	private function GetDuration($duration)
	{
		if ($duration == QuotaDuration::Day)
		{
			return new QuotaDurationDay();
		}

		if ($duration == QuotaDuration::Week)
		{
			return new QuotaDurationWeek();
		}

		return new QuotaDurationMonth();
	}
}
