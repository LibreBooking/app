<?php
interface IEmailMessage
{
	/**
	 * @return string
	 */
	function Charset();
	
	/**
	 * @return array|EmailAddress[]|EmailAddress
	 */
	function To();
	
	/**
	 * @return EmailAddress
	 */
	function From();
	
	/**
	 * @return array|EmailAddress[]|EmailAddress
	 */
	function CC();
	
	/**
	 * @return array|EmailAddress[]|EmailAddress
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