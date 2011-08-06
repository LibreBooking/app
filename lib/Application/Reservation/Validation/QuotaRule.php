<?php

class QuotaRule implements IReservationValidationRule
{
	/**
	 * @var \IQuotaRepository
	 */
	private $quotaRepository;

	/**
	 * @var \IReservationViewRepository
	 */
	private $reservationViewRepository;

	/**
	 * @var \IUserRepository
	 */
	private $userRepository;

	/**
	 * @var \IScheduleRepository
	 */
	private $scheduleRepository;

	public function __construct(IQuotaRepository $quotaRepository, IReservationViewRepository $reservationViewRepository, IUserRepository $userRepository, IScheduleRepository $scheduleRepository)
	{
		$this->quotaRepository = $quotaRepository;
		$this->reservationViewRepository = $reservationViewRepository;
		$this->userRepository = $userRepository;
		$this->scheduleRepository = $scheduleRepository;
	}

	/**
	 * @param ReservationSeries $reservationSeries
	 * @return ReservationRuleResult
	 */
	public function Validate($reservationSeries)
	{
		$quotas = $this->quotaRepository->LoadAll();
		$user = $this->userRepository->LoadById($reservationSeries->UserId());
		$schedule = $this->scheduleRepository->LoadById($reservationSeries->ScheduleId());
		
		foreach ($quotas as $quota)
		{
			if ($quota->ExceedsQuota($reservationSeries, $user, $schedule, $this->reservationViewRepository))
			{
				return new ReservationRuleResult(false, 'QuotaExceeded');
			}
		}

		return new ReservationRuleResult();
	}
}

?>