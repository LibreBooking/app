<?php

/**
 * An interface for Page class implementation
 */
interface IPage {

    public function Redirect($url);

    public function RedirectToError($errorMessageId, $lastPage = '');

    public function IsPostBack();

    public function IsValid();

    public function GetLastPage();

    public function RegisterValidator($validatorId, $validator);
}

?>