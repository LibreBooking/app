<?php

class BooleanConverter implements IConvert
{
    public function Convert($value)
    {
        return self::ConvertValue($value);
    }

    /**
     * @param mixed $value
     * @return bool
     */
    public static function ConvertValue($value)
    {
        return $value === true || strtolower($value) == 'true' || $value === 1 || $value === '1';
    }
}
