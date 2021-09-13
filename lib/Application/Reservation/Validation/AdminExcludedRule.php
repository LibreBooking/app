<?php

class AdminExcludedRule implements IReservationValidationRule
{
    /**
     * @var IReservationValidationRule
     */
    private $rule;

    /**
     * @var UserSession
     */
    private $userSession;

    /**
     * @var IUserRepository
     */
    private $userRepository;

    public function __construct(IReservationValidationRule $baseRule, UserSession $userSession, IUserRepository $userRepository)
    {
        $this->rule = $baseRule;
        $this->userSession = $userSession;
        $this->userRepository = $userRepository;
    }

    public function Validate($reservationSeries, $retryParameters)
    {
        if ($this->userSession->IsAdmin) {
            Log::Debug('User is application admin. Skipping check. UserId=%s', $this->userSession->UserId);

            return new ReservationRuleResult(true);
        }

        if ($this->userSession->IsGroupAdmin || $this->userSession->IsResourceAdmin || $this->userSession->IsScheduleAdmin) {
            if ($this->userSession->IsGroupAdmin) {
                $user = $this->userRepository->LoadById($this->userSession->UserId);
                $reservationUser = $this->userRepository->LoadById($reservationSeries->UserId());

                if ($user->IsAdminFor($reservationUser)) {
                    Log::Debug('User is admin for reservation user. Skipping check. UserId=%s', $this->userSession->UserId);
                    return new ReservationRuleResult(true);
                }
            }

            if ($this->userSession->IsResourceAdmin || $this->userSession->IsScheduleAdmin) {
                $user = $this->userRepository->LoadById($this->userSession->UserId);
                $isResourceAdmin = true;

                foreach ($reservationSeries->AllResources() as $resource) {
                    if (!$user->IsResourceAdminFor($resource)) {
                        $isResourceAdmin = false;
                        break;
                    }
                }

                if ($isResourceAdmin) {
                    Log::Debug('User is admin for all resources. Skipping check. UserId=%s', $this->userSession->UserId);
                    return new ReservationRuleResult(true);
                }
            }
        }

        return $this->rule->Validate($reservationSeries, $retryParameters);
    }
}
