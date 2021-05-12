<?php

require_once(ROOT_DIR . 'Presenters/Admin/ManageReservationsPresenter.php');

class ManageReservationsPresenterTests extends TestBase
{
    /**
     * @var ManageReservationsPresenter
     */
    private $presenter;

    /**
     * @var IManageReservationsPage|PHPUnit_Framework_MockObject_MockObject
     */
    private $page;

    /**
     * @var IManageReservationsService|PHPUnit_Framework_MockObject_MockObject
     */
    private $reservationsService;

    /**
     * @var IScheduleRepository|PHPUnit_Framework_MockObject_MockObject
     */
    private $scheduleRepository;

    /**
     * @var IResourceRepository|PHPUnit_Framework_MockObject_MockObject
     */
    private $resourceRepository;

    /**
     * @var IAttributeService|PHPUnit_Framework_MockObject_MockObject
     */
    private $attributeService;

    /**
     * @var IUserRepository|PHPUnit_Framework_MockObject_MockObject
     */
    private $userRepository;

    /**
     * @var ITermsOfServiceRepository|PHPUnit_Framework_MockObject_MockObject
     */
    private $termsOfServiceRepository;

    public function setUp(): void
    {
        parent::setup();

        $this->page = $this->createMock('IManageReservationsPage');
        $this->reservationsService = $this->createMock('IManageReservationsService');
        $this->scheduleRepository = $this->createMock('IScheduleRepository');
        $this->resourceRepository = $this->createMock('IResourceRepository');
        $this->attributeService = $this->createMock('IAttributeService');
        $this->userRepository = $this->createMock('IUserRepository');
        $this->termsOfServiceRepository = $this->createMock('ITermsOfServiceRepository');

        $this->presenter = new ManageReservationsPresenter($this->page,
            $this->reservationsService,
            $this->scheduleRepository,
            $this->resourceRepository,
            $this->attributeService,
            $this->userRepository,
            $this->termsOfServiceRepository);

        $this->userRepository->expects($this->any())
            ->method('LoadById')
            ->with($this->anything())
            ->will($this->returnValue(new FakeUser()));
    }

