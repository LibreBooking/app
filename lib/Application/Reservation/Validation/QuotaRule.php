<?php

class QuotaRule implements IReservationValidationRule
{
	/**
	 * @var \IQuotaRepository
	 */
	private $quotaRepository;

	public function __construct(IQuotaRepository $quotaRepository)
	{
		$this->quotaRepository = $quotaRepository;
	}

	/**
	 * @param ReservationSeries $reservationSeries
	 * @return ReservationRuleResult
	 */
	public function Validate($reservationSeries)
	{
		$allQuotas = array();

		foreach ($reservationSeries->AllResources() as $resourceId)
		{
			$quotas = $this->quotaRepository->GetQuotas($resourceId);
			$allQuotas = array_merge($quotas, $allQuotas);
		}

		$allQuotas = array_unique($allQuotas);

		/** @var $quota Quota */
		foreach ($allQuotas as $quota)
		{
			if ($quota->ExceedsQuota($reservationSeries))
			{
				return new ReservationRuleResult(false, 'QuotaExceeded');
			}
		}

		return new ReservationRuleResult();
	}
}

?>