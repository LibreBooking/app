<?php

class BlackoutDateTimeValidationResult implements IBlackoutValidationResult
{
	/**
	 * @return bool
	 */
	public function WasSuccessful()
	{
		return false;
	}

	/**
	 * @return string
	 */
	public function Message()
	{
		return Resources::GetInstance()->GetString('StartDateBeforeEndDateRule');
	}

	/**
	 * @return array|ReservationItemView[]
	 */
	public function ConflictingReservations()
	{
		return array();
	}

	/**
	 * @return array|BlackoutItemView[]
	 */
	public function ConflictingBlackouts()
	{
		return array();
	}
}

class BlackoutSecurityValidationResult implements IBlackoutValidationResult
{
	/**
	 * @return bool
	 */
	public function WasSuccessful()
	{
		return false;
	}

	/**
	 * @return string
	 */
	public function Message()
	{
		return Resources::GetInstance()->GetString('NoResourcePermission');
	}

	/**
	 * @return array|ReservationItemView[]
	 */
	public function ConflictingReservations()
	{
		return array();
	}

	/**
	 * @return array|BlackoutItemView[]
	 */
	public function ConflictingBlackouts()
	{
		return array();
	}
}
