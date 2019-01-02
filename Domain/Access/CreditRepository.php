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

require_once (ROOT_DIR . 'Domain/Values/CreditLogView.php');
require_once (ROOT_DIR . 'Domain/Access/PageableDataStore.php');

interface ICreditRepository
{
    /**
     * @param int $pageNumber
     * @param int $pageSize
     * @param int $userId
     * @param string $sortField
     * @param string $sortDirection
     * @param ISqlFilter $filter
     * @return PageableData|CreditLogView[]
     */
    public function GetList($pageNumber, $pageSize, $userId = -1, $sortField = null, $sortDirection = null, $filter = null);
}

class CreditRepository implements ICreditRepository
{
    public function GetList($pageNumber, $pageSize, $userId = -1, $sortField = null, $sortDirection = null, $filter = null)
    {
        $command = new GetAllCreditLogsCommand($userId);

        if ($filter != null)
        {
            $command = new FilterCommand($command, $filter);
        }

        $builder = array('CreditLogView', 'Populate');
        return PageableDataStore::GetList($command, $builder, $pageNumber, $pageSize, $sortField, $sortDirection);
    }
}