    public function testUsesTwoWeekSpanWhenNoDateFilterProvided()
    {
        $userTimezone = 'America/Chicago';
        $defaultStart = Date::Now()->AddDays(-7)->ToTimezone($userTimezone)->GetDate();
        $defaultEnd = Date::Now()->AddDays(7)->ToTimezone($userTimezone)->GetDate();
        $searchedScheduleId = 15;
        $searchedResourceId = 105;
        $searchedStatusId = ReservationStatus::Pending;
        $searchedUserId = 111;
        $searchedReferenceNumber = 'abc123';
        $searchedUserName = 'some user';
        $searchedResourceStatusId = 292;
        $searchedResourceStatusReasonId = 4292;
        /** @var TestCustomAttribute[] $customAttributes */
        $customAttributes = array(new TestCustomAttribute(1, 'something'));
        /** @var Attribute[] $attributes */
        $attributes = array(new Attribute($customAttributes[0], 'value'));

        $this->resourceRepository->expects($this->once())
            ->method('GetStatusReasons')
            ->will($this->returnValue(array()));

        $this->page->expects($this->any())
            ->method('FilterButtonPressed')
            ->will($this->returnValue(true));

        $this->page->expects($this->atLeastOnce())
            ->method('GetStartDate')
            ->will($this->returnValue(null));

        $this->page->expects($this->atLeastOnce())
            ->method('GetEndDate')
            ->will($this->returnValue(null));

        $this->page->expects($this->atLeastOnce())
            ->method('GetScheduleId')
            ->will($this->returnValue($searchedScheduleId));

        $this->page->expects($this->atLeastOnce())
            ->method('GetResourceId')
            ->will($this->returnValue($searchedResourceId));

        $this->page->expects($this->atLeastOnce())
            ->method('GetReservationStatusId')
            ->will($this->returnValue($searchedStatusId));

        $this->page->expects($this->atLeastOnce())
            ->method('GetUserId')
            ->will($this->returnValue($searchedUserId));

        $this->page->expects($this->atLeastOnce())
            ->method('GetUserName')
            ->will($this->returnValue($searchedUserName));

        $this->page->expects($this->atLeastOnce())
            ->method('GetReferenceNumber')
            ->will($this->returnValue($searchedReferenceNumber));

        $this->page->expects($this->atLeastOnce())
            ->method('GetResourceStatusFilterId')
            ->will($this->returnValue($searchedResourceStatusId));

        $this->page->expects($this->atLeastOnce())
            ->method('GetResourceStatusReasonFilterId')
            ->will($this->returnValue($searchedResourceStatusReasonId));

        $this->page->expects($this->atLeastOnce())
            ->method('GetAttributeFilters')
            ->will($this->returnValue(array(new AttributeFormElement($customAttributes[0]->Id(), 'value'))));

        $filter = $this->GetExpectedFilter($defaultStart, $defaultEnd, $searchedReferenceNumber, $searchedScheduleId,
            $searchedResourceId, $searchedUserId, $searchedStatusId,
            $searchedResourceStatusId, $searchedResourceStatusReasonId, $attributes);

        $data = new PageableData($this->getReservations());
        $this->reservationsService->expects($this->once())
            ->method('LoadFiltered')
            ->with($this->anything(), $this->anything(), $this->anything(), $this->anything(), $this->equalTo($filter),
                $this->equalTo($this->fakeUser))
            ->will($this->returnValue($data));

        $this->attributeService->expects($this->once())
            ->method('GetByCategory')
            ->with($this->equalTo(CustomAttributeCategory::RESERVATION))
            ->will($this->returnValue($customAttributes));

        $this->page->expects($this->once())
            ->method('SetAttributeFilters')
            ->with($attributes);

        $this->page->expects($this->once())
            ->method('SetStartDate')
            ->with($this->equalTo($defaultStart));

        $this->page->expects($this->once())
            ->method('SetEndDate')
            ->with($this->equalTo($defaultEnd));

        $this->page->expects($this->once())
            ->method('SetReferenceNumber')
            ->with($this->equalTo($searchedReferenceNumber));

        $this->page->expects($this->once())
            ->method('SetScheduleId')
            ->with($this->equalTo($searchedScheduleId));

        $this->page->expects($this->once())
            ->method('SetResourceId')
            ->with($this->equalTo($searchedResourceId));

        $this->page->expects($this->once())
            ->method('SetReservationStatusId')
            ->with($this->equalTo($searchedStatusId));

        $this->page->expects($this->once())
            ->method('SetUserId')
            ->with($this->equalTo($searchedUserId));

        $this->page->expects($this->once())
            ->method('SetUserName')
            ->with($this->equalTo($searchedUserName));

        $this->page->expects($this->once())
            ->method('SetUserName')
            ->with($this->equalTo($searchedUserName));

        $this->page->expects($this->once())
            ->method('SetResourceStatusFilterId')
            ->with($this->equalTo($searchedResourceStatusId));

        $this->page->expects($this->once())
            ->method('SetResourceStatusReasonFilterId')
            ->with($this->equalTo($searchedResourceStatusReasonId));

        $this->presenter->PageLoad($userTimezone);
    }

    public function testUpdatesSingleResourceStatus()
    {
        $resourceId = 19191;
        $resourceStatusId = ResourceStatus::HIDDEN;
        $resourceStatusReasonId = 111;
        $referenceNumber = 'abc123';

        $resource = new FakeBookableResource($resourceId);
        $resource->ChangeStatus(ResourceStatus::AVAILABLE, null);

        $this->page->expects($this->once())
            ->method('CanUpdateResourceStatuses')
            ->will($this->returnValue(true));

        $this->page->expects($this->once())
            ->method('GetResourceStatus')
            ->will($this->returnValue($resourceStatusId));

        $this->page->expects($this->once())
            ->method('GetUpdateScope')
            ->will($this->returnValue(''));

        $this->page->expects($this->once())
            ->method('GetResourceStatusReason')
            ->will($this->returnValue($resourceStatusReasonId));

        $this->page->expects($this->once())
            ->method('GetUpdateResourceId')
            ->will($this->returnValue($resourceId));

        $this->page->expects($this->once())
            ->method('GetResourceStatusReferenceNumber')
            ->will($this->returnValue($referenceNumber));

        $this->resourceRepository->expects($this->once())
            ->method('LoadById')
            ->with($resourceId)
            ->will($this->returnValue($resource));

        $this->resourceRepository->expects($this->once())
            ->method('Update')
            ->with($this->anything());

        $this->presenter->UpdateResourceStatus();

        $this->assertEquals($resourceStatusId, $resource->GetStatusId());
        $this->assertEquals($resourceStatusReasonId, $resource->GetStatusReasonId());
    }

