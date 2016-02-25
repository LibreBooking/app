<?php

/**
 * Copyright 2016 Nick Korbel
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

require_once(ROOT_DIR . 'Presenters/ResourceDisplayPresenter.php');

interface IResourceDisplayPage extends IPage, IActionPage
{

	public function DisplayLogin();

	public function DisplayResourceList();

	public function DisplayResourceAvailability();

	/**
	 * @return string
	 */
	public function GetResourceId();
}

class ResourceDisplayPage extends ActionPage implements IResourceDisplayPage
{
	/**
	 * @var ResourceDisplayPresenter
	 */
	private $presenter;

	public function __construct()
	{
		parent::__construct('Resource');
		$this->presenter = new ResourceDisplayPresenter($this, new ResourceRepository(), new ReservationViewRepository(), PluginManager::Instance()->LoadAuthorization());
	}

	/**
	 * @return void
	 */
	public function ProcessAction()
	{
		// TODO: Implement ProcessAction() method.
	}

	/**
	 * @param $dataRequest string
	 * @return void
	 */
	public function ProcessDataRequest($dataRequest)
	{
		// TODO: Implement ProcessDataRequest() method.
	}

	/**
	 * @return void
	 */
	public function ProcessPageLoad()
	{
		$this->presenter->PageLoad();
	}

	/**
	 * @return string
	 */
	public function GetResourceId()
	{
		// TODO: Implement GetResourceId() method.
	}

	public function DisplayLogin()
	{
		// TODO: Implement DisplayLogin() method.
	}

	public function DisplayResourceList()
	{
		// TODO: Implement DisplayResourceList() method.
	}

	public function DisplayResourceAvailability()
	{
		// TODO: Implement DisplayResourceAvailability() method.
	}
}

