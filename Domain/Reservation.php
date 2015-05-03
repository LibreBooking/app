<?php
/**
Copyright 2011-2015 Nick Korbel

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

require_once(ROOT_DIR . 'lib/Common/namespace.php');
require_once(ROOT_DIR . 'Domain/Values/FullName.php');

class Reservation
{
	/**
	 * @var string
	 */
	protected $referenceNumber;

	/**
	 * @return string
	 */
	public function ReferenceNumber()
	{
		return $this->referenceNumber;
	}

	/**
	 * @var Date
	 */
	protected $startDate;

	/**
	 * @return Date
	 */
	public function StartDate()
	{
		return $this->startDate;
	}

	/**
	 * @var Date
	 */
	protected $endDate;

	/**
	 * @return Date
	 */
	public function EndDate()
	{
		return $this->endDate;
	}

	/**
	 * @return DateRange
	 */
	public function Duration()
	{
		return new DateRange($this->StartDate(), $this->EndDate());
	}

	protected $reservationId;

	public function ReservationId()
	{
		return $this->reservationId;
	}

	/**
	 * @var array|int[]
	 */
	private $_participantIds = array();

	/**
	 * @var array|int[]
	 */
	protected $addedParticipants = array();

	/**
	 * @var array|int[]
	 */
	protected $removedParticipants = array();

	/**
	 * @var array|int[]
	 */
	protected $unchangedParticipants = array();

	/**
	 * @var int[]
	 */
	private $_inviteeIds = array();

	/**
	 * @var int[]
	 */
	protected $addedInvitees = array();

	/**
	 * @var int[]
	 */
	protected $removedInvitees = array();

	/**
	 * @var int[]
	 */
	protected $unchangedInvitees = array();


	/**
	 * @var ReservationSeries
	 */
	public $series;

	public function __construct(ReservationSeries $reservationSeries, DateRange $reservationDate, $reservationId = null,
								$referenceNumber = null)
	{
		$this->series = $reservationSeries;

		$this->SetReservationDate($reservationDate);
		$this->SetReferenceNumber($referenceNumber);

		if (!empty($reservationId))
		{
			$this->SetReservationId($reservationId);
		}

		if (empty($referenceNumber))
		{
			$this->SetReferenceNumber(str_replace('.', '', uniqid('', true)));
		}
	}

	public function SetReservationId($reservationId)
	{
		$this->reservationId = $reservationId;
	}

	public function SetReferenceNumber($referenceNumber)
	{
		$this->referenceNumber = $referenceNumber;
	}

	public function SetReservationDate(DateRange $reservationDate)
	{
		$this->startDate = $reservationDate->GetBegin();
		$this->endDate = $reservationDate->GetEnd();
	}

	/**
	 * @internal
	 * @param array|int[] $participantIds
	 * @return void
	 */
	public function WithParticipants($participantIds)
	{
		$this->_participantIds = $participantIds;
		$this->unchangedParticipants = $participantIds;
	}

	/**
	 * @param int $participantId
	 */
	public function WithParticipant($participantId)
	{
		$this->_participantIds[] = $participantId;
		$this->unchangedParticipants[] = $participantId;
	}

	/**
	 * @internal
	 * @param array|int[] $inviteeIds
	 * @return void
	 */
	public function WithInvitees($inviteeIds)
	{
		$this->_inviteeIds = $inviteeIds;
		$this->unchangedInvitees = $inviteeIds;
	}

	/**
	 * @param int $inviteeId
	 */
	public function WithInvitee($inviteeId)
	{
		$this->_inviteeIds[] = $inviteeId;
		$this->unchangedInvitees[] = $inviteeId;
	}

	/**
	 * @param array|int[] $participantIds
	 * @return int
	 */
	public function ChangeParticipants($participantIds)
	{
		$diff = new ArrayDiff($this->_participantIds, $participantIds);

		$this->addedParticipants = $diff->GetAddedToArray1();
		$this->removedParticipants = $diff->GetRemovedFromArray1();
		$this->unchangedParticipants = $diff->GetUnchangedInArray1();

		$this->_participantIds = $participantIds;

		return count($this->addedParticipants) + count($this->removedParticipants);
	}

	/**
	 * @return array|int[]
	 */
	public function Participants()
	{
		return $this->_participantIds;
	}

	/**
	 * @return array|int[]
	 */
	public function AddedParticipants()
	{
		return $this->addedParticipants;
	}

	/**
	 * @return array|int[]
	 */
	public function RemovedParticipants()
	{
		return $this->removedParticipants;
	}

	/**
	 * @return array|int[]
	 */
	public function UnchangedParticipants()
	{
		return $this->unchangedParticipants;
	}

	/**
	 * @return array|int[]
	 */
	public function AddedInvitees()
	{
		return $this->addedInvitees;
	}

	/**
	 * @return array|int[]
	 */
	public function RemovedInvitees()
	{
		return $this->removedInvitees;
	}

	/**
	 * @return array|int[]
	 */
	public function UnchangedInvitees()
	{
		return $this->unchangedInvitees;
	}

	/**
	 * @param array|int[] $inviteeIds
	 * @return int
	 */
	public function ChangeInvitees($inviteeIds)
	{
		$diff = new ArrayDiff($this->_inviteeIds, $inviteeIds);

		$this->addedInvitees = $diff->GetAddedToArray1();
		$this->removedInvitees = $diff->GetRemovedFromArray1();
		$this->unchangedInvitees = $diff->GetUnchangedInArray1();

		$this->_inviteeIds = $inviteeIds;

		return count($this->addedInvitees) + count($this->removedInvitees);
	}

	/**
	 * @return bool
	 */
	public function IsNew()
	{
		return $this->ReservationId() == null;
	}

	/**
	 * @param int $inviteeId
	 * @return bool whether the invitation was accepted
	 */
	public function AcceptInvitation($inviteeId)
	{
		if (in_array($inviteeId, $this->_inviteeIds))
		{
			$this->addedParticipants[] = $inviteeId;
			$this->_participantIds[] = $inviteeId;
			$this->removedInvitees[] = $inviteeId;

			return true;
		}

		return false;
	}

	/**
	 * @param int $inviteeId
	 * @return bool whether the invitation was declined
	 */
	public function DeclineInvitation($inviteeId)
	{
		if (in_array($inviteeId, $this->_inviteeIds))
		{
			$this->removedInvitees[] = $inviteeId;
			return true;
		}

		return false;
	}

	/**
	 * @param int $participantId
	 * @return bool whether the participant was removed
	 */
	public function CancelParticipation($participantId)
	{
		if (in_array($participantId, $this->_participantIds))
		{
			$this->removedParticipants[] = $participantId;
			return true;
		}

		return false;
	}

	static function Compare(Reservation $res1, Reservation $res2)
	{
		return $res1->StartDate()->Compare($res2->StartDate());
	}
}

?>