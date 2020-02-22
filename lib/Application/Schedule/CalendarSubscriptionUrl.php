<?php
/**
Copyright 2013-2020 Nick Korbel

This file is part of Booked Scheduler is free software: you can redistribute it and/or modify
it under the terms of the GNU General Public License as published by
the Free Software Foundation, either version 3 of the License, or
(at your option) any later version is distributed in the hope that it will be useful,
but WITHOUT ANY WARRANTY; without even the implied warranty of
MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
GNU General Public License for more details.

You should have received a copy of the GNU General Public License
along with Booked Scheduler.  If not, see <http://www.gnu.org/licenses/>.
 */

class CalendarSubscriptionUrl
{
    /**
     * @var Url
     */
    private $url;

	const PAGE_TOKEN = '{page}';

    public function __construct($userPublicId, $schedulePublicId, $resourcePublicId)
    {
        $config = Configuration::Instance();
		$subscriptionKey = $config->GetSectionKey(ConfigSection::ICS, ConfigKeys::ICS_SUBSCRIPTION_KEY);

		if (empty($subscriptionKey))
		{
			$this->url = new Url('#');
			return;
		}

        $scriptUrl = $config->GetScriptUrl();
        $scriptUrl .= '/export/' . self::PAGE_TOKEN;
		$url = new Url($scriptUrl);

        $url->AddQueryString(QueryStringKeys::USER_ID, $userPublicId);
        $url->AddQueryString(QueryStringKeys::SCHEDULE_ID, $schedulePublicId);
        $url->AddQueryString(QueryStringKeys::RESOURCE_ID, $resourcePublicId);
		$url->AddQueryString(QueryStringKeys::SUBSCRIPTION_KEY, $subscriptionKey);
        $this->url = $url;
    }

	public function GetWebcalUrl()
	{
		$scriptUrl = $this->url->ToString();
		return str_replace(self::PAGE_TOKEN,  Pages::CALENDAR_SUBSCRIBE, $scriptUrl);
	}

	public function GetAtomUrl()
	{
		$scriptUrl = $this->url->ToString();
		return str_replace(self::PAGE_TOKEN, Pages::CALENDAR_SUBSCRIBE_ATOM, $scriptUrl);
	}

    public function __toString()
    {
        return $this->GetWebcalUrl();
    }
}
