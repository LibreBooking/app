<?php

abstract class Language
{
    public $Charset = 'UTF-8';
    public $Dates = [];
    public $Strings = [];
    public $Days = [];
    public $Months = [];
    public $Letters = [];
    public $HtmlLang;
    public $TextDirection = 'ltr';

    public function __construct()
    {
        $this->_LoadDates();
        $this->_LoadStrings();
        $this->_LoadDays();
        $this->_LoadMonths();
        $this->_LoadLetters();

        $this->HtmlLang = $this->_GetHtmlLangCode();
    }

    abstract protected function _LoadDates();

    abstract protected function _LoadStrings();

    abstract protected function _LoadDays();

    abstract protected function _LoadMonths();

    abstract protected function _LoadLetters();

    abstract protected function _GetHtmlLangCode();
}
