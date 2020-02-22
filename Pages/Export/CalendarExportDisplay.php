<?php
/**
Copyright 2017-2020 Nick Korbel

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

class CalendarExportDisplay extends Page
{
	public function __construct()
	{
		parent::__construct();
	}

	/**
	 * @param $reservations iCalendarReservationView[]
	 * @return string
	 */
	public function Render($reservations)
	{
		$config = Configuration::Instance();

		$this->Set('bookedVersion', $config->GetKey(ConfigKeys::VERSION));
		$this->Set('DateStamp', Date::Now());

		/**
		 * ScriptUrl is used to generate iCal UID's. As a workaround to this bug
		 * https://bugzilla.mozilla.org/show_bug.cgi?id=465853
		 * we need to avoid using any slashes "/"
		 */
		$url = $config->GetScriptUrl();
		$this->Set('UID', parse_url($url, PHP_URL_HOST));
		$this->Set('Reservations', $reservations);

		return preg_replace('~\R~u',"\r\n", $this->smarty->fetch('Export/ical.tpl'));
	}

	public function PageLoad()
	{
		// no-op
	}
}