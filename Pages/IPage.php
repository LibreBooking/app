<?php
interface IPage
{
	public function Redirect($url);
	public function IsPostBack();
	public function GetLastPage();
}
?>