<?php

class JobCop
{
    public static function EnsureCommandLine()
    {
        try {
            if (array_key_exists('REQUEST_METHOD', $_SERVER)) {
                die('This can only be accessed via the command line');
            }
        } catch (Exception $ex) {
            Log::Error('Error in JobCop->EnsureCommandLine: %s', $ex);
        }
    }
}
