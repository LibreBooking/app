<?php

class ReminderValidationRule implements IReservationValidationRule
{
    /**
     * @param ReservationSeries $reservationSeries
     * @param $retryParameters
     * @return ReservationRuleResult
     */
    public function Validate($reservationSeries, $retryParameters)
    {
        $errorMessage = new StringBuilder();
        if ($reservationSeries->GetStartReminder()->Enabled()) {
            if (!$this->minutesValid($reservationSeries->GetStartReminder())) {
                $errorMessage->AppendLine(Resources::GetInstance()->GetString('InvalidStartReminderTime'));
            }
        }

        if ($reservationSeries->GetEndReminder()->Enabled()) {
            if (!$this->minutesValid($reservationSeries->GetEndReminder())) {
                $errorMessage->AppendLine(Resources::GetInstance()->GetString('InvalidEndReminderTime'));
            }
        }

        $message = $errorMessage->ToString();
        if (strlen($message) > 0) {
            return new ReservationRuleResult(false, $message);
        }
        return new ReservationRuleResult();
    }

    private function minutesValid(ReservationReminder $reminder)
    {
        $minutes = intval($reminder->MinutesPrior());
        return $minutes > 0;
    }
}
