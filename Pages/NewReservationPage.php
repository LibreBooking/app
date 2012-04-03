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

require_once(ROOT_DIR . 'Pages/ReservationPage.php');
require_once(ROOT_DIR . 'lib/Application/Reservation/namespace.php');
require_once(ROOT_DIR . 'Presenters/ReservationPresenter.php');

interface INewReservationPage extends IReservationPage
{
	public function GetRequestedResourceId();
	
	public function GetRequestedScheduleId();
	
	/**
	 * @return Date
	 */
	public function GetReservationDate();
	
	/**
	 * @return Date
	 */
	public function GetStartDate();
	
	/**
	 * @return Date
	 */
	public function GetEndDate();
}

class NewReservationPage extends ReservationPage implements INewReservationPage
{
	public function __construct()
	{
		parent::__construct('CreateReservation');

		$this->SetParticipants(array());
		$this->SetInvitees(array());
	}
	
	protected function GetPresenter()
	{
		$preconditionService = new NewReservationPreconditionService($this->permissionServiceFactory);
		
		return new ReservationPresenter(
			$this, 
			$this->initializationFactory,
			$preconditionService);
	}

	protected function GetTemplateName()
	{
		return 'Reservation/create.tpl';
	}
	
	protected function GetReservationAction()
	{
		return ReservationAction::Create;
	}
	
	public function GetRequestedResourceId()
	{
		return $this->server->GetQuerystring(QueryStringKeys::RESOURCE_ID);
	}
	
	public function GetRequestedScheduleId()
	{
		return $this->server->GetQuerystring(QueryStringKeys::SCHEDULE_ID);
	}
	
	public function GetReservationDate()
	{
		$timezone = ServiceLocator::GetServer()->GetUserSession()->Timezone;
		$dateTimeString = $this->server->GetQuerystring(QueryStringKeys::RESERVATION_DATE);

		if (empty($dateTimeString))
		{
			return null;
		}
		return new Date($dateTimeString, $timezone);
	}
	
	public function GetStartDate()
	{
		$timezone = ServiceLocator::GetServer()->GetUserSession()->Timezone;
		$dateTimeString = $this->server->GetQuerystring(QueryStringKeys::START_DATE);

		if (empty($dateTimeString))
		{
			return null;
		}
		return new Date($dateTimeString, $timezone);
	}
	
	public function GetEndDate()
	{
		$timezone = ServiceLocator::GetServer()->GetUserSession()->Timezone;
		$dateTimeString = $this->server->GetQuerystring(QueryStringKeys::END_DATE);

		if (empty($dateTimeString))
		{
			return null;
		}
		return new Date($dateTimeString, $timezone);
	}
}
?>