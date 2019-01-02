<?php
/**
Copyright 2011-2019 Nick Korbel

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

@define('BASE_DIR', dirname(__FILE__) . '/../..');
require_once(BASE_DIR . '/lib/PHPMailer.class.php');

class FakeMailer extends PHPMailer
{
	var $addresses = array();
	var $Subject = null;
	var $Body = null;
	var $sendWasCalled = false;
	var $isHtml = true;

	function FakeMailer() {

	}

	function AddAddress($address, $name = '') {
		$this->addresses[] = $address;
	}

	function Send() {
		$this->sendWasCalled = true;
	}

	function IsHTML($bool) {
		$this->isHtml = $bool;
	}
}
?>