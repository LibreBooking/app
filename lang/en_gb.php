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

require_once('Language.php');
require_once('en_us.php');

class en_gb extends en_us
{
    public function __construct()
    {
        parent::__construct();
    }

    protected function _LoadDates()
    {
        $dates = parent::_LoadDates();

        // change defaults here
        $dates['general_date'] = 'd/m/Y';
        $dates['general_datetime'] = 'd/m/Y H:i:s';
        $dates['schedule_daily'] = 'l, d/m/Y';
        $dates['reservation_email'] = 'd/m/Y @ H:i (e)';
        $dates['res_popup'] = 'd/m/Y H:i';
        $dates['dashboard'] = 'l, d/m/Y H:i';
        $dates['period_time'] = "H:i";
        $dates['timepicker'] = 'H:i';
        $dates['general_date_js'] = "dd/mm/yy";
		$dates['short_datetime'] = 'j/n/y H:i';
		$dates['schedule_daily'] = 'l, d/m/Y';
		$dates['res_popup_time'] = 'D, d/n H:i';
		$dates['short_reservation_date'] = 'j/n/y H:i';
		$dates['mobile_reservation_date'] = 'j/n H:i';
        $dates['general_time_js'] = 'H:mm';
        $dates['timepicker_js'] = 'H:i';
        $dates['momentjs_datetime'] = 'D/M/YY H:mm';
		$dates['calendar_time'] = 'H:mm';
		$dates['calendar_dates'] = 'd M';
        $dates['report_date'] = '%d/%m';

        $this->Dates = $dates;
        return $this->Dates;
    }
}