    public function testUpdatesReservationResourceStatuses()
    {
        $resourceStatusId = ResourceStatus::HIDDEN;
        $resourceStatusReasonId = 111;
        $referenceNumber = 'abc123';

        $reservations = array(new TestReservationItemView(1, Date::Now(), Date::Now(), 1), new TestReservationItemView(1, Date::Now(), Date::Now(), 2));
        $pageableReservations = new PageableData($reservations);

        $resource1 = new FakeBookableResource(1);
        $resource1->ChangeStatus(ResourceStatus::AVAILABLE, null);

        $resource2 = new FakeBookableResource(2);
        $resource2->ChangeStatus(ResourceStatus::AVAILABLE, null);

        $this->page->expects($this->once())
            ->method('CanUpdateResourceStatuses')
            ->will($this->returnValue(true));

        $this->page->expects($this->once())
            ->method('GetResourceStatus')
            ->will($this->returnValue($resourceStatusId));

        $this->page->expects($this->once())
            ->method('GetUpdateScope')
            ->will($this->returnValue('all'));

        $this->page->expects($this->once())
            ->method('GetResourceStatusReason')
            ->will($this->returnValue($resourceStatusReasonId));

        $this->page->expects($this->once())
            ->method('GetResourceStatusReferenceNumber')
            ->will($this->returnValue($referenceNumber));

        $this->reservationsService->expects($this->once())
            ->method('LoadFiltered')
            ->with($this->isNull(), $this->isNull(), $this->anything(), $this->anything(),
                $this->equalTo(new ReservationFilter(null, null, $referenceNumber, null, null, null, null, null)),
                $this->equalTo($this->fakeUser))
            ->will($this->returnValue($pageableReservations));

        $this->resourceRepository->expects($this->at(0))
            ->method('LoadById')
            ->with(1)
            ->will($this->returnValue($resource1));

        $this->resourceRepository->expects($this->at(2))
            ->method('LoadById')
            ->with(2)
            ->will($this->returnValue($resource2));

        $this->resourceRepository->expects($this->at(1))
            ->method('Update')
            ->with($this->anything());

        $this->resourceRepository->expects($this->at(3))
            ->method('Update')
            ->with($this->anything());

        $this->presenter->UpdateResourceStatus();

        $this->assertEquals($resourceStatusId, $resource1->GetStatusId());
        $this->assertEquals($resourceStatusReasonId, $resource1->GetStatusReasonId());
    }

    public function testLoadsReservation()
    {
        $referenceNumber = 'rn';

        $reservationView = new ReservationView();

        $this->page->expects($this->once())
            ->method('GetReferenceNumber')
            ->will($this->returnValue($referenceNumber));

        $this->reservationsService->expects($this->once())
            ->method('LoadByReferenceNumber')
            ->with($this->equalTo($referenceNumber), $this->equalTo($this->fakeUser))
            ->will($this->returnValue($reservationView));

        $this->page->expects($this->once())
            ->method('SetReservationJson')
            ->with($this->equalTo($reservationView));

        $this->presenter->ProcessDataRequest('load');
    }

    public function testUpdatesReservationAttribute()
    {
        $referenceNumber = 'rn';
        $attrId = 'attid';
        $attrValue = 'val';

        $this->page->expects($this->once())
            ->method('GetReferenceNumber')
            ->will($this->returnValue($referenceNumber));

        $this->page->expects($this->once())
            ->method('GetName')
            ->will($this->returnValue($attrId));

        $this->page->expects($this->once())
            ->method('GetValue')
            ->will($this->returnValue($attrValue));

        $this->reservationsService->expects($this->once())
            ->method('UpdateAttribute')
            ->with($this->equalTo($referenceNumber), $this->equalTo($attrId), $this->equalTo($attrValue), $this->equalTo($this->fakeUser))
            ->will($this->returnValue(array()));

        $this->presenter->UpdateAttribute();
    }

