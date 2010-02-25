<?php
interface IPage
{
	public function Redirect($url);
	public function RedirectToError($errorMessageId, $lastPage = '');
	public function IsPostBack();
	public function GetLastPage();
}
?>