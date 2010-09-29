<?php
class ReservationRuleResult
{
	private $_isValid;
	private $_errorMessage;
	
	/**
	 * @param bool $isValid
	 * @param string $errorMessage
	 */
	public function __construct($isValid = true, $errorMessage = null)
	{
		$this->_isValid = $isValid;
		$this->_errorMessage = $errorMessage;
	}
	
	/**
	 * @return bool
	 */
	public function IsValid()
	{
		return $this->_isValid;
	}
	
	/**
	 * @return string
	 */
	public function ErrorMessage()
	{
		return $this->_errorMessage;
	}
}
?>