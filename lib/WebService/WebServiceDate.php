<?php

class WebServiceDate
{
    /**
     * @param string $dateString
     * @param UserSession $session
     * @return Date
     */
    public static function GetDate($dateString, UserSession $session)
    {
        try {
            if (BookedStringHelper::Contains($dateString, 'T')) {
                return Date::ParseExact($dateString);
            }

            return Date::Parse($dateString, $session->Timezone);
        } catch (Exception $ex) {
            return Date::Now();
        }
    }
}
