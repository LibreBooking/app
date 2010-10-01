<?php
interface IEmailService
{
	/**
	 * @param IEmailMessage $emailMessage
	 */
	function Send(IEmailMessage $emailMessage);
}
?>