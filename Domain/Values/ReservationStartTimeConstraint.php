<?php

class ReservationStartTimeConstraint
{
    const _DEFAULT = 'future';
    const FUTURE = 'future';
    const CURRENT = 'current';
    const NONE = 'none';

	/**
	 * @static
	 * @param string $startTimeConstraint
	 * @return bool
	 */
	public static function IsCurrent($startTimeConstraint)
	{
		return strtolower($startTimeConstraint) == self::CURRENT;
	}

	/**
	 * @static
	 * @param string $startTimeConstraint
	 * @return bool
	 */
	public static function IsNone($startTimeConstraint)
	{
		return strtolower($startTimeConstraint) == self::NONE;
	}

	/**
	 * @static
	 * @param string $startTimeConstraint
	 * @return bool
	 */
	public static function IsFuture($startTimeConstraint)
	{
		return strtolower($startTimeConstraint) == self::FUTURE;
	}
}
