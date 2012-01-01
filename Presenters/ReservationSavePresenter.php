<?php
/**
Copyright 2011-2012 Nick Korbel

This file is part of phpScheduleIt.

phpScheduleIt is free software: you can redistribute it and/or modify
it under the terms of the GNU General Public License as published by
the Free Software Foundation, either version 3 of the License, or
(at your option) any later version.

phpScheduleIt is distributed in the hope that it will be useful,
but WITHOUT ANY WARRANTY; without even the implied warranty of
MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
GNU General Public License for more details.

You should have received a copy of the GNU General Public License
along with phpScheduleIt.  If not, see <http://www.gnu.org/licenses/>.
*/
 
require_once(ROOT_DIR . 'Presenters/ReservationHandler.php');

class ReservationSavePresenter
{
	/**
	 * @var IReservationSavePage
	 */
	private $_page;
	
	/**
	 * @var IReservationPersistenceService
	 */
	private $_persistenceService;
	
	/**
	 * @var IReservationHandler
	 */
	private $_handler;

	/**
	 * @var IResourceRepository
	 */
	private $_resourceRepository;
	
	public function __construct(
		IReservationSavePage $page, 
		IReservationPersistenceService $persistenceService,
		IReservationHandler $handler,
		IResourceRepository $resourceRepository)
	{
		$this->_page = $page;
		$this->_persistenceService = $persistenceService;
		$this->_handler = $handler;
		$this->_resourceRepository = $resourceRepository;
	}
	
	public function BuildReservation()
	{
		//TODO: reminders

		$userId = $this->_page->GetUserId();
		$resource = $this->_resourceRepository->LoadById($this->_page->GetResourceId());
		$title = $this->_page->GetTitle();
		$description = $this->_page->GetDescription();
		$repeatOptions = $this->_page->GetRepeatOptions();
		$duration = $this->GetReservationDuration();
		
		$reservationSeries = ReservationSeries::Create($userId, $resource, $title, $description, $duration, $repeatOptions, ServiceLocator::GetServer()->GetUserSession());
		
		$resourceIds = $this->_page->GetResources();
		
		foreach ($resourceIds as $resourceId)
		{
			$reservationSeries->AddResource($this->_resourceRepository->LoadById($resourceId));
		}

		$accessories = $this->_page->GetAccessories();

		foreach ($accessories as $accessory)
		{
			$reservationSeries->AddAccessory(new ReservationAccessory($accessory->Id, $accessory->Quantity));
		}

		$participantIds = $this->_page->GetParticipants();
		$reservationSeries->ChangeParticipants($participantIds);

		$inviteeIds = $this->_page->GetInvitees();
		$reservationSeries->ChangeInvitees($inviteeIds);

		return $reservationSeries;
	}
	
	/**
	 * @param ReservationSeries $reservationSeries
	 */
	public function HandleReservation($reservationSeries)
	{		
		$successfullySaved = $this->_handler->Handle(
					$reservationSeries,
					$this->_page);
			
		if ($successfullySaved)
		{
			$this->_page->SetReferenceNumber($reservationSeries->CurrentInstance()->ReferenceNumber());
		}
	}
	
	/**
	 * @return DateRange
	 */
	private function GetReservationDuration()
	{
		$startDate = $this->_page->GetStartDate();
		$startTime = $this->_page->GetStartTime();
		$endDate = $this->_page->GetEndDate();
		$endTime = $this->_page->GetEndTime();
		
		$timezone = ServiceLocator::GetServer()->GetUserSession()->Timezone;
		return DateRange::Create($startDate . ' ' . $startTime, $endDate . ' ' . $endTime, $timezone);
	}
	
	/**s
	 * @return IRepeatOptions
	 */
	public function GetRepeatOptions()
	{
		$timezone = ServiceLocator::GetServer()->GetUserSession()->Timezone;
		$factory = new RepeatOptionsFactory();
		
		$repeatType = $this->_page->GetRepeatType();
		$interval = $this->_page->GetRepeatInterval();
		$weekdays = $this->_page->GetRepeatWeekdays();
		$monthlyType = $this->_page->GetRepeatMonthlyType();
		$terminationDate = Date::Parse($this->_page->GetRepeatTerminationDate(), $timezone);
		
		return $factory->Create($repeatType, $interval, $terminationDate, $weekdays, $monthlyType);
	}
}
?>