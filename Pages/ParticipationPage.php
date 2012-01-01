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

require_once(ROOT_DIR . 'Pages/SecurePage.php');
require_once(ROOT_DIR . 'Presenters/ParticipationPresenter.php');

interface IParticipationPage
{
	/**
	 * @return string|InvitationAction
	 */
	function GetInvitationAction();

	/**
	 * @return string|InvitationAction
	 */
	function GetInvitationReferenceNumber();

	/**
	 * @return void
	 */
	function DisplayParticipation();

	/**
	 * @param $results serializable json
	 * @return void
	 */
	function DisplayResult($results);

	/**
	 * @return int
	 */
	function GetUserId();

	/**
	 * @return string
	 */
	function GetResponseType();

	/**
	 * @abstract
	 * @param array|ReservationViewItem[] $reservations
	 * @return void
	 */
	function BindReservations($reservations);

	/**
	 * @abstract
	 * @param $timezone
	 * @return void
	 */
	public function SetTimezone($timezone);
}

class ParticipationPage extends SecurePage implements IParticipationPage
{
	/**
	 * @var \ParticipationPresenter
	 */
	private $presenter;
	
	public function __construct()
	{
	    parent::__construct('OpenInvitations');
		$this->presenter = new ParticipationPresenter($this, new ReservationRepository(), new ReservationViewRepository());
	}
	
	public function PageLoad()
	{
		$this->presenter->PageLoad();
	}

	public function DisplayParticipation()
	{
		$this->Display('participation.tpl');
	}

	public function DisplayResult($results)
	{
		$this->SetJson($results);
	}

	function GetInvitationAction()
	{
		return $this->GetQuerystring(QueryStringKeys::INVITATION_ACTION);
	}

	function GetInvitationReferenceNumber()
	{
		return $this->GetQuerystring(QueryStringKeys::REFERENCE_NUMBER);
	}

	public function GetUserId()
	{
		return ServiceLocator::GetServer()->GetUserSession()->UserId;
	}

	function GetResponseType()
	{
		return $this->GetQuerystring(QueryStringKeys::RESPONSE_TYPE);
	}

	function BindReservations($reservations)
	{
		$this->Set('Reservations', $reservations);
	}

	public function SetTimezone($timezone)
	{
		$this->Set('Timezone', $timezone);
	}
}
?>