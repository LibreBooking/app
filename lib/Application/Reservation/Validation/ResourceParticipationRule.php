<?php

class ResourceParticipationRule implements IReservationValidationRule
{
    /**
     * @param ReservationSeries $reservationSeries
     * @param $retryParameters
     * @return ReservationRuleResult
     */
    public function Validate($reservationSeries, $retryParameters)
    {
        $errorMessage = new StringBuilder();
        foreach ($reservationSeries->AllResources() as $resource) {
            if (!$resource->HasMaxParticipants()) {
                continue;
            }

            foreach ($reservationSeries->Instances() as $instance) {
                $numberOfParticipants = count($instance->Participants());

                Log::Debug(
                    'ResourceParticipationRule Resource=%s,InstanceId=%s,MaxParticipants=%s,CurrentParticipants=%s',
                    $resource->GetName(),
                    $instance->ReservationId(),
                    $resource->GetMaxParticipants(),
                    $numberOfParticipants
                );
                if ($numberOfParticipants > $resource->GetMaxParticipants()) {
                    $errorMessage->AppendLine(Resources::GetInstance()->GetString(
                        'MaxParticipantsError',
                        [$resource->GetName(), $resource->GetMaxParticipants()]
                    ));
                    continue;
                }
            }
        }

        $message = $errorMessage->ToString();
        if (strlen($message) > 0) {
            return new ReservationRuleResult(false, $message);
        }
        return new ReservationRuleResult();
    }
}
