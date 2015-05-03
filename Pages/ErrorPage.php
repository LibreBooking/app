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

require_once(ROOT_DIR . 'Pages/Page.php');

class ErrorPage extends Page
{
	public function __construct()
	{
		parent::__construct('Error');
	}

	public function PageLoad()
	{
		$returnUrl = $this->server->GetQuerystring(QueryStringKeys::REDIRECT);

		if (empty($returnUrl))
		{
			$returnUrl = "index.php";
		}

		$errorMessageKey = ErrorMessages::Instance()->GetResourceKey($this->server->GetQuerystring(QueryStringKeys::MESSAGE_ID));

		//TODO: Log

		$this->Set('ReturnUrl', urldecode($returnUrl));
		$this->Set('ErrorMessage', $errorMessageKey);
		$this->Display('error.tpl');
	}
}
?>