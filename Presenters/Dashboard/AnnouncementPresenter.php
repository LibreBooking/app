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

require_once(ROOT_DIR . 'Domain/Access/namespace.php');

class AnnouncementPresenter
{
	private $_control;
	private $_announcements;

	/**
	 * @param IAnnouncementsControl $control the control to populate
	 * @param IAnnouncementRepository $announcements Announcements domain object
	 */
	public function __construct(IAnnouncementsControl $control, $announcements = null)
	{
		$this->_control = $control;

		$this->_announcements = $announcements;
		if (is_null($announcements))
		{
			$this->_announcements = new AnnouncementRepository();
		}
	}

	public function PageLoad()
	{
		$this->PopulateAnnouncements();
	}

	private function PopulateAnnouncements()
	{
		$this->_control->SetAnnouncements($this->_announcements->GetFuture());
	}
}