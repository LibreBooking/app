<?php

class AdminExcludedRuleTests extends TestBase
{
    /**
     * @var AdminExcludedRule
     */
    private $rule;

    /**
     * @var IReservationValidationRule|PHPUnit_Framework_MockObject_MockObject
     */
    private $baseRule;

    /**
     * @var IUserRepository|PHPUnit_Framework_MockObject_MockObject
     */
    private $userRepository;

    /**
     * @var User|PHPUnit_Framework_MockObject_MockObject
     */
    private $user;

    /**
     * @var TestReservationSeries
     */
    private $reservationSeries;

    private $resource1;
    private $resource2;

    public function setUp(): void
    {
        parent::setup();

        $this->userRepository = $this->createMock('IUserRepository');
        $this->baseRule = $this->createMock('IReservationValidationRule');
        $this->user =  $this->createMock('User');

        $this->rule = new AdminExcludedRule($this->baseRule, $this->fakeUser, $this->userRepository);

        $this->reservationSeries = new TestReservationSeries();
        $this->resource1 = new FakeBookableResource(1);
        $this->resource2 = new FakeBookableResource(2);

        $this->reservationSeries->WithResource($this->resource1);
        $this->reservationSeries->AddResource($this->resource2);
    }

    public function testIfUserIsApplicationAdmin_ReturnTrue()
    {
        $this->fakeUser->IsAdmin = true;

        $result = $this->rule->Validate($this->reservationSeries, null);

        $this->assertTrue($result->IsValid());
    }

    public function testIfUserIsAdminForAllResources_ReturnTrue()
    {
        $this->fakeUser->IsAdmin = false;
        $this->fakeUser->IsScheduleAdmin = true;

        $this->userRepository->expects($this->once())
                    ->method('LoadById')
                    ->with($this->equalTo($this->fakeUser->UserId))
                    ->will($this->returnValue($this->user));

        $this->user->expects($this->at(0))
                    ->method('IsResourceAdminFor')
                    ->with($this->equalTo($this->resource1))
                    ->will($this->returnValue(true));

        $this->user->expects($this->at(1))
                    ->method('IsResourceAdminFor')
                    ->with($this->equalTo($this->resource2))
                    ->will($this->returnValue(true));

        $result = $this->rule->Validate($this->reservationSeries, null);

        $this->assertTrue($result->IsValid());
    }

    public function testIfUserIsNotAdminForAtLeastOneResource_InvokeBaseRule()
    {
        $expectedResult = new ReservationValidationResult(false, ['some error']);
        $this->fakeUser->IsAdmin = false;

        $this->userRepository->expects($this->once())
                    ->method('LoadById')
                    ->with($this->equalTo($this->fakeUser->UserId))
                    ->will($this->returnValue($this->user));

        $this->user->expects($this->at(0))
                    ->method('IsResourceAdminFor')
                    ->with($this->equalTo($this->resource1))
                    ->will($this->returnValue(true));

        $this->user->expects($this->at(1))
                    ->method('IsResourceAdminFor')
                    ->with($this->equalTo($this->resource2))
                    ->will($this->returnValue(false));

        $this->baseRule->expects($this->once())
                    ->method('Validate')
                    ->with($this->equalTo($this->reservationSeries))
                    ->will($this->returnValue($expectedResult));

        $result = $this->rule->Validate($this->reservationSeries, null);

        $this->assertEquals($expectedResult, $result);
    }

    public function testIfUserIsAdminForReservationUserReturnTrue()
    {
        $this->fakeUser->IsAdmin = false;
        $this->fakeUser->IsGroupAdmin = true;

        $adminUser =  $this->createMock('User');
        $reservationUser =  $this->createMock('User');

        $this->userRepository->expects($this->at(0))
                            ->method('LoadById')
                            ->with($this->equalTo($this->fakeUser->UserId))
                            ->will($this->returnValue($adminUser));

        $this->userRepository->expects($this->at(1))
                            ->method('LoadById')
                            ->with($this->equalTo($this->reservationSeries->UserId()))
                            ->will($this->returnValue($reservationUser));

        $adminUser->expects($this->once())
                    ->method('IsAdminFor')
                    ->with($this->equalTo($reservationUser))
                    ->will($this->returnValue(true));

        $result = $this->rule->Validate($this->reservationSeries, null);

        $this->assertTrue($result->IsValid());
    }
}
