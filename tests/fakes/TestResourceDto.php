<?php

/**
 * Copyright 2017-2018 Nick Korbel
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

require_once(ROOT_DIR . 'Domain/Access/ResourceRepository.php');

class TestResourceDto extends ResourceDto
{
	public function __construct($id = 1,
								$name = 'testresourcedto',
								$canAccess = true,
								$canBook = true,
								$scheduleId = 1,
								$minLength = null,
								$resourceTypeId = null,
								$adminGroupId = null,
								$scheduleAdminGroupId = null,
								$statusId = 1,
								$requiresApproval = false,
								$isCheckInEnabled = false,
								$isAutoReleased = false,
								$autoReleaseMinutes = null,
								$color = null)
	{
		parent::__construct($id, $name, $canAccess, $canBook, $scheduleId, ($minLength == null ? TimeInterval::None() : $minLength), $resourceTypeId, $adminGroupId,
							$scheduleAdminGroupId, $statusId, $requiresApproval, $isCheckInEnabled, $isAutoReleased, $autoReleaseMinutes, $color);
	}
}