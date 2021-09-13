<?php

class TermsOfServiceRule implements IReservationValidationRule
{
    /**
     * @var ITermsOfServiceRepository
     */
    private $termsOfServiceRepository;

    public function __construct(ITermsOfServiceRepository $termsOfServiceRepository)
    {
        $this->termsOfServiceRepository = $termsOfServiceRepository;
    }

    /**
     * @see IReservationValidationRule::Validate()
     *
     * @param ReservationSeries $reservationSeries
     * @param null|ReservationRetryParameter[] $retryParameters
     * @return ReservationRuleResult
     */
    public function Validate($reservationSeries, $retryParameters)
    {
        if (!$reservationSeries->HasAcceptedTerms()) {
            $terms = $this->termsOfServiceRepository->Load();
            if ($terms != null && $terms->AppliesToReservation()) {
                return new ReservationRuleResult(false, Resources::GetInstance()->GetString('TermsOfServiceError'));
            }
        }

        return new ReservationRuleResult();
    }
}
