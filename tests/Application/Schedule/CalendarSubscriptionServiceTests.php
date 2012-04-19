<?php
/**
Copyright 2012 Nick Korbel

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
require_once(ROOT_DIR . 'lib/Application/Schedule/namespace.php');

class CalendarSubscriptionServiceTests extends TestBase
{
    /**
     * @var CalendarSubscriptionService
     */
    private $service;

    /**
     * @var IUserRepository|PHPUnit_Framework_MockObject_MockObject
     */
    private $userRepo;

    /**
     * @var IResourceRepository|PHPUnit_Framework_MockObject_MockObject
     */
    private $resourceRepo;

    /**
     * @var IScheduleRepository|PHPUnit_Framework_MockObject_MockObject
     */
    private $scheduleRepo;

    public function setup()
    {
        parent::setup();

        $this->userRepo = $this->getMock('IUserRepository');
        $this->resourceRepo = $this->getMock('IResourceRepository');
        $this->scheduleRepo = $this->getMock('IScheduleRepository');

        $this->service = new CalendarSubscriptionService($this->userRepo, $this->resourceRepo, $this->scheduleRepo);
    }

    public function testGetsUserByPublicId()
    {
        $expected = new FakeUser();
        $publicId = uniqid();

        $this->userRepo->expects($this->once())
                ->method('LoadByPublicId')
                ->with($this->equalTo($publicId))
                ->will($this->returnValue($expected));

        $actual = $this->service->GetUser($publicId);

        $this->assertEquals($expected, $actual);
    }

    public function testGetsResourceByPublicId()
    {
        $expected = new FakeBookableResource(123);
        $publicId = uniqid();

        $this->resourceRepo->expects($this->once())
                ->method('LoadByPublicId')
                ->with($this->equalTo($publicId))
                ->will($this->returnValue($expected));

        $actual = $this->service->GetResource($publicId);

        $this->assertEquals($expected, $actual);
    }

    public function testGetsScheduleByPublicId()
    {
        $expected = new FakeSchedule();
        $publicId = uniqid();

        $this->scheduleRepo->expects($this->once())
                ->method('LoadByPublicId')
                ->with($this->equalTo($publicId))
                ->will($this->returnValue($expected));

        $actual = $this->service->GetSchedule($publicId);

        $this->assertEquals($expected, $actual);
    }
}

?>