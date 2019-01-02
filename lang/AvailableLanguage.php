<?php
/**
Copyright 2011-2019 Nick Korbel

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

class AvailableLanguage
{
    /**
     * @var string
     */
    public $LanguageCode;

    /**
     * @var string
     */
    public $LanguageFile;

    /**
     * @var string
     */
    public $DisplayName;

    /**
     * @var string
     */
    public $LanguageClass;

    /**
     * @return string
     */
    public function GetDisplayName()
    {
        return $this->DisplayName;
    }

    /**
     * @return string
     */
    public function GetLanguageCode()
    {
        return $this->LanguageCode;
    }

    /**
     * @param string $languageCode
     * @param string $languageFile
     * @param string $displayName
     */
    public function __construct($languageCode, $languageFile, $displayName)
    {
        $this->LanguageCode = $languageCode;
        $this->LanguageFile = $languageFile;
        $this->DisplayName = $displayName;
        $this->LanguageClass = str_replace('.php', '', $languageFile);
    }
}