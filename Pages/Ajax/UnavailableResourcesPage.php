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

require_once(ROOT_DIR . 'Presenters/UnavailableResourcesPresenter.php');

interface IAvailableResourcesPage
{
	public function GetStartDate();

	public function GetEndDate();

	public function GetStartTime();

	public function GetEndTime();

	public function GetReferenceNumber();

	/**
	 * @param int[] $unavailableResourceIds
	 */
	public function BindUnavailable($unavailableResourceIds);
}

class UnavailableResourcesPage extends Page implements IAvailableResourcesPage
{
	public function __construct()
	{
		parent::__construct('', 1);
	}

	public function PageLoad()
	{
		$presenter = new UnavailableResourcesPresenter($this, new ResourceAvailability(new ReservationViewRepository()), ServiceLocator::GetServer()->GetUserSession());
		$presenter->PageLoad();

	}

	public function GetStartDate()
	{
		return $this->GetQuerystring(QueryStringKeys::START_DATE);
	}

	public function GetEndDate()
	{
		return $this->GetQuerystring(QueryStringKeys::END_DATE);
	}

	public function GetReferenceNumber()
	{
		return $this->GetQuerystring(QueryStringKeys::REFERENCE_NUMBER);
	}

	public function GetStartTime()
	{
		return $this->GetQuerystring(QueryStringKeys::START_TIME);
	}

	public function GetEndTime()
	{
		return $this->GetQuerystring(QueryStringKeys::END_TIME);
	}

	public function BindUnavailable($unavailableResourceIds)
	{
		$this->SetJson($unavailableResourceIds);
	}
}