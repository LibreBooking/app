<?php
/**
Copyright 2011-2015 Nick Korbel

This file is part of Booked Scheduler.

Booked Scheduler is free software: you can redistribute it and/or modify
it under the terms of the GNU General Public License as published by
the Free Software Foundation, either version 3 of the License, or
(at your option) any later version.

Booked Scheduler is distributed in the hope that it will be useful,
but WITHOUT ANY WARRANTY; without even the implied warranty of
MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
GNU General Public License for more details.

You should have received a copy of the GNU General Public License
along with Booked Scheduler.  If not, see <http://www.gnu.org/licenses/>.
*/

require_once(ROOT_DIR . 'lib/Application/Reservation/namespace.php');

interface IReservationSavePresenter
{
	/**
	 * @return ReservationSeries
	 */
	public function BuildReservation();

	/**
	 * @param ReservationSeries $reservationSeries
	 */
	public function HandleReservation($reservationSeries);
}

class ReservationSavePresenter implements IReservationSavePresenter
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
		IResourceRepository $resourceRepository,
		UserSession $userSession)
	{
		$this->_page = $page;
		$this->_persistenceService = $persistenceService;
		$this->_handler = $handler;
		$this->_resourceRepository = $resourceRepository;
		$this->userSession = $userSession;
	}

	public function BuildReservation()
	{
		$userId = $this->_page->GetUserId();
		$primaryResourceId = $this->_page->GetResourceId();
		$resource = $this->_resourceRepository->LoadById($primaryResourceId);
		$title = $this->_page->GetTitle();
		$description = $this->_page->GetDescription();
		$roFactory = new RepeatOptionsFactory();
		$repeatOptions = $roFactory->CreateFromComposite($this->_page, $this->userSession->Timezone);
		$duration = $this->GetReservationDuration();

		$reservationSeries = ReservationSeries::Create($userId, $resource, $title, $description, $duration, $repeatOptions, $this->userSession);

		$resourceIds = $this->_page->GetResources();
		foreach ($resourceIds as $resourceId)
		{
			if ($primaryResourceId != $resourceId)
			{
				$reservationSeries->AddResource($this->_resourceRepository->LoadById($resourceId));
			}
		}

		$accessories = $this->_page->GetAccessories();
		foreach ($accessories as $accessory)
		{
			$reservationSeries->AddAccessory(new ReservationAccessory($accessory->Id, $accessory->Quantity, $accessory->Name));
		}

		$attributes = $this->_page->GetAttributes();
		foreach ($attributes as $attribute)
		{
			$reservationSeries->AddAttributeValue(new AttributeValue($attribute->Id, $attribute->Value));
		}

		$participantIds = $this->_page->GetParticipants();
		$reservationSeries->ChangeParticipants($participantIds);

		$inviteeIds = $this->_page->GetInvitees();
		$reservationSeries->ChangeInvitees($inviteeIds);

		$attachments = $this->_page->GetAttachments();

		foreach($attachments as $attachment)
		{
			if ($attachment != null)
			{
				if ($attachment->IsError())
				{
					Log::Error('Error attaching file %s. %s', $attachment->OriginalName(), $attachment->Error());
				}
				else
				{
					$att = ReservationAttachment::Create($attachment->OriginalName(), $attachment->MimeType(), $attachment->Size(), $attachment->Contents(), $attachment->Extension(), 0);
					$reservationSeries->AddAttachment($att);
				}
			}
		}

		if ($this->_page->HasStartReminder())
		{
			$reservationSeries->AddStartReminder(new ReservationReminder($this->_page->GetStartReminderValue(), $this->_page->GetStartReminderInterval()));
		}

		if ($this->_page->HasEndReminder())
		{
			$reservationSeries->AddEndReminder(new ReservationReminder($this->_page->GetEndReminderValue(), $this->_page->GetEndReminderInterval()));
		}

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
			$this->_page->SetRequiresApproval($reservationSeries->RequiresApproval());
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

		$timezone = $this->userSession->Timezone;
		return DateRange::Create($startDate . ' ' . $startTime, $endDate . ' ' . $endTime, $timezone);
	}
}