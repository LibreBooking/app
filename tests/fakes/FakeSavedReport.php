<?php
/**
Copyright 2012-2016 Nick Korbel

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

require_once(ROOT_DIR . 'Domain/SavedReport.php');

class FakeSavedReport extends SavedReport
{
	public function __construct()
	{
		parent::__construct(
			'fake',
			1,
			new Report_Usage(Report_Usage::ACCESSORIES),
			new Report_ResultSelection(Report_ResultSelection::COUNT),
			new Report_GroupBy(Report_GroupBy::NONE),
			new Report_Range(Report_Range::ALL_TIME, Date::Now(), Date::Now()),
			new Report_Filter(null, null, null, null, null, null, null) );
	}
}