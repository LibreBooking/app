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

class ActivationPresenterTests extends TestBase
{
	/**
	 * @var ActivationPresenter
	 */
	private $presenter;

	/**
	 * @var IActivationPage|PHPUnit_Framework_MockObject_MockObject
	 */
	private $page;

	/**
	 * @var IAccountActivation|PHPUnit_Framework_MockObject_MockObject
	 */
	private $accountActivation;

	public function setup()
	{
		parent::setup();

		$this->presenter = new ActivationPresenter($this->page, $this->accountActivation);
	}

	public function testResendEmail()
	{
		
		
	}
	
	public function testActivatesAccount()
	{
		
	}

	public function testWhenAccountCannotBeActivated()
	{

	}
}

?>