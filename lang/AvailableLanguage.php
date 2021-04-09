<?php

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
