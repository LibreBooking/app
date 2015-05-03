<?php
/**
Copyright 2012-2015 Nick Korbel

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

require_once(ROOT_DIR . 'Pages/Export/CalendarSubscriptionPage.php');
require_once(ROOT_DIR . 'lib/Application/Schedule/namespace.php');

class CalendarSubscriptionValidatorTests extends TestBase
{
    /**
     * @var ICalendarSubscriptionPage|PHPUnit_Framework_MockObject_MockObject
     */
    private $page;

    /**
     * @var CalendarSubscriptionValidator
     */
    private $validator;

    /**
     * @var ICalendarSubscriptionService|PHPUnit_Framework_MockObject_MockObject
     */
    private $subscriptionService;

    public function setup()
    {
        parent::setup();

        $this->page = $this->getMock('ICalendarSubscriptionPage');
        $this->subscriptionService = $this->getMock('ICalendarSubscriptionService');
        $this->validator = new CalendarSubscriptionValidator($this->page, $this->subscriptionService);
    }

    public function testIsNotValidWhenTurnedOffForResource()
    {
        $resource = new FakeBookableResource(12);
        $resource->DisableSubscription();

        $publicId = uniqid();

        $this->page->expects($this->once())
                ->method('GetResourceId')
                ->will($this->returnValue($publicId));

        $this->subscriptionService->expects($this->once())
                ->method('GetResource')
                ->with($this->equalTo($publicId))
                ->will($this->returnValue($resource));

        $this->StubSubscriptionKey();

        $isValid = $this->validator->IsValid();

        $this->assertFalse($isValid);
    }

    public function testIsNotValidWhenTurnedOffForSchedule()
    {
        $schedule = new FakeSchedule(12);
        $schedule->DisableSubscription();

        $publicId = uniqid();

        $this->page->expects($this->once())
                ->method('GetScheduleId')
                ->will($this->returnValue($publicId));

        $this->subscriptionService->expects($this->once())
                ->method('GetSchedule')
                ->with($this->equalTo($publicId))
                ->will($this->returnValue($schedule));

        $this->StubSubscriptionKey();

        $isValid = $this->validator->IsValid();

        $this->assertFalse($isValid);
    }

    public function testIsNotValidWhenTurnedOffForUser()
    {
        $user = new FakeUser();
        $user->DisableSubscription();

        $publicId = uniqid();

        $this->page->expects($this->once())
                ->method('GetUserId')
                ->will($this->returnValue($publicId));

        $this->subscriptionService->expects($this->once())
                ->method('GetUser')
                ->with($this->equalTo($publicId))
                ->will($this->returnValue($user));

        $this->StubSubscriptionKey();

        $isValid = $this->validator->IsValid();

        $this->assertFalse($isValid);
    }

    public function testIsNotValidWhenSubscriptionKeyDoesNotMatch()
    {
        $this->page->expects($this->once())
            ->method('GetSubscriptionKey')
            ->will($this->returnValue('12'));

        $this->fakeConfig->SetSectionKey(ConfigSection::ICS, ConfigKeys::ICS_SUBSCRIPTION_KEY, '123');

        $isValid = $this->validator->IsValid();

        $this->assertFalse($isValid);
    }

    public function testIsNotValidWhenSubscriptionKeyIsNotConfigured()
    {
        $this->fakeConfig->SetSectionKey(ConfigSection::ICS, ConfigKeys::ICS_SUBSCRIPTION_KEY, '');

        $isValid = $this->validator->IsValid();

        $this->assertFalse($isValid);
    }

    private function StubSubscriptionKey()
    {
        $this->page->expects($this->once())
            ->method('GetSubscriptionKey')
            ->will($this->returnValue('123'));

        $this->fakeConfig->SetSectionKey(ConfigSection::ICS, ConfigKeys::ICS_SUBSCRIPTION_KEY, '123');
    }
}

?>