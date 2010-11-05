<?php
interface IEmailMessage
{
	/**
	 * @return string
	 */
	function Charset();
	
	/**
	 * @return EmailAddress[]
	 */
	function To();
	
	/**
	 * @return EmailAddress
	 */
	function From();
	
	/**
	 * @return EmailAddress[]
	 */
	function CC();
	
	/**
	 * @return EmailAddress[]
	 */
	function BCC();
	
	/**
	 * @return string
	 */
	function Subject();
	
	/**
	 * @return string
	 */
	function Body();
	
	/**
	 * @return EmailAddress
	 */
	function ReplyTo();
}
?>