<?php
/**
 * Copyright 2011-2016 Nick Korbel
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

require_once(ROOT_DIR . 'Domain/namespace.php');
require_once(ROOT_DIR . 'lib/Application/Reservation/Validation/namespace.php');

class CreditsRuleTests extends TestBase
{
	/**
	 * @var FakeUserRepository
	 */
	public $userRepository;

	/**
	 * @var AccessoryAvailabilityRule
	 */
	public $rule;

	public function setup()
	{
		parent::setup();

		$this->userRepository = new FakeUserRepository();

		$this->rule = new CreditsRule($this->userRepository, $this->fakeUser);

		$this->fakeConfig->SetSectionKey(ConfigSection::CREDITS, ConfigKeys::CREDITS_ENABLED, 'true');
	}

	public function testRuleIsValidIfUserHasEnoughCredits()
	{
		$reservation = new TestReservationSeries();
		$reservation->WithCreditsRequired(10);

		$user = new FakeUser();
		$user->WithCredits(10);

		$this->userRepository->_User = $user;

		$result = $this->rule->Validate($reservation, null);

		$this->assertTrue($result->IsValid());
	}

	public function testRuleIsNotValidIfUserDoesNotHaveEnoughCredits()
	{
		$reservation = new TestReservationSeries();
		$reservation->WithCreditsRequired(10);

		$user = new FakeUser();
		$user->WithCredits(9);

		$result = $this->rule->Validate($reservation, null);

		$this->assertFalse($result->IsValid());
	}


}