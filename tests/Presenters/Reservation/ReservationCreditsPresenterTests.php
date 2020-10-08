<?php
/**
 * Copyright 2017-2020 Nick Korbel
 *
 * This file is part of Booked Scheduler.
 *
 * Booked Scheduler is free software: you can redistribute it and/or modify
 * it under the terms of the GNU General Public License as published by
 * the Free Software Foundation, either version 3 of the License, or
 * (at your option) any later version.
 *
 * Booked Scheduler is distributed in the hope that it will be useful,
 * but WITHOUT ANY WARRANTY; without even the implied warranty of
 * MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
 * GNU General Public License for more details.
 *
 * You should have received a copy of the GNU General Public License
 * along with Booked Scheduler.  If not, see <http://www.gnu.org/licenses/>.
 */

require_once(ROOT_DIR . 'Presenters/Reservation/ReservationCreditsPresenter.php');

class ReservationCreditsPresenterTests extends TestBase
{
	/**
	 * @var FakeReservationCreditsPage
	 */
	private $page;
	/**
	 * @var ReservationCreditsPresenter
	 */
	private $presenter;
	/**
	 * @var FakeReservationRepository
	 */
	private $reservationRepository;
	/**
	 * @var FakeScheduleRepository
	 */
	private $scheduleRepository;
	/**
	 * @var FakeResourceRepository
	 */
	private $resourceRepository;
	/**
	 * @var FakePaymentRepository
	 */
	private $paymentRepository;
	/**
	 * @var FakeAccessoryRepository
	 */
	private $accessoryRepository;

	public function setUp(): void
	{
		parent::setup();

		$this->page = new FakeReservationCreditsPage();
		$this->reservationRepository = new FakeReservationRepository();
		$this->scheduleRepository = new FakeScheduleRepository();
		$this->resourceRepository = new FakeResourceRepository();
		$this->paymentRepository = new FakePaymentRepository();
		$this->accessoryRepository = new FakeAccessoryRepository();

		$this->presenter = new ReservationCreditsPresenter($this->page,
														   $this->reservationRepository,
														   $this->scheduleRepository,
														   $this->resourceRepository,
														   $this->paymentRepository,
														   $this->accessoryRepository);

		$this->fakeConfig->SetSectionKey(ConfigSection::CREDITS, ConfigKeys::CREDITS_ENABLED, 'true');
		$this->fakeConfig->SetSectionKey(ConfigSection::CREDITS, ConfigKeys::CREDITS_ALLOW_PURCHASE, 'true');
	}

	public function testReturnsNumberOfCreditsConsumedForNewReservation()
	{
		$scheduleId = 100;
		$resource1 = new FakeBookableResource(1);
		$resource1->ChangeCredits(1, 0, CreditApplicability::SLOT);
		$resource1->SetScheduleId($scheduleId);
		$resource2 = new FakeBookableResource(2);
		$resource2->ChangeCredits(1, 0, CreditApplicability::SLOT);
		$resource2->SetScheduleId($scheduleId);

		foreach ($this->page->GetAccessories() as $a)
		{
			$accessory = new Accessory($a->Id, "name", 100);
			$accessory->ChangeCredits(1, 1, CreditApplicability::SLOT);
			$this->accessoryRepository->_AccessoryList[$a->Id] = $accessory;
		}

		$fakeScheduleLayout = new FakeScheduleLayout();
		$this->scheduleRepository->_Layout = $fakeScheduleLayout;
		$fakeScheduleLayout->_SlotCount = new SlotCount(5, 0);

		$expectedCost = Booked\Currency::Create('USD')->Format(300);

		$this->paymentRepository->_CreditCost = new CreditCost(15, 'USD');

		$this->page->_ResourceId = 1;
		$this->page->_ResourceIds = [2];

		$this->resourceRepository->_ResourceList[1] = $resource1;
		$this->resourceRepository->_ResourceList[2] = $resource2;

		$this->presenter->PageLoad($this->fakeUser);

		$this->assertEquals(20, $this->page->_CreditsRequired, '2 resources for 5 slots + 1 accessory x 2 quantity for 5 slots');
		$this->assertEquals($expectedCost, $this->page->_CreditCost, '15 * 20');
	}

