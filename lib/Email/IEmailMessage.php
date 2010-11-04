<?php
interface IEmailMessage
{
	function Charset();
	function To();
	function From();
	function CC();
	function Subject();
	function Body();	
}
?>