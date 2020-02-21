<?php
/**
Copyright 2012-2020 Nick Korbel

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

require_once(ROOT_DIR . 'lib/Server/UserSession.php');
require_once(ROOT_DIR . 'Domain/Values/WebService/WebServiceExpiration.php');
require_once(ROOT_DIR . 'Domain/Values/WebService/WebServiceSessionToken.php');

class WebServiceUserSession extends UserSession
{
	public $SessionToken = '';
	public $SessionExpiration = '';

	public function __construct($id)
	{
		parent::__construct($id);
		$this->SessionToken = WebServiceSessionToken::Generate();
		$this->SessionExpiration = WebServiceExpiration::Create();
	}

	/**
	 * @param UserSession $session
	 * @return WebServiceUserSession
	 */
	public static function FromSession(UserSession $session)
	{
		$webSession = new WebServiceUserSession($session->UserId);

		$webSession->FirstName = $session->FirstName;
		$webSession->LastName = $session->LastName;
		$webSession->Email = $session->Email;
		$webSession->Timezone = $session->Timezone;
		$webSession->HomepageId = $session->HomepageId;
		$webSession->IsAdmin = $session->IsAdmin;
		$webSession->IsGroupAdmin = $session->IsGroupAdmin;
		$webSession->IsResourceAdmin = $session->IsResourceAdmin;
		$webSession->IsScheduleAdmin = $session->IsScheduleAdmin;
		$webSession->LanguageCode = $session->LanguageCode;
		$webSession->PublicId = $session->PublicId;
		$webSession->ScheduleId = $session->ScheduleId;
		$webSession->Groups = $session->Groups;
		$webSession->AdminGroups = $session->AdminGroups;

		return $webSession;
	}

	public function ExtendSession()
	{
		$this->SessionExpiration = WebServiceExpiration::Create();
	}

	/**
	 * @return bool
	 */
	public function IsExpired()
	{
		return WebServiceExpiration::IsExpired($this->SessionExpiration);
	}
}