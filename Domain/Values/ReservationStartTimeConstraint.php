<?php

class ReservationStartTimeConstraint
{
    public const _DEFAULT = 'future';
    public const FUTURE = 'future';
    public const CURRENT = 'current';
    public const NONE = 'none';

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
