<?php
/**
Part of phpScheduleIt
written by Stephen Oliver
add the 'PreReservationReminder' file into /plugins/PreReservation
 */

class PreReservationReminderValidation implements IReservationValidationService
{
	/**
	 * @var IReservationValidationService
	 */
	private $serviceToDecorate;

	public function __construct(IReservationValidationService $serviceToDecorate)
	{
		$this->serviceToDecorate = $serviceToDecorate;
	}

	/**
	 * @param ReservationSeries|ExistingReservationSeries $series
	 * @return IReservationValidationResult
	 */
	public function Validate($series)
	{
		$result = $this->serviceToDecorate->Validate($series);

		// don't bother validating this rule if others have failed
		if (!$result->CanBeSaved())
		{
			return $result;
		}

		return $this->EvaluateCustomRule($series);
	}

	/**
	 * @param ReservationSeries $series
	 * @return bool
	 */
	private function EvaluateCustomRule($series)
	{

	// make your custom checks here
        $reminderRepository = new ReminderRepository();
        $user = ServiceLocator::GetServer()->GetUserSession();
	// add your individual custom attribute IDs to the $series->GetAttributeValues below
        // radio checkbox, if the user wants a reminder
        $wantsit = $series->GetAttributeValue(5);
        // small textbox where the user wants the reminder sent
        $address = $series->GetAttributeValue(6);
        // small textbox what the user wants the reminder to say
        $message = $series->GetAttributeValue(7);
        // select list where the user can select when they want the reminder sent
        // the values of the select list are below in the 'switch($sendtime)' statement
        // add these to possible values:
        // "When It Starts,5 minutes before,10 minutes before,15 minutes before,30 minutes before,1 hour before,2 hours before,1 day before"
        $sendtime = $series->GetAttributeValue(8);
	$referenceNumber = $series->CurrentInstance()->ReferenceNumber();
        $startTime = $series->CurrentInstance()->StartDate();
        if($reminderRepository->GetByRefNumber($referenceNumber))
        {
            $reminderRepository->DeleteReminderByRefNumber($referenceNumber);
            return new ReservationValidationResult(true);
        }

        elseif($wantsit)
        {
            switch($sendtime)
            {
                case 'When It Starts':
                    $sendtime = $startTime;
                    break;
                case '5 minutes before':
                    $sendtime = $startTime->RemoveMinutes(5);
                    break;
                case '10 minutes before':
                    $sendtime = $startTime->RemoveMinutes(10);
                    break;
                case '15 minutes before':
                    $sendtime = $startTime->RemoveMinutes(15);
                    break;
                case '30 minutes before':
                    $sendtime = $startTime->RemoveMinutes(30);
                    break;
                case '1 hour before':
                    $sendtime = $startTime->RemoveMinutes(60);
                    break;
                case '2 hours before':
                    $sendtime = $startTime->RemoveMinutes(120);
                    break;
                case '1 day before':
                    $sendtime = $startTime->RemoveMinutes(1440);
                    break;
            }

            if(!$address)
            {
                $address = $user->Email;
            }

		    if (!$message)
		    {
		    	$message = "Reminder! About what, we don't know.";
		    }
            $user = ServiceLocator::GetServer()->GetUserSession();
            $currentuser = $user->Email;
            $newReminder = new Reminder(null, $currentuser, $address, $message, $sendtime, $referenceNumber);
            $reminderRepository->Add($newReminder);
            return new ReservationValidationResult(true);
        }
        else
            return new ReservationValidationResult(true);
	}
}
?>