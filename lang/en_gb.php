<?php
/**
Copyright 2011-2012 Nick Korbel

This file is part of phpScheduleIt.

phpScheduleIt is free software: you can redistribute it and/or modify
it under the terms of the GNU General Public License as published by
the Free Software Foundation, either version 3 of the License, or
(at your option) any later version.

phpScheduleIt is distributed in the hope that it will be useful,
but WITHOUT ANY WARRANTY; without even the implied warranty of
MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
GNU General Public License for more details.

You should have received a copy of the GNU General Public License
along with phpScheduleIt.  If not, see <http://www.gnu.org/licenses/>.
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
        parent::_LoadDates();

        // change defaults here
        $this->Dates['general_date'] = 'd/m/Y';
        $this->Dates['general_datetime'] = 'd/m/Y H:i:s';
        $this->Dates['schedule_daily'] = 'l, d/m/Y';
        $this->Dates['reservation_email'] = 'd/m/Y @ g:i A (e)';
        $this->Dates['res_popup'] = 'd/m/Y g:i A';
        $this->Dates['dashboard'] = 'l, d/m/Y g:i A';
        $this->Dates['period_time'] = "g:i A";
        $this->Dates['general_date_js'] = "dd/mm/yy";
    }

    protected function _LoadStrings()
    {
        parent::_LoadStrings();

        // change defaults here
    }

    protected function _LoadDays()
    {
        parent::_LoadDays();

        // change defaults here
    }

    protected function _LoadMonths()
    {
        parent:: _LoadMonths();

        // change defaults here
    }
}

?>