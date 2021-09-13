<?php

class AccountStatus
{
    private function __construct()
    {
    }

    public const ALL = 0;
    public const ACTIVE = 1;
    public const AWAITING_ACTIVATION = 2;
    public const INACTIVE = 3;
}
