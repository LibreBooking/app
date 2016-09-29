<?php

/**
 * Copyright 2016 Nick Korbel
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

require_once(ROOT_DIR . 'lib/external/Google/autoload.php');
require_once(ROOT_DIR . 'lib/Application/Authentication/namespace.php');

class GoogleAuthentication
{
	const CLIENT_ID = '14982897376-5ah3dfgjsbhbrqtqv3ln289jl4b3vi85.apps.googleusercontent.com';
	const CLIENT_SECRET = 'kHwvAJIq0678Bvs4ULLP8O31';

	public function GetUser($code)
	{
		$client = new Google_Client();
		$client->setClientId(self::CLIENT_ID);
		$client->setClientSecret(self::CLIENT_SECRET);
		$client->setRedirectUri(Configuration::Instance()->GetScriptUrl() . '/external-auth.php?type=google');
		$client->authenticate($code);

		$oauth = new Google_Service_Oauth2($client);
		return $oauth->userinfo->get();
	}
}
