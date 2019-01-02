<?php

/**
 * Copyright 2018-2019 Nick Korbel
 *
 * This file is part of Booked Scheduler is free software: you can redistribute it and/or modify
 * it under the terms of the GNU General Public License as published by
 * the Free Software Foundation, either version 3 of the License, or
 * (at your option) any later version is distributed in the hope that it will be useful,
 * but WITHOUT ANY WARRANTY; without even the implied warranty of
 * MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
 * GNU General Public License for more details.
 *
 * You should have received a copy of the GNU General Public License
 * along with Booked Scheduler.  If not, see <http://www.gnu.org/licenses/>.
 */

class ResourceMinimumNoticeRuleUpdate extends ResourceMinimumNoticeRuleAdd
{
    protected function EnforceMinimumNotice($resource)
    {
        return $resource->HasMinNoticeUpdate();
    }

    protected function GetMinimumNotice($resource)
    {
        return $resource->GetMinNoticeUpdate();
    }

    protected function GetErrorKey()
    {
        return 'MinNoticeErrorUpdate';
    }

    protected function ViolatesMinStartRule($instance, $minStartDate)
    {
        return $instance->PreviousStartDate()->LessThan($minStartDate) || $instance->StartDate()->LessThan($minStartDate);
    }
}

class ResourceMinimumNoticeCurrentInstanceRuleUpdate extends ResourceMinimumNoticeRuleUpdate
{
	protected function GetInstances($reservationSeries)
	{
		return array($reservationSeries->CurrentInstance());
	}
}
