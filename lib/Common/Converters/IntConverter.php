<?php

class IntConverter implements IConvert
{
    public function Convert($value)
    {
        return intval($value);
    }
}
