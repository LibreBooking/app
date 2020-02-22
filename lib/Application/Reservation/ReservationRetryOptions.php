<?php

interface IReservationRetryOptions {
	/**
	 * @param ExistingReservationSeries $series
	 * @param ReservationRetryParameter[] $retryParameters
	 */
	public function AdjustReservation(ExistingReservationSeries $series, $retryParameters);
}

class ReservationRetryOptions implements IReservationRetryOptions
{
	/**
	 * @var IReservationConflictIdentifier
	 */
	private $conflictIdentifier;
	/**
	 * @var IScheduleRepository
	 */
	private $scheduleRepository;

	public function __construct(IReservationConflictIdentifier $conflictIdentifier, IScheduleRepository $scheduleRepository)
	{
		$this->conflictIdentifier = $conflictIdentifier;
		$this->scheduleRepository = $scheduleRepository;
	}

	public function AdjustReservation(ExistingReservationSeries $series, $retryParameters)
	{
		$shouldSkipConflicts = ReservationRetryParameter::GetValue(ReservationRetryParameter::$SKIP_CONFLICTS, $retryParameters, new BooleanConverter()) == true;
		if (!$shouldSkipConflicts) {
			return;
		}

		$conflicts = $this->conflictIdentifier->GetConflicts($series);

		foreach ($conflicts as $conflict) {
			$series->RemoveInstance($conflict->Reservation);
		}

		$series->CalculateCredits($this->scheduleRepository->GetLayout($series->ScheduleId(), new ScheduleLayoutFactory($series->CurrentInstance()->StartDate()->Timezone())));
	}
}