	public function testReturnsNumberOfCreditsConsumedForExistingReservation()
	{
		$pageDate = Date::Now()->AddDays(1);
		$scheduleId = 100;
		$resource1 = new FakeBookableResource(1);
		$resource1->ChangeCredits(1, 0, CreditApplicability::SLOT);
		$resource1->SetScheduleId($scheduleId);
		$resource2 = new FakeBookableResource(2);
		$resource2->ChangeCredits(1, 0, CreditApplicability::SLOT);
		$resource2->SetScheduleId($scheduleId);

		foreach ($this->page->GetAccessories() as $a)
		{
			$accessory = new Accessory($a->Id, "name", 100);
			$accessory->ChangeCredits(1, 1, CreditApplicability::SLOT);
			$this->accessoryRepository->_AccessoryList[$a->Id] = $accessory;
		}

		$builder = new ExistingReservationSeriesBuilder();
		$series = $builder->Build();
		$this->reservationRepository->_Series = $series;

		$fakeScheduleLayout = new FakeScheduleLayout();
		$this->scheduleRepository->_Layout = $fakeScheduleLayout;
		$fakeScheduleLayout->_SlotCount = new SlotCount(5, 0);

		$this->page->_ResourceId = 1;
		$this->page->_ResourceIds = array(2);
		$this->page->_ReferenceNumber = '123';
		$this->page->_StartDate = $pageDate->Format('Y-m-d');
		$this->page->_StartTime = '01:00';
		$this->page->_EndDate = $pageDate->Format('Y-m-d');
		$this->page->_EndTime = '02:00';

		$this->resourceRepository->_ResourceList[1] = $resource1;
		$this->resourceRepository->_ResourceList[2] = $resource2;

		$this->presenter->PageLoad($this->fakeUser);

		$this->assertEquals(20, $this->page->_CreditsRequired, 'two resources for 5 slots + 1 accessory x 2 quantity for 5 slots');
	}
}

class FakeReservationCreditsPage implements IReservationCreditsPage
{
	/**
	 * @var int
	 */
	public $_CreditsRequired;
	/**
	 * @var int
	 */
	public $_ResourceId;
	/**
	 * @var string
	 */
	public $_RepeatType;
	/**
	 * @var string
	 */
	public $_RepeatInterval;
	/**
	 * @var int[]|null
	 */
	public $_RepeatWeekdays = [];
	/**
	 * @var string
	 */
	public $_RepeatMonthlyType;
	/**
	 * @var string
	 */
	public $_RepeatTerminationDate;
	/**
	 * @var int
	 */
	public $_UserId;
	/**
	 * @var string
	 */
	public $_StartDate;
	/**
	 * @var string
	 */
	public $_EndDate;
	/**
	 * @var string
	 */
	public $_StartTime;
	/**
	 * @var string
	 */
	public $_EndTime;
	/**
	 * @var int[]|null
	 */
	public $_ResourceIds;
	/**
	 * @var string
	 */
	public $_ReferenceNumber;
	/**
	 * @var string
	 */
	public $_CreditCost;

	/**
	 * @var Date[]
	 */
	public $_RepeatCustomDates = [];
	public $_Accessories = [];

	public function __construct()
	{
		$start = Date::Now()->AddHours(1);
		$end = $start->AddHours(1);

		$this->_ResourceId = 1;
		$this->_UserId = 2;
		$this->_StartDate = $start->Format('Y-m-d');
		$this->_EndDate = $end->Format('Y-m-d');
		$this->_StartTime = $start->Format('H:i');
		$this->_EndTime = $end->Format('H:i');
		$this->_Accessories = [AccessoryFormElement::Create(1, 2)];
	}

	public function GetRepeatType()
	{
		return $this->_RepeatType;
	}

	public function GetRepeatInterval()
	{
		return $this->_RepeatInterval;
	}

	public function GetRepeatWeekdays()
	{
		return $this->_RepeatWeekdays;
	}

	public function GetRepeatMonthlyType()
	{
		return $this->_RepeatMonthlyType;
	}

	public function GetRepeatTerminationDate()
	{
		return $this->_RepeatTerminationDate;
	}

	public function GetUserId()
	{
		return $this->_UserId;
	}

	public function GetResourceId()
	{
		return $this->_ResourceId;
	}

	public function GetStartDate()
	{
		return $this->_StartDate;
	}

	public function GetEndDate()
	{
		return $this->_EndDate;
	}

	public function GetStartTime()
	{
		return $this->_StartTime;
	}

	public function GetEndTime()
	{
		return $this->_EndTime;
	}

	public function GetResources()
	{
		return $this->_ResourceIds;
	}

	public function GetReferenceNumber()
	{
		return $this->_ReferenceNumber;
	}

	public function SetCreditRequired($creditsRequired, $cost)
	{
		$this->_CreditsRequired = $creditsRequired;
		$this->_CreditCost = $cost;
	}

	public function GetRepeatCustomDates()
	{
		return $this->_RepeatCustomDates;
	}

	public function GetAccessories()
	{
		return $this->_Accessories;
	}
}