    public function testImportsReservations()
    {
        ReferenceNumberGenerator::$__referenceNumber = 'test';
        $this->fakeUser->IsAdmin = true;

        $importFile = new FakeUploadedFile();
        $importFile->Contents = "email,resource names,title,description,begin,end,att1,att2\n" .
            "u@e.com,\"r1,r2\",title,description,1/2/17 8:30 am,1/2/17 9:30 am,a1value,a2value\n" .
            "u2@e.com,r2,title2,description2,1/4/17 8:30 pm,1/4/17 22:00,,\n" .
            "madeupuser,r2,title2,description2,1/4/17 8:30 pm,1/4/17 22:00,,\n" .
            "u@e.com,makeupresource,title2,description2,1/4/17 8:30 pm,1/4/17 22:00,,\n" .
            "u@e.com,r2,title2,description2,unparseabledate,1/4/17 22:00,,";

        $attributes = array(new TestCustomAttribute(1, 'att1'), new TestCustomAttribute(2, 'att2'), new TestCustomAttribute(3, 'att3'));

        $resources = array(new FakeBookableResource(1, 'r1'), new FakeBookableResource(2, 'r2'));

        $users = array(new FakeUser(1, 'u@e.com'), new FakeUser(2, 'u2@e.com'));

        $res1 = ReservationSeries::Create(1, $resources[0], 'title', 'description', DateRange::Create('2017-1-2 8:30', '2017-1-2 9:30', $this->fakeUser->Timezone), new RepeatNone(), $this->fakeUser);
        $res1->AddResource($resources[1]);
        $res1->AddAttributeValue(new AttributeValue(1, 'a1value'));
        $res1->AddAttributeValue(new AttributeValue(2, 'a2value'));

        $res2 = ReservationSeries::Create(2, $resources[1], 'title2', 'description2', DateRange::Create('2017-1-4 20:30', '2017-1-4 22:00', $this->fakeUser->Timezone), new RepeatNone(), $this->fakeUser);

        $this->page->expects($this->once())
            ->method('GetImportFile')
            ->will($this->returnValue($importFile));

        $this->attributeService->expects($this->once())
            ->method('GetByCategory')
            ->with($this->equalTo(CustomAttributeCategory::RESERVATION))
            ->will($this->returnValue($attributes));

        $this->resourceRepository->expects($this->once())
            ->method('GetResourceList')
            ->will($this->returnValue($resources));

        $this->userRepository->expects($this->once())
            ->method('GetAll')
            ->will($this->returnValue($users));

        $this->reservationsService->expects($this->at(0))
            ->method('UnsafeAdd')
            ->with($this->equalTo($res1));

        $this->reservationsService->expects($this->at(1))
            ->method('UnsafeAdd')
            ->with($this->equalTo($res2));

        $this->page->expects($this->once())
            ->method('SetImportResult')
            ->with($this->equalTo(new CsvImportResult(2, array(), array('Invalid data in row 3. Ensure the user and resource in this row exist.', 'Invalid data in row 4. Ensure the user and resource in this row exist.', 'Invalid data in row 5'))));

        $this->presenter->ImportReservations();
    }

    public function testDeletesMultiple()
    {
        $ids = array(1, 2);

        $this->page->expects($this->once())
            ->method('GetDeletedReservationIds')
            ->will($this->returnValue($ids));

        $this->reservationsService->expects($this->at(0))
            ->method('UnsafeDelete')
            ->with($this->equalTo(1), $this->equalTo($this->fakeUser));

        $this->reservationsService->expects($this->at(1))
            ->method('UnsafeDelete')
            ->with($this->equalTo(2), $this->equalTo($this->fakeUser));

        $this->presenter->DeleteMultiple();
    }

    /**
     * @param Date $startDate
     * @param Date $endDate
     * @param string $referenceNumber
     * @param int $scheduleId
     * @param int $resourceId
     * @param int $userId
     * @param int $statusId
     * @param null $resourceStatusId
     * @param null $resourceStatusReasonId
     * @param Attribute[] $attributes
     * @return ReservationFilter
     */
    private function GetExpectedFilter($startDate = null, $endDate = null, $referenceNumber = null, $scheduleId = null,
                                       $resourceId = null, $userId = null, $statusId = null, $resourceStatusId = null,
                                       $resourceStatusReasonId = null, $attributes = null)
    {
        return new ReservationFilter($startDate, $endDate, $referenceNumber, $scheduleId, $resourceId, $userId, $statusId, $resourceStatusId, $resourceStatusReasonId, $attributes);
    }

    private function getReservations()
    {
        $reservations = array();
        for ($i = 1; $i <= 10; $i++) {
            $r1 = new ReservationItemView();
            $r1->SeriesId = $i;
            $reservations[] = $r1;
        }

        return $reservations;

    }
}
