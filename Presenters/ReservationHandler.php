<?php
class ReservationHandler
{
	/**
	 * @param ReservationSeries $reservationSeries
	 * @param IReservationSaveResultsPage $page
	 * @param unknown_type $persistenceService
	 * @param unknown_type $validationService
	 * @param unknown_type $notificationService
	 * @return bool
	 */
	public function Handle(
		$reservationSeries,
		IReservationSaveResultsPage $page, 
		$persistenceService,
		$validationService,
		$notificationService)
	{
		$validationResult = $validationService->Validate($reservationSeries);
		$result = $validationResult->CanBeSaved();
		
		if ($validationResult->CanBeSaved())
		{
			try 
			{
				$persistenceService->Persist($reservationSeries);
			}
			catch (Exception $ex)
			{
				Log::Error('Error saving reservation: %s', $ex);
				throw($ex);
			}
			
			$notificationService->Notify($reservationSeries);
			
			$page->SetSaveSuccessfulMessage($result);
		}
		else
		{
			$page->SetSaveSuccessfulMessage($result);
			$page->ShowErrors($validationResult->GetErrors());
		}
		
		$page->ShowWarnings($validationResult->GetWarnings());
		
		return $result;
	}
}
?>