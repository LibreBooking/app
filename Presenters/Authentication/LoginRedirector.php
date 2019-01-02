<?php

/**
 * Copyright 2017-2019 Nick Korbel
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

require_once(ROOT_DIR . 'Pages/Authentication/ILoginBasePage.php');

class LoginRedirector
{
	public static function Redirect(ILoginBasePage $page)
	{
		$redirect = $page->GetResumeUrl();

		if (!empty($redirect))
		{
			$page->Redirect(html_entity_decode($redirect));
		}
		else
		{
			$defaultId = ServiceLocator::GetServer()->GetUserSession()->HomepageId;
			$url = Pages::UrlFromId($defaultId);
			$page->Redirect(empty($url) ? Pages::UrlFromId(Pages::DEFAULT_HOMEPAGE_ID) : $url);
		}
	}
}