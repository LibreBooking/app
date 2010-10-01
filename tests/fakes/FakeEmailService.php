<?php
class FakeEmailService implements IEmailService
{
	/**
	 * @var IEmailMessage[]
	 */
	public $_Messages = array();
	
	/**
	 * @var IEmailMessage
	 */
	public $_LastMessage = null;
	
	/**
	 * @param IEmailMessage $emailMessage
	 * @see IEmailService::Send()
	 */
	public function Send(IEmailMessage $emailMessage)
	{
		$this->_Messages[] = $emailMessage;
		$this->_LastMessage = $emailMessage;
	}
}